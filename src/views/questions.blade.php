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

<!-- Search Form -->
<form action="/search" method="GET">
    <input type="text" name="q" placeholder="Search questions"/>
    <button type="submit">Search</button>
</form>

<p></p>
<!-- Question List -->
@foreach ($questions as $question)
    <div class="question">
        <h2>{{ $question->title }}</h2>
        <p>{{ $question->message }}</p>
        <p><strong>Votes:</strong> {{ $question->vote_number }}</p>
        <p><strong>Submitted on:</strong> {{ $question->submission_time }}</p>
        <a href="/create/{{ $question->id }}">Add a New Answer</a>
        <a href="/question/edit/{{ $question->id }}">Edit</a>
        <a href="/answers/list/{{ $question->id }}"><button>Show Answers</button></a>
        <form action="/question/delete/{{ $question->id }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" >Delete</button>
        </form>
        <hr>
    </div>
@endforeach

</body>
</html>