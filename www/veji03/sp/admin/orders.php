<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/checkAdmin.php';

$pdo = (new Database())->getConnection();

//Změna stavu objednávky
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status'])) {
    $orderId = intval($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $validStatuses = ['processing', 'shipped', 'delivered', 'cancelled'];

    if ($orderId > 0 && in_array($status, $validStatuses)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
        $currentStatus = $stmt->fetchColumn();

        if ($currentStatus === 'delivered') {
            $_SESSION['success_message'] = "Stav objednávky #$orderId již nelze změnit (již doručeno).";
            header('Location: orders.php');
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT u.email, u.first_name, o.id 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            WHERE o.id = ?
        ");
        $stmt->execute([$orderId]);
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);

        $email = $orderData['email'];
        $firstName = $orderData['first_name'];
        $orderNumber = $orderData['id'];

        $subject = "Aktualizace stavu objednavky no. $orderNumber";
        $message = "Dobrý den $firstName,\n\nstav Vaší objednávky č. $orderNumber byl změněn na: $status.\n\nS pozdravem,\nMobilShop";
        $headers = "From: veji03@vse.cz\r\n" .
                "Reply-To: veji03@vse.cz\r\n" .
                "Content-Type: text/plain; charset=UTF-8";

        @mail($email, $subject, $message, $headers);


        $_SESSION['success_message'] = "Stav objednávky #$orderId byl změněn.";
        header('Location: orders.php');
        exit;
    }
}

$statusFilter = trim($_GET['status'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$ordersPerPage = 5;
$offset = ($page - 1) * $ordersPerPage;

$orders = $orderDB->getFilteredOrders($ordersPerPage, $offset, $statusFilter);
$totalOrders = $orderDB->countOrders($statusFilter);
$totalPages = (int)ceil($totalOrders / $ordersPerPage);

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

    <form method="get" class="mb-3 d-flex align-items-center" style="max-width: 400px;">
        <select name="status" class="form-select me-2">
            <option value="">-- Všechny stavy --</option>
            <?php
            $statuses = ['processing', 'shipped', 'delivered', 'cancelled'];
            foreach ($statuses as $s) {
                $selected = $statusFilter === $s ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-outline-secondary">Filtrovat</button>
    </form>

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
                                <?php if ($o['status'] === 'delivered'): ?>
                                    <span>delivered</span>
                                <?php elseif ($o['status'] === 'cancelled'): ?>
                                    <span>cancelled</span>
                                <?php else: ?>
                                    <form method="post" class="d-flex">
                                        <input type="hidden" name="change_status" value="1">
                                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                        <select name="status" class="form-select form-select-sm me-2">
                                            <?php
                                            $statuses = ['processing', 'shipped', 'delivered', 'cancelled'];
                                            foreach ($statuses as $status) {
                                                $selected = $status === $o['status'] ? 'selected' : '';
                                                echo "<option value=\"$status\" $selected>$status</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Změnit</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" class="bg-light">
                                <strong>Položky v objednávce:</strong>
                                <ul class="mb-0">
                                    <?php
                                    $items = $orderDB->getItemsByOrderId($o['id']);
                                    foreach ($items as $item):
                                    ?>
                                        <li>
                                            <?= htmlspecialchars($item['name']) ?> – <?= $item['quantity'] ?> ks × <?= number_format($item['price'], 0, ',', ' ') ?> Kč
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination mt-3">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&status=<?= urlencode($statusFilter) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
