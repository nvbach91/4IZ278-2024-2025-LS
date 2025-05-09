<?php include_once 'database/Database.php';?>
<?php
$database=new Database();
if(!isset($_SESSION)) { 
    session_start(); 
}

if (!isset($_SESSION['user_id'])) {
    die("Nejste přihlášen!");
}

$id = (int)$_GET['id'];
$product = $database->connection->prepare("SELECT * FROM products WHERE id = :id");
$product->execute(['id' => $id]);
$product = $product->fetch();

if (!$product) {
    die("Produkt nenalezen.");
}

// Uložíme timestamp do sessionu
$_SESSION['optimistic_ts'][$id] = $product['last_updated'];
?>

<h2>Editace produktu (optimistický zámek)</h2>

<form action="save_optimistic.php" method="post">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <label>Název: <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"></label><br>
    <label>Cena: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"></label><br>
    <button type="submit">Uložit</button>
</form>

<p><a href="index.php">Zpět na seznam</a></p>
