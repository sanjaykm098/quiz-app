<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\QuizAnswerRecord;
use App\Models\QuizRecord;
use App\QuizType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function show($uuid, $level)
    {
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        if (!$quizType) {
            return redirect()->back();
        }
        $category = Category::where('id', $id)->firstOrFail();
        $category->uuid = $uuid;
        return Inertia::render('Quiz/Start', compact('category', 'quizType'));
    }

    public function start($uuid, $level)
    {
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        if (!$quizType) {
            return redirect()->back();
        }
        $category = Category::where('id', $id)->firstOrFail();
        $category->uuid = $uuid;

        $questions = $category->questions()->inRandomOrder()->limit($quizType['no_of_que'])->get();

        $quiz = QuizRecord::create(
            [
                'user_id' => Auth::id(),
                'category_id' => $category->id,
                'level' => $quizType['level'],
                'no_of_questions' => $quizType['no_of_que'],
                'time' => $quizType['each_que_time'],
                'question_ids' => $questions->pluck('id'),
            ]
        );

        return redirect()->route('quiz.play', ['uuid' => $uuid, 'level' => $level, 'quiz' => $quiz->id, 'question' => 1]);
    }

    public function play($uuid, $level, $quiz, $questionIndex)
    {
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        if (!$quizType) {
            return redirect()->back();
        }
        $category = Category::where('id', $id)->firstOrFail();
        $category->uuid = $uuid;

        $quiz = QuizRecord::where('id', $quiz)->where('user_id', Auth::id())->firstOrFail();
        $question = $quiz->question_ids[$questionIndex - 1];
        $question = $category->questions()->where('id', $question)->firstOrFail();
        $nextQuestionRoute = route(
            'quiz.play',
            [
                'uuid' => $uuid,
                'level' => $level,
                'quiz' => $quiz->id,
                'question' => $questionIndex,
            ]
        );
        // dd($nextQuestionRoute);
        if ($questionIndex == $quizType['no_of_que']) {
            $nextQuestionRoute = route('quiz.result', ['uuid' => $uuid, 'level' => $level, 'quiz' => $quiz->id, 'question' => $questionIndex]);
        }
        // dd($nextQuestionRoute);
        return Inertia::render('Quiz/Play', compact('category', 'quizType', 'quiz', 'question', 'nextQuestionRoute'));
    }

    public function result(Request $request, $uuid, $level, $quiz, $questionIndex)
    {
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        $category = Category::where('id', $id)->firstOrFail();
        $category->uuid = $uuid;
        $quiz = QuizRecord::where('id', $quiz)->where('user_id', Auth::id())->firstOrFail();
        if ($request->method() == 'PUT') {
            $request->validate([
                'selectedAnswer' => 'required'
            ]);
            $question = $quiz->question_ids[$questionIndex - 1];

            QuizAnswerRecord::create(
                [
                    'quiz_record_id' => $quiz->id,
                    'question_id' => $question,
                    'option' => $request->selectedAnswer,
                    'is_correct' => $category->questions()->where('id', $question)->firstOrFail()->correct_option == $request->selectedAnswer,
                ]
            );
            $quiz->update(['current_question' => $questionIndex]);
        }
        $quizResult = QuizAnswerRecord::where('quiz_record_id', $quiz->id)->with('quizRecord', 'question')->get();
        return Inertia::render('Quiz/Result', compact('category', 'quizType', 'quiz', 'quizResult'));
    }

    public function store(Request $request, $uuid, $level, $quiz, $questionIndex)
    {

        // dd($questionIndex);
        $request->validate([
            'selectedAnswer' => 'required'
        ]);
        $id = base64_decode($uuid);
        $quizType = QuizType::getQuiz($level);
        if (!$quizType) {
            return redirect()->back();
        }
        $category = Category::where('id', $id)->firstOrFail();
        $category->uuid = $uuid;

        $quiz = QuizRecord::where('id', $quiz)->where('user_id', Auth::id())->firstOrFail();
        $question = $quiz->question_ids[$questionIndex - 1];

        QuizAnswerRecord::create(
            [
                'quiz_record_id' => $quiz->id,
                'question_id' => $question,
                'option' => $request->selectedAnswer,
                'is_correct' => $category->questions()->where('id', $question)->firstOrFail()->correct_option == $request->selectedAnswer,
            ]
        );

        $quiz->update(['current_question' => $questionIndex]);

        return redirect()->route('quiz.play', ['uuid' => $uuid, 'level' => $level, 'quiz' => $quiz->id, 'question' => $questionIndex + 1]);
    }

    public function allResults()
    {
        $quizResults = QuizRecord::where('user_id', Auth::id())->latest()->with('category')->get();
        foreach ($quizResults as $quizResult) {
            $quizResult->correct = QuizAnswerRecord::where('quiz_record_id', $quizResult->id)->where('is_correct', true)->count();
            $quizResult->wrong = QuizAnswerRecord::where('quiz_record_id', $quizResult->id)->where('is_correct', false)->count();
            $quizResult->total = $quizResult->correct + $quizResult->wrong;
            $quizResult->score = number_format(($quizResult->correct / $quizResult->total) * 100, 2);
        }
        return Inertia::render('Quiz/AllResults', compact('quizResults'));
    }
}
