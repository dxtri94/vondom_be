<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Ignore Report</h2>

<div>
    <p>Hello {{ $reporter->name }}</p>
    <div class="">We have ignored your report with:</div>
    <p>Reason: {{ $reason->name }}</p>
    <p>Comment: {{ $comment }}</p>
</div>

<p>Thanks</p>
</body>
</html>