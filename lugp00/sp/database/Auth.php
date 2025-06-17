<?php
// sp/database/Auth.php

namespace App;

use PDO;
use PDOException;

class Auth {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        // session_start() voláme v headeru nebo přímo v skriptu
        $this->pdo = $pdo;
    }

    /**
     * Standardní login pomocí e-mailu a hesla.
     */
    public function login(string $email, string $password): bool {
        $stmt = $this->pdo->prepare('SELECT id, password, name FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']    = (int)$user['id'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name']  = $user['name'];
            return true;
        }
        return false;
    }

    /**
     * OAuth login: zaloguje uživatele pouze na základě e-mailu (bez kontroly hesla).
     */
    public function loginByEmail(string $email): bool {
        $stmt = $this->pdo->prepare('SELECT id, name FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id']    = (int)$user['id'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name']  = $user['name'];
            return true;
        }
        return false;
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']
            );
        }
        session_destroy();
    }

    public function isLoggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }

    public function isAdmin(): bool {
        if (!$this->isLoggedIn()) return false;
        return in_array($_SESSION['user_email'], ADMIN_USERS, true);
    }
}
