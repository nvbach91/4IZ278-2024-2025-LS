<?php require __DIR__ . '/../fileHandling.php'; ?>
<?php
$parsedUsers = fetchUsers();	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../css/adminTable.css">
</head>

<body>
    <h1>Users</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parsedUsers as $user): ?>
                <tr>
                    <td><?= $user["name"] ?></td>
                    <td><?= $user["email"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>