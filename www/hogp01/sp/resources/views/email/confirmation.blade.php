<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Potvrzení objednávky</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 40px 20px;
            color: #333;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <p class="greeting">Ahoj {{ $order->user->firstname }},</p>

        <div class="message">
            <p>Vaše objednávka č. <strong>{{ $order->id }}</strong> byla úspěšně vytvořena.</p>
            <p>V příloze tohoto e-mailu naleznete kopii faktury ve formátu PDF.</p>
        </div>

        <div class="footer">
            Děkujeme,<br>
            <strong>{{ config('app.name') }}</strong>
        </div>
    </div>
</body>
</html>
