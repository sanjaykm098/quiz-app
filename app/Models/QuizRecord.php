<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizRecord extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'level',
        'question_ids',
        'no_of_questions',
        'time',
        'current_question'
    ];

    protected $casts = [
        'question_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
