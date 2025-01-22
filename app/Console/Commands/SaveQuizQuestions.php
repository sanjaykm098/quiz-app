<?php

namespace App\Console\Commands;

use App\Jobs\SaveQuizJob;
use Illuminate\Console\Command;

class SaveQuizQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:save-quiz-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save quiz questions to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $numberOfQuestions = 50;
        $difficultyLevels = ['easy', 'medium', 'hard'];
        $type = "multiple";
        $categoryStart = 9;
        $categoryEnd = 32;
        $categories = range($categoryStart, $categoryEnd);
        $questions = [];

        foreach ($categories as $category) {
            foreach ($difficultyLevels as $difficulty) {
                $url = "https://opentdb.com/api.php?amount=$numberOfQuestions&category=$category&difficulty=$difficulty&type=$type";

                dispatch(new SaveQuizJob($url));
                $this->info("Dispatched job for category $category and difficulty $difficulty");
            }
        }
    }
}
