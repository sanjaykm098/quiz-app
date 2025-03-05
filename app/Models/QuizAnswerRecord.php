<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswerRecord extends Model
{
    protected $fillable = [
        'quiz_record_id',
        'question_id',
        'option',
        'is_correct',
    ];

    public function quizRecord()
    {
        return $this->belongsTo(QuizRecord::class, 'quiz_record_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(Questions::class, 'question_id', 'id');
    }
}
