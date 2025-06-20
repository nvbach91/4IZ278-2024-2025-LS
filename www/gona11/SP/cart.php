<?php require __DIR__ . "/includes/head.php"; ?>
<?php require __DIR__ . "/requires/navbar.php"; ?>

<?php require_once __DIR__ . '/database/DB_Scripts/ProductDB.php'?>

<?php 
    
    $loggedIn = false;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
    }

    if(isset($_SESSION["deleteFromCartFailed"])) {
        $deleteFromCartFailed = $_SESSION["deleteFromCartFailed"];
        unset($_SESSION["deleteFromCartFailed"]);
    }

    if(isset($_SESSION["deleteFromCartSuccess"])) {
        $deleteFromCartSuccess = $_SESSION["deleteFromCartSuccess"];
        unset($_SESSION["deleteFromCartSuccess"]);
    }

    if(isset($_SESSION["createOrderFailed"])) {
        $createOrderFailed = $_SESSION["createOrderFailed"];
        unset($_SESSION["createOrderFailed"]);
    }

    $cartItems = $_SESSION["cart"] ?? [];
    $productIds = array_keys($cartItems);
    $allIds = implode(',', $productIds);
    // $productsInCart = $productDB->getProductsByIds($productIds);
?>

<div class="container mb-5">
    <h1 class="text-center mt-3">Košík</h1>
    <p class="lead text-center">Produkty se z košíku odstraní po Vašem odhlášení.</p>
    <?php if(isset($deleteFromCartSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($deleteFromCartSuccess);?></div>
    <?php endif; ?>
    <?php if(isset($deleteFromCartFailed)) :?>
        <div class="alert alert-warning mt-3"><?php echo htmlspecialchars($deleteFromCartFailed);?></div>
    <?php endif; ?>
    <?php if(isset($createOrderFailed)) :?>
        <div class="alert alert-warning mt-3"><?php echo htmlspecialchars($createOrderFailed);?></div>
    <?php endif; ?>

    <?php if($loggedIn): ?>
        <div class="row mt-4">

        <div class="col-md-4 mb-4">
            <div class="card p-4 shadow-sm d-flex flex-column h-100">
                <h3 class="mb-3">Shrnutí košíku</h3>
                <?php
                    $totalPrice = 0;
                    $totalItems = 0;
                    foreach ($cartItems as $item) {
                        $totalPrice += $item["price"] * $item["quantity"];
                        $totalItems += $item["quantity"];
                    }
                ?>
                <p><b>Počet položek:</b> <?php echo $totalItems; ?></p>
                <p><b>Celková cena:</b> <?php echo htmlspecialchars($totalPrice);?> Kč</p>
                <?php if($totalItems > 0): ?>
                    <a class="btn btn-primary w-100 mt-auto" href="./create-order.php">Pokračovat k objednávce</a>
                <?php endif; ?>
            </div>
        </div>

            <div class="col-md-8">
                <?php if (!empty($cartItems)) : ?>
                    <div class="cart-list bg-white rounded shadow-sm">
                        <div class="cart-list-header d-flex fw-bold border-bottom py-2 px-3">
                            <div class="flex-grow-1">Název</div>
                            <div class="cart-item">Cena</div>
                            <div class="cart-item">Množství</div>
                            <div class="cart-item">Odstranění</div>
                        </div>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-list-row d-flex align-items-center border-bottom py-2 px-3">
                                <div class="flex-grow-1"><?php echo htmlspecialchars($item["name"]);?></div>
                                <div class="cart-item"><?php echo htmlspecialchars($item["price"]);?> Kč</div>
                                <div class="cart-item"><?php echo htmlspecialchars($item["quantity"]);?></div>
                                <div class="cart-item">
                                    <a href="./scripts/deleteFromCart.php?id_product=<?php echo htmlspecialchars($item["id_product"]);?>" class="btn btn-danger btn-sm">Odstranit</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <h4>Váš košík je aktuálně prázdný.</h4>
                <?php endif;?>
            </div>
        </div>
    <?php else: ?>
        <h3 class="text-center mt-3 mb-5">Pro přístup do košíku musíte být přihlášeni</h3>
        <div>
            <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
            <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
        </div>
    <?php endif;?>
</div>
<?php require __DIR__ . "/includes/foot.php"; ?>