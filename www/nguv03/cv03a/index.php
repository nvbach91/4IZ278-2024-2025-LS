<?php
$correctEmail = 'abc@def.com';
$correctPassword = '12345678';

// var_dump($_POST);
// var_dump($_GET);
$isSubmittedForm = !empty($_POST);
$errors = [];

if ($isSubmittedForm) {
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));
  $type = htmlspecialchars(trim($_POST['type']));
  $phone = htmlspecialchars(trim($_POST['phone']));
  // ???
  // a) hash - v databazi se budou ukladat hesla, v zahasovane podobe
  // b) + check existence user
  // c) + validate email format (account@domain.realm, david@seznam.cz)
  // d) + display form data errors
  // e) + clean data
  // ...
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // chyba => zobrazit
    $errors['email'] = 'Invalid email';
  }

  if ($email != $correctEmail) {
    $errors['email'] = 'Email does not exist';
  }
  if ($password != $correctPassword) {
    $errors['password'] = 'Password is incorrect';
  }

  // regular expressions
  // +420 776 456 789
  // '/^\+[0-9]$/'
  if (!preg_match('/^(\+\d{3} ?)?\d{3} ?\d{3} ?\d{3}$/', $phone)) {
    $errors['phone'] = 'Phone has incorrect format';
  }

  if (empty($errors) && $email == $correctEmail && $password == $correctPassword) {
    // login success
    // => redirect to a different page + initiate session
    header('Location: ./profile.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
</head>
<body>
  <main class="container">
    <h1>PHP Form data processing</h1>
    <!--
    <?php foreach($errors as $error) : ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endforeach; ?>
    -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <?php if (isset($errors['email'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input
          name="email"
          class="form-control"
          value="<?php echo isset($email) ? $email : ''; ?>"
        >
      </div>
      <?php if (isset($errors['password'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input
          name="password"
          type="password"
          class="form-control"
        >
      </div>
      <?php if (isset($errors['phone'])) : ?>
        <div class="alert alert-danger"><?php echo $errors['phone']; ?></div>
      <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Phone number</label>
        <input
          name="phone"
          class="form-control"
          value="<?php echo isset($phone) ? $phone : ''; ?>"
        >
      </div>
      <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-control">
          <option value="A"<?php echo isset($type) && $type == 'A' ? ' selected' : '' ?>>A</option>
          <option value="B"<?php echo isset($type) && $type == 'B' ? ' selected' : '' ?>>B</option>
          <option value="C"<?php echo isset($type) && $type == 'C' ? ' selected' : '' ?>>C</option>
        </select>
      </div>
      <button class="btn btn-primary">Submit</button>
    </form>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>