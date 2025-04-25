<?php
session_start();
require 'db/DatabaseConnection.php';
require 'db/UsersDB.php';
$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
if (!isset($_SESSION['user_email'])||$usersDB->checkUserPrivilege($_SESSION['user_email']) < 1) {
    header('Location: login.php');
    exit();
}
$name = htmlspecialchars($_SESSION['user_email'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<?php require './incl/header.php'; ?>
   <main class="container">
      <h1>About me</h1>
      <form method="POST">
         <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" id="name" placeholder="Name" value="<?php echo $name; ?>">
            
         </div>
         <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <div style="margin-bottom: 600px"></div>
   </main>
<?php require './incl/footer.php'; ?>