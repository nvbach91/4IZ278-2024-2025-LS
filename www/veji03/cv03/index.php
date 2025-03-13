<?php
$invalidInputs = [];
$alertMessages = [];
$alertType = 'alert-danger';

$name = $gender = $email = $phone = $avatar = $deck_name = $card_count = "";

$submittedForm = !empty($_POST);
if ($submittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatar = htmlspecialchars(trim($_POST['avatar']));
    $deck_name = htmlspecialchars(trim($_POST['deck_name']));
    $card_count = htmlspecialchars(trim($_POST['card_count']));

    if (!$name) {
        array_push($alertMessages, 'Please enter your name');
        array_push($invalidInputs, 'name');
    }
    if (!in_array($gender, ['N', 'F', 'M'])) {
        array_push($alertMessages, 'Please select your gender');
        array_push($invalidInputs, 'gender');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($alertMessages, 'Please use a valid email address');
        array_push($invalidInputs, 'email');
    }
    if (!preg_match('/^(\+\d{3} ?)?(\d{3} ?){3}$/', $phone)) {
        array_push($alertMessages, 'Please use a valid phone number');
        array_push($invalidInputs, 'phone');
    }
    if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
        array_push($alertMessages, 'Please use a valid URL for your avatar');
        array_push($invalidInputs, 'avatar');
    }
    if (!$deck_name) {
        array_push($alertMessages, 'Please enter deck name');
        array_push($invalidInputs, 'deck_name');
    }
    if (!ctype_digit($card_count) || (int)$card_count <= 0) {
        array_push($alertMessages, 'Please enter number count');
        array_push($invalidInputs, 'card_count');
    }

    if (!count($alertMessages)) {
        $alertType = 'alert-success';
        $alertMessages = ['You have successfully signed up!'];
    }
}
?>

<?php include './includes/header.php'; ?>

<div class="container mt-5">
    <h2>Registration form</h2>
    
    <?php if (!empty($alertMessages)): ?>
        <div class="alert <?= $alertType ?>">
            <ul>
                <?php foreach ($alertMessages as $message): ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form-signup" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="mb-3">
            <label class="form-label">Name*</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
            <small class="text-muted">Example: Franta Flinta</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Gender*</label>
            <select class="form-control" name="gender">
                <option value="N"<?php echo isset($gender) && $gender === 'N' ? ' selected' : '' ?>>Neutral</option>
                <option value="F"<?php echo isset($gender) && $gender === 'F' ? ' selected' : '' ?>>Female</option>
                <option value="M"<?php echo isset($gender) && $gender === 'M' ? ' selected' : '' ?>>Male</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail*</label>
            <input class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : '' ?>">
            <small class="text-muted">Example: example@mailinator.com</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone*</label>
            <input class="form-control" name="phone" value="<?php echo isset($phone) ? $phone : '' ?>">
            <small class="text-muted">Example: +420 123 456 789</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Profile picture (URL)*</label>
            <input class="form-control" type="url" name="avatar" value="<?php echo isset($avatar) ? $avatar : '' ?>">
            <small class="text-muted">Example: https://eso.vse.cz/~veji03/cv03/oh.png</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Deck name*</label>
            <input class="form-control" name="deck_name" value="<?php echo isset($deck_name) ? $deck_name : '' ?>">
            <small class="text-muted">Example: Super deck</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Number count*</label>
            <input class="form-control" type="number" name="card_count" value="<?php echo isset($card_count) ? $card_count : '' ?>">
            <small class="text-muted">Example: 30</small>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>

    <?php if ($alertType === 'alert-success'): ?>
        <div class="mt-4">
            <img src="<?php echo isset($avatar) ? $avatar : '' ?>" class="img-fluid rounded" style="max-width: 200px;">
        </div>
    <?php endif; ?>
</div>
<?php include './includes/footer.php'; ?>
