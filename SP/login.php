<?php require __DIR__ . '/Database/DB_Scripts/UserDB.php'; ?>
<?php require __DIR__ . '/includes/head.php'; ?>

<?php   
    if(isset($_SESSION["registrationSuccess"])) {
        $registrationSuccess = $_SESSION["registrationSuccess"];
        unset($_SESSION["registrationSuccess"]);
    }

    $userDB = new UserDB();
    $isSubmittedForm = !empty($_POST);
    $correctPassword = false;
    if($isSubmittedForm) {
        $email= htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $errors = [];

        if(empty($email)) {
            $errors['email'] = "Zadejte svůj email.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Zadejte platný email.";
        } else if(!$userDB->checkUserEmail($email)) {
            $errors['email'] = "Tento email je už registrován.";
        } else {
            $user = $userDB->getUserByEmail($email);
        }
        if (empty($password)) {
            $errors['password'] = "Zadejte své heslo.";
        } else {
          $correctPassword = password_verify($password, $user['password_hash']);
          if(!$correctPassword) {
            $errors['password'] = "Heslo není správné.";
          }
        }

        if(empty($errors) && $correctPassword) {
            $_SESSION["loginSuccess"] = "Přihlášení proběhlo úspěšně.";
            $_SESSION["privilege"] = $user['privilege_level'];
            setcookie('loginSuccess', $email, time() + 3600, "/");
            header('Location: ./index.php');
            exit();
        }
    }
?>
<?php if(isset($registrationSuccess)) :?>
    <div class="alert alert-success mt-3"><?php echo $registrationSuccess;?></div>
<?php endif; ?>
  <h1>Přihlášení</h1>
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <?php if(isset($errors['email'])) : ?>
      <div class="alert alert-danger mt-1"><?php echo $errors['email'];?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '';?>">
    </div>

    <?php if(isset($errors['password'])) : ?>
      <div class="alert alert-danger mt-1"><?php echo $errors['password'];?></div>
    <?php endif; ?>
    <div class="mb-3">
      <label for="password" class="form-label">Heslo</label>
      <input type="password" class="form-control" name="password" value="<?php echo isset($password) ? $password : '';?>">
    </div>
    <button class="btn btn-primary" type="submit">Přihlásit se</button>
  </form>
  <p>Nemáte účet? Registrujte se <a href="./register.php">zde</a></p>

<?php require __DIR__ . '/includes/foot.php' ?>