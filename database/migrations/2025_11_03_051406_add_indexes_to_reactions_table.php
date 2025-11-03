<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            //

            $table->index(['post_id', 'type'], 'reactions_post_type_index');
            $table->index('user_id', 'reactions_user_id_index');
            $table->index('created_at', 'reactions_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            //

            $table->dropIndex('reactions_post_type_index');
            $table->dropIndex('reactions_user_id_index');
            $table->dropIndex('reactions_created_at_index');
        });
    }
};
