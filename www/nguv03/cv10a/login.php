<?php require_once __DIR__ . '/database/UsersDB.php'; ?>

<?php

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usersDB = new UsersDB();
    $user = $usersDB->findOneByEmail($email); // null or user
    if ($user == null) {
        echo 'User not found';
        exit;
    }
    $isPasswordCorrect = password_verify($password, $user['password']);
    if (!$isPasswordCorrect) {
        echo 'Password is incorrect';
        exit;
    }
    echo 'User authenticated';
    session_start();
    $_SESSION['username'] = $user['email'];
    $_SESSION['privilege'] = $user['privilege'];
    header('Location: ./profile.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div>
            <label>Email</label>
            <input name="email" type="email">
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password">
        </div>
        <button>Submit</button>
    </form>
</body>
</html>