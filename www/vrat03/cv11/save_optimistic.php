<?php include_once 'database/Database.php';?>
<?php

if(!isset($_SESSION)) { 
    session_start(); 
}

if (!isset($_SESSION['user_id'])) {
    die("Nejste přihlášen!");
}

$database=new Database();

$id = (int)$_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];

$product = $database->connection->prepare("SELECT * FROM products WHERE id = :id");
$product->execute(['id' => $id]);
$product = $product->fetch();

if (!$product) {
    die("Produkt nenalezen.");
}

if (!isset($_SESSION['optimistic_ts'][$id]) || $_SESSION['optimistic_ts'][$id] !== $product['last_updated']) {
    echo("Produkt byl mezitím změněn jiným uživatelem. Vaše změny nebyly uloženy.");
} else {
    $stmt = $database->connection->prepare("UPDATE products SET name = :name, price = :price, last_updated = NOW() WHERE id = :id");
    $stmt->execute(['name' => $name, 'price' => $price, 'id' => $id]);
    unset($_SESSION['optimistic_ts'][$id]);
    echo "Změny byly úspěšně uloženy (optimisticky).";
}
?>

<p><a href="index.php">Zpět na seznam</a></p>