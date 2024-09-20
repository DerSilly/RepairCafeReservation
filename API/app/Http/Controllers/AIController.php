<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;

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
        $result = $this->aiService->generateText($prompt);

        return $result;
    }
}
