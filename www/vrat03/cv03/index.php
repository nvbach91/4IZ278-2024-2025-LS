<?php
$correctEmail="a@b.cz";
$correctPassword="a";
// umožňuje získat data z formuláře s metodou POST
//var_dump($_POST);

$isSubmitedForm = !empty($_POST);
$errors=[];


if ($isSubmitedForm) {

    $name = htmlspecialchars(trim($_POST['name'])); 
    $gender= htmlspecialchars(trim($_POST['gender']));
    $email= htmlspecialchars(trim($_POST['email']));
    $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
    $profilePicture = htmlspecialchars(trim($_POST['profilePicture']));
    $deckName = htmlspecialchars(trim($_POST['deckName']));
    $numberOfCards = htmlspecialchars(trim($_POST['numberOfCards']));

    if (!preg_match('/^[\p{L} ]+$/u', $name)) {
        $errors['name'] = 'Invalid name, only letters are allowed';
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email';
    }

    // Někteří lidé si pamatují své telefonní číslo např. jako trojice - dvojice - dvojice - dvojice
    // předvolba může mít 1-3 číslice
    if (!preg_match('/^(\+\d{1,3} )?([0-9] ?){9}$/', $phoneNumber)) {
        $errors['phoneNumber'] = 'Phone number has incorrect format';
    }

    if (!filter_var($profilePicture, FILTER_VALIDATE_URL)) {
        $errors['profilePicture'] = 'Invalid URL';
    }

    if (!preg_match('/^[\p{L}0-9 ]+$/u', $deckName)) {
        $errors['deckName'] = 'Invalid deck name, only alphanumeric characters are allowed';
    }

    if (!is_numeric($numberOfCards) || $numberOfCards<1) {
        $errors['numberOfCards'] = 'Invalid number of cards. It must be a positive number.';
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
                    <h1>Registration to card tournament was successful.</h1>
                    <p>Here are the details you entered:</p>
                    <ul>
                        <li>Name: $name</li>
                        <li>Gender: $gender</li>
                        <li>Email: $email</li>
                        <li>Phone number: $phoneNumber</li>
                        <li>
                            <div style='display: flex; align-items: center; list-style: inside;'>
                                <p>Profile picture:</p>
                                <img src='$profilePicture' alt='Profile Picture' width='100' style='margin-left: 10px'>
                            </div>
                        </li>
                        <li>Deck name: $deckName</li>
                        <li>Number of cards in deck:</strong> $numberOfCards</li>
                    </ul>
                </body>
            </html>";
        if(mail($email, "Registration was successful", $message, $headers)){
            $errors['success'] = 'Registration was successfull';
        } else {
            $errors['error'] = 'Failed to send email.';
        }  
    }
}

?>

<?php include __DIR__.'/includes/head.php'; ?>

<form class="form" method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
    <h1>Registration form</h1>
    <?php if(isset($errors['success'])):?>
        <div class="alert alert-success" role="alert">
            <?php echo $errors['success']; ?>
        </div>
    <?php endif; ?>
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

    <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name='gender' class="form-select">
            <option value="Male" <?php echo isset($gender) && $gender== 'Male'? 'selected' : '' ?>>Male</option>
            <option value="Female" <?php echo isset($gender) && $gender== 'Female'? 'selected' : '' ?>>Female</option>
            <option value="Other" <?php echo isset($gender) && $gender== 'Other'? 'selected' : '' ?>>Other</option>
        </select>
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

    <?php if(isset($errors['phoneNumber'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['phoneNumber']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="phoneNumber" class="form-label">Phone Number</label>
        <input name="phoneNumber" class="form-control" value="<?php echo isset($phoneNumber) ? $phoneNumber : ''?>">
    </div>

    <?php if(isset($errors['profilePicture'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['profilePicture']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="profilePicture" class="form-label">Profile picture url</label>
        <?php if (isset($profilePicture) && !isset($errors['profilePicture'])): ?>
            <img class="profilePicture" src="<?php echo $profilePicture; ?>" alt="profilePicture">
        <?php endif; ?>
        <input name="profilePicture" class="form-control" id="profilePicture" value="<?php echo isset($profilePicture) ? $profilePicture : ''?>">
    </div>

    <?php if(isset($errors['deckName'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['deckName']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="deckName" class="form-label">Deck name</label>
        <input name="deckName" class="form-control" value="<?php echo isset($deckName) ? $deckName : ''?>">
    </div>

    <?php if(isset($errors['numberOfCards'])):?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errors['numberOfCards']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="numberOfCards" class="form-label">Number of cards in deck</label>
        <input name="numberOfCards" class="form-control" value="<?php echo isset($numberOfCards) ? $numberOfCards : ''?>">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php include __DIR__.'/includes/foot.php'; ?>