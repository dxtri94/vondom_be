<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Forgot Password</h2>

<div>
    Hello {{ $user->username }}! <br/><br/>

    <p>You requested an reset password. Please click on this link to reset: </p>

    <a href="{{ $link }}">{{$link}}</a>

    <p>PlayOrGo Team!</p>
</div>
</body>
</html>