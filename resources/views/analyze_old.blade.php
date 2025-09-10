<!DOCTYPE html>
<html>
<head>
    <title>Laravel AI/ML Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h1 class="mb-4">AI Sentiment Analyzer</h1>

    <form action="/analyze" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label">Enter text:</label>
            <textarea name="text" id="text" class="form-control" rows="3">{{ old('text', $text ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Analyze</button>
    </form>

    @isset($result)
        <div class="alert alert-info">
            <strong>Sentiment:</strong> {{ $result['sentiment'] }} <br>
            <strong>Score:</strong> {{ $result['score'] }}
        </div>
    @endisset

</body>
</html>
