{{-- resources/views/emails/student-registered.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vítej v naší aplikaci</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6;">
    <h1 style="color: #333;">Ahoj {{ $student->name }},</h1>

    <p>děkujeme Ti za registraci do naší platformy. Tvoje údaje:</p>

    <ul>
        <li><strong>Jméno:</strong> {{ $student->name }}</li>
        <li><strong>E-mail:</strong> {{ $student->email }}</li>
        @if($student->birth_year)
            <li><strong>Rok narození:</strong> {{ $student->birth_year }}</li>
        @endif
    </ul>

    <p>
        Máš rovněž k dispozici svůj profil, kam se můžeš kdykoli přihlásit: 
        <a href="{{ secure_url('/student/login') }}">Přihlásit se</a>.
    </p>

    <hr>

    <p>
        Pokud bys měl(a) jakékoliv dotazy, napiš nám na <a href="mailto:support@mojeapp.cz">support@mojeapp.cz</a>.
    </p>

    <p>S pozdravem,<br>tým Moje Appka</p>
</body>
</html>
