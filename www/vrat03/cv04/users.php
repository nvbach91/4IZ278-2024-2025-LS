<?php

function fetchUsers() {
    $users = [];
    $lines = file('./users.db');
    foreach($lines as $line) {
        $fields = explode(';',trim($line));
        $user = [];
        $user['name'] = $fields[0];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class=users>
<h1>Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach(fetchUsers() as $user): ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>