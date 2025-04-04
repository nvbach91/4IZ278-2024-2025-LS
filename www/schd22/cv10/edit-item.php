<?php
require_once __DIR__ . '/database/ProductDB.php';

$productsDB = new ProductDB();
$errors = [];
$success = false;

// Získání ID z URL
if (!isset($_GET['good_id']) || !is_numeric($_GET['good_id'])) {
    die('Neplatné ID.');
}
$goodId = (int) $_GET['good_id'];

// Načtení produktu
$product = $productsDB->findBy('product_id', $goodId);
if (!$product || count($product) === 0) {
    die('Produkt nenalezen.');
}
$product = $product[0]; // fetchAll → první záznam

// Zpracování POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $img = trim($_POST['img'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);

    if (!$name) $errors[] = 'Název je povinný.';
    if (!$description) $errors[] = 'Popis je povinný.';
    if ($price <= 0) $errors[] = 'Cena musí být větší než 0.';
    if (!$img) $errors[] = 'Obrázek je povinný.';
    if ($category_id <= 0) $errors[] = 'Kategorie musí být vybraná.';

    if (empty($errors)) {
        $productsDB->updateProduct($goodId, $name, $description, $price, $img, $category_id);
        header("Location: edit-item.php?good_id=$goodId&success=1");
        exit();
    }
}

// Zobrazí se hláška po redirectu
if (isset($_GET['success'])) {
    $success = true;
}
?>

<?php require_once 'incl/header.php'; ?>

<div class="container mt-4">
  <h2>Upravit produkt</h2>

  <?php if ($success): ?>
    <div class="alert alert-success">Produkt byl úspěšně upraven.</div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <div><?php echo htmlspecialchars($error); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label for="name">Název</label>
      <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>

    <div class="form-group">
      <label for="description">Popis</label>
      <textarea name="description" id="description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>

    <div class="form-group">
      <label for="price">Cena</label>
      <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    </div>

    <div class="form-group">
      <label for="img">URL obrázku</label>
      <input type="text" name="img" id="img" class="form-control" value="<?php echo htmlspecialchars($product['img']); ?>" required>
    </div>

    <div class="form-group">
      <label for="category_id">ID kategorie</label>
      <input type="number" name="category_id" id="category_id" class="form-control" value="<?php echo htmlspecialchars($product['category_id']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Uložit změny</button>
    <br>
    <br>
    <a href="delete-item.php?good_id=<?php echo $product['product_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Opravdu chceš smazat tento produkt?');">Smazat</a>

  </form>
</div>
