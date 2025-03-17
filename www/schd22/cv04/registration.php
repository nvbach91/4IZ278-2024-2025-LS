<?php 

require './utils/utils.php';

$errors = [];
$isSubmittedForm = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isSubmittedForm) {
  // Načtení hodnot z formuláře a sanitizace
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));
  $repeatpassword = htmlspecialchars(trim($_POST['repeatpassword']));
  $name = htmlspecialchars(trim($_POST['name']));

  // Test validity
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not valid';
  }
  if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
    $errors['name'] = 'Name is not valid';
  }
  if (strlen($password) < 4) {
    $errors['password'] = 'Password is too short';
  }
  if (strlen($repeatpassword) < 4) {
    $errors['repeatpassword'] = 'Password is too short';
  }

  // Test prázdných polí
  if (empty($email)) {
    $errors['email'] = 'Please fill in the email';
  }
  if (empty($password)) {
    $errors['password'] = 'Please fill in the password';
  }
  if (empty($name)) {
    $errors['name'] = 'Please fill in the name';
  }
  if (empty($repeatpassword)) {
    $errors['repeatpassword'] = 'Please fill in the password';
  }

  //email taken
  $users = fetchUsers();
  if (array_key_exists($email, $users)) {
    $errors['email'] = 'Email already registered. Please use another email address.';
  }

  //passwords do not match
  if ($password !== $repeatpassword) {
    $errors['repeatpassword'] = 'Passwords do not match';
  }

  // Pokud nejsou žádné chyby, uložíme uživatele
  if (empty($errors)) {
    $registerNewUser = registerNewUser($_POST);
    if ($registerNewUser['success']) {
        header('Location: login.php');

    }
}
}

?>

<?php include './incl/header.php'; ?>
<body>
    <h1>Registration</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <div class="container">
      <div class="mb3">
        <label for="exampleInputName">Name</label>
        <input 
            name="name"
            class="form-control"
            placeholder="Name"
            value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
      </div>
      <?php if (isset($errors['name'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['name']; ?></div>
      <?php endif; ?>
      
      <div class="mb3">
            <label for="exampleInputEmail">Email address</label>
            <input 
                name="email"
                class="form-control"
                placeholder="Enter email"
                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
      </div>
      <?php if (isset($errors['email'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
      <?php endif; ?>

    <div class="mb3">
        <label for="exampleInputPassword">Password</label>
        <input 
            name="password"
            type="password"
            class="form-control"
            placeholder="Password">
            <div id="min" class="form-text">Minimal password length: 4</div>
    </div>
    <?php if (isset($errors['password'])) : ?>
      <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
    <?php endif; ?>

    <div class="mb3">
        <label for="exampleInputPassword">Repeat Password</label>
        <input 
            name="repeatpassword"
            type="repeatpassword"
            class="form-control"
            placeholder="Password">
    </div>
    <?php if (isset($errors['repeatpassword'])) : ?>
      <div class="alert alert-danger"><?php echo $errors['repeatpassword']; ?></div>
    <?php endif; ?>
    </div>
    <div class="button">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </div>
    </form>

<?php include './incl/footer.php'; ?>
