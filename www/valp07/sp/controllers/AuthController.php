<?php

namespace Controllers;

use DatabaseConnection;
use PDO;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../db/UsersDB.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';

class AuthController
{

    public function login()
    {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email'], $_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $usersDB = new \UsersDB(DatabaseConnection::getPDOConnection());
                $users = $usersDB->findUserByEmail($email);
                $existing_user = $users[0] ?? null;

                if ($existing_user && password_verify($password, $existing_user['password_hash'])) {
                    $_SESSION['id'] = $existing_user['id'];
                    $_SESSION['user_email'] = $existing_user['email'];
                    header('Location: index.php');
                    exit;
                } else {
                    http_response_code(401);
                    exit('Invalid login');
                }
            } else {
                http_response_code(400);
                exit('Missing email or password.');
            }
        }

        require __DIR__ . '/../views/login.view.php';
    }

    public function register()
    {
        require_once __DIR__ . '/../db/DatabaseConnection.php';
        require_once __DIR__ . '/../db/UsersDB.php';

        $connection = DatabaseConnection::getPDOConnection();
        $usersDB = new \UsersDB($connection);

        $error = null;
        $email = '';
        $name = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST['email'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format!";
            } elseif ($password !== $confirmPassword) {
                $error = "Passwords do not match!";
            } else {
                try {
                    if ($usersDB->findUserByEmail($email)) {
                        $error = "Email is already registered!";
                    } else {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $usersDB->create([
                            'name' => $name,
                            'email' => $email,
                            'password' => $hashedPassword,
                        ]);

                        header('Location: index.php');
                        exit();
                    }
                } catch (\Exception $e) {
                    $error = "Registration failed. Please try again later.";
                }
            }
        }

        require __DIR__ . '/../views/registration.view.php';
    }
    public function requestReset()
    {
        $usersDB = new \UsersDB(DatabaseConnection::getPDOConnection());

        $resetLink = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $user = $usersDB->findUserByEmail($email);
            $user = $user[0] ?? null;

            if ($user) {
                $resetLink = $usersDB->resetPassword($user['id']);

                $to = $user['email'];
                $subject = "Your Password Reset Link";
                $message = "Hi " . htmlspecialchars($user['name']) . ",\n\n";
                $message .= "You requested a password reset. Click the link below to reset your password:\n";
                $message .= $resetLink . "\n\n";
                $message .= "If you didn’t request this, you can safely ignore this message.";

                $headers = "From: mock-eshop@example.com\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8";

                mail($to, $subject, $message, $headers);
            } else {
                $error = 'No user found with that email.';
            }
        }

        require __DIR__ . '/../views/request-reset.view.php';
    }
    public function resetPassword()
    {
        require_once __DIR__ . '/../db/DatabaseConnection.php';
        require_once __DIR__ . '/../db/UsersDB.php';

        $connection = \DatabaseConnection::getPDOConnection();
        $usersDB = new \UsersDB($connection);

        $token = $_GET['token'] ?? '';
        $newPassword = null;
        $error = null;

        if (!$token) {
            $error = 'Invalid or missing reset token.';
        } else {
            $stmt = $connection->prepare("SELECT * FROM users WHERE reset_token = :token");
            $stmt->execute(['token' => $token]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user) {
                $error = 'This reset link is invalid or expired.';
            } else {
                $newPassword = bin2hex(random_bytes(8));
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateStmt = $connection->prepare("UPDATE users SET password_hash = :password, reset_token = NULL WHERE id = :id");
                $updateStmt->execute([
                    'password' => $passwordHash,
                    'id' => $user['id']
                ]);
            }
        }

        require __DIR__ . '/../views/reset-password.view.php';
    }
}
