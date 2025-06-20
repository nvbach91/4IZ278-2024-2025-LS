<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/login.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../../database-config/ProductsAdminDB.php';

$productsDB = new ProductsAdminDB();

// Načtení žánrů a kategorií z DB
$pdo = $productsDB->getPdo();

$genres = $pdo->query('SELECT id, name FROM genres ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query('SELECT id, name FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

// Mapování 
$genreMap = [];
$genreMapFlipped = [];
foreach ($genres as $g) {
    $genreMap[$g['id']] = $g['name'];
    $genreMapFlipped[$g['name']] = $g['id'];
}
$categoryMap = [];
$categoryMapFlipped = [];
foreach ($categories as $c) {
    $categoryMap[$c['id']] = $c['name'];
    $categoryMapFlipped[$c['name']] = $c['id'];
}

$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$totalProducts = $productsDB->countAll();
$totalPages = ceil($totalProducts / $limit);

$products = $productsDB->fetchPage($limit, $offset);

// Textové hodnoty pro zobrazení v tabulce
foreach ($products as &$p) {
    $p['genre_text'] = isset($genreMap[$p['genre_id']]) ? $genreMap[$p['genre_id']] : '';
    $p['category_text'] = isset($categoryMap[$p['category_id']]) ? $categoryMap[$p['category_id']] : '';
}
unset($p);
