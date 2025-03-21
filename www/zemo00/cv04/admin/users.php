<?php
include __DIR__ . "/../includes/head.html";

require __DIR__ . "/../utilities/user_management.php";

$users = [];

$lines = file('./../users.db');
foreach($lines as $line){
    $fields = explode(';', trim($line));
    $user = [$fields[0], $fields[1], $fields[2]];
    array_push($users, $user);
}


?>

<H1>Users</H1>

<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Password</th>
            <th>Username</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user[0]; ?></td>
                <td><?php echo $user[1];?></td>
                <td><?php echo $user[2];?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>











<?php include __DIR__ . "/../includes/foot.html"; ?>