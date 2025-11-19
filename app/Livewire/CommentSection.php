<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public Post $post;
    public $content = '';
    public $parentId = null;
    public $editingCommentId = null;
    public $editingContent = '';
    public $replyToUsername = '';

    public $sortBy = 'latest';

    // Remove polling - we'll use manual refresh instead
    public $lastUpdated;

    public $isExpanded = false;
    public $allThreadsExpanded = false;

    protected $rules = [
        'content' => 'required|string|min:3|max:1000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->lastUpdated = now()->timestamp;
    }

    public function toggleSection()
    {
        $this->isExpanded = !$this->isExpanded;

        if ($this->isExpanded) {
            $this->dispatch('section-expanded');
        }
    }

    public function collapseAllThreads()
    {
        $this->allThreadsExpanded = false;
        $this->dispatch('threads-collapsed');
    }

    public function expandAllThreads()
    {
        $this->allThreadsExpanded = true;
        $this->dispatch('threads-expanded');
    }

    public function postComment()
    {

        // Check reply depth
        if ($this->parentId) {
            $depth = 0;
            $parent = Comment::find($this->parentId);
            while ($parent && $parent->parent_id) {
                $depth++;
                if ($depth >= 3) {
                    $this->addError('content', 'Maximum reply depth reached');
                    return;
                }
                $parent = $parent->parent;
            }
        }
        // Rate limiting
        $key = 'comment:' . Auth::id() . ':' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('content', "Too many comments. Please wait {$seconds} seconds.");
            return;
        }

        $this->validate();

        RateLimiter::hit($key, 120); // 3 attempts per 2 minutes

        // Validate parent comment if replying
        if ($this->parentId) {
            $parentComment = Comment::find($this->parentId);
            if (!$parentComment || $parentComment->post_id !== $this->post->id) {
                $this->addError('content', 'Invalid parent comment');
                return;
            }
        }

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
            'parent_id' => $this->parentId,
            'content' => trim($this->content),
            'is_approved' => true,
        ]);

        $this->content = '';
        $this->parentId = null;
        $this->replyToUsername = '';
        $this->lastUpdated = now()->timestamp;

        $this->isExpanded = true;

        session()->flash('message', 'Comment posted successfully!');

        // Broadcast to other users
        $this->dispatch('comment-posted');
    }

    public function startReply($commentId, $username)
    {
        $this->parentId = $commentId;
        $this->replyToUsername = $username;
        $this->isExpanded = true;
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

        $this->isExpanded = true;
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

        $comment->update(['content' => trim($this->editingContent)]);

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
        $query = $this->post->comments()
            ->approved()
            ->parentOnly()
            ->with([
                'user:id,name,email',
                'replies' => fn($q) => $q->approved()->with('user:id,name,email')
            ])
            ->withCount('replies');


        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_replies':
                $query->withCount('replies')
                    ->orderBy('replies_count', 'desc')
                    ->orderBy('created_at', 'desc'); // Secondary sort by date
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $comments = $query->get();
        $totalReplies = $comments->sum(function ($comment) {
            return $comment->replies->count();
        });

        if (session()->has('message') || session()->has('error')) {
            $this->isExpanded = true;
        }

        return view('livewire.comment-section', [
            'comments' => $comments,
            'commentsCount' => $comments->count() + $totalReplies,
        ]);
    }
}