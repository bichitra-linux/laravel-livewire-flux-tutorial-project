<?php

namespace App\Http\Controllers;

use App\Enums\ReactionType;
use Illuminate\Http\Request;
use App\Models\Reaction;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;


class ReactionController extends Controller
{
    //
   public function toggle(Request $request, Post $post)
    {
        // Validate reaction type using enum
        $request->validate([
            'type' => ['required', Rule::enum(ReactionType::class)],
        ]);

        $user = auth()->user();
        $type = $request->type;

        // ✅ Rate limiting: 30 reactions per minute
        $key = 'reaction:' . $user->id . ':' . $post->id;
        
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => "Too many reactions. Please try again in {$seconds} seconds.",
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($key, 60); // 30 attempts per 60 seconds

        try {
            DB::beginTransaction();

            // Check for existing reaction
            $existingReaction = $post->reactions()
                ->where('user_id', $user->id)
                ->first();

            $status = null;
            $message = null;

            if ($existingReaction) {
                // Same reaction: remove it (toggle off)
                if ($existingReaction->type->value === $type) {
                    $existingReaction->delete();
                    $status = 'removed';
                    $message = 'Reaction removed';
                } else {
                    // Different reaction: update it
                    $existingReaction->update(['type' => $type]);
                    $status = 'updated';
                    $message = 'Reaction updated';
                }
            } else {
                // Create new reaction
                $post->reactions()->create([
                    'user_id' => $user->id,
                    'type' => $type,
                ]);
                $status = 'added';
                $message = 'Reaction added';
            }

            // ✅ Clear cache
            $post->clearReactionCache();

            DB::commit();

            return response()->json([
                'status' => $status,
                'message' => $message,
                'reactions' => $this->getReactionStats($post),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Reaction toggle error', [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to process reaction. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get reaction statistics for a post
     */
    private function getReactionStats(Post $post)
    {
        // Force fresh data by using eager loading
        $post->loadCount(
            collect(ReactionType::cases())
                ->mapWithKeys(function($type) {
                    return ["reactions as {$type->value}_count" => fn($q) => $q->where('type', $type->value)];
                })
                ->toArray()
        );

        // Collect counts
        $counts = collect(ReactionType::cases())
            ->mapWithKeys(function($type) use ($post) {
                $countKey = "{$type->value}_count";
                return [$type->value => $post->$countKey ?? 0];
            })
            ->filter(fn($count) => $count > 0);

        $user = auth()->user();
        $userReaction = $user ? $post->userReaction($user->id) : null;

        return [
            'total' => $counts->sum(),
            'counts' => $counts,
            'user_reaction' => $userReaction?->type?->value ?? null,
            'most_popular' => $post->most_popular_reaction,
        ];
    }

    /**
     * Get users who reacted to a post
     */
    public function users(Post $post, $type = null)
    {
        $query = $post->reactions()
            ->with(['user' => fn($q) => $q->select('id', 'name', 'email')])
            ->select('id', 'user_id', 'post_id', 'type', 'created_at');

        // Validate and filter by type if provided
        if ($type) {
            try {
                $reactionType = ReactionType::from($type);
                $query->where('type', $reactionType->value);
            } catch (\ValueError $e) {
                return redirect()
                    ->route('reactions.users', $post)
                    ->with('error', 'Invalid reaction type');
            }
        }

        $reactions = $query->latest()->paginate(20);

        // Get reaction summary
        $reactionSummary = collect(ReactionType::cases())
            ->mapWithKeys(function($reactionType) use ($post) {
                $count = $post->reactions()->where('type', $reactionType->value)->count();
                return [
                    $reactionType->value => [
                        'count' => $count,
                        'emoji' => $reactionType->emoji(),
                        'label' => $reactionType->label(),
                        'color' => $reactionType->color(),
                    ]
                ];
            })
            ->filter(fn($data) => $data['count'] > 0);

        return view('reactions.users', compact('post', 'reactions', 'type', 'reactionSummary'));
    }
}
