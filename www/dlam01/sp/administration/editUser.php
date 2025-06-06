<?php
require_once __DIR__ . '/saveUser.php';
@session_start();

if ($_SESSION['privilege'] < '3') {
    header("Location: /../index.php");
    exit;
}
    
require_once __DIR__ . '/../database/UsersDB.php';
$usersDB = new UsersDB();

if (!isset($_GET["id"])) {
    header("Location: /../index.php");
    exit;
}
$userId = $_GET["id"];
$user = $usersDB->fetchById($userId);
if (!$user) {
    header("Location: /../index.php");
    exit;
}
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="container">
    <form action=<?php echo "saveUser.php" . "?id=" . $userId ?> method="POST" class="form-register">
        <h1>Edit User</h1>
        <div class="form-group">
            <?php if (isset($errors["firstName"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["firstName"]; ?>
                </div>
            <?php endif; ?>
            <label for="firstName">First Name</label>
            <input class="form-control" id="firstName" value="<?= $user["firstName"]; ?>" name="firstName" placeholder="First Name">

            <?php if (isset($errors["secondName"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["secondName"]; ?>
                </div>
            <?php endif; ?>
            <label for="secondName">Second Name</label>
            <input class="form-control" id="secondName" value="<?= $user["secondName"]; ?>" name="secondName" placeholder="Second Name">

            <?php if (isset($errors["email"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["email"]; ?>
                </div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input class="form-control" id="email" value="<?= $user["email"]; ?>" name="email" placeholder="Email">

            <?php if (isset($errors["password"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["password"]; ?>
                </div>
            <?php endif; ?>
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">

            <?php if (isset($errors["privilege"])): ?>
                <div class='alert alert-danger' role='alert'>
                    <?php echo $errors["privilege"]; ?>
                </div>
            <?php endif; ?>
            <label for="privilege">Privilege</label>
            <input class="form-control" id="privilege" value="<?= $user["privilege"]; ?>" name="privilege" placeholder="Privilege">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
