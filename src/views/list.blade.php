<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answers List</title>
</head>
<body>
<h1>All Answers</h1>

<table >
    <thead>
    <tr>
        <th>ID</th>
        <th>Question ID</th>
        <th>User ID</th>
        <th>Message</th>
        <th>Votes</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($answers as $answer)
        <tr>
            <td>{{ $answer->id }}</td>
            <td>{{ $answer->id_question }}</td>
            <td>{{ $answer->id_registered_user }}</td>
            <td>{{ $answer->message }}</td>
            <td>{{ $answer->vote_number }}</td>
            <td>
                <!-- Edit Answer Button -->
                <a href="/answer/edit?id={{ $answer->id }}">Edit</a> |

                <!-- Delete Answer Form -->
                <form action="/answer/delete" method="POST" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="{{ $_SESSION['csrf_token'] ?? '' }}">
                    <input type="hidden" name="id" value="{{ $answer->id }}">
                    <input type="hidden" name="question_id" value="{{ $answer->id_question }}">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>
<a href="/answer/create">Add a New Answer</a>
</body>
</html>