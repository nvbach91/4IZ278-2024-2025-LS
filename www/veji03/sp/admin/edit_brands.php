<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$pdo = (new Database())->getConnection();
$errors = [];
$success = '';

// Přidání nové značky
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_brand'])) {
    $newName = trim($_POST['new_name'] ?? '');
    if ($newName === '') {
        $errors[] = 'Název nové značky nesmí být prázdný.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO brands (name) VALUES (?)");
        $stmt->execute([$newName]);
        $success = 'Značka byla úspěšně přidána.';
    }
}

// Úprava existující značky
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_brand'])) {
    $id = intval($_POST['brand_id'] ?? 0);
    $updatedName = trim($_POST['updated_name'] ?? '');
    if ($updatedName === '') {
        $errors[] = 'Název značky nesmí být prázdný.';
    } else {
        $stmt = $pdo->prepare("UPDATE brands SET name = ? WHERE id = ?");
        $stmt->execute([$updatedName, $id]);
        $success = 'Značka byla upravena.';
    }
}

// Odebrání značky
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_brand'])) {
    $brandId = intval($_POST['brand_id'] ?? 0);

    if ($brandId > 0) {
        // Zjisti počet produktů s touto značkou
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE brand_id = ?");
        $stmt->execute([$brandId]);
        $count = $stmt->fetchColumn();

        if ((int)$count === 0) {
            $stmt = $pdo->prepare("DELETE FROM brands WHERE id = ?");
            $stmt->execute([$brandId]);
            $success = 'Značka byla úspěšně odstraněna.';
        } else {
            $errors[] = 'Značku nelze smazat – je přiřazena k produktům.';
        }
    }
}

// Načtení značek
$stmt = $pdo->query("
    SELECT b.*, COUNT(p.id) AS product_count
    FROM brands b
    LEFT JOIN products p ON p.brand_id = b.id
    GROUP BY b.id
    ORDER BY b.id ASC
");
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Správa značek</h2>

    <?php renderMessages($success, $errors); ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle" style="max-width: 900px;">
            <thead>
                <tr>
                    <th>Aktuální název značky</th>
                    <th>Nový název značky</th>
                    <th>Akce</th>
                    <th>Smazat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form method="post">
                        <td></td>
                        <td>
                            <input type="text" name="new_name" class="form-control" placeholder="Nová značka">
                        </td>
                        <td>
                            <button type="submit" name="add_brand" class="btn btn-success btn-sm">Přidat</button>
                        </td>
                        <td></td>
                    </form>
                </tr>

                <?php foreach ($brands as $brand): ?>
                    <tr>
                        <form method="post">
                            <td><?= htmlspecialchars($brand['name']) ?></td>
                            <td>
                                <input type="text" name="updated_name" value="<?= htmlspecialchars($brand['name']) ?>" class="form-control">
                            </td>
                            <td>
                                <input type="hidden" name="brand_id" value="<?= $brand['id'] ?>">
                                <button type="submit" name="update_brand" class="btn btn-primary btn-sm">Uložit</button>
                            </td>
                            <td>
                                <?php if ($brand['product_count'] == 0): ?>
                                    <form method="post" onsubmit="return confirm('Opravdu chcete tuto značku smazat?');">
                                        <input type="hidden" name="brand_id" value="<?= $brand['id'] ?>">
                                        <button type="submit" name="delete_brand" class="btn btn-danger btn-sm">Smazat</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">Nelze (Existující produkty:  <?= $brand['product_count'] ?>)</span>
                                <?php endif; ?>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
