<!DOCTYPE html>
<html>
<head>
    <title>Tags</title>
</head>
<body>

<h1>Tags</h1>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Number of Questions with this tag</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tags as $tag)
        <tr>
            <td>{{ $tag->id }}</td>
            <td>{{ $tag->name }}</td>
            <td>{{ $tag->question_count ?? 0 }}</td>
            <td>
                <form action="/tag/remove/{{ $tag->id }}" method="POST">
                    <button type="submit" >Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    <a href="/tag/create">Add new Tag</a>
    </tbody>
</table>

</body>
</html>