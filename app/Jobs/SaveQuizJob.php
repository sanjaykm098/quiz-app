<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Questions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Log;

class SaveQuizJob implements ShouldQueue
{
    use Queueable;
    private $url;
    /**
     * Create a new job instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get($this->url);
        $data = $response->json();
        $questions = $data['results'] ?? [];

        if (empty($questions)) {
            Log::info('No questions found', $data);
            $this->fail('No questions found');
            return;
        }

        foreach ($questions as $question) {
            $categoryName = $question['category'];
            $category = Category::firstOrCreate(['name' => $categoryName]);
            try {
                Questions::updateOrCreate(
                    ['question' => $question['question']],
                    [
                        'category_id' => $category->id,
                        'type' => $question['type'],
                        'difficulty' => $question['difficulty'],
                        'options' => array_merge($question['incorrect_answers'], [$question['correct_answer']]),
                        'answer' => $question['correct_answer'],
                    ]
                );
            } catch (\Throwable $th) {
                Log::error('Error saving question', $question);
            }
        }
    }
}
