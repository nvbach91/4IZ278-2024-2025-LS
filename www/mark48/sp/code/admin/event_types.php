<?php

/**
 * Admin Event Types Management
 */

// Initialize the application
require_once '../includes/init.php';

// Redirect if not logged in as admin
if (!isLoggedIn() || !isAdmin()) {
    setFlashMessage('error', 'Access denied. Admin privileges required.');
    redirect(SITE_URL);
}

// Initialize models
$eventModel = new EventDb();

// Process form submission
$action = $_GET['action'] ?? 'list';
$typeId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid security token. Please try again.');
        redirect(SITE_URL . '/admin/event_types.php');
    }

    // Handle event type creation/update
    if ($action === 'create' || $action === 'edit') {
        $name = trim($_POST['name'] ?? '');
        $version = (int)($_POST['version'] ?? 1);

        // Validate required fields
        if (empty($name)) {
            setFlashMessage('error', 'Name is required.');
            redirect(SITE_URL . '/admin/event_types.php?action=' . $action . ($typeId ? '&id=' . $typeId : ''));
        }

        $typeData = [
            'name' => $name
        ];

        // Create or update event type
        $result = false;
        if ($action === 'create') {
            $result = $eventModel->createEventType($typeData);
            if ($result) {
                setFlashMessage('success', 'Event type created successfully.');
                redirect(SITE_URL . '/admin/event_types.php');
            }
        } else if ($action === 'edit' && $typeId) {
            // Add version for optimistic locking
            $typeData['version'] = $version;
            $result = $eventModel->updateEventType($typeId, $typeData);

            if ($result === 'version_mismatch') {
                // Get the current type data to show what changed
                $currentType = $eventModel->getEventTypeById($typeId);
                setFlashMessage(
                    'error',
                    'This record has been modified by another user. ' .
                        '<br>Your changes: Name = "' . htmlspecialchars($name) . '"' .
                        '<br>Current value: Name = "' . htmlspecialchars($currentType['name']) . '"' .
                        '<br>Please review the changes and try again.'
                );
                // Store the user's input in session to preserve it
                $_SESSION['form_data'] = [
                    'name' => $name
                ];
                redirect(SITE_URL . '/admin/event_types.php?action=edit&id=' . $typeId);
            } else if ($result) {
                setFlashMessage('success', 'Event type updated successfully.');
                redirect(SITE_URL . '/admin/event_types.php');
            }
        }

        if (!$result) {
            setFlashMessage('error', 'There was an error saving the event type.');
        }
    }

    // Handle event type deletion
    if ($action === 'delete' && $typeId) {
        // Check if type is used by any events
        $eventsUsingType = $eventModel->getEventsByTypeId($typeId);
        if (!empty($eventsUsingType)) {
            setFlashMessage('error', 'This event type cannot be deleted because it is used by existing events.');
            redirect(SITE_URL . '/admin/event_types.php');
        }

        if ($eventModel->deleteEventType($typeId)) {
            setFlashMessage('success', 'Event type deleted successfully.');
        } else {
            setFlashMessage('error', 'There was an error deleting the event type.');
        }
        redirect(SITE_URL . '/admin/event_types.php');
    }
}

// Get event type for edit
$eventType = null;
if ($action === 'edit' && $typeId) {
    $eventType = $eventModel->getEventTypeById($typeId);
    if (!$eventType) {
        setFlashMessage('error', 'Event type not found.');
        redirect(SITE_URL . '/admin/event_types.php');
    }
}

// Get all event types for list
$eventTypes = [];
if ($action === 'list') {
    $eventTypes = $eventModel->getAllEventTypes();
}

// Include the header
include '../views/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $action === 'list' ? 'Event Types Management' : ($action === 'create' ? 'Create Event Type' : 'Edit Event Type'); ?></h1>
                <?php if ($action === 'list'): ?>
                    <a href="<?php echo SITE_URL; ?>/admin/event_types.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create Event Type
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($action === 'list'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Event Types List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($eventTypes as $type): ?>
                                        <tr>
                                            <td><?php echo $type['id']; ?></td>
                                            <td><?php echo htmlspecialchars($type['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo SITE_URL; ?>/admin/event_types.php?action=edit&id=<?php echo $type['id']; ?>" class="btn btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#deleteModal<?php echo $type['id']; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?php echo $type['id']; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Event Type</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this event type?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <form method="post" action="<?php echo SITE_URL; ?>/admin/event_types.php?action=delete&id=<?php echo $type['id']; ?>">
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
                    </div>
                </div>
            <?php elseif ($action === 'create' || $action === 'edit'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><?php echo $action === 'create' ? 'Create Event Type' : 'Edit Event Type'; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php
                        // Get stored form data if it exists
                        $formData = $_SESSION['form_data'] ?? null;
                        unset($_SESSION['form_data']); // Clear stored data after retrieving
                        ?>
                        <form method="post" action="<?php echo SITE_URL; ?>/admin/event_types.php?action=<?php echo $action; ?><?php echo $typeId ? '&id=' . $typeId : ''; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="version" value="<?php echo $eventType['version']; ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo $formData ? htmlspecialchars($formData['name']) : ($eventType ? htmlspecialchars($eventType['name']) : ''); ?>" required>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Save Event Type</button>
                                <a href="<?php echo SITE_URL; ?>/admin/event_types.php" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Include the footer
include '../views/footer.php';
?>