<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Answer</title>
</head>
<body>

<h1>Post a New Answer</h1>

<!-- Debugging: Display Question ID (Remove this after testing) -->
<p>Debug: Question ID = {{ $question_id }}</p>

<form action="/answers/post/{{ $question_id }}" method="POST">
    <!-- CSRF Protection -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

    <!-- Hidden Question ID -->
    <input type="hidden" name="question_id" value="{{ $question_id }}">

    <br>

    <label for="message">Message:</label>
    <textarea name="message" required></textarea>

    <br>

    <button type="submit">Submit</button>
</form>

<br>

<!-- Ensure the correct Question ID is used -->
<a href="/questions">Back to Questions List</a>

</body>
</html>