<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div>
        <a href="/">Home</a>
    </div>
    <div>
        @if(isset($_SESSION['user_id']))
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endif
        <a href="/tags">Tags</a>
    </div>
</div>

<div class="container">
    <h1>Welcome</h1>

    <!-- Check Questions Button -->
    <a href="/questions">
        <button>Check Questions</button>
    </a>
</div>

</body>
</html>