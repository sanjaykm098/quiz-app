<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\QuizType;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($uuid, $level)
    {
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        if (!$quizType) {
            return redirect()->back();
        }
        $category = Category::where('id', $id)->with('questions')->firstOrFail();
    }
}
