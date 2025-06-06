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
    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $secondName = htmlspecialchars(trim($_POST["secondName"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $city = htmlspecialchars(trim($_POST["city"]));
    $street = htmlspecialchars(trim($_POST["street"]));
    $zipCode = htmlspecialchars(trim($_POST["zipCode"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
    }

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
    if (!empty($zipCode) && !preg_match('/^\d{5}(-\d{4})?$/', $zipCode)) {
        $errors["zipCode"] = "Invalid zip code format.";
    }
    
    if (empty($errors)) {
        $_SESSION["checkout_details"] = [
            "firstName" => $firstName,
            "secondName" => $secondName,
            "email" => $email,
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

            <label for="email">email</label>
            <input class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user["email"] ?? ''); ?>" placeholder="email">
            
            <label for="city">City</label>
            <input class="form-control" id="city" name="city" placeholder="City">

            <label for="street">Street</label>
            <input class="form-control" id="street" name="street" placeholder="Street">

            <label for="zipCode">Zip Code</label>
            <input class="form-control" id="zipCode" name="zipCode" placeholder="Zip Code" type="number" pattern="\d{5}(-\d{4})?">
        </div>
        <button type="submit" class="btn btn-primary">Confirm order</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>