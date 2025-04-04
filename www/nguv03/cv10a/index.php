<?php require_once __DIR__ . '/database/UsersDB.php'; ?>
<?php
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $privilege = 0; // normal user
    $usersDB = new UsersDB();
    $usersDB->create([
        'email' => $email,
        'password' => $password,
        'name' => $name,
        'privilege' => $privilege,
    ]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>User registration + password hashing</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label>Email</label>
            <input name="email" type="email">
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password">
        </div>
        <div>
            <label>Name</label>
            <input name="name">
        </div>
        <button>Submit</button>
    </form>
</body>
</html>