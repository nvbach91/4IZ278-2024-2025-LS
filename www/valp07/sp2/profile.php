<?php
require 'requireUser.php';
require_once 'db/DatabaseConnection.php';
require_once 'db/UsersDB.php';
$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
$name = $usersDB->getUserById($_SESSION['id'])['name'];
$email = $usersDB->getUserById($_SESSION['id'])['email'];
?>
<?php require 'incl/header.php'; ?>
<main class="container pt-3">

  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <p class="fw-bold"><?php echo $name ?></p>
      </div>
      <div class="mb-3">
        <p class="fw-bold"><?php echo $email ?></p>
      </div>
      <hr>
      <p>Change password</p>
      <div class="mb-3">
        <input type="password" class="form-control" placeholder="old password ">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" placeholder="new password">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" placeholder="new password again">
      </div>
      <div class="mb-3">
        <button class="btn btn-outline-secondary">change password</button>
      </div>
      <hr>
      <?php if ($current_user['role'] === 'admin') : ?>
      <div class="mb-3">
        <button class="btn btn-outline-warning w-100">edits products button (if admin)</button>
      </div>
      <div class="mb-3">
        <button class="btn btn-outline-warning w-100">edits orders button (if admin)</button>
      </div>
      <?php endif; ?>
    </div>

    <div class="col-md-8">
      <div class="border p-3 mb-3">
        <div class="row fw-bold mb-2 text-center">
          <div class="col">order id</div>
          <div class="col">date</div>
          <div class="col">item</div>
          <div class="col">price</div>
          <div class="col">status</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'incl/footer.php'; ?>