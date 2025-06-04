<?php

function sendVerificationMail(string $recipient, $token): void {
    $url = "https://eso.vse.cz/~zemo00/sp/verify?token=" . urlencode($token);
    $message = "
    <html>
    <body>
    <p>Hello,</p>
    <br>
    <p>by clicking on this button, you will verify your email address:</p>
    <a href=\"$url\" style=\"
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background-color: #007BFF;
        text-decoration: none;
        border-radius: 5px;
    \">Verify Email</a>
    </body>
    </html>
    ";

    $headers = implode("\r\n", [
        "MIME-version: 1.0",
        "Content-type:text/html;charset=UTF-8",
        "From: zemo00@vse.cz"
    ]);

    mail(
        $recipient,
        "Verify your email",
        $message,
        $headers
    );
}

?>