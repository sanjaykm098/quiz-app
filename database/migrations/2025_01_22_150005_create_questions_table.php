<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('type');
            $table->string('difficulty');
            $table->json('options');
            $table->string('answer');
            $table->foreignId('category_id')->constrained('categories');
            $table->uuid('uuid')->unique();
            $table->index('category_id');
            $table->index('uuid');
            $table->index('type');
            $table->index('difficulty');
            $table->index('question');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
