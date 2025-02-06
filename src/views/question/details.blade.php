<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>

<div class="question">
    <h2>{{ $question->title }}</h2>
    <p>{{ $question->message }}</p>
    <p><strong>Votes:</strong> {{ $question->vote_number }}</p>
    <p><strong>Submitted on:</strong> {{ $question->submission_time }}</p>
</div>

<a href="/questions">Back to questions list</a>
</body>
</html>