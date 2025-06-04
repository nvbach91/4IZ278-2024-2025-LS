<?php

session_start();
require_once __DIR__ . '/database/UsersDB.php';

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit;
}

$usersDB = new UsersDB();
$user = null;

if (isset($_SESSION["user_id"])) {
    $user = $usersDB->fetchById($_SESSION["user_id"]);
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST["firstName"]);
    $secondName = trim($_POST["secondName"]);
    $city = trim($_POST["city"]);
    $street = trim($_POST["street"]);
    $zipCode = trim($_POST["zipCode"]);

    if (empty($firstName)) {
        $errors["firstName"] = "First name is required.";
    }

    if (empty($secondName)) {
        $errors["secondName"] = "Second name is required.";
    }

    if (empty($city)) {
        $errors["city"] = "City is required.";
    }

    if (empty($street)) {
        $errors["street"] = "Street is required.";
    }

    if (empty($zipCode)) {
        $errors["zipCode"] = "Zip code is required.";
    }

    if (empty($errors)) {
        $_SESSION["checkout_details"] = [
            "firstName" => $firstName,
            "secondName" => $secondName,
            "city" => $city,
            "street" => $street,
            "zipCode" => $zipCode,
        ];
        header("Location: confirmOrder.php");
        exit;
    }
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container">
    <h1>Checkout</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user["firstName"] ?? ''); ?>" placeholder="First Name">

            <label for="secondName">Second Name</label>
            <input class="form-control" id="secondName" name="secondName" value="<?php echo htmlspecialchars($user["secondName"] ?? ''); ?>" placeholder="Second Name">

            <label for="city">City</label>
            <input class="form-control" id="city" name="city" placeholder="City">

            <label for="street">Street</label>
            <input class="form-control" id="street" name="street" placeholder="Street">

            <label for="zipCode">Zip Code</label>
            <input class="form-control" id="zipCode" name="zipCode" placeholder="Zip Code">
        </div>
        <button type="submit" class="btn btn-primary">Confirm order</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>