<?php
if (!isset($answer)) {
    die("Answer not found.");
}
?>

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Answer</title>
</head>
<body>
<h1>Edit Your Answer</h1>

<form action="/answer/update/id/{{$answer->id}}" method="POST">
    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

    <!-- Hidden Fields for IDs -->
    <input type="hidden" name="id" value="<?= $answer->id ?>">
    <input type="hidden" name="question_id" value="<?= $answer->id_question ?>">

    <!-- Editable Textarea for Answer Message -->
    <label for="message">Message:</label>
    <textarea name="message" required><?= htmlspecialchars($answer->message) ?></textarea>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="/answers/list/{{$answer->id_question}}">Cancel</a>
</body>
</html>