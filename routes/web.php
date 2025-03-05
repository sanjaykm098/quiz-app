<?php

use App\Http\Controllers\Auth\User\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('/login')->group(function () {
        Route::get('/', [AuthController::class, 'loginPage'])->name('login');
        Route::post('/', [AuthController::class, 'login'])->name('login');
    });
    Route::prefix('register')->group(function () {
        Route::get('/', [AuthController::class, 'registerPage'])->name('register');
        Route::post('/', [AuthController::class, 'register'])->name('register');
    });
});
Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('home', HomeController::class)->name('user.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/category/{uuid}', [CategoryController::class, 'show'])->name('category');
    Route::get('/category/{uuid}/quiz/{level}', [QuizController::class, 'show'])->name('quiz');
    Route::post('/category/{uuid}/quiz/{level}', [QuizController::class, 'start'])->name('quiz');
    Route::get('/category/{uuid}/quiz/{level}/play/{quiz}/question/{question}', [QuizController::class, 'play'])->name('quiz.play');
    Route::put('/category/{uuid}/quiz/{level}/play/{quiz}/question/{question}', [QuizController::class, 'store'])->name('quiz.play');
    Route::match(['get', 'put'], '/category/{uuid}/quiz/{level}/play/{quiz}/question/{question}/result', [
        QuizController::class,
        'result'
    ])->name('quiz.result');
});
