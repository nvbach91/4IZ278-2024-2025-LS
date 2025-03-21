<?php

require_once '../functions.php';
$users = fetchUsers();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Seznam uživatelů</title>
</head>
<body>
    <h1>Registrovaní uživatelé</h1>
    <?php if(empty($users)): ?>
        <p>Žádní uživatelé nejsou registrováni.</p>
    <?php else: ?>
        <ul>
            <?php foreach($users as $user): ?>
                <li><?php echo htmlspecialchars($user['name'] . " - " . $user['email']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
