<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class aiController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function nicknames(Request $request)
    {
        $prompt = file_get_contents(base_path('prompts/getNickNames.txt'));
        /*$result = $this->aiService->generateText($prompt);

        return $result;*/

        $faker = \Faker\Factory::create();
        $words = [];
        $existingUsers = \App\Models\User::pluck('name')->toArray(); // Assuming you have a User model with a 'username' field

        while (count($words) < 15) {
            $username = $faker->userName;
            if (!in_array($username, $existingUsers)) {
                array_push($words, $username);
            }
        }

        return $words;
    }

    public function errorList(Request $request)
    {
        $requestData = $request->json()->all();
        $prompt = str_replace("{device}", $requestData['device'], file_get_contents(base_path('prompts/getErrorList.txt')));
        $prompt = str_replace("{language}", $requestData['language'], $prompt);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. config('services.huggingface.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api-inference.huggingface.co/models/' . config('services.huggingface.model') .'/v1/chat/completions', [
            'model' => 'mistralai/Mixtral-8x7B-Instruct-v0.1',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $prompt
                ],
            ],
            'temperature' => 0.5,
            'max_tokens' => 1024,
            'top_p' => 0.7,
            'stream' => false
        ]);

        return $response->json();
    }
}
