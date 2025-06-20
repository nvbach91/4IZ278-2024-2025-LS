<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/layouts/head.php';
$orderId = $_GET['order'] ?? null;
?>
<div class="container mt-5" style="max-width: 700px;">
    <div class="alert alert-success text-center">
        <h2>Objednávka byla úspěšně odeslána!</h2>
        <p>Děkujeme za nákup. Číslo objednávky: <b><?= htmlspecialchars($orderId) ?></b></p>
        <a href="../index.php" class="btn btn-primary mt-3">Zpět na hlavní stránku</a>
    </div>
</div>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
