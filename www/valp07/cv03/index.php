<?php
$messages = [];
$invalidInputs = [];
$isSubmitted = !empty($_POST);

if ($isSubmitted) {
    $name = htmlspecialchars(trim($_POST['name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatar = htmlspecialchars(trim($_POST['avatar']));
    $deckName = htmlspecialchars(trim($_POST['deckName']));
    $cardCount = (int)$_POST['cardCount'];

    if (!$name) {
        $messages['name'] = 'Please enter a name';
    }

    if (!in_array($gender, ['O', 'F', 'M'])) {
        $messages['gender'] = 'Please select a gender';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messages['email'] = 'Please enter a valid email';
    }

    if (!preg_match('/^(\+\d{1,3}\s)?\d{3}\s\d{3}\s\d{3}$/', $phone)) {
        $messages['phone'] = 'Please enter a valid phone number';
    }

    if (!filter_var($avatar, FILTER_VALIDATE_URL) || !preg_match('/\.(jpg|jpeg|png|gif|bmp|webp|svg)$/i', parse_url($avatar, PHP_URL_PATH))) {
        $messages['avatar'] = 'Please enter a valid image URL';
    }

    if (!$deckName) {
        $messages['deckName'] = 'Please enter a deck name';
    }

    if ($cardCount <= 0) {
        $messages['cardCount'] = 'Please add a positive number of cards';
    }
    if (!$messages) {
        $messages['success'] = 'Registered Successfully';
    }
}

?>
<?php include './includes/header.php'; ?>
<main class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2 class="text-center">Signup Form</h2>
                <?php if (isset($messages['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($messages['success']); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control<?php echo in_array('name', $invalidInputs) ? ' is-invalid' : '' ?>" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : '' ?>">
                    <small class="text-muted">Format: John Cena</small>
                    <?php if (isset($messages['name'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['name']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                        <option value="O" <?php echo isset($gender) && $gender === 'O' ? ' selected' : '' ?>>Other</option>
                        <option value="F" <?php echo isset($gender) && $gender === 'F' ? ' selected' : '' ?>>Female</option>
                        <option value="M" <?php echo isset($gender) && $gender === 'M' ? ' selected' : '' ?>>Male</option>
                    </select>
                    <?php if (isset($messages['gender'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['gender']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control<?php echo in_array('email', $invalidInputs) ? ' is-invalid' : '' ?>" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : '' ?>">
                    <small class="text-muted">Format: example@email.com</small>
                    <?php if (isset($messages['email'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['email']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input class="form-control<?php echo in_array('phone', $invalidInputs) ? ' is-invalid' : '' ?>" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : '' ?>">
                    <small class="text-muted">Format: (+420) 123 456 789</small>
                    <?php if (isset($messages['phone'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['phone']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Avatar URL</label>
                    <?php if (isset($avatar) && $avatar): ?>
                        <img class="img-responsive center-block" style="max-width:150px;" src="<?php echo htmlspecialchars($avatar); ?>" alt="avatar">
                    <?php endif; ?>
                    <input class="form-control<?php echo in_array('avatar', $invalidInputs) ? ' is-invalid' : '' ?>" name="avatar" value="<?php echo isset($avatar) ? htmlspecialchars($avatar) : ''; ?>">
                    <small class="text-muted">Format: https://example.com/avatar.jpg</small>
                    <?php if (isset($messages['avatar'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['avatar']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Deck name</label>
                    <input class="form-control" name="deckName" value="<?php echo isset($deckName) ? htmlspecialchars($deckName) : '' ?>">
                    <small class="text-muted">Format: Example Deck Name</small>
                    <?php if (isset($messages['deckName'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['deckName']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Number of cards in deck</label>
                    <input class="form-control" name="cardCount" value="<?php echo isset($cardCount) ? htmlspecialchars($cardCount) : '' ?>">
                    <small class="text-muted">Format: 52</small>
                    <?php if (isset($messages['cardCount'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['cardCount']); ?></div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
<?php include './includes/footer.php'; ?>