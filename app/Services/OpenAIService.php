<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function chat(string $message): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini', // or 'gpt-4.1'
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        return $response->choices[0]->message->content ?? 'No response';
    }

    public function summarize(string $text): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Summarize the following text:'],
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        return $response->choices[0]->message->content ?? 'No summary';
    }
}
