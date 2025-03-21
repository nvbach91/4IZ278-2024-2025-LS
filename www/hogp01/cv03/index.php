<?php
$error = "";
if (!empty($_POST)) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $avatar = $_POST['avatar'];
    $pack = $_POST['pack'];
    $cards = $_POST['cards'];

    if (empty($name) || empty($email) || empty($gender) || empty($phone) || empty($avatar) || empty($pack) || empty($cards)) {
        $error .= "One or more fields empty.<br>";

    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Invalid email format.<br>";
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $error .= "Invalid name. Only letters and white space allowed.<br>";
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $error .= "Invalid avatar URL.<br>";
        }

        if (!preg_match('/^\+?\d{7,15}$/', $phone)) {
            $error .= "Invalid phone number.<br>";
        }

        if (filter_var($cards, FILTER_VALIDATE_INT) === false) {
            $error .= "Number of cards is not a number.<br>";
        }

        if ((int)$cards == 0 || (int)$cards % 2 != 0) {
            $error .= "Invalid number of cards.<br>";
        }

    }


}
?>
<?php include 'src/header.php'; ?>
    <div class="wrapper">
        <form class="form-signup" method="POST" action="<?=$_SERVER['PHP_SELF']?>">
            <div class="alert alert-danger"><?php  echo ($error == '' && !empty($_POST)) ? 'Registrace proběhla úspěšne!' : $error?></div>
            <div class="form-group">
                <label>Name*</label>
                <input class="form-control" name="name" value="<?= isset($name) ? $name : '' ?>">
            </div>
            <div class="form-group">
                <label>Gender*</label>
                <select class="form-control" name="gender">
                    <option value="man" <?= (isset($gender) && $gender == "man") ? 'selected="selected"' : '' ?>>Man</option>
                    <option value="woman" <?= (isset($gender) && $gender == "woman") ? 'selected="selected"' : '' ?>>Woman</option>
                    <option value="other" <?= (isset($gender) && $gender == "other") ? 'selected="selected"' : '' ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email*</label>
                <input class="form-control" name="email" value="<?= isset($email) ? $email : '' ?>">
            </div>
            <div class="form-group">
                <label>Phone*</label>
                <input class="form-control" name="phone" value="<?= isset($phone) ? $phone : '' ?>">
            </div>
            <div class="form-group">
                <label>Avatar URL*</label>
                <input class="form-control" name="avatar" value="<?= isset($avatar) ? $avatar : '' ?>">
                <?= empty($avatar) ? "<br><img src=\"$avatar\"  width=64 height=64/>" : "" ?>
            </div>
            <div class="form-group">
                <label>Pack name*</label>
                <input class="form-control" name="pack" value="<?= isset($pack) ? $pack : '' ?>">
            </div>
            <div class="form-group">
                <label>Card count*</label>
                <input class="form-control" name="cards" value="<?= isset($cards) ? $cards : '' ?>">
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
<?php include 'src/footer.php'; ?>