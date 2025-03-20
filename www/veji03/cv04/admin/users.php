<?php
function fetchUsers() {
    $users = [];
    $lines = file('../users.db');
    foreach($lines as $line) {
        $fields = explode(';',$line);
        $user = [];
        $user['name'] = $fields[0];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

$users = fetchUsers();

?>



<div class="container mt-5">
    <h2>Seznam uživatelů</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['name']) ?>, <?= htmlspecialchars($user['email']) ?></li>
        <?php endforeach; ?>
    </ul>
</div>

