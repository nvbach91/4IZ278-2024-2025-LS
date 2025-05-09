<?php include_once 'database/Database.php';?>
<?php

if(!isset($_SESSION)) { 
    session_start(); 
}

if (!isset($_SESSION['user_id'])) {
    die("Nejste přihlášen!");
}

$database=new Database();

$id = (int)$_GET['id'];
$product = $database->connection->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$id]);
$product = $product->fetch();

if (!$product) {
    die("Produkt nenalezen.");
}

$now = new DateTime();
$editTime = $product['edit_lock_time'] ? new DateTime($product['edit_lock_time']) : null;
$expired = $editTime && $editTime < (clone $now)->modify('-5 minutes');

if ($product['edit_user_id'] && !$expired && $product['edit_user_id'] != $_SESSION['user_id']) {
    header('Location: ./err_pessimistic.php');
    exit();
}

$stmt = $database->connection->prepare("UPDATE products SET edit_lock_time = NOW(), edit_user_id = :user_id WHERE id = :id");
$stmt->execute(['user_id' => $_SESSION['user_id'], 'id' => $id]);
?>

<h2>Editace produktu (pesimistický zámek)</h2>

<form action="save_pessimistic.php" method="post">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <label>Název: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"></label><br>
    <label>Cena: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"></label><br>
    <button type="submit">Uložit</button>
</form>

<p><a href="index.php">Zpět na seznam</a></p>
