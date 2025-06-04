<?php

session_start();
require_once __DIR__ . '/database/ShippingDB.php';

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit;
}

$shippingDB = new ShippingDB();
$shippingMethods = $shippingDB->fetch(null);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["shipping_method"])) {
        $error = "Please select a shipping method.";
    } else {
        $selectedShippingMethod = $_POST["shipping_method"];
        $_SESSION["shipping_method"] = $selectedShippingMethod;
        header("Location: checkout.php");
        exit;
    }
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container">
    <h1>Choose Shipping Method</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <?php foreach ($shippingMethods as $method): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shipping_method" id="shipping_<?php echo $method["id"]; ?>" value="<?php echo $method["id"]; ?>">
                    <label class="form-check-label" for="shipping_<?php echo $method["id"]; ?>">
                        <?php echo htmlspecialchars($method["name"]); ?> - $<?php echo number_format($method["price"], 2); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Continue to Checkout</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>