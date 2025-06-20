<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 
    require_once __DIR__ . '/database/DB_Scripts/OrderDB.php';
    require_once __DIR__ . '/database/DB_Scripts/OrderStatusDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    if(isset($_SESSION["viewOrderFailed"])) {
        $viewOrderFailed = $_SESSION["viewOrderFailed"];
        unset($_SESSION["viewOrderFailed"]);
    }

    $orderDB = new OrderDB();
    $orders = $orderDB->getAllOrders() ?? null;

?>

<div class="container mt-5">

    <?php if(isset($viewOrderFailed)) :?>
        <div class="alert alert-danger mt-3"><?php echo $viewOrderFailed;?></div>
    <?php endif; ?>

    <?php if($loggedIn && $privilegeLevel > 1): ?>
        <h1 class="text-center mb-4">Přehled objednávek</h1>
        <div class="row mt-4">
            <?php if(isset($orders) && count($orders) > 0): ?>
                <?php foreach ($orders as $order): 
                    $date = new DateTime($order["created_at"]);
                    $date = $date->format("d.m.Y H:i:s");
                    $orderStatusDB = new OrderStatusDB();
                    $orderStatus = $orderStatusDB->getStatusName($order["status"]);
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title mb-2">Objednávka #<?php echo htmlspecialchars($order["id_order"]); ?></h4>
                                <p class="mb-1"><b>Datum:</b> <?php echo $date; ?></p>
                                <p class="mb-1"><b>Celková cena:</b> <?php echo number_format($order["total_price"], 0, ',', ' ') . ' Kč'; ?></p>
                                <p class="mb-3"><b>Stav:</b> <?php echo htmlspecialchars($orderStatus); ?></p>
                                <div class="mt-auto d-flex justify-content-end">
                                    <a class="btn btn-secondary btn-sm" href="./order.php?id=<?php echo htmlspecialchars($order["id_order"]); ?>">Zobrazit detaily</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Nebyly nalezeny žádné objednávky k zobrazení.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif($privilegeLevel <= 1): ?>
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