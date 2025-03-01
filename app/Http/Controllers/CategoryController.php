<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\QuizType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($uuid)
    {
        $id = base64_decode($uuid);
        $category = Category::where('id', $id)->firstOrFail();
        $quizType = [
            QuizType::$Beginner,
            QuizType::$Intermediate,
            QuizType::$Advanced,
            QuizType::$Expert,
            QuizType::$Master,
        ];
        $category->uuid = $uuid;
        return Inertia::render('Category/Show', compact('category', 'quizType'));
    }
}
