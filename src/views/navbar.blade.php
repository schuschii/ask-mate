<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="user/login">Login</a>
            <a href="/user/register">Register</a>
        @endif
        <a href="/tags">Tags</a>
    </div>
</div>

</body>
</html>