<?php

include('header.html');

$error   = '';
$success = '';

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$avatar = isset($_POST['avatar']) ? trim($_POST['avatar']) : '';
$deckName = isset($_POST['deck_name']) ? trim($_POST['deck_name']) : '';
$deckCount = isset($_POST['deck_count']) ? trim($_POST['deck_count']) : '';

if (!empty($_POST)) {

    if (empty($name)) {
        $error = "Jméno je povinné. ";
    }
    if (empty($gender)) {
        $error = "Pohlaví je povinné. ";
    }
    if (empty($email)) {
        $error = "Email je povinný. ";
    }
    if (empty($phone)) {
        $error .= "Telefon je povinný. ";
    } else {
        if (!preg_match('/^(?:\+\d{1,3}[ \-]?)?(?:\d[ \-]?){9,}$/', $phone)) {
            $error .= "Neplatný formát telefonního čísla. ";
        }
    }
    
    if (empty($avatar)) {
        $error = "URL avataru je povinná. ";
    }
    if (empty($deckName)) {
        $error = "Název balíku je povinný. ";
    }
    if (empty($deckCount)) {
        $error = "Počet karet je povinný. ";
    } elseif (!is_numeric($deckCount) || $deckCount <= 0) {
        $error = "Počet karet musí být kladné číslo. ";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Neplatný formát e-mailu. ";
    }

    if (empty($error)) {
        $success = "Registrace byla úspěšná!";

        $subject = "Registrace na turnaj";
        $message = "Registrace byla úspěšná";
        mail($email, $subject, $message);
    }
}
?>

<?php if (!empty($_POST)) : ?>
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    <div class="form-group">
        <label>Celé jméno*</label>
        <input class="form-control" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    </div>
    
    <div class="form-group">
        <label>Pohlaví*</label>
        <select class="form-control" name="gender">
            <option value="" <?php echo ($gender == '') ? 'selected' : ''; ?>>-- Vyberte --</option>
            <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Muž</option>
            <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Žena</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>E-mail*</label>
        <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
    
    <div class="form-group">
        <label>Telefon*</label>
        <input class="form-control" type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    </div>
    
    <div class="form-group">
        <label>Profilový obrázek (URL)*</label>
        <input class="form-control" type="url" name="avatar" value="<?php echo htmlspecialchars($avatar); ?>">
    </div>
    
    <div class="form-group">
        <label>Název balíku*</label>
        <input class="form-control" type="text" name="deck_name" value="<?php echo htmlspecialchars($deckName); ?>">
    </div>
    
    <div class="form-group">
        <label>Počet karet v balíku*</label>
        <input class="form-control" type="number" name="deck_count" value="<?php echo htmlspecialchars($deckCount); ?>">
    </div>
    
    <button class="btn" type="submit">Submit</button>
</form>

<?php if (!empty($_POST) && !empty($avatar) && empty($error)) : ?>
    <div class="mt-3">
        <h4>Váš avatar:</h4>
        <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" style="max-width: 150px;">
    </div>
<?php endif; ?>

<?php
include('footer.html');
?>
