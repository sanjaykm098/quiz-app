<?php

use App\Console\Commands\SaveQuizQuestions;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SaveQuizQuestions::class)->everyMinute();
