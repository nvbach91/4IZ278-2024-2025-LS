<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 
    require_once __DIR__ . '/database/DB_Scripts/OrderDB.php';
    require_once __DIR__ . '/database/DB_Scripts/PaymentMethodDB.php';
    require_once __DIR__ . '/database/DB_Scripts/ShippingMethodDB.php';
    require_once __DIR__ . '/database/DB_Scripts/OrderItemDB.php';
    require_once __DIR__ . '/database/DB_Scripts/OrderStatusDB.php';
    require_once __DIR__ . '/database/DB_Scripts/UserDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    if(isset($_SESSION["updateStatusFailed"])) {
        $updateStatusFailed = $_SESSION["updateStatusFailed"];
        unset($_SESSION["updateStatusFailed"]);
    }

    if(isset($_SESSION["updateStatusSuccess"])) {
        $updateStatusSuccess = $_SESSION["updateStatusSuccess"];
        unset($_SESSION["updateStatusSuccess"]);
    }

    $orderId = isset($_GET["id"]) ? (int)$_GET["id"] : null;

    if(!$orderId) {
        $_SESSION["viewOrderFailed"] = "Neplatný identifikátor objednávky. Zkontrolujte prosím odkaz.";
        header("Location: ./orders.php");
        exit();
    }

    $orderDB = new OrderDB();
    $order = $orderDB->getOrderById($orderId) ?? null;

    if(!$order) {
        $_SESSION["viewOrderFailed"] = "Tato objednávka neexistuje nebo byla smazána.";
        header("Location: ./orders.php");
        exit();
    }
?>

<div class="container mt-5">
    <?php if(isset($updateStatusFailed)) :?>
        <div class="alert alert-danger mt-3"><?php echo $updateStatusFailed;?></div>
    <?php endif; ?>

    <?php if(isset($updateStatusSuccess)) :?>
        <div class="alert alert-danger mt-3"><?php echo $updateStatusSuccess;?></div>
    <?php endif; ?>

    <?php if(($loggedIn && $privilegeLevel > 1) || ($loggedIn && $privilegeLevel <= 1 && $order[0]["user"] == $_SESSION["user_id"])): 
        $date = new DateTime($order[0]["created_at"]);
        $date = $date->format("d.m.Y H:i:s");

        $paymentMethodDB = new PaymentMethodDB();
        $shippingMethodDB = new ShippingMethodDB();
        $orderItemDB = new OrderItemDB();
        $orderStatusDB = new OrderStatusDB();
        $userDB = new UserDB();

        $paymentMethod = $paymentMethodDB->getMethodName($order[0]["payment_method"]);
        $shippingMethod = $shippingMethodDB->getMethodName($order[0]["shipping_method"]);
        $orderProducts = $orderItemDB->getProductsFromOrder($orderId);
        $orderStatus = $orderStatusDB->getStatusName($order[0]["status"]);

        $user = $userDB->getUserById($order[0]["user"]);
        $name = $user["name"];
        $surname = $user["surname"];
        $fullName = htmlspecialchars($name . ' ' . $surname);
    ?>
        <h1 class="text-center mt-3 mb-5">Objednávka č. <?php echo htmlspecialchars($order[0]["id_order"]); ?></h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm mb-4 card-order-detail">
                    <p><b>Datum objednávky:</b> <?php echo $date; ?></p>
                    <p><b>Stav objednávky:</b> <?php echo $orderStatus; ?></p>
                    <p><b>Způsob platby:</b> <?php echo $paymentMethod; ?></p>
                    <p><b>Způsob dopravy:</b> <?php echo $shippingMethod; ?></p>
                    <p><b>Adresa doručení:</b> <?php echo htmlspecialchars($order[0]["billing_address"]); ?></p>
                    <p><b>Objednal:</b> <?php echo $fullName;?></p>
                    <p><b>Cena dopravy:</b> <?php echo $order[0]["shipping_price"];?> Kč</p>
                    <p><b>Cena platby:</b> <?php echo $order[0]["payment_price"];?> Kč</p>
                    <p><b>Celková cena:</b> <?php echo $order[0]["total_price"];?> Kč</p>
                    <?php if($privilegeLevel > 1): ?>
                        <a class="btn btn-primary w-100 mb-2" href="./scripts/acceptOrder.php?id=<?php echo htmlspecialchars($order[0]["id_order"])?>">Potvrdit objednávku</a>
                        <a class="btn btn-warning w-100" href="./scripts/rejectOrder.php?id=<?php echo htmlspecialchars($order[0]["id_order"])?>">Zamítnout</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Název</th>
                            <th>Množství</th>
                            <th>Cena za kus</th>
                            <th>Celkem za položku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderProducts as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product["name"]); ?></td>
                                <td><?php echo htmlspecialchars($product["quantity"]); ?></td>
                                <td><?php echo htmlspecialchars($product["price_per_item"]); ?> Kč</td>
                                <td><?php echo htmlspecialchars($product["quantity"] * $product["price_per_item"]); ?> Kč</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif($loggedIn && $privilegeLevel == 1 && $order[0]["user"] !== $_SESSION["user_id"]): ?>

        <h1 class="text-center mt-3 mb-5">Přístup odepřen</h1>
        <div class="container text-center mb-5">
            <p>Tato stránka je dostupná pouze administrátorům.</p>
            <a class="btn btn-primary mt-3" href="./index.php">Zpět na hlavní stránku</a>
        </div>

    <?php else: ?>

        <h1 class="text-center mt-3 mb-5">Pro přístup k této stránce musíte být přihlášeni</h1>
        <div>
            <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
            <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
        </div>

    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/foot.php'; ?>