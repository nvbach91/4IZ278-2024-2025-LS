<?php

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
$stmt->execute([
    'id' => $_SESSION['id']
]);

$current_user = $stmt->fetchAll()[0];

if (!$current_user || $current_user['role'] !== 'admin') {
    session_destroy();
    header('Location: index.php');
    exit;
}

?>