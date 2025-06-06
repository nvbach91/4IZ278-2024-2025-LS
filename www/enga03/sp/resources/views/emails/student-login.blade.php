<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Information</title>
</head>
<body style="font-family: sans-serif; line-height:1.6;">
    <p>Hello {{ $student->name }},</p>
    <p>thank you for registering. You can log in using the link below:</p>
    <p><a href="{{ secure_url('/student/login') }}">Log in to your account</a></p>
</body>
</html>
