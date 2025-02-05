<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>


<form action="/add-question" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br><br>

    <label for="message">Message:</label>
    <textarea name="message" id="message" required></textarea><br><br>

    <input type="submit" value="Submit Question">
</form>
</body>
</html>
