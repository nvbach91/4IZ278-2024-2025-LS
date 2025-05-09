<?php include_once 'database/Database.php';?>
<?php

if(!isset($_SESSION)) { 
    session_start(); 
}

$database=new Database();


if (isset($_POST['login'])) {
    $_SESSION['user_id'] = (int)$_POST['user_id'];
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$products = $database->connection->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Přihlášení</h2>

<?php if (isset($_SESSION['user_id'])): ?>
    <p>Přihlášen jako uživatel ID: <strong><?= $_SESSION['user_id'] ?></strong></p>
    <form method="post">
        <button type="submit" name="logout">Odhlásit se</button>
    </form>
<?php else: ?>
    <form method="post">
        <label>Zadej ID uživatele:
            <input type="number" name="user_id" required>
        </label>
        <button type="submit" name="login">Přihlásit se</button>
    </form>
<?php endif; ?>

<hr>

<h2>Produkty</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Název</th>
        <th>Cena</th>
        <th>Akce</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= $product['price'] ?> Kč</td>
            <td>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="edit_optimistic.php?id=<?= $product['id'] ?>">Editovat optimisticky</a> |
                    <a href="edit_pessimistic.php?id=<?= $product['id'] ?>">Editovat pesimisticky</a>
                <?php else: ?>
                    (Přihlaš se pro editaci)
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>