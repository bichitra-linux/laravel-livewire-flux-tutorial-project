<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;

class CommentSection extends Component
{
    public Post $post;
    public $content = '';
    public $parentId = null;
    public $editingCommentId = null;
    public $editingContent = '';
    public $replyToUsername = '';
    
    // Remove polling - we'll use manual refresh instead
    public $lastUpdated;

    protected $rules = [
        'content' => 'required|string|min:3|max:1000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->lastUpdated = now()->timestamp;
    }

    public function postComment()
    {
        // Rate limiting
        $key = 'comment:' . auth()->id();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('content', "Too many comments. Please try again in {$seconds} seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 60);

        // Validate parent comment if replying
        if ($this->parentId) {
            $parentComment = Comment::find($this->parentId);
            if (!$parentComment || $parentComment->post_id !== $this->post->id) {
                $this->addError('content', 'Invalid parent comment');
                return;
            }
        }

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $this->post->id,
            'parent_id' => $this->parentId,
            'content' => $this->content,
            'is_approved' => true,
        ]);

        $this->content = '';
        $this->parentId = null;
        $this->replyToUsername = '';
        $this->lastUpdated = now()->timestamp;
        
        session()->flash('message', 'Comment posted successfully!');
        
        // Broadcast to other users
        $this->dispatch('comment-posted');
    }

    public function startReply($commentId, $username)
    {
        $this->parentId = $commentId;
        $this->replyToUsername = $username;
        $this->dispatch('focusCommentInput');
    }

    public function cancelReply()
    {
        $this->parentId = null;
        $this->replyToUsername = '';
        $this->content = '';
    }

    public function startEdit($commentId, $content)
    {
        $comment = Comment::findOrFail($commentId);
        
        if (!$comment->canEdit()) {
            $this->addError('editingContent', 'You cannot edit this comment.');
            return;
        }

        $this->editingCommentId = $commentId;
        $this->editingContent = $content;
    }

    public function updateComment()
    {
        $this->validate([
            'editingContent' => 'required|string|min:3|max:1000',
        ]);

        $comment = Comment::findOrFail($this->editingCommentId);
        
        if (!$comment->canEdit()) {
            $this->addError('editingContent', 'You cannot edit this comment.');
            return;
        }

        $comment->update(['content' => $this->editingContent]);

        $this->editingCommentId = null;
        $this->editingContent = '';
        $this->lastUpdated = now()->timestamp;
        
        session()->flash('message', 'Comment updated successfully!');
    }

    public function cancelEdit()
    {
        $this->editingCommentId = null;
        $this->editingContent = '';
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        if (!$comment->canDelete()) {
            session()->flash('error', 'You cannot delete this comment.');
            return;
        }

        $comment->delete();
        $this->lastUpdated = now()->timestamp;
        
        session()->flash('message', 'Comment deleted successfully!');
        
        $this->dispatch('comment-deleted');
    }

    // Listen for updates from other users
    #[On('refresh-comments')]
    public function refreshComments()
    {
        $this->lastUpdated = now()->timestamp;
    }

    // Check for new comments (called via JS interval)
    public function checkForUpdates()
    {
        // Just return the last update timestamp
        // The view will handle the comparison
        return now()->timestamp;
    }

    public function render()
    {
        $comments = $this->post->comments()
            ->approved()
            ->parentOnly()
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalReplies = $comments->sum(function($comment) {
            return $comment->replies->count();
        });

        return view('livewire.comment-section', [
            'comments' => $comments,
            'commentsCount' => $comments->count() + $totalReplies,
        ]);
    }
}