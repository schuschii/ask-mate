<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<div class="navbar">
    <div>
        <a href="/">Home</a>
    </div>
    <div>
        @if(isset($_SESSION['user_id']))
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
            <a href="/user/register">Register</a>
        @endif
    </div>
</div>
<h1>{{ $title }}</h1>

@foreach ($questions as $question)
    <div class="question">
        <h2>{{ $question->title }}</h2>
        <p>{{ $question->message }}</p>
        <p><strong>Votes:</strong> {{ $question->vote_number }}</p>
        <p><strong>Submitted on:</strong> {{ $question->submission_time }}</p>
        <a href="/create/{{ $question->id }}">
            Add a New Answer
        </a>
        <a href="/question/edit/{{ $question->id }}">Edit</a>
        <a href="/answers/list/{{ $question->id }}">
            <button>Show Answers</button>
        </a>
        <form action="/question/delete/{{ $question->id }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" >Delete</button>
        </form>
        <hr>
    </div>
@endforeach

</body>
</html>