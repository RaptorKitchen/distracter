<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('follows', function (Blueprint $table) {
            // Only add these if they don't already exist
            if (!Schema::hasColumn('follows', 'follower_id')) {
                $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('follows', 'followee_id')) {
                $table->foreignId('followee_id')->constrained('users')->onDelete('cascade');
            }

            $table->unique(['follower_id', 'followee_id']);
        });
    }

    public function down(): void
    {
        Schema::table('follows', function (Blueprint $table) {
            $table->dropUnique(['follower_id', 'followee_id']);
            $table->dropForeign(['follower_id']);
            $table->dropForeign(['followee_id']);
            $table->dropColumn(['follower_id', 'followee_id']);
        });
    }
};
