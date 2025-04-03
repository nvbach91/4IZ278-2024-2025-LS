<?php require __DIR__ . '/config/global.php'; ?>
<?php require __DIR__ . '/db/ProductsDB.php'; ?>
<?php require_once __DIR__ . '/db/DatabaseConnection.php'; ?>               
<?php
$name = @$_POST['name'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   setcookie("name", $_POST['name'], time() + 3600);
   header('Location: index.php');
   exit();
}
?>
<?php require './incl/header.php'; ?>
   <main class="container">
      <h1>Login</h1>
      <form method="POST">
         <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" id="name" name="name" placeholder="Name">
         </div>
         <button type="submit" class="btn btn-primary">Submit</button>  
      </form>
      <div style="margin-bottom: 600px"></div>
   </main>



<?php require __DIR__ . '/incl/footer.php'; ?>
