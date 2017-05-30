<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Welcome Registration.</h2>

<div>
    Hello {{ $user->username }}! <br/><br/>

    <p>Thank for registration.</p>

    <p>Please click on this link to verify your account.</p>

    <p><a href="{{ $link }}">{{ $link }}</a></p>

    <p>PlayOrGo Team!</p>
</div>
</body>
</html>