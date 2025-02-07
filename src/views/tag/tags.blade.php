<!DOCTYPE html>
<html>
<head>
    <title>Tags</title>
</head>
<body>

<h1>Tags</h1>
<a class="button-add" href="/tag/create">Add new Tag</a>

<div class="container">
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
                    <button class="button-delete" type="submit" >Delete</button>
                </form>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
</div>

</body>
</html>