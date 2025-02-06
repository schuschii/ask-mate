<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>

<!-- Create Question Form -->
<form action="/question/add" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br><br>

    <label for="message">Message:</label>
    <textarea name="message" id="message" required></textarea><br><br>

    <!-- ✅ Add Tag Selection Here -->
    <label for="tag">Select Tags (Optional):</label>
    <select name="tag_ids[]" id="tag" multiple> <!-- "multiple" allows multi-select -->
        @foreach ($allTags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select>
    <br><br>

    <input type="submit" value="Submit Question">
</form>

</body>
</html>