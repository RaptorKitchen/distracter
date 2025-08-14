<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('distraction_id')->constrained()->onDelete('cascade');
            $table->string('emoji', 191); // stores emoji character
            $table->timestamps();

            // Prevent duplicate reaction from same user on same post with same emoji
            $table->unique(['user_id', 'distraction_id', 'emoji']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};