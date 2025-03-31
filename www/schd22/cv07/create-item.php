<?php
require_once __DIR__ . '/database/ProductDB.php';
require_once __DIR__ . '/database/CategoriesDB.php';

$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->getAllCategories();
$productsDB = new ProductDB();
$success = false;
$errors = [];

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
        $productsDB->insert($name, $description, $price, $img, $category_id);
        header('Location: index.php');
        exit();
    }
}
?>

<?php require_once 'incl/header.php'; ?>

<div class="container mt-5">
  <h2>Přidat nový produkt</h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $e): ?>
        <div><?php echo htmlspecialchars($e); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label for="name">Název</label>
      <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="form-group">
      <label for="description">Popis</label>
      <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
    </div>

    <div class="form-group">
      <label for="price">Cena</label>
      <input type="number" step="10" class="form-control" name="price" id="price" required>
    </div>

    <div class="form-group">
  <label for="img">Vyber obrázek</label>
  <select name="img" id="img" class="form-control" required>
    <option value="">-- Vyber ikonu --</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/classicon_warrior.jpg">Meč</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/classicon_priest.jpg">Staff</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/inv_scroll_03.jpg">Scroll</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/ability_rogue_masterofsubtlety.jpg">Spell</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/inv_magemount_fire.jpg">Cyborg</option>
    <option value="https://wow.zamimg.com/images/wow/icons/large/spell_nature_forceofnature.jpg">Universal</option>
  </select>
</div>


    <div class="form-group">
        <label for="category_id">Kategorie</label>
            <select name="category_id" id="category_id" class="form-control" required>
                 <option value="">-- Vyber kategorii --</option>
                     <?php foreach ($categories as $category): ?>
                         <option value="<?php echo $category['category_id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                         </option>
                     <?php endforeach; ?>
            </select>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Vytvořit</button>
  </form>
</div>
