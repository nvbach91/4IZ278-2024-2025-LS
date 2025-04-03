<?php
// database.php

const DB_SERVER_URL = '127.0.0.1';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_DATABASE = 'cv07';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_SERVER_URL . ';dbname=' . DB_DATABASE,
        DB_USERNAME,
        DB_PASSWORD
    );
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    
    die("Database connection failed: " . $e->getMessage());
}

function fetchAllGoods($pdo, $limit, $offset) {
    $stmt = $pdo->prepare("SELECT * FROM cv07_goods ORDER BY good_id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchGoodById($pdo, $good_id) {
    $stmt = $pdo->prepare("SELECT * FROM cv07_goods WHERE good_id = :good_id");
    $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addGood($pdo, $name, $description, $price, $img) {
    $stmt = $pdo->prepare("INSERT INTO cv07_goods (name, description, price, img) VALUES (:name, :description, :price, :img)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':img', $img);
    return $stmt->execute();
}

function updateGood($pdo, $good_id, $name, $description, $price, $img) {
    $stmt = $pdo->prepare("UPDATE cv07_goods SET name = :name, description = :description, price = :price, img = :img WHERE good_id = :good_id");
    $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':img', $img);
    return $stmt->execute();
}

function deleteGood($pdo, $good_id) {
    $stmt = $pdo->prepare("DELETE FROM cv07_goods WHERE good_id = :good_id");
    $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
    return $stmt->execute();
}
?>