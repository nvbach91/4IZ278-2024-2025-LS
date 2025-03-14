<?php
$required = array('name', 'lastName', 'email', 'phone', 'avatar', 'deckName', 'numberOfCards');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $gender = $_POST['gender'];
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatar = htmlspecialchars(trim($_POST['avatar']));
    $deckName = htmlspecialchars(trim($_POST['deckName']));
    $NumOfCards = htmlspecialchars(trim($_POST['numberOfCards']));

    if (!preg_match('/^(\+\d{3} ?)?\d{3} ?\d{3} ?\d{3}$/', $phone)) {
        $errors['phone'] = 'Invalid phone number';
    }

    if (!preg_match('/^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9_\.-]+\.[a-zA-Z]+$/', $email)) {
        $errors['email'] = 'Invalid email format';
    }

    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
        $errors['name'] = 'Enter valid name';
    }
    if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $errors['lastName'] = 'Enter valid last name';
    }
    if (!preg_match('/^\d+$/', $NumOfCards)) {
        $errors['numberOfCards'] = 'Enter a number';
    }
    if (!preg_match('/^[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)$/', $avatar)) {
        $errors['avatar'] = 'Enter a valid URL';
    }
    if ($gender == 'Choose...') {
        $errors['gender'] = 'Choose a gender';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Fill required fields';
        }
    }
}
?>
<main class="container">
    <h1>Card game tournament Registration form</h1>


    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <?php if (isset($errors['lastName'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['lastName']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Last name*</label>
            <input class="form-control" name="lastName" value="<?php echo isset($lastName) ? $lastName : '' ?>">
        </div>
        <?php if (isset($errors['email'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>">
        </div>
        <?php if (isset($errors['gender'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['gender']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Gender*</label>
            <select id="inputState" name="gender" class="form-control">
                <option <?php echo !isset($gender) ? 'selected' : '' ?>>Choose...</option>
                <option <?php echo isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                <option <?php echo isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                <option <?php echo isset($gender) && $gender == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <?php if (isset($errors['phone'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['phone']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Phone*</label>
            <input class="form-control" name="phone" value="<?php echo isset($phone) ? $phone : '' ?>">
        </div>
        <?php if (isset($errors['avatar'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['avatar']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($avatar) && $avatar != '') : ?>
            <img src="<?php echo $avatar ?>" alt="avatar">
        <?php endif; ?>
        <div class="form-group">
            <label>Avatar URL*</label>
            <input class="form-control" name="avatar" value="<?php echo isset($avatar) ? $avatar : '' ?>">
        </div>
        <?php if (isset($errors['deckName'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['deckName']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Deck name*</label>
            <input class="form-control" name="deckName" value="<?php echo isset($deckName) ? $deckName : '' ?>">
        </div>
        <?php if (isset($errors['numberOfCards'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['numberOfCards']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Number of cards in deck*</label>
            <input class="form-control" name="numberOfCards" value="<?php echo isset($NumOfCards) ? $NumOfCards : '' ?>">
        </div>
        <?php if (empty($errors) && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <div class="alert alert-success">
                Registration was successful.
            </div>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>