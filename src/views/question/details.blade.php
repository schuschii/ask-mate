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

    <a href="/question/edit/{{ $question->id }}">Edit</a>

    <form action="/question/delete/{{ $question->id }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" >Delete</button>
    </form>

    <div>
        <p>Tags:</p>
        <ul>
            @foreach ($question->tags as $tag)
                {{ $tag->name }}
                <form method="POST" action="/question/{{ $question->id }}/removeTag" style="display:inline;">
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                    <button type="submit">❌ Remove</button>
                </form>
            @endforeach
        </ul>
    </div>


    <a href="/create/{{ $question->id }}">Add a New Answer</a>

    <!-- Include the answers list -->
    @include('answer.list', ['answers' => $answers])

</div>

<a href="/questions">Back to questions list</a>
</body>
</html>