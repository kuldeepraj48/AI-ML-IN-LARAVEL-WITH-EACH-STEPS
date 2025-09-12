<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\AiLog;
use Illuminate\Support\Facades\Http;

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


    //New one.................showForm_second_old_workng fine........................
    public function showForm_second_old()
    {
        return view('analyze');
    }

    public function handleForm_second_old(Request $request)
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
    public function analyze_second_old(Request $request)
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

    //with database connection new changes...........................................
    public function showForm()
    {
        return view('analyze');
    }

    public function handleForm(Request $request)
    {
        $text = $request->input('text');
        $mode = $request->input('mode', 'local');

        $result = $this->processAI($text, $mode);

        return view('analyze', [
            'text'   => $text,
            'mode'   => $mode,
            'result' => $result
        ]);
    }

    // API endpoint (ChatGPT default)
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

    // API endpoint with mode
    public function apiProcess(Request $request)
    {
        $text = $request->input('text');
        $mode = $request->input('mode', 'local');

        $result = $this->processAI($text, $mode);

        return response()->json($result);
    }

    private function processAI($text, $mode)
    {
        $result = null;

        if ($mode === 'local') {
            // Run local Python ML
            $escapedText = escapeshellarg($text);
            $python = "python"; // or "py"
            $script = base_path("ml/sentiment.py");
            $command = "$python $script $escapedText 2>&1";
            $output  = shell_exec($command);
            $result  = json_decode($output, true);

            if (!$result) {
                $result = ['error' => 'Local ML script failed'];
            }

        } elseif ($mode === 'chatgpt') {
            // ChatGPT general response
            try {
                //old backup with dynamic values
                // $chat = OpenAI::chat()->create([
                //     'model' => 'gpt-3.5-turbo',
                //     'messages' => [
                //         ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                //         ['role' => 'user', 'content' => $text],
                //     ],
                // ]);
                //New code as per response
                $chat = OpenAI::chat()->create([
                    'model' => 'gpt-4o-mini', // free tier model (if quota available)
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => 'Hello OpenAI, can you reply?'],
                    ],
                ]);
                $result = ['response' => $chat->choices[0]->message->content];
            } catch (\Exception $e) {
                $result = ['error' => 'ChatGPT failed: ' . $e->getMessage()];
            }

        } elseif ($mode === 'summary') {
            // ChatGPT summarizer
            try {
                $chat = OpenAI::chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Summarize this text in 3 sentences.'],
                        ['role' => 'user', 'content' => $text],
                    ],
                ]);
                $result = ['summary' => $chat->choices[0]->message->content];
            } catch (\Exception $e) {
                $result = ['error' => 'Summarization failed: ' . $e->getMessage()];
            }
        }

        // ✅ Save log
        AiLog::create([
            'mode'   => $mode,
            'input'  => $text,
            'output' => json_encode($result),
        ]);

        return $result;
    }
    
}
