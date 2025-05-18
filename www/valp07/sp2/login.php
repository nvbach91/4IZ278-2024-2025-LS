<?php require __DIR__ . '/config/db.php'; ?>
<?php require __DIR__ . '/db/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/db/DatabaseConnection.php'; ?>          
<?php
$db = new PDO(
    'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE . ';charset=utf8mb4',
    DB_USERNAME,
    DB_PASSWORD
);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_user && password_verify($password, $existing_user['password_hash'])) {
            $_SESSION['id'] = $existing_user['id'];
            $_SESSION['user_email'] = $existing_user['email'];

            header('Location: index.php');
            exit;
        } else {
            header('HTTP/1.1 401 Unauthorized');
            exit('Invalid login');
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        exit('Missing email or password.');
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
