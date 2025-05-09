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

if ($product['edit_user_id'] != $_SESSION['user_id']) {
    echo("Zámek již nevlastníte – úpravy nebyly uloženy.");
} else {
    $stmt = $database->connection->prepare("UPDATE products SET name = :name, price = :price, last_updated = NOW(), edit_lock_time = NULL, edit_user_id = NULL WHERE id = :id");
    $stmt->execute(['name' => $name, 'price' => $price, 'id' => $id]);
    echo "Změny byly úspěšně uloženy (pesimisticky).";
}
?>

<p><a href="index.php">Zpět na seznam</a></p>
