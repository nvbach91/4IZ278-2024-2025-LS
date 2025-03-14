<?php

$isSubmitedForm = !empty($_POST);
$errors=[];

function fetchUsers() {
    $users = [];
    $lines = file('./users.db');
    foreach($lines as $line) {
        $fields = explode(';',$line);
        $user = [];
        $user['name'] = $fields[0];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

function fetchUser($email) {
    $users = fetchUsers();
    foreach($users as $user) {
        if ($user['email']==$email)
        return $user;
    }
    return null;
}

function addUser($user) {
    $name = $user['name'];
    $email = $user['email'];
    $password = $user['password'];
    
    $record = "$name;$email;$password";
    file_put_contents('./users.db',$record.PHP_EOL, FILE_APPEND);
}

if ($isSubmitedForm) {
    $name = htmlspecialchars(trim($_POST['name'])); 
    $email= htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password2 = htmlspecialchars(trim($_POST['password2']));

    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (!preg_match('/^[\p{L} ]+$/u', $name)) {
        $errors['name'] = 'Invalid name, only letters are allowed';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email';
    } elseif (substr($email, -7) !== '@vse.cz') {
        $errors['email'] = 'Email must be from the vse.cz domain';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if ($password != $password2) {
        $errors['password'] = 'Passwords do not match';
    }

    if(empty($errors)) {
        $headers = 
            "MIME-Version: 1.0\r\n" .
            "From: vrat03@vse.cz\r\n" .
            "Reply-To: vrat03@vse.cz\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n".
            "X-Mailer: PHP/".phpversion();
        $message = 
            "<html>
                <head>
                    <title>Registration Successful</title>
                </head>
                <body>
                    <h1>Registration was successful.</h1>
                    <p>Here are the details you entered:</p>
                    <ul>
                        <li>Name: $name</li>
                        <li>Email: $email</li>
                        <li>Password: $password</li>
                    </ul>
                    You can now <a href='https://eso.vse.cz/~vrat03/cv04/login.php?email=$email'>login</a>.
                </body>
            </html>";
        $users = fetchUsers();
        $isExistingUser=false;
        foreach($users as $user) {
            if(fetchUser($_POST['email']) != null) {
                $isExistingUser=true;
                break;
            }
        }
        if(!$isExistingUser) {
            addUser([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ]);
            if(!mail($email, "Registration was successful", $message, $headers)){
                $errors['error'] = 'Failed to send email.';
            }
            header('Location: ./login.php?success=1&email='.urlencode($email));
            exit();
        } else {
            $errors['error'] = 'User with this email already exists';
        }
        
    }
}

?>

<?php include __DIR__.'/includes/head.php'; ?>

<form class="form" method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
    <h1>Register</h1>
    <?php if(isset($errors['error'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['error']; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($errors['name'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['name']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="name" class="form-label">Full name</label>
        <input name="name" class="form-control" id="name" value="<?php echo isset($name) ? $name : ''?>">
    </div>
    
    <?php if(isset($errors['email'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['email']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input name="email" class="form-control" id="email" value="<?php echo isset($email) ? $email : ''?>">
    </div>

    <?php if(isset($errors['password'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['password']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password2" class="form-label">Enter password one more time</label>
        <input type="password" name="password2" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>
<?php include __DIR__.'/includes/foot.php'; ?>