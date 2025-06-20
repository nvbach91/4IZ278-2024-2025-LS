<?php require_once __DIR__ . '/../database/DB_Scripts/ProductDB.php'; ?>
<?php 
    session_start();
    
    $loggedIn = false;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
    }

    $productId = isset($_GET["id_product"]) ? (int)$_GET["id_product"] : null;

    if(!$loggedIn) {
        $_SESSION["addToCartFailed"] = "Musíte být přihlášeni, aby jste mohli přidat produkt do košíku.";
        header("Location: ../product.php?id=" . $productId);
        exit();
    }

    $productDB = new ProductDB();
    $product = $productDB->getProductById($productId);

    if (!$product) {
        $_SESSION["addToCartFailed"] = "Produkt neexistuje.";
        header("Location: ../product.php?id=" . $productId);
        exit();
    }

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    if (isset($_SESSION["cart"][$productId])) {
        if($_SESSION["cart"][$productId]["quantity"] >= $product["stock"]) {
            $_SESSION["addToCartFailed"] = "Do košíku nelze přidat více kusů, než je skladem.";
            header("Location: ../product.php?id=" . $productId);
            exit();
        } else {
            $_SESSION["cart"][$productId]["quantity"]++;
        }
    } else {
        if($product["stock"] <= 0) {
            $_SESSION["addToCartFailed"] = "Produkt není skladem.";
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION["cart"][$productId] = [
                "id_product" => $product["id_product"],
                "name" => $product["name"],
                "price" => $product["price"],
                "quantity" => 1,
                "image" => $product["image"]
            ];
        }
    }

    $_SESSION["addToCartSuccess"] = "Zboží bylo přidáno do košíku.";
    header("Location: ../product.php?id=" . $productId);
    exit();
?>