<?php
require_once __DIR__ . '/../../database-config/UsersDB.php';

function handleRegistration(): array {
    $usersDB = new UsersDB();
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (!$name || !$email || !$password || !$password2) {
            $error = 'Vyplňte všechna pole.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Neplatný e-mail.';
        } elseif (strlen($password) < 6) {
            $error = 'Heslo musí mít alespoň 6 znaků.';
        } elseif ($password !== $password2) {
            $error = 'Hesla se neshodují.';
        } elseif ($usersDB->findByEmail($email)) {
            $error = 'Tento e-mail již je registrovaný.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $ok = $usersDB->insert($name, $email, $passwordHash);

            $to = $email;
            $subject = "Registrace Deskovkárna";
            $message = "Dobrý den $name,\n\nděkujeme za registraci na našem webu.";
            $headers = "From: adaj12@vse.cz";

            $headers .= "MIME-Version: 1.0";

            $headers .= "Content-Type: text/plain; charset=UTF-8";
            
            if ($ok) {
                $success = 'Registrace byla úspěšná, nyní se můžete přihlásit.';
            } else {
                $error = 'Registrace selhala.';
            }
        }
    }

    return [$error, $success];
}
