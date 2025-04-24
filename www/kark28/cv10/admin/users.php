<?php require __DIR__ . '/../database/UserDB.php';
session_start();
$usersDB = new UserDB();
$priv = 0;
if(isset($_SESSION['name'])) {
$priv = $usersDB->fetchUser($_SESSION['email'])[0]['privilege'];
}
if($priv < 1) {
    header('Location: ./login.php');
    exit();
}
$users = $usersDB->find();
?>

<?php 
$contextPath = '..';
require __DIR__ . '/../includes/header.php'; ?>
<main style="width:80%; margin:auto" class="container">
<h1>Edit users</h1>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<?php foreach($users as $user): ?>
    <div class="card h-100">
<div class="card-body">

<div class="mb-3">
    <label for="price" class="form-label">ID</label>
    <input type="text" class="form-control" name="id" value="<?php echo $user['user_id']?>">
  </div>

<div class="mb-3">
<label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>">
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>">
  </div>

  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>">
  </div>

  <div class="mb-3">
    <label for="phone" class="form-label">Email</label>
    <input type="text" class="form-control" name="phone" value="<?php echo $user['phone']; ?>">
  </div>
 
  <div class="mb-3">
  <label for="select" class="form-label">User Category</label>
  <select class="form-select" name="priv">
  <option value="0" <?php if($user['privilege'] == 0) echo 'selected';?>>User</option>
  <option value="1" <?php if($user['privilege'] == 1) echo 'selected';?>>Manager</option>
  <option value="2" <?php if($user['privilege'] == 0) echo 'selected';?>>Admin</option>
</select>
  </div>
</div>
    </div>
<?php endforeach ?>
<br>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="../index.php">Back to homepage</a>
<br>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>