<!DOCTYPE html>
<html>
<head>
    <title>AI Sentiment & ChatGPT Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h1 class="mb-4">AI Sentiment & ChatGPT Demo</h1>

    <form action="/analyze" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label">Enter text:</label>
            <textarea name="text" id="text" class="form-control" rows="3">{{ old('text', $text ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="mode" class="form-label">Choose Mode:</label>
            <select name="mode" id="mode" class="form-select">
                <option value="local" {{ (isset($mode) && $mode == 'local') ? 'selected' : '' }}>Local Sentiment (Python)</option>
                <option value="chatgpt" {{ (isset($mode) && $mode == 'chatgpt') ? 'selected' : '' }}>ChatGPT API</option>
                <option value="summary" {{ (isset($mode) && $mode == 'summary') ? 'selected' : '' }}>
                    ChatGPT Summarizer
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Analyze</button>
    </form>

    @isset($result)
        <div class="alert alert-info">
            @if($mode == 'local')
                @if(isset($result['sentiment']))
                    <strong>Sentiment:</strong> {{ $result['sentiment'] }} <br>
                    <strong>Score:</strong> {{ $result['score'] }}
                @else
                    <pre>{{ print_r($result, true) }}</pre>
                @endif

            @elseif($mode == 'chatgpt')
                @if(isset($result['response']))
                    <strong>ChatGPT Response:</strong>
                    <p>{{ $result['response'] }}</p>
                @else
                    <pre>{{ print_r($result, true) }}</pre>
                @endif

            @elseif($mode == 'summary')
                @if(isset($result['summary']))
                    <strong>ChatGPT Summary:</strong>
                    <p>{{ $result['summary'] }}</p>
                @else
                    <pre>{{ print_r($result, true) }}</pre>
                @endif
            @endif
        </div>
    @endisset



</body>
</html>
