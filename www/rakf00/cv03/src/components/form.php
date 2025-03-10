<?php
$gender = "";
$formValid = false;
$isSubmittedForm = ! empty($_POST);

if ($isSubmittedForm) {
    $errors = [];

    $fullName = htmlspecialchars(trim($_POST["fullName"]));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatarUrl = htmlspecialchars(trim($_POST['avatarUrl']));
    if ( ! empty($_POST["gender"])) {
        $gender = htmlspecialchars(trim($_POST['gender']));
    } else {
        $errors["gender"] = "Please select a gender.";
    }

    //email validace
    if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format";
    }
    //url validace
    if ( ! filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
        $errors["avatarUrl"] = "Invalid URL";
    }
    //telefon validace
    if ( ! preg_match('/^\+[0-9]{3}\s?\d{3}\s?\d{3}\s?\d{3}$/', $phone)) {
        $errors["phone"] = "Invalid phone number";
    }
    //jmeno validace
    if (!preg_match("/^[\p{L}]+ [\p{L}]+(?: [\p{L}]+)*$/u", $fullName)) {
        $errors["fullName"] = "Invalid full name";
    }
    //gender validace
    if ( ! $gender == "male" || ! $gender == "female") {
        $errors["gender"] = "Invalid gender";
    }
    if (empty($errors)) {
        $formValid = true;}
}
?>

<?php if ($formValid): ?>
  <div class="alert alert-success m-3" role="alert">
    Signed up!
  </div>
<?php endif; ?>
<form method="POST" class="m-3" action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="fullName">Your name</label>
        <input id="fullName" class="form-control" name="fullName"
               placeholder="Bryan Johnson" value="<?php
        echo $fullName ?? "" ?>">
        <?php
        if (isset($errors["fullName"])): ?>
            <div class="alert alert-danger p-0" role="alert">
                <?= $errors["fullName"] ?>
            </div>
        <?php
        endif; ?>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control">
                <option selected disabled>Please select your gender</option>
                <option value="male" <?php
                echo ($gender == "male") ? "selected" : ""; ?>>Male
                </option>
                <option value="female" <?php
                echo ($gender == "female") ? "selected" : ""; ?>>Female
                </option>
            </select>
            <?php
            if (isset($errors["gender"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["gender"] ?>
                </div>
            <?php
            endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" class="form-control" name="email"
                   placeholder="example@domain.com" value="<?php
            echo $email ?? "" ?>">
            <?php
            if (isset($errors["email"])): ?>
                <div class="alert alert-danger p-0" role="alert">
                    <?= $errors["email"] ?>
                </div>
            <?php
            endif; ?>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input class="form-control" id="phone" name="phone"
                       placeholder="+420 999 999 999" value="<?php
                echo $phone ?? "" ?>">
                <?php
                if (isset($errors["phone"])): ?>
                    <div class="alert alert-danger p-0" role="alert">
                        <?= $errors["phone"] ?>
                    </div>
                <?php
                endif; ?>
            </div>
            <div class="form-group">
                <label for="avatarUrl">Avatar URL</label>
                <input id="avatarUrl" class="form-control" name="avatarUrl"
                       placeholder="include protocol ex. http://"
                       value="<?php
                       echo $avatarUrl ?? "" ?>">
                <?php
                if (isset($errors["avatarUrl"])): ?>
                    <div class="alert alert-danger p-0" role="alert">
                        <?= $errors["avatarUrl"] ?>
                    </div>
                <?php
                endif; ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Click me</button>
</form>

<?php if ($formValid): ?>
    <br>Avatar:
<img src="<?php echo $avatarUrl ?>" alt="avatar-image" width="100" height="100" style="margin-top: 10px">
<?php endif; ?>