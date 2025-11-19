<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add slug column WITHOUT unique constraint first
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Step 2: Generate slugs for existing posts
        $this->generateSlugs();

        // Step 3: Now add the unique constraint
        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }

    private function generateSlugs(): void
    {
        Post::chunk(100, function ($posts) {
            foreach ($posts as $post) {
                $baseSlug = Str::slug($post->title);
                $slug = $baseSlug;
                $count = 1;
                
                // Ensure uniqueness
                while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                
                // Update without triggering model events
                $post->timestamps = false;
                $post->slug = $slug;
                $post->save();
            }
        });
    }
};