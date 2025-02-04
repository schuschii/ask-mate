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
    <title>Delete Answer</title>
</head>
<body>
<h1>Confirm Delete</h1>
<p>Are you sure you want to delete this answer?</p>

<form action="/answer/delete" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

    <input type="hidden" name="id" value="<?= $answer->id ?>">
    <input type="hidden" name="question_id" value="<?= $answer->id_question ?>">

    <button type="submit">Yes, Delete</button>
</form>

<br>
<a href="/question/view?id=<?= $answer->id_question ?>">Cancel</a>
</body>
</html>