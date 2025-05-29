<?php

/**
 * Admin Seat Categories Management
 */

// Initialize the application
require_once '../includes/init.php';

// Redirect if not logged in as admin
if (!isLoggedIn() || !isAdmin()) {
    setFlashMessage('error', 'Access denied. Admin privileges required.');
    redirect(SITE_URL);
}

// Initialize models
$seatModel = new SeatDb();

// Process form submission
$action = $_GET['action'] ?? 'list';
$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid security token. Please try again.');
        redirect(SITE_URL . 'admin/seat_categories.php');
    }

    // Handle seat category creation/update
    if ($action === 'create' || $action === 'edit') {
        $name = trim($_POST['name'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $version = (int)($_POST['version'] ?? 1);

        // Validate required fields
        if (empty($name) || $price <= 0) {
            setFlashMessage('error', 'Name and price (greater than 0) are required.');
            redirect(SITE_URL . 'admin/seat_categories.php?action=' . $action . ($categoryId ? '&id=' . $categoryId : ''));
        }

        $categoryData = [
            'name' => $name,
            'price' => $price
        ];

        // Create or update seat category
        $result = false;
        if ($action === 'create') {
            $result = $seatModel->createSeatCategory($categoryData);
            if ($result) {
                setFlashMessage('success', 'Seat category created successfully.');
                redirect(SITE_URL . 'admin/seat_categories.php');
            }
        } else if ($action === 'edit' && $categoryId) {
            // Add version for optimistic locking
            $categoryData['version'] = $version;
            $result = $seatModel->updateSeatCategory($categoryId, $categoryData);

            if ($result === 'version_mismatch') {
                // Get the current category data to show what changed
                $currentCategory = $seatModel->getSeatCategoryById($categoryId);
                setFlashMessage(
                    'error',
                    'This record has been modified by another user. ' .
                        '<br>Your changes: Name = "' . htmlspecialchars($name) . '", Price = $' . number_format($price, 2) .
                        '<br>Current values: Name = "' . htmlspecialchars($currentCategory->name) . '", Price = $' . number_format($currentCategory->price, 2) .
                        '<br>Please review the changes and try again.'
                );
                // Store the user's input in session to preserve it
                $_SESSION['form_data'] = [
                    'name' => $name,
                    'price' => $price
                ];
                redirect(SITE_URL . 'admin/seat_categories.php?action=edit&id=' . $categoryId);
            } else if ($result) {
                setFlashMessage('success', 'Seat category updated successfully.');
                redirect(SITE_URL . 'admin/seat_categories.php');
            }
        }

        if (!$result) {
            setFlashMessage('error', 'There was an error saving the seat category.');
            redirect(SITE_URL . 'admin/seat_categories.php?action=' . $action . ($categoryId ? '&id=' . $categoryId : ''));
        }
    }

    // Handle seat category deletion
    if ($action === 'delete' && $categoryId) {
        // Check if category is used by any seats
        $seatsUsingCategory = $seatModel->getSeatsByCategoryId($categoryId);
        if (!empty($seatsUsingCategory)) {
            setFlashMessage('error', 'This seat category cannot be deleted because it is used by existing seats.');
            redirect(SITE_URL . 'admin/seat_categories.php');
        }

        if ($seatModel->deleteSeatCategory($categoryId)) {
            setFlashMessage('success', 'Seat category deleted successfully.');
        } else {
            setFlashMessage('error', 'There was an error deleting the seat category.');
        }
        redirect(SITE_URL . 'admin/seat_categories.php');
    }
}

// Get seat category for edit
$seatCategory = null;
if ($action === 'edit' && $categoryId) {
    $seatCategory = $seatModel->getSeatCategoryById($categoryId);
    if (!$seatCategory) {
        setFlashMessage('error', 'Seat category not found.');
        redirect(SITE_URL . 'admin/seat_categories.php');
    }
}

// Get all seat categories for list
$seatCategories = [];
if ($action === 'list') {
    $seatCategories = $seatModel->getAllSeatCategories();
}

// Include the header
include '../views/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $action === 'list' ? 'Seat Categories Management' : ($action === 'create' ? 'Create Seat Category' : 'Edit Seat Category'); ?></h1>
                <?php if ($action === 'list'): ?>
                    <a href="<?php echo SITE_URL; ?>admin/seat_categories.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create Seat Category
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($action === 'list'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Seat Categories List</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($seatCategories)): ?>
                            <div class="alert alert-info">No seat categories found.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($seatCategories as $category): ?>
                                            <tr>
                                                <td><?php echo $category->id; ?></td>
                                                <td><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td>$<?php echo number_format($category->price, 2); ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?php echo SITE_URL; ?>admin/seat_categories.php?action=edit&id=<?php echo $category->id; ?>" class="btn btn-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#deleteModal<?php echo $category->id; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $category->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the seat category "<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>"?
                                                                    This action cannot be undone.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <form method="post" action="<?php echo SITE_URL; ?>admin/seat_categories.php?action=delete&id=<?php echo $category->id; ?>">
                                                                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif ($action === 'create' || $action === 'edit'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><?php echo $action === 'create' ? 'Create Seat Category' : 'Edit Seat Category'; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php
                        // Get stored form data if it exists
                        $formData = $_SESSION['form_data'] ?? null;
                        unset($_SESSION['form_data']); // Clear stored data after retrieving
                        ?>
                        <form method="post" action="<?php echo SITE_URL; ?>admin/seat_categories.php?action=<?php echo $action; ?><?php echo $categoryId ? '&id=' . $categoryId : ''; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="version" value="<?php echo $seatCategory->version; ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo $formData ? htmlspecialchars($formData['name']) : ($seatCategory ? htmlspecialchars($seatCategory->name) : ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Price *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="price" name="price"
                                        value="<?php echo $formData ? floatval($formData['price']) : ($seatCategory ? floatval($seatCategory->price) : '0.00'); ?>"
                                        step="0.01" min="0.01" required>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Save Seat Category</button>
                                <a href="<?php echo SITE_URL; ?>admin/seat_categories.php" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .color-swatch {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
        border-radius: 3px;
        vertical-align: middle;
        border: 1px solid #ddd;
    }
</style>

<?php
// Include the footer
include '../views/footer.php';
?>