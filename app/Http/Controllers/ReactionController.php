<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Post;

class ReactionController extends Controller
{
    //
   public function toggle(Request $request, Post $post)
    {
        $request->validate([
            'type' => 'required|in:like,love,care,haha,wow,sad,angry'
        ]);

        $user = auth()->user();
        
        // Check if user already reacted to this post
        $existingReaction = $post->reactions()
            ->where('user_id', $user->id)
            ->first();

        if ($existingReaction) {
            // If same reaction, remove it (toggle off)
            if ($existingReaction->type === $request->type) {
                $existingReaction->delete();
                
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Reaction removed',
                    'reactions' => $this->getReactionStats($post),
                ]);
            }
            
            // If different reaction, update it
            $existingReaction->update(['type' => $request->type]);
            
            return response()->json([
                'status' => 'updated',
                'message' => 'Reaction updated',
                'reactions' => $this->getReactionStats($post),
            ]);
        }

        // Create new reaction
        $post->reactions()->create([
            'user_id' => $user->id,
            'type' => $request->type,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'Reaction added',
            'reactions' => $this->getReactionStats($post),
        ]);
    }

    /**
     * Get reaction statistics for a post
     */
    private function getReactionStats(Post $post)
    {
        $reactions = $post->reactions()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type');

        $total = $post->reactions()->count();
        
        $user = auth()->user();
        $userReaction = $user ? $post->userReaction($user->id) : null;

        return [
            'total' => $total,
            'counts' => $reactions,
            'user_reaction' => $userReaction ? $userReaction->type : null,
        ];
    }

    /**
     * Get users who reacted to a post
     */
    public function users(Post $post, $type = null)
    {
        $query = $post->reactions()->with('user');

        if ($type) {
            $query->where('type', $type);
        }

        $reactions = $query->latest()->paginate(20);

        return view('reactions.users', compact('post', 'reactions', 'type'));
    }
}
