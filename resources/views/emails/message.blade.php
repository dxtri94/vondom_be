<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Contact Message</h2>

<div>
    Hello {{ $name }}!

    <div>
        From <strong>{{ $sender['name'] }} </strong> <<a href="mailto:{{ $sender['email'] }}">{{ $sender['email'] }}</a>>!
    </div>

    <div>Hello Support Team.</div>
    <div>I have some problem. Hope you can help.</div>

    <div style="margin-top: 15px;">Subject: <strong>{{ $sender['subject'] }}</strong></div>
    <div>Message: {{ $sender['message'] }}</div>

    <p>Thanks</p>
</div>
</body>
</html>