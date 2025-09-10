<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function analyze(Request $request)
    {
        $text = $request->input('text');

        // Always use escapeshellarg for safety
        $escapedText = escapeshellarg($text);

        // Absolute path to Python script
        $python = "python"; // or "py" if that's the only one that works
        $script = base_path("ml/sentiment.py");

        // Build the command safely
        $command = "$python $script $escapedText 2>&1";

        // Execute
        $output = shell_exec($command);

        if (!$output) {
            return response()->json([
                "error" => "ML script failed",
                "cmd"   => $command,   // debug info
                "cwd"   => getcwd()    // debug info
            ]);
        }

        // Return the JSON from Python
        return response($output, 200)
            ->header('Content-Type', 'application/json');
    }
}
