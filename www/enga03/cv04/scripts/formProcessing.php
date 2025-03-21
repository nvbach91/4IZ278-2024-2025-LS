<?php
$errors = [];
$successMessage = '';
$name = $email = $avatarUrl = $password = $confirm_password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $avatarUrl = $_POST['avatarurl'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $result = registerNewUser($name, $email, $password, $avatarUrl);
        if ($result === true) {
            $emailBody = "Registration was successful.\n\n";
            $emailBody .= "Here are the details you entered:\n";
            $emailBody .= "Name: " . htmlspecialchars($name) . "\n";
            $emailBody .= "You can now login.";

            mail(
                $email,
                "Registration Successful",
                $emailBody,
                "From: enga03@vse.cz\r\nReply-To: enga03@vse.cz"
            );
            header('Location: ' . getBaseUrl() . '/login.php?registered=true&email=' . urlencode($email));
            exit();
        } else {
            $errors['email'] = $result;
        }
    }
}

function fetchUsers() {
    $users = [];
    $lines = file(__DIR__ . '/../users.db');
    foreach ($lines as $line) {
        $fields = explode(';', $line);
        $users[$fields[0]] = [
            'email' => $fields[0],
            'password' => $fields[1],
            'name' => $fields[2]
        ];
    }
    return $users;
}

function fetchUser($email) {
    $users = fetchUsers();
    return $users[$email] ?? null;
}

function registerNewUser($name, $email, $password, $avatarUrl) {
    $users = fetchUsers();
    if (isset($users[$email])) {
        return 'Email is already registered.';
    }
    $record = implode(';', [$email, $password, $name, $avatarUrl]) . "\n";
    if (file_put_contents(__DIR__ . '/../users.db', $record, FILE_APPEND) === false) {
        return 'Failed to write to users.db';
    }
    return true;
}

function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    return $protocol . $domainName . $scriptName;
}
?>