<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
</head>
<body>
<h1>{{$title}}</h1>

<div class="container">
<form action="/question/edit/{{ $question->id }}" method="POST">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="{{ $question->title }}" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" required>{{ $question->message }}</textarea>

    <button type="submit">Update Question</button>
</form>
</div>

</body>
</html>