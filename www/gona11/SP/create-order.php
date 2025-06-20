<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 
    require_once __DIR__ . '/database/DB_Scripts/PaymentMethodDB.php';
    require_once __DIR__ . '/database/DB_Scripts/ShippingMethodDB.php';
    require_once __DIR__ . '/database/DB_Scripts/OrderDB.php';
    require_once __DIR__ . '/database/DB_Scripts/OrderItemDB.php';
    require_once __DIR__ . '/database/DB_Scripts/ProductDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE["loginSuccess"])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION["privilege"] ?? 1;
    }

    $cartItems = $_SESSION["cart"] ?? [];
    $productIds = array_keys($cartItems);
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item["price"] * $item["quantity"];
    }

    if (!isset($cartItems) && empty($cartItems)) {
        $_SESSION["createOrderFailed"] = "Produkt neexistuje.";
        header("Location: ./cart.php");
        exit(); 
    }

    $paymentDB = new PaymentMethodDB();
    $paymentMethods = $paymentDB->getAllMethods();

    $shippingDB = new ShippingMethodDB();
    $shippingMethods = $shippingDB->getAllMethods();

    $orderDB = new OrderDB();
    $orderItemDB = new OrderItemDB();
    $productDB = new ProductDB();

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $shippingMethod = htmlspecialchars(trim($_POST['shipping_method']));
        $billingAddress = htmlspecialchars(trim($_POST['billing_address']));
        $paymentMethod = htmlspecialchars(trim($_POST['payment_method']));

        $errors = [];
        if(empty($shippingMethod)) {
            $errors['shipping_method'] = "Zvolte typ dopravy.";
        }

        if(empty($billingAddress)) {
            $errors['shipping_method'] = "Zadejte adresu k doručení zboží.";
        }

        if(empty($paymentMethod)) {
            $errors['payment_method'] = "Zvolte typ platby.";
        }

        if(empty($cartItems)) {
            $errors['cart'] = "Košík je prázdný, nelze vytvořit objednávku.";
        }

        $userId = $_SESSION["user_id"];
        $shippingMethodPrice = $shippingMethods[$shippingMethod-1]["price"];
        $paymentMethodPrice = $paymentMethods[$paymentMethod-1]["price"];
        $orderPrice = $totalPrice + $shippingMethodPrice + $paymentMethodPrice;

        if(empty($errors)) {
            $orderId = $orderDB->createOrder(
                $userId,
                $shippingMethod,
                $shippingMethodPrice,
                $paymentMethod,
                $paymentMethodPrice,
                $billingAddress,
                $orderPrice
            );
            foreach ($cartItems as $item) {
                $orderItemDB->insertOrderItem($orderId, $item["id_product"], $item["quantity"], $item["price"]);
                $productDB->updateProductStock($item["id_product"], $item["quantity"]);
            }
            unset($_SESSION["cart"]);
            header('Location: ./order-created.php');
            exit();
        }
    }


?>

<div class="container mt-4 mb-5">
<?php if($loggedIn): ?>
    <h1 class="text-center">Vytvoření objednávky</h1>
    <p class="lead text-center">Zadejte typ dopravy, adresu a typ platby pro vytvoření objednávky.</p>
    <div class="row">

        <div class="col-md-4 mb-4">
            <h2 class="mb-3">Vaše produkty v košíku:</h2>
            <div class="cart-list bg-white rounded shadow-sm">
                <div class="cart-list-header d-flex fw-bold border-bottom py-2 px-3">
                    <div class="flex-grow-1">Název</div>
                    <div style="width: 90px;">Cena</div>
                    <div style="width: 80px;">Množství</div>
                </div>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-list-row d-flex align-items-center border-bottom py-2 px-3">
                        <div class="flex-grow-1"><?php echo htmlspecialchars($item["name"]);?></div>
                        <div style="width: 90px;"><?php echo htmlspecialchars($item["price"]);?> Kč</div>
                        <div style="width: 80px;"><?php echo htmlspecialchars($item["quantity"]);?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <h4 class="mt-4">Mezisoučet: <?php echo htmlspecialchars($totalPrice);?> Kč</h4>
            <a href="./cart.php" class="btn btn-primary mt-3">Zpět do košíku</a>
        </div>

        <div class="col-md-8">
            <form method="POST" action="create-order.php">
                <h2 class="mt-2">Zvolte typ dopravy:</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Název dopravy</th>
                            <th>Cena</th>
                            <th>Doba doručení</th>
                            <th>Vybrat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($shippingMethods as $method): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($method["name"]); ?></td>
                                <td><?php echo htmlspecialchars($method["price"]); ?> Kč</td>
                                <td><?php echo htmlspecialchars($method["delivery_time"]); ?> Dní</td>
                                <td>
                                    <input type="radio" name="shipping_method" value="<?php echo htmlspecialchars($method["id_shipping_method"]); ?>" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <b><label>Zadejte adresu k doručení:</label></b>
                <input type="text" class="form-control mb-3" name="billing_address" placeholder="Zadejte adresu" required>

                <h2 class="mt-4">Zvolte typ platby:</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Název platby</th>
                            <th>Cena</th>
                            <th>Vybrat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentMethods as $method): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($method["name"]); ?></td>
                                <td><?php echo htmlspecialchars($method["price"]); ?> Kč</td>
                                <td>
                                    <input type="radio" name="payment_method" value="<?php echo htmlspecialchars($method["id_payment_method"]); ?>" required>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary mt-4" type="submit">Vytvořit objednávku</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <h3 class="text-center mt-3 mb-5">Vytvoření objednávky je možné pouze po přihlášení.</h3>
    <div>
        <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
        <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
    </div>
<?php endif; ?>
</div>

</div>

<?php require __DIR__ . '/includes/foot.php'; ?>