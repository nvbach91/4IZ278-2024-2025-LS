<?php

session_start();
require_once __DIR__ . '/database/GoodsDB.php';
$goodsDB = new GoodsDB();


if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}
$goodId = $_GET["id"];
$good = $goodsDB->fetchById($goodId);
if (!$good) {
    header("Location: index.php");
    exit;
}

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST["name"]));
    $price = htmlspecialchars(trim($_POST["price"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $img = htmlspecialchars(trim($_POST["img"]));

    if (empty($name)) {
        $errors["name"] = "Name is required";
    }

    if (empty($price)) {
        $errors["price"] = "Price is required";
    }

    if (empty($description)) {
        $errors["description"] = "Description is required";
    }

    if (!filter_var($img, FILTER_VALIDATE_URL)) {
        $errors["img"] = "Link to image is required";
    }

    if (empty($errors)) {
        if(time() - $good["timestampP"] > 60){
            header("Location: error.php");
            exit;
        }
        $goodsDB->updateP($goodId, $name, $price, $description, $img);
        header("Location: index.php");
    }
}
