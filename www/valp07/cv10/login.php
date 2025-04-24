<?php require __DIR__ . '/config/global.php'; ?>
<?php require __DIR__ . '/db/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/db/DatabaseConnection.php'; ?>               
<?php
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!empty($email) && !empty($password)) {
        session_regenerate_id(true);
        $_SESSION['user_email'] = $email;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<?php require './incl/header.php'; ?>
   <main class="container">
      <h1>Login</h1>
      <form method="POST">
         <div class="form-group">
            <label for="name">E-mail</label>
            <input class="form-control" id="email" name="email" placeholder="E-mail">
         </div>
        <div class="form-group mb-3">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" required>
        </div>
         <button type="submit" class="btn btn-primary">Submit</button>  
      </form>
   </main>



<?php require __DIR__ . '/incl/footer.php'; ?>
