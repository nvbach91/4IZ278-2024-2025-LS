<?php require 'database/UsersDB.php'?>
<?php

$error = null;

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    if (empty($email) || empty($password) || empty($name)) {
        $error = 'Všechna pole jsou povinná.';
    } else {
        $userDB = new UsersDB();
        $existingUser = $userDB->findOneByEmail($email);

        if ($existingUser) {
            $error = 'Uživatel s tímto emailem již existuje.';
        } else {
            $privilege = 1;
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $userDB->create([
                'email' => $email,
                'password' => $passwordHash,
                'name' => $name,
                'privilege' => $privilege
            ]);
        }
    }
}

?>
<?php require_once 'incl/header.php'; ?>

<div class="container mt-5">
  <h2>Přihlášení</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <label for="name">email</label>
                <input name="email" type="email">
            </div>
            <div>
                <label for="name">password</label>
                <input name="password" type="password">
            </div>
            <div>
                <label for="name">name</label>
                <input name="name">
            </div>
            <button>Submit</button>
        </form>
</div>

