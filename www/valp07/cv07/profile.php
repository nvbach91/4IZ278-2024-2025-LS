<?php
if (!isset($_COOKIE['name'])) {
   header('Location: login.php');
   exit();
}
$name = @$_COOKIE['name'];
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