<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});
Route::get('/home', function () {
    return Inertia::render('Home');
})->name('user.dashboard');
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
});

