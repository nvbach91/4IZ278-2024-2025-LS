<?php

@session_start();
require_once __DIR__ . '/../database/ProductsDB.php';
require_once __DIR__ . '/../database/CategoriesDB.php';

$categoriesDB = new CategoriesDB();
$productsDB = new ProductsDB();

if (!isset($_GET["id"])) {
    header("Location: /../index.php");
    exit;
}
$productId = $_GET["id"];
$product = $productsDB->fetchById($productId);
if (!$product) {
    header("Location: /../index.php");
    exit;
}

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $price = htmlspecialchars(trim($_POST["price"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $img = htmlspecialchars(trim($_POST["img"]));
    $stock = htmlspecialchars(trim($_POST["stock"]));
    $category = htmlspecialchars(trim($_POST["category_id"]));

    if (empty($name)) {
        $errors["name"] = "Name is required";
    }

    if (empty($price)) {
        $errors["price"] = "Price is required";
    }

    if (empty($description)) {
        $errors["description"] = "Description is required";
    }

    if (empty($stock)) {
        $errors["stock"] = "Stock is required";
    } elseif (!is_numeric($stock) || $stock < 0) {
        $errors["stock"] = "Stock must be a non-negative number";
    }
    if (empty($category)) {
        $errors["category"] = "Category is required";
    } elseif (!is_numeric($category) || !$categoriesDB->fetchById($category)) {
        $errors["category"] = "Invalid category selected";
    }


    if (!filter_var($img, FILTER_VALIDATE_URL)) {
        $errors["img"] = "Link to image is required";
    }

    if (empty($errors)) {
        if ($productsDB->fetchById($productId)['last_updated'] !== $_SESSION['timestamp']) {
            $_SESSION['errors'] = ["timestamp" => "This product has been modified by another user."];
            header("Location: editProduct.php?id=" . $productId);
            exit;
        } else {
            $productsDB->update($productId, $name, $description, $price, $img, $stock, time(), $category);
            $_SESSION["success"] = "Product was successfully edited";
            header("Location: adminProducts.php");
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: editProduct.php?id=" . $productId);
    }
}
