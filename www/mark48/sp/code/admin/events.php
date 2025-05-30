<?php

/**
 * Admin Events Management
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
$seatModel = new SeatDb();

// Process form submission
$action = $_GET['action'] ?? 'list';
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid security token. Please try again.');
        redirect(SITE_URL . 'admin/events.php');
    }

    // Handle event creation
    if ($action === 'create' || $action === 'edit') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $eventTypeId = (int)($_POST['event_type_id'] ?? 0);
        $startDateTime = trim($_POST['start_datetime'] ?? '');
        $endDateTime = trim($_POST['end_datetime'] ?? '');
        $location = trim($_POST['location'] ?? '');

        // Validate required fields
        if (empty($title) || empty($startDateTime) || empty($endDateTime) || $eventTypeId <= 0) {
            setFlashMessage('error', 'All required fields must be filled in.');
            redirect(SITE_URL . 'admin/events.php?action=' . $action . ($eventId ? '&id=' . $eventId : ''));
        }

        $eventData = [
            'title' => $title,
            'description' => $description,
            'event_type_id' => $eventTypeId,
            'start_datetime' => $startDateTime,
            'end_datetime' => $endDateTime,
            'location' => $location,
            'created_by' => $_SESSION['user_id']
        ];

        // Create or update event
        $result = false;
        if ($action === 'create') {
            $result = $eventModel->createEvent($eventData);
            if ($result) {
                setFlashMessage('success', 'Event created successfully.');
                redirect(SITE_URL . 'admin/events.php?action=edit&id=' . $result);
            }
        } else if ($action === 'edit' && $eventId) {
            // Add version for optimistic locking
            $eventData['version'] = (int)($_POST['version'] ?? 1);
            $result = $eventModel->updateEvent($eventId, $eventData);

            if ($result === 'version_mismatch') {
                // Get the current event data to show what changed
                $currentEvent = $eventModel->getEventById($eventId);
                setFlashMessage(
                    'error',
                    'This record has been modified by another user. ' .
                        '<br>Your changes: ' .
                        '<br>- Title: "' . htmlspecialchars($title) . '"' .
                        '<br>- Type: "' . htmlspecialchars($eventTypes[$eventTypeId]['name']) . '"' .
                        '<br>- Start: ' . $startDateTime .
                        '<br>- End: ' . $endDateTime .
                        '<br>- Location: "' . htmlspecialchars($location) . '"' .
                        '<br><br>Current values: ' .
                        '<br>- Title: "' . htmlspecialchars($currentEvent->title) . '"' .
                        '<br>- Type: "' . htmlspecialchars($currentEvent->event_type_name) . '"' .
                        '<br>- Start: ' . $currentEvent->start_datetime .
                        '<br>- End: ' . $currentEvent->end_datetime .
                        '<br>- Location: "' . htmlspecialchars($currentEvent->location) . '"' .
                        '<br><br>Please review the changes and try again.'
                );
                // Store the user's input in session to preserve it
                $_SESSION['form_data'] = [
                    'title' => $title,
                    'description' => $description,
                    'event_type_id' => $eventTypeId,
                    'start_datetime' => $startDateTime,
                    'end_datetime' => $endDateTime,
                    'location' => $location
                ];
                redirect(SITE_URL . 'admin/events.php?action=edit&id=' . $eventId);
            } else if ($result) {
                setFlashMessage('success', 'Event updated successfully.');
                redirect(SITE_URL . 'admin/events.php?action=edit&id=' . $eventId);
            }
        }

        if (!$result) {
            setFlashMessage('error', 'There was an error saving the event.');
        }
    }

    // Handle event deletion
    if ($action === 'delete' && $eventId) {
        if ($eventModel->deleteEvent($eventId)) {
            setFlashMessage('success', 'Event deleted successfully.');
        } else {
            setFlashMessage('error', 'There was an error deleting the event.');
        }
        redirect(SITE_URL . 'admin/events.php');
    }
}

// Get event types for forms
$eventTypes = $eventModel->getAllEventTypes();

// Get event for edit
$event = null;
if ($action === 'edit' && $eventId) {
    $event = $eventModel->getEventById($eventId);
    if (!$event) {
        setFlashMessage('error', 'Event not found.');
        redirect(SITE_URL . 'admin/events.php');
    }
    // Check if event has a seating plan
    $hasSeatPlan = $seatModel->getSeatingPlanForEvent($eventId);
}

// Get all events for list
$events = [];
if ($action === 'list') {
    $events = $eventModel->getAllEvents(true); // Include past events
    // Check which events have seating plans
    $processedEvents = [];
    foreach ($events as $event) {
        $event->has_seating_plan = $seatModel->getSeatingPlanForEvent($event->id) ? true : false;
        $processedEvents[] = $event;
    }
    $events = $processedEvents;
}

// Handle seating plan creation
if ($action === 'create_seating_plan' && $eventId) {
    // Redirect to seating plan editor
    redirect(SITE_URL . 'admin/seating_plan.php?event_id=' . $eventId);
}

// Include the header
include '../views/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?php echo $action === 'list' ? 'Events Management' : ($action === 'create' ? 'Create Event' : 'Edit Event'); ?></h1>
                <?php if ($action === 'list'): ?>
                    <a href="<?php echo SITE_URL; ?>admin/events.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create Event
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($action === 'list'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Event List</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($events)): ?>
                            <div class="alert alert-info">No events found.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($events as $event): ?>
                                            <tr>
                                                <td><?php echo $event->id; ?></td>
                                                <td><?php echo escape($event->title); ?></td>
                                                <td><?php echo escape($event->event_type_name); ?></td>
                                                <td><?php echo formatDate($event->start_datetime); ?></td>
                                                <td><?php echo escape($event->location); ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?php echo SITE_URL; ?>admin/events.php?action=edit&id=<?php echo $event->id; ?>" class="btn btn-primary" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo SITE_URL; ?>event.php?id=<?php echo $event->id; ?>" class="btn btn-info" title="View" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <?php if (!$event->has_seating_plan): ?>
                                                            <a href="<?php echo SITE_URL; ?>admin/events.php?action=create_seating_plan&id=<?php echo $event->id; ?>" class="btn btn-success" title="Create Seating Plan">
                                                                <i class="fas fa-chair"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo SITE_URL; ?>admin/seating_plan.php?event_id=<?php echo $event->id; ?>" class="btn btn-warning" title="Edit Seating Plan">
                                                                <i class="fas fa-chair"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <button type="button" class="btn btn-danger" title="Delete" data-toggle="modal" data-target="#deleteModal<?php echo $event->id; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $event->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the event "<?php echo escape($event->title); ?>"? This action cannot be undone.
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <form method="post" action="<?php echo SITE_URL; ?>admin/events.php?action=delete&id=<?php echo $event->id; ?>">
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
                        <h4 class="mb-0"><?php echo $action === 'create' ? 'Create Event' : 'Edit Event'; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php
                        // Get stored form data if it exists
                        $formData = $_SESSION['form_data'] ?? null;
                        unset($_SESSION['form_data']); // Clear stored data after retrieving
                        ?>
                        <form method="post" action="<?php echo SITE_URL; ?>admin/events.php?action=<?php echo $action; ?><?php echo $eventId ? '&id=' . $eventId : ''; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <?php if ($action === 'edit'): ?>
                                <input type="hidden" name="version" value="<?php echo $event->version; ?>">
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="<?php echo $formData ? htmlspecialchars($formData['title']) : ($event ? htmlspecialchars($event->title) : ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $formData ? htmlspecialchars($formData['description']) : ($event ? htmlspecialchars($event->description) : ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="event_type_id">Event Type *</label>
                                <select class="form-control" id="event_type_id" name="event_type_id" required>
                                    <option value="">Select Event Type</option>
                                    <?php foreach ($eventTypes as $type): ?>
                                        <option value="<?php echo $type['id']; ?>"
                                            <?php echo ($formData && $formData['event_type_id'] == $type['id']) ||
                                                (!$formData && $event && $event->event_type_id == $type['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="start_datetime">Start Date/Time *</label>
                                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime"
                                    value="<?php echo $formData ? $formData['start_datetime'] : ($event ? $event->start_datetime : ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="end_datetime">End Date/Time *</label>
                                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime"
                                    value="<?php echo $formData ? $formData['end_datetime'] : ($event ? $event->end_datetime : ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="location"
                                    value="<?php echo $formData ? htmlspecialchars($formData['location']) : ($event ? htmlspecialchars($event->location) : ''); ?>">
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Save Event</button>
                                <a href="<?php echo SITE_URL; ?>admin/events.php" class="btn btn-secondary ml-2">Cancel</a>
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