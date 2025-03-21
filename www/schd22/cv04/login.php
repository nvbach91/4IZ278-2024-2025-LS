
<?php

require './utils/utils.php';

$errors = [];
$isSubmittedForm = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($isSubmittedForm) {
  // Načtení hodnot z formuláře a sanitizace
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));
  $authentication = authenticate($email, $password);
  
  // Test validity
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email is not valid';
  }
  if (strlen($password) < 4) {
    $errors['password'] = 'Password is too short';
  }

  // Test prázdných polí
  if (empty($email)) {
    $errors['email'] = 'Please fill in the email';
  }
  if (empty($password)) {
    $errors['password'] = 'Please fill in the password';
  }

  //email not registered
  $users = fetchUsers();
  if (!array_key_exists($email, $users)) {
    $errors['email'] = 'Email not registered. Please register first.';
  }

  // Pokud nejsou žádné chyby
  if (!$authentication['success']) {
    $errors['authentication'] = $authentication['msg'];
      } else {
    header('Location: profile.php');
    exit();
    }
}



?>


<?php include './incl/header.php'; ?>
<body>
    <h1>Log in</h1>
    <form method="POST" action="<?php echo  $_SERVER['PHP_SELF'] ?>">
    <div class="container">
      
      <div class="mb3">
            <label for="exampleInputEmail">Email address</label>
            <input 
                name = "email"
                class="form-control"
                placeholder="Enter email"
                value="<?php echo isset($email) ? $email : ''; ?>">
      </div>
      <?php if(isset($errors['email'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
      <?php endif; ?>

    <div class="mb3">
            <label for="exampleInputPassword">Password</label>
            <input 
                name = "password"
                class="form-control"
                placeholder="Password"
                value="<?php echo isset($password) ? $password : ''; ?>">
        </div>
        <?php if(isset($errors['password'])) : ?>
          <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
        <?php endif; ?>
        </div>

        <div class="button">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </div>
    </form>

<?php include './incl/footer.php'; ?>