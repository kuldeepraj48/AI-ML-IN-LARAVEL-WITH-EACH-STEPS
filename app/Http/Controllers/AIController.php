<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class AIController extends Controller
{
    // API Endpoint (already working)
    public function analyze_old(Request $request)
    {
        $text = $request->input('text');
        $escapedText = escapeshellarg($text);

        $python = "python"; // or "py" if that's your working command
        $script = base_path("ml/sentiment.py");

        $command = "$python $script $escapedText 2>&1";
        $output  = shell_exec($command);

        if (!$output) {
            return response()->json([
                "error" => "ML script failed",
                "cmd"   => $command,
                "cwd"   => getcwd()
            ]);
        }

        return response($output, 200)
            ->header('Content-Type', 'application/json');
    }

    // Web form handler
    public function showForm_old()
    {
        return view('analyze');
    }

    public function handleForm_old(Request $request)
    {
        $text = $request->input('text');
        $escapedText = escapeshellarg($text);

        $python = "python"; // or "py"
        $script = base_path("ml/sentiment.py");

        $command = "$python $script $escapedText 2>&1";
        $output  = shell_exec($command);

        $result = json_decode($output, true);

        return view('analyze', [
            'text'   => $text,
            'result' => $result
        ]);
    }


    //New one.........................................
    public function showForm()
    {
        return view('analyze');
    }

    public function handleForm(Request $request)
    {
        $text = $request->input('text');
        $mode = $request->input('mode', 'local'); // default local

        $result = null;

        if ($mode === 'local') {
            // Run Python sentiment analysis
            $escapedText = escapeshellarg($text);
            $python = "python"; // or "py"
            $script = base_path("ml/sentiment.py");
            $command = "$python $script $escapedText 2>&1";
            $output  = shell_exec($command);

            $result = json_decode($output, true);

            if (!$result) {
                $result = [
                    'error' => 'Local ML script failed or returned no result'
                ];
            }
        } elseif ($mode === 'chatgpt') {
            try {
                $chat = OpenAI::chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $text],
                    ],
                ]);
                $result = [
                    'response' => $chat->choices[0]->message->content ?? null,
                ];
            } catch (\Exception $e) {
                $result = [
                    'error' => 'OpenAI API failed: ' . $e->getMessage()
                ];
            }
        }
        return view('analyze', [
            'text'   => $text,
            'mode'   => $mode,
            'result' => $result
        ]);
    }


    // API endpoint
    public function analyze(Request $request)
    {
        $text = $request->input('text');
        $chat = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        return response()->json([
            'response' => $chat->choices[0]->message->content
        ]);
    }
}
