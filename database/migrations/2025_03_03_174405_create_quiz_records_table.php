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
        Schema::create('quiz_records', function (Blueprint $table) {
            $table->id();
            $table->text('question_ids');
            $table->string('user_id');
            $table->integer('current_question')->default(1);
            $table->string('category_id');
            $table->string('level');
            $table->string('no_of_questions');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_records');
    }
};
