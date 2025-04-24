<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="navbar-left">
        <a class="nav-link" href="/">Home</a>
    </div>
    <div class="navbar-right">
        @if(isset($_SESSION['user']))
            <a class="nav-link" href="/logout">Logout</a>
        @else
            <a class="nav-link" href="/user/login">Login</a>
            <a class="nav-link" href="/user/register">Register</a>
        @endif
        <a class="nav-link" href="/tags">Tags</a>
    </div>
</div>


</body>
</html>