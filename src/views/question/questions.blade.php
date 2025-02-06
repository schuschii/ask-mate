<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>

<p></p>
<a href="/tags">View All Tags</a>


<!-- Search Form -->
<form action="/search" method="GET">
    <input type="text" name="q" placeholder="Search questions"/>
    <button type="submit">Search</button>
</form>

<p></p>
<!-- Question List -->

@foreach ($questions as $question)
    <div class="question">
    <a href="question/{{ $question->id }}">
        <h2>{{ $question->title }}</h2>
    </a>
        <p>{{ $question->message }}</p>
        <p><strong>Votes:</strong> {{ $question->vote_number }}</p>
        <p><strong>Submitted on:</strong> {{ $question->submission_time }}</p>

        <hr>
    </div>
@endforeach

</body>
</html>