<?php
if (empty($_POST)) {
    $alerts = [];
    $alertType = "";
    $success = false;
    $show_avatar = false;
} else {
    $alerts = [];
    $success = true;
    $show_avatar = false;

    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : "";
    $gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender'])) : "";
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : "";
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : "";
    $avatar = isset($_POST['avatar']) ? htmlspecialchars(trim($_POST['avatar'])) : "";
    $cards_name = isset($_POST['cards-name']) ? htmlspecialchars(trim($_POST['cards-name'])) : "";
    $cards_count = isset($_POST['cards-count']) ? htmlspecialchars(trim($_POST['cards-count'])) : "";

    if (empty($name)) {
        array_push($alerts, "Name is required");
        $success = false;
    } elseif (strlen($name) < 2) {
        array_push($alerts, "Name is too short");
        $success = false;
    }
    if (empty($gender)) {
        array_push($alerts, "Gender is required");
        $success = false;
    } elseif ($gender != "F" && $gender != "M" && $gender != "N") {
        array_push($alerts, "Invalid gender entered");
        $success = false;
    }
    if (empty($email)) {
        array_push($alerts, "Email is required");
        $success = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($alerts, "Email format is invalid");
        $success = false;
    }

    if (empty($phone)) {
        array_push($alerts, "Phone number is required");
        $success = false;
    } elseif (!preg_match("/^(\+\d{1,4}\d{3}\d{3}(\d{3})?|\d{3}\d{3}\d{3})$/", $phone)) {
        array_push($alerts, "Phone number must be in format '+xxxyyyzzzwww' or 'xxxyyyzzz'");
        $success = false;
    }

    if (empty($avatar)) {
        array_push($alerts, "Avatar URL is required");
        $success = false;
    } elseif (!filter_var($avatar, FILTER_VALIDATE_URL)) {
        array_push($alerts, "Enter a valid image URL for the avatar");
        $success = false;
    }

    if (empty($cards_name)) {
        array_push($alerts, "Cards package name is required");
        $success = false;
    } elseif (strlen($cards_name) < 2) {
        array_push($alerts, "Cards package name is too short");
        $success = false;
    }

    if (empty($cards_count)) {
        array_push($alerts, "Cards count is required");
        $success = false;
    } elseif (!is_numeric($cards_count) || intval($cards_count) != $cards_count || intval($cards_count) <= 0) {
        array_push($alerts, "Cards count must be a positive integer");
        $success = false;
    }

    $alertType = $success ? "alert-success" : "alert-danger";
    if ($success) {
        array_push($alerts, "Form submitted successfully!");
        $show_avatar = True;
    }
}
?>

<div class="container">
    <h2>Sign Up Form</h2>
    <form class="form-signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php if (!empty($_POST)): ?>
            <div class="alert <?php echo $alertType; ?>">
                <?php echo implode('<br>', $alerts); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : ""; ?>">
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select class="form-control" name="gender">
                <option value="N" <?php echo isset($gender) && $gender === 'N' ? ' selected' : '' ?>>Neutral</option>
                <option value="F" <?php echo isset($gender) && $gender === 'F' ? ' selected' : '' ?>>Female</option>
                <option value="M" <?php echo isset($gender) && $gender === 'M' ? ' selected' : '' ?>>Male</option>
            </select>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" value="<?php echo isset($email) ? $email : ""; ?>">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input class="form-control" name="phone" value="<?php echo isset($phone) ? $phone : ""; ?>">
        </div>
        <div class="form-group">
            <label>Avatar URL</label>
            <input class="form-control" name="avatar" value="<?php echo isset($avatar) ? $avatar : ""; ?>">
        </div>
        <div class="form-group">
            <label>Cards package name</label>
            <input class="form-control" name="cards-name" value="<?php echo isset($cards_name) ? $cards_name : ""; ?>">
        </div>
        <div class="form-group">
            <label>Cards count in package</label>
            <input class="form-control" name="cards-count" value="<?php echo isset($cards_count) ? $cards_count : ""; ?>">
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <img class="img <?php echo $show_avatar ? "active" : "inactive"; ?>" src="<?php echo isset($avatar) ? $avatar : ""; ?>" width="200px" alt="Avatar">
</div>