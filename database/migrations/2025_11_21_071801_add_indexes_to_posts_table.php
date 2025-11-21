<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // For listing published posts by date
            $table->index(['status', 'created_at']);
            
            // For category filtering
            $table->index(['category_id', 'status']);
            
            // For popular posts queries
            $table->index('views');
            
            // For slug lookups (if not already unique)
            if (!Schema::hasColumn('posts', 'slug')) {
                $table->index('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['category_id', 'status']);
            $table->dropIndex(['views']);
            
            if (Schema::hasColumn('posts', 'slug')) {
                $table->dropIndex(['slug']);
            }
        });
    }
};