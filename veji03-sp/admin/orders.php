<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$pdo = (new Database())->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $orderId = intval($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $validStatuses = ['Zpracovává se', 'Odeslána', 'Doručena', 'Zrušena'];

    if ($orderId > 0 && in_array($status, $validStatuses)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
        $_SESSION['success_message'] = "Stav objednávky #$orderId byl změněn.";
        header('Location: orders.php');
        exit;
    }
}

$stmt = $pdo->query("
    SELECT o.id, o.created_at, o.street, o.city, o.zip, o.country, o.payment_method, o.note, o.status,
            u.first_name, u.last_name, u.email,
            SUM(oi.quantity * oi.price) AS total
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_items oi ON oi.order_id = o.id
    GROUP BY o.id
    ORDER BY o.id ASC
");

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../includes/head.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<main class="container mt-5">
    <h2>Objednávky</h2>
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <p>Žádné objednávky zatím nebyly vytvořeny.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Datum</th>
                        <th>Zákazník</th>
                        <th>E-mail</th>
                        <th>Adresa</th>
                        <th>Platba</th>
                        <th>Poznámka</th>
                        <th>Celkem</th>
                        <th>Stav</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?= $o['id'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></td>
                            <td><?= htmlspecialchars($o['first_name'] . ' ' . $o['last_name']) ?></td>
                            <td><?= htmlspecialchars($o['email']) ?></td>
                            <td><?= htmlspecialchars("{$o['street']}, {$o['city']} {$o['zip']}, {$o['country']}") ?></td>
                            <td><?= htmlspecialchars($o['payment_method']) ?></td>
                            <td><?= htmlspecialchars($o['note']) ?></td>
                            <td><?= number_format($o['total'], 0, ',', ' ') ?> Kč</td>
                            <td>
                                <form method="post" class="d-flex">
                                    <input type="hidden" name="change_status" value="1">
                                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                    <select name="status" class="form-select form-select-sm me-2">
                                        <?php
                                        $statuses = ['Zpracovává se', 'Odeslána', 'Doručena', 'Zrušena'];
                                        foreach ($statuses as $status) {
                                            $selected = $status === $o['status'] ? 'selected' : '';
                                            echo "<option value=\"$status\" $selected>$status</option>";
                                        }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Změnit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
