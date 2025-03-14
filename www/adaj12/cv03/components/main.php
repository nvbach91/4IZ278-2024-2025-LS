<?php
require './functions/validate.php';
?>

<?php if ($successMessage): ?>
    <div class="alert alert-success"><?php echo $successMessage; ?></div>
<?php endif; ?>
<form class="form-signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label>Name*</label>
        <input class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <small class="form-text text-muted">example: Jakub Adam</small>
        <div class="text-danger"><?php echo htmlspecialchars($nameErr); ?></div>
    </div>
    <div class="form-group">
        <label>Gender*</label>
        <select class="form-control" name="gender">
            <option value="male" <?php if ($gender == "male") echo "selected"; ?>>Male</option>
            <option value="female" <?php if ($gender == "female") echo "selected"; ?>>Female</option>
            <option value="other" <?php if ($gender == "other") echo "selected"; ?>>Other</option>
        </select>
        <small class="form-text text-muted">Select your gender</small>
        <div class="text-danger"><?php echo $genderErr; ?></div>
    </div>
    <div class="form-group">
        <label>Email*</label>
        <input class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <small class="form-text text-muted">example: jakub.adam@gmail.com</small>
        <div class="text-danger"><?php echo $emailErr; ?></div>
    </div>
    <div class="form-group">
        <label>Phone*</label>
        <input class="form-control" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
        <small class="form-text text-muted">example: 123456789</small>
        <div class="text-danger"><?php echo $phoneErr; ?></div>
    </div>
    <div class="form-group">
        <label>Avatar URL*</label>
        <input class="form-control" name="avatar" value="<?php echo isset($avatar) ? $avatar : ''; ?>">
        <small class="form-text text-muted">example: https://wigym.cz/wp-content/uploads/2021/03/NOTSUREIF-1280x640.jpg</small>
        <div class="text-danger"><?php echo $avatarErr; ?></div>
    </div>
    <div class="form-group">
        <label>Deck name*</label>
        <input class="form-control" name="deckName" value="<?php echo isset($deckName) ? $deckName : ''; ?>">
        <small class="form-text text-muted">example: Pokemon Deck</small>
        <div class="text-danger"><?php echo $deckNameErr; ?></div>
    </div>
    <div class="form-group">
        <label>Number of cards in the deck*</label>
        <input class="form-control" name="deckNumber" value="<?php echo isset($deckNumber) ? $deckNumber : ''; ?>">
        <small class="form-text text-muted">example: 40</small>
        <div class="text-danger"><?php echo $deckNumberErr; ?></div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
<?php if ($successMessage && $avatar): ?>
    <div class="mt-3">
        <img src="<?php echo $avatar; ?>" alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
    </div>
<?php endif; ?>