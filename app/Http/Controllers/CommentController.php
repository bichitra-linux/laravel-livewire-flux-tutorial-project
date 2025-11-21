<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index(Request $request)
    {

        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to manage comments.');
        }

        $stats = [
            'total' => Comment::count(),
            'pending' => Comment::where('is_approved', false)->count(),
            'approved' => Comment::where('is_approved', true)->count(),
            'today' => Comment::whereDate('created_at', today())->count(),
        ];

        $query = Comment::with(['user', 'post', 'replies']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");

                    })
                    ->orWhereHas('post', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        if ($request->filled('type')) {
            if ($request->type === 'parent') {
                $query->whereNull('parent_id');
            } elseif ($request->type === 'reply') {
                $query->whereNotNull('parent_id');
            }
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_replies':
                $query->withCount('replies')->orderBy('replies_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $comments = $query->paginate(15)->withQueryString();

        return view('comments.index', compact('comments', 'stats'));
    }

    public function show(Comment $comment)
    {

        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to view this comment.');
        }
        $comment->load(['user', 'post', 'replies.user', 'parent']);
        return view('comments.show', compact('comment'));
    }

    public function approve(Comment $comment)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to approve comments.');
        }
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Comment approved successfully.');
    }

    public function reject(Comment $comment)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to reject comments.');
        }
        $comment->update(['is_approved' => false]);
        return back()->with('success', 'Comment marked as pending.');
    }

    public function destroy(Comment $comment)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to delete comments.');
        }
        // Delete all replies first
        $comment->replies()->delete();
        // Delete the comment
        $comment->delete();

        return back()->with('success', 'Comment and all replies deleted successfully.');
    }

    public function bulkApprove(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to approve comments.');
        }
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        Comment::whereIn('id', $request->comment_ids)->update(['is_approved' => true]);

        return back()->with('success', count($request->comment_ids) . ' comment(s) approved successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'You do not have permission to delete comments.');
        }
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        // Delete replies first
        Comment::whereIn('parent_id', $request->comment_ids)->delete();
        // Delete selected comments
        Comment::whereIn('id', $request->comment_ids)->delete();

        return back()->with('success', count($request->comment_ids) . ' comment(s) deleted successfully.');
    }
}
