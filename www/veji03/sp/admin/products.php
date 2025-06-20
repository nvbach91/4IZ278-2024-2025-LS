<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);

$pdo = (new Database())->getConnection();

$stmt = $pdo->query("
    SELECT p.id, p.name, p.price, p.image, b.name AS brand_name, p.deactivated
    FROM products p
    JOIN brands b ON p.brand_id = b.id
    ORDER BY p.id ASC
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Správa produktů</h2>

    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <a href="new_product.php" class="btn btn-success mb-3">+ Přidat nový produkt</a>
    <a href="edit_brands.php" class="btn btn-success mb-3">Spravovat značky</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Název</th>
                    <th>Značka</th>
                    <th>Cena</th>
                    <th>Obrázek</th>
                    <th>Stav</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['brand_name']) ?></td>
                        <td><?= number_format($p['price'], 0, ',', ' ') ?> Kč</td>
                        <td><img src="../images/<?= htmlspecialchars($p['image']) ?>" alt="" style="height: 40px;"></td>
                        <td>
                            <?= $p['deactivated'] ? '<span class="text-danger">Neaktivní</span>' : '<span class="text-success">Aktivní</span>' ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">Upravit</a>
                            <?php if (!$p['deactivated']): ?>
                                <a href="deactivate_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Deaktivovat</a>
                            <?php else: ?>
                                <a href="activate_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-success">Aktivovat</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
