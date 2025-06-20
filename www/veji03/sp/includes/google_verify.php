<?php
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['credential'] ?? '';

    if ($token) {
        $clientId = '93214513756-blv2f9oqtouqn7drk8ku497udj6r5rp3.apps.googleusercontent.com';

        $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($token);
        $response = file_get_contents($url);
        $payload = json_decode($response, true);

        if ($payload && $payload['aud'] === $clientId) {
            $email = $payload['email'];
            $firstName = $payload['given_name'] ?? '';
            $lastName = $payload['family_name'] ?? '';

            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user) {
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, address, is_admin) VALUES (?, ?, ?, '', '', 0)");
                $stmt->execute([$firstName, $lastName, $email]);
                $userId = $pdo->lastInsertId();
            } else {
                $userId = $user['id'];
            }

            $_SESSION['user'] = [
                'id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'is_admin' => $user['is_admin'] ?? 0
            ];

            header("Location: index.php");
            exit;
        }
    }
}

