<?php require_once __DIR__ . '/Database/DB_Scripts/UserDB.php'; ?>
<?php require __DIR__ . '/includes/head.php'; ?>

<?php 
    $userDB = new UserDB();
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $name = htmlspecialchars(trim($_POST['name']));
        $surname = htmlspecialchars(trim($_POST['surname']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $passwordRepeat = htmlspecialchars(trim($_POST['passwordRepeat']));
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $errors = [];
        if(empty($name)) {
            $errors['name'] = "Zadejte své jméno";
        }
        if(empty($surname)) {
            $errors['surname'] = "Zadejte své příjmení";
        }
        if(empty($email)) {
            $errors['email'] = "Zadejte svůj email";
        }
        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] ='Zadejte platný email';
        }
        if(empty($password)) {
            $errors['password'] = "Zadejte své heslo";
        }
        if(empty($passwordRepeat)) {
            $errors['passwordRepeat'] = "Zopakujte své heslo";
        }
        if($password !== $passwordRepeat) {
            $errors['passwordRepeat'] = "Hesla se neshodují";
        }
        if($userDB->checkUserEmail($email)) {
            $errors['email'] = "Email již byl zaregistrován";
        }

        if(empty($errors)) {
            $userDB->insertUser($name, $surname, $passwordHash, $email);
            $_SESSION["registrationSuccess"] = "Váš účet byl úspěšně vytvořen! Nyní se můžete přihlásit.";
            header('Location: ./login.php');
            exit();
        }
    }
?>
<div class="register-flex">
    <div class="register-left">
        <h1>Registrace</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <?php if(isset($errors['name'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors["name"];?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Jméno</label>
                <input type="text" class="input-text-short form-control" name="name" value="<?php echo isset($name) ? $name : '';?>">
            </div>

            <?php if(isset($errors['surname'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors["surname"];?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="surname" class="form-label">Příjmení</label>
                <input type="text" class="input-text-short form-control" name="surname" value="<?php echo isset($surname) ? $surname : '';?>">
            </div>

            <?php if(isset($errors['email'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['email'];?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="input-text-short form-control" name="email" value="<?php echo isset($email) ? $email : '';?>">
            </div>

            <?php if(isset($errors['password'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['password'];?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" class="input-text-short form-control" name="password" value="<?php echo isset($password) ? $password : '';?>">
            </div>

            <?php if(isset($errors['passwordRepeat'])) : ?>
                <div class="alert alert-danger mt-1"><?php echo $errors['passwordRepeat'];?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="passwordRepeat" class="form-label">Heslo</label>
                <input type="password" class="input-text-short form-control" name="passwordRepeat">
            </div>
            <button class="btn btn-primary" type="submit">Registrovat se</button>
        </form>
    </div>

    <div class="register-right">
        <img src="https://eso.vse.cz/~gona11/SP/assets/register-login.jpg" alt="Cestovatel s batohem" />
    </div>
</div>
    
<?php require __DIR__ . '/includes/foot.php' ?>