<div class="list-group">
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/dashboard.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
    </a>
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/events.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'events.php' ? 'active' : ''; ?>">
        <i class="fas fa-calendar-alt mr-2"></i> Events
    </a>
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/event_types.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'event_types.php' ? 'active' : ''; ?>">
        <i class="fas fa-list mr-2"></i> Event Types
    </a>
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/seat_categories.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'seat_categories.php' ? 'active' : ''; ?>">
        <i class="fas fa-chair mr-2"></i> Seat Categories
    </a>
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/orders.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">
        <i class="fas fa-shopping-cart mr-2"></i> Orders
    </a>
    <a href="<?php echo SITE_URL . ADMIN_PATH; ?>/users.php" class="list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>">
        <i class="fas fa-users mr-2"></i> Users
    </a>
</div>

<div class="mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Quick Info</h5>
        </div>
        <div class="card-body p-3">
            <p class="mb-1"><small><i class="fas fa-user mr-1"></i> <strong>User:</strong> <?php echo escape($_SESSION['user_name']); ?></small></p>
            <p class="mb-1"><small><i class="fas fa-clock mr-1"></i> <strong>Date:</strong> <?php echo date('d.m.Y'); ?></small></p>
            <p class="mb-0"><small><i class="fas fa-calendar mr-1"></i> <strong>Time:</strong> <?php echo date('H:i'); ?></small></p>
        </div>
    </div>
</div>