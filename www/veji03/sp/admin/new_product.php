<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$errors = [];

$product = [
    'name' => '',
    'price' => '',
    'brand_id' => '',
    'image' => '',
    'description' => '',
    'display_size' => '',
    'ram' => '',
    'release_year' => '',
    'battery_capacity' => '',
    'deactivated' => 0
];

$pdo = (new Database())->getConnection();
$stmt = $pdo->query("SELECT id, name FROM brands ORDER BY name");
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product['name'] = trim($_POST['name'] ?? '');
    $product['price'] = floatval($_POST['price'] ?? 0);
    $product['brand_id'] = intval($_POST['brand_id'] ?? 0);
    $product['description'] = trim($_POST['description'] ?? '');
    $product['display_size'] = floatval($_POST['display_size'] ?? 0);
    $product['ram'] = intval($_POST['ram'] ?? 0);
    $product['release_year'] = intval($_POST['release_year'] ?? 0);
    $product['battery_capacity'] = intval($_POST['battery_capacity'] ?? 0);
    $product['deactivated'] = isset($_POST['deactivated']) ? 1 : 0;

    if ($product['name'] === '') {
        $errors[] = "Název produktu je povinný.";
    }

    if ($product['price'] <= 0) {
        $errors[] = "Cena musí být větší než 0.";
    }

    if ($product['brand_id'] <= 0) {
        $errors[] = "Vyberte platnou značku.";
    }

    if ($product['display_size'] <= 0) {
        $errors[] = "Zadejte velikost displeje v palcích (větší než 0).";
    }

    if ($product['ram'] <= 0) {
        $errors[] = "Zadejte hodnotu RAM v GB (větší než 0).";
    }

    if ($product['release_year'] <= 0) {
        $errors[] = "Zadejte rok vydání.";
    }

    if ($product['battery_capacity'] <= 0) {
        $errors[] = "Zadejte kapacitu baterie v mAh (větší než 0).";
    }

    // nahrávání obrázku pro obhajobu
    if (empty($errors)) {
        $uploadDir = __DIR__ . '/../images/';
        $imageName = basename($_FILES['image_file']['name']);
        $targetPath = $uploadDir . $imageName;

        
        $check = getimagesize($_FILES['image_file']['tmp_name']);
        if ($check === false) {
            $errors[] = "Soubor není platný obrázek.";
        }

        elseif (file_exists($targetPath)) {
            $errors[] = "Soubor s tímto názvem již existuje. Přejmenujte prosím obrázek.";
        }

        elseif (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO products 
                (name, price, brand_id, description, image, display_size, ram, release_year, battery_capacity, deactivated) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $product['name'],
                $product['price'],
                $product['brand_id'],
                $product['description'],
                $imageName,
                $product['display_size'],
                $product['ram'],
                $product['release_year'],
                $product['battery_capacity'],
                $product['deactivated']
            ]);

            $_SESSION['success_message'] = "Produkt byl úspěšně přidán.";
            header('Location: products.php');
            exit;
        } else {
            $errors[] = "Nepodařilo se nahrát obrázek.";
        }
    }
}
?>

<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Přidat produkt</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Název</label>
            <input type="text" name="name" id="name" class="form-control"  value="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Cena</label>
            <input type="number" name="price" id="price" class="form-control"  step="0.01" value="<?= htmlspecialchars($product['price']) ?>">
        </div>

        <div class="mb-3">
            <label for="brand_id" class="form-label">Značka</label>
            <select name="brand_id" id="brand_id" class="form-select" >
                <option value="">Vyber značku</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= $b['id'] == $product['brand_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Obrázek</label>
            <input type="file" name="image_file" id="image_file" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="display_size" class="form-label">Velikost displeje (palce)</label>
            <input type="number" name="display_size" id="display_size" class="form-control" step="0.1"  value="<?= htmlspecialchars($product['display_size']) ?>">
        </div>

        <div class="mb-3">
            <label for="ram" class="form-label">RAM (v GB)</label>
            <input type="number" name="ram" id="ram" class="form-control"  value="<?= htmlspecialchars($product['ram']) ?>">
        </div>

        <div class="mb-3">
            <label for="release_year" class="form-label">Rok vydání</label>
            <input type="number" name="release_year" id="release_year" class="form-control"  value="<?= htmlspecialchars($product['release_year']) ?>">
        </div>

        <div class="mb-3">
            <label for="battery_capacity" class="form-label">Kapacita baterie (mAh)</label>
            <input type="number" name="battery_capacity" id="battery_capacity" class="form-control"  value="<?= htmlspecialchars($product['battery_capacity']) ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Popis</label>
            <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="deactivated" id="deactivated" value="1" <?= $product['deactivated'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="deactivated">Produkt je deaktivovaný</label>
        </div>

        <button type="submit" class="btn btn-success">Uložit</button>
    </form>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
