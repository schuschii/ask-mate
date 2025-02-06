<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>

<p></p>
<a href="/tags">View All Tags</a>


<!-- Search Form -->
<form action="/search" method="GET">
    <input type="text" name="q" placeholder="Search questions"/>
    <button type="submit">Search</button>
</form>

<p></p>
<!-- Question List -->

@foreach ($questions as $question)
    <div class="question">
    <a href="question/{{ $question->id }}">
        <h2>{{ $question->title }}</h2>
    </a>
        <p>{{ $question->message }}</p>
        <p><strong>Votes:</strong> {{ $question->vote_number }}</p>
        <p><strong>Submitted on:</strong> {{ $question->submission_time }}</p>
        <div>
            <p>Tags:</p>
            <ul>
                @foreach ($question->tags as $tag)
                    {{ $tag->name }}
                    <form method="POST" action="/question/{{ $question->id }}/removeTag" style="display:inline;">
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                        <button type="submit">❌ Remove</button>
                    </form>
                @endforeach
            </ul>
            <form method="POST" action="/question/{{ $question->id }}/addTag">
                <input type="hidden" name="question_id" value="{{ $question->id }}">

                <label for="tag-{{ $question->id }}">Add Tag:</label>
                <select name="tag_id" id="tag-{{ $question->id }}">
                    @foreach ($allTags as $tag)
                        @php
                            $isAssigned = false;
                            foreach ($question->tags as $assignedTag) {
                                if ($assignedTag->id == $tag->id) {
                                    $isAssigned = true;
                                    break;
                                }
                            }
                        @endphp

                        @if(!$isAssigned)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endif
                    @endforeach
                </select>

                <button type="submit">➕ Add</button>
            </form>
        </div>

        <hr>
    </div>
@endforeach

</body>
</html>