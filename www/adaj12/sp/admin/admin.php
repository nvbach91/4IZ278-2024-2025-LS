<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../pages/home.php?error=Nemáte oprávnění.');
    exit;
}
require_once __DIR__ . '/../pages/layouts/admin-head.php';
?>
    <div class="row justify-content-center">
        <div class="col-md-4 d-flex justify-content-center mb-4">
            <a href="products.php" class="admin-dashboard-link-card">
                Spravovat katalog
            </a>
        </div>
        <div class="col-md-4 d-flex justify-content-center mb-4">
            <a href="orders.php" class="admin-dashboard-link-card">
                Spravovat objednávky
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../pages/layouts/admin-footer.php'; ?>
