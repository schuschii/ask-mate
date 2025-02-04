<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Answer</title>
</head>
<body>
<h1>Post a New Answer</h1>

<form action="/answers/post" method="POST">
    <!-- CSRF Protection -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

    <!-- Auto-fill Question ID if available -->
    <label for="question_id">Question ID:</label>
    <input type="number" name="question_id" value="<?php echo $_GET['question_id'] ?? ''; ?>" required readonly>

    <br>

    <label for="message">Message:</label>
    <textarea name="message" required></textarea>

    <br>

    <button type="submit">Submit</button>
</form>

<br>
<a href="/answers/list">Back to Answers List</a>
</body>
</html>