<?php

require_once __DIR__ . '/saveProfile.php';
@session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require_once __DIR__ . '/database/UsersDB.php';
$usersDB = new UsersDB();

$userId = $_SESSION['user_id'];
$user = $usersDB->fetchById($userId);
if (!$user) {
    header("Location: index.php");
    exit;
}

$errors = [];
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <div class="text-start my-4">
        <a href="profile-information.php" class="btn btn-primary btn-lg mx-2">My profile</a>
        <a href="profile-orders.php" class="btn btn-primary btn-lg mx-2">My orders</a>
    </div>
    <form action="saveProfile.php" method="POST" class="form-register">
        <h1>Update Profile</h1>
        <div class="form-group">
            <?php if (isset($errors["email"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["email"]; ?>
                </div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input class="form-control" id="email" value="<?= htmlspecialchars($user["email"]); ?>" name="email" placeholder="Email">

            <?php if (isset($errors["password"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["password"]; ?>
                </div>
            <?php endif; ?>
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="New Password">

            <?php if (isset($errors["firstName"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["firstName"]; ?>
                </div>
            <?php endif; ?>
            <label for="firstName">First Name</label>
            <input class="form-control" id="firstName" value="<?= htmlspecialchars($user["firstName"]); ?>" name="firstName" placeholder="First Name">

            <?php if (isset($errors["secondName"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["secondName"]; ?>
                </div>
            <?php endif; ?>
            <label for="secondName">Second Name</label>
            <input class="form-control" id="secondName" value="<?= htmlspecialchars($user["secondName"]); ?>" name="secondName" placeholder="Second Name">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>