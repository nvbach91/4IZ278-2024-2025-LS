<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$productId = $_GET['id'] ?? null;
if (!$productId) {
    header('Location: products.php');
    exit;
}

$pdo = (new Database())->getConnection();
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: products.php');
    exit;
}

$errors = [];
$stmtBrands = $pdo->query("SELECT id, name FROM brands ORDER BY name");
$brands = $stmtBrands->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $brand = intval($_POST['brand_id']);
    $desc = trim($_POST['description']);
    $image = trim($_POST['image']);
    $displaySize = floatval($_POST['display_size']);
    $ram = intval($_POST['ram']);
    $releaseYear = intval($_POST['release_year']);
    $battery = intval($_POST['battery_capacity']);
    $deactivated = isset($_POST['deactivated']) ? 1 : 0;

    if (!$name || !$price || !$brand || !$image) {
        $errors[] = "Všechna pole kromě popisu jsou povinná.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, brand_id = ?, description = ?, image = ?, display_size = ?, ram = ?, release_year = ?, battery_capacity = ?, deactivated = ? WHERE id = ?");
        $stmt->execute([$name, $price, $brand, $desc, $image, $displaySize, $ram, $releaseYear, $battery, $deactivated, $productId]);

        $_SESSION['success_message'] = "Produkt byl úspěšně upraven.";
        header("Location: products.php");
        exit;
    }
}
?>

<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Upravit produkt</h2>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Název</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Cena</label>
            <input type="number" name="price" id="price" class="form-control" value="<?= $product['price'] ?>" required step="0.01">
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">Značka</label>
            <select name="brand_id" id="brand_id" class="form-select" required>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= $b['id'] == $product['brand_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Obrázek (název souboru)</label>
            <input type="text" name="image" id="image" class="form-control" value="<?= htmlspecialchars($product['image']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="display_size" class="form-label">Velikost displeje (palce)</label>
            <input type="number" name="display_size" id="display_size" class="form-control" step="0.1" value="<?= $product['display_size'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="ram" class="form-label">RAM (v MB)</label>
            <input type="number" name="ram" id="ram" class="form-control" value="<?= $product['ram'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">Rok vydání</label>
            <input type="number" name="release_year" id="release_year" class="form-control" value="<?= $product['release_year'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="battery_capacity" class="form-label">Kapacita baterie (mAh)</label>
            <input type="number" name="battery_capacity" id="battery_capacity" class="form-control" value="<?= $product['battery_capacity'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Popis</label>
            <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="deactivated" id="deactivated" value="1" <?= $product['deactivated'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="deactivated">Produkt je deaktivovaný</label>
        </div>
        <button type="submit" class="btn btn-primary">Uložit změny</button>
    </form>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
