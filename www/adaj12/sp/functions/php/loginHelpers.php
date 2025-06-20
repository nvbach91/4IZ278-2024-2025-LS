<?php
require_once __DIR__ . '/../../database-config/UsersDB.php';

function handleLogin() {
    $usersDB = new UsersDB();
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = $usersDB->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_avatar'] = $user['avatar'] ?? '';
            $_SESSION['user_role'] = $user['role'] ?? 'user';

            // Přesměrování podle role:
            if ($_SESSION['user_role'] === 'admin') {
                header('Location: /~adaj12/test/admin/admin.php');
                exit;
            } else {
                header('Location: /~adaj12/test/pages/user.php');
                exit;
            }
        } else {
            $error = 'Neplatný e-mail nebo heslo.';
        }
    }
    return $error;
}
