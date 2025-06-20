<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/requires/navbar.php'; ?>

<?php require_once __DIR__ . '/database/DB_Scripts/UserDB.php'?>
<?php require_once __DIR__ . '/database/DB_Scripts/OrderDB.php'?>
<?php require_once __DIR__ . '/database/DB_Scripts/OrderStatusDB.php'?>

<?php 
    $loggedIn = false;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
    }

    $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

?>
<div class="container mb-5">
    <h1 class="mt-4 text-center">Můj profil</h1>
    <p class="lead text-center">Prohlédněte si své objednávky, předměty a gearlisty.</p>
    <?php if ($loggedIn): 
        $userDB = new UserDB();
        $user = $userDB->getUserById($userId);

        $name = $user["name"];
        $surname = $user["surname"];
        $fullName = htmlspecialchars($name . ' ' . $surname);

        $orderDB = new OrderDB();
        $orders = $orderDB->getOrdersByUserId($userId);

        $orderStatusDB = new OrderStatusDB();
    ?>
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card p-4 shadow-sm mb-4  profile-sidebar">
                <div class="alert alert-success mb-3">Jste přihlášen jako <b><?php echo htmlspecialchars($fullName); ?></b></div>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                <p><strong>Úroveň oprávnění:</strong> <?php echo htmlspecialchars($user["privilege_level"] ?? "Základní"); ?></p>
            </div>
            <div class="card p-4 shadow-sm mb-4  profile-sidebar">
                <h4 class="mb-3">Gearlisty</h4>
                <a href="./gearlists.php" class="btn btn-primary w-100 mb-2">Moje Gearlisty</a>
            </div>
            <div class="card p-4 shadow-sm  profile-sidebar ">
                <h4 class="mb-3">Předměty</h4>
                <a href="./my-items.php" class="btn btn-primary w-100">Moje předměty</a>
            </div>
        </div>

        <div class="col-md-8">
            <h2 class="mb-4">Vaše objednávky</h2>
            <?php if (count($orders) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID objednávky</th>
                                <th>Datum vytvoření</th>
                                <th>Celková cena</th>
                                <th>Status</th>
                                <th>Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): 
                                $orderStatus = $orderStatusDB->getStatusName($order["status"]);
                                $date = new DateTime($order["created_at"]);
                                $date = $date->format("d.m.Y H:i:s");    
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order["id_order"]); ?></td>
                                    <td><?php echo htmlspecialchars($date); ?></td>
                                    <td><?php echo htmlspecialchars($order["total_price"]); ?> Kč</td>
                                    <td><?php echo htmlspecialchars($orderStatus); ?></td>
                                    <td><a href="./order.php?id=<?php echo htmlspecialchars($order["id_order"]); ?>" class="btn btn-primary btn-sm">Zobrazit detaily</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Nemáte žádné objednávky.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
        <div>
            <h3>Nejste přihlášeni</h3>
            <p>Pro zobrazení profilu se prosím přihlaste.</p>
            <div>
                <a href="./login.php" class="btn btn-primary">Přihlásit se</a>
                <a href="./register.php" class="btn btn-secondary">Registrovat se</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/foot.php'; ?>