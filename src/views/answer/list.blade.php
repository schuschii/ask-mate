
<h1>All Answers</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Votes</th>
        <th>Message</th>
        <th>Username</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($answers as $answer)
        <tr>
            <td>{{ $answer->id }}</td>
            <!--<td>{{ $answer->id_question }}</td> -->
            <td>{{ $answer->vote_number }}</td>
            <td>{{ $answer->message }}</td>
            <td>{{ $answer->email }}</td>
            <td class="horizontal">
                @if(1 == $answer->id_registered_user)
                    <!-- Edit Answer Button -->
                <a class="button-neutral" href="/answer/edit/id/{{$answer->id }}">Edit</a>

                <!-- Delete Answer Form -->
                 {{-- Change 1 to $_SESSION['user_id'] when authentication is implemented --}}
                <form action="/delete/answer_id/{{$answer->id}}" method="POST" style="display:inline;"
                      onsubmit="return confirmDelete({{ $answer->id }})">
                    <input type="hidden" name="csrf_token" value="{{ $_SESSION['csrf_token'] ?? '' }}">
                    <input type="hidden" name="id" value="{{ $answer->id }}">
                    <input type="hidden" name="question_id" value="{{ $answer->id_question }}">
                    <button class="button-delete" type="submit">Delete</button>
                </form>
                @else
                <div style="padding: 10px">&nbsp;</div>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


<!-- JavaScript for Delete Confirmation -->
<script>
    function confirmDelete(answerId) {
        return confirm("Are you sure you want to delete answer ID: " + answerId + "? This action cannot be undone.");
    }
</script>
