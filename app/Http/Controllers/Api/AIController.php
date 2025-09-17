<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    private OpenAIService $openai;

    public function __construct(OpenAIService $openai)
    {
        $this->openai = $openai;
    }

    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $reply = $this->openai->chat($request->input('message'));
        return response()->json(['reply' => $reply]);
    }

    public function summarize(Request $request)
    {
        $request->validate(['text' => 'required|string']);
        $summary = $this->openai->summarize($request->input('text'));
        return response()->json(['summary' => $summary]);
    }
}
