<?php

/**
 * Admin Seating Plan Management
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

// Get event ID from query string
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;

// Verify event exists
$event = null;
if ($eventId) {
    $event = $eventModel->getEventById($eventId);
    if (!$event) {
        setFlashMessage('error', 'Event not found.');
        redirect(SITE_URL . '/admin/events.php');
    }

    // Check if seating plan is being edited by another user
    if ($eventModel->isLocked($eventId, $_SESSION['user_id'])) {
        setFlashMessage('error', 'The seating plan is currently being modified by another administrator. Please try again later.');
        redirect(SITE_URL . '/admin/events.php');
    }

    // Acquire lock for this session
    if (!$eventModel->acquireLock($eventId, $_SESSION['user_id'])) {
        setFlashMessage('error', 'Could not acquire lock for editing. Please try again.');
        redirect(SITE_URL . '/admin/events.php');
    }
}

// Get seating plan dimensions
$dimensions = null;
$hasSeatPlan = false;
if ($event) {
    $dimensions = $seatModel->getSeatingDimensions($eventId);
    $hasSeatPlan = $dimensions !== false;
}

// Get all seat categories
$categories = $seatModel->getAllSeatCategories();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid security token. Please try again.');
        redirect(SITE_URL . '/admin/seating_plan.php?event_id=' . $eventId);
    }

    // Check if we still have the lock - only for existing seating plans
    if ($hasSeatPlan && $eventModel->isLocked($eventId, $_SESSION['user_id'])) {
        setFlashMessage('error', 'The seating plan is currently being modified by another administrator. Please try again in a moment.');
        redirect(SITE_URL . '/admin/events.php');
    }

    // Create initial seating layout
    if (isset($_POST['create_layout'])) {
        $rows = (int)$_POST['rows'];
        $cols = (int)$_POST['cols'];
        $categoryId = (int)$_POST['default_category_id'];

        if ($rows < 1 || $cols < 1 || $categoryId < 1) {
            setFlashMessage('error', 'Invalid layout parameters.');
            redirect(SITE_URL . '/admin/seating_plan.php?event_id=' . $eventId);
        } else {
            $seatsCreated = $seatModel->createSeatingLayout($eventId, $rows, $cols, $categoryId);
            if ($seatsCreated > 0) {
                setFlashMessage('success', $seatsCreated . ' seats have been created.');
                redirect(SITE_URL . '/admin/seating_plan.php?event_id=' . $eventId);
            } else {
                setFlashMessage('error', 'Failed to create seating layout.');
                redirect(SITE_URL . '/admin/seating_plan.php?event_id=' . $eventId);
            }
        }
    }

    // Update multiple seats
    if (isset($_POST['update_multiple_seats'])) {
        $selectedSeats = isset($_POST['selected_seats']) ? $_POST['selected_seats'] : '';
        $categoryId = (int)$_POST['multi_category_id'];

        if (!empty($selectedSeats) && $categoryId > 0) {
            $seatsList = explode(',', $selectedSeats);
            $result = $seatModel->updateSeatCategoryRange($eventId, $minRow, $maxRow, $minCol, $maxCol, $categoryId);
            if ($result > 0) {
                setFlashMessage('success', $result . ' seats have been updated successfully.');
            } else {
                setFlashMessage('error', 'No seats were updated. Please try again.');
            }
        } else {
            setFlashMessage('error', 'Invalid parameters. Please select seats and a category.');
        }
        redirect(SITE_URL . '/admin/seating_plan.php?event_id=' . $eventId);
    }
}

// Get seats for display
$seats = [];
if ($hasSeatPlan) {
    $seats = $seatModel->getSeatsForEvent($eventId);
}

// Include the header
include '../views/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Seating Plan: <?php echo escape($event->title); ?></h1>
                <a href="<?php echo SITE_URL; ?>/admin/events.php?action=edit&id=<?php echo $eventId; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Event
                </a>
            </div>

            <?php if (!$hasSeatPlan): ?>
                <!-- Create Initial Seating Layout -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create Seating Layout</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo SITE_URL; ?>/admin/seating_plan.php?event_id=<?php echo $eventId; ?>" class="create-layout-form">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="rows">Number of Rows</label>
                                    <input type="number" class="form-control" id="rows" name="rows" min="1" value="10" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cols">Number of Columns</label>
                                    <input type="number" class="form-control" id="cols" name="cols" min="1" value="10" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="default_category_id">Default Seat Category</label>
                                    <select class="form-control" id="default_category_id" name="default_category_id" required>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category->id; ?>"><?php echo escape($category->name); ?> (<?php echo formatCurrency($category->price); ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" name="create_layout" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Create Layout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Edit Existing Seating Layout -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h4 class="mb-0">Seating Legend</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <?php foreach ($categories as $category): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo escape($category->name); ?>
                                            <span class="badge badge-primary"><?php echo formatCurrency($category->price); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Seating Plan Visualization</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="bg-dark text-white p-2 mb-4">STAGE</div>

                                    <div class="seating-grid">
                                        <?php
                                        // Organize seats by row and column
                                        $seatMap = [];
                                        foreach ($seats as $seat) {
                                            $seatMap[$seat->row_index][$seat->col_index] = $seat;
                                        }
                                        ?>

                                        <div class="table-responsive">
                                            <table class="table table-bordered seating-table">
                                                <thead>
                                                    <tr>
                                                        <th class="row-label"></th>
                                                        <?php for ($col = 1; $col <= $dimensions['cols']; $col++): ?>
                                                            <th class="col-label"><?php echo $col; ?></th>
                                                        <?php endfor; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($row = 1; $row <= $dimensions['rows']; $row++): ?>
                                                        <tr>
                                                            <td class="row-label"><?php echo $row; ?></td>
                                                            <?php for ($col = 1; $col <= $dimensions['cols']; $col++): ?>
                                                                <?php
                                                                $seat = $seatMap[$row][$col] ?? null;
                                                                $categoryId = '';
                                                                $categoryClass = '';
                                                                $categoryName = '';
                                                                $seatStatus = '';
                                                                $seatId = '';

                                                                if ($seat) {
                                                                    $seatId = $seat->id;
                                                                    $categoryId = $seat->seat_category_id;
                                                                    $categoryClass = 'seat-cat-' . $categoryId;
                                                                    $categoryName = $seat->category_name;
                                                                    $seatStatus = $seat->status;
                                                                }

                                                                $statusClass = '';
                                                                if ($seatStatus === 'reserved') {
                                                                    $statusClass = 'seat-reserved';
                                                                } else if ($seatStatus === 'sold') {
                                                                    $statusClass = 'seat-sold';
                                                                }
                                                                ?>
                                                                <td class="seat <?php echo $categoryClass; ?> <?php echo $statusClass; ?>"
                                                                    data-row="<?php echo $row; ?>"
                                                                    data-col="<?php echo $col; ?>"
                                                                    data-seat-id="<?php echo $seatId; ?>"
                                                                    data-category-id="<?php echo $categoryId; ?>"
                                                                    data-toggle="tooltip"
                                                                    title="Row <?php echo $row; ?>, Col <?php echo $col; ?><?php echo $categoryName ? ' - ' . $categoryName : ''; ?>">
                                                                    <?php echo $row . '-' . $col; ?>
                                                                </td>
                                                            <?php endfor; ?>
                                                        </tr>
                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seat Category Management -->
                                <div class="card mt-3">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Assign Category to Selected Seats</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <strong>Instructions:</strong> Click on seats to select/deselect them, then assign a category to all selected seats.
                                        </div>

                                        <form method="post" action="<?php echo SITE_URL; ?>/admin/seating_plan.php?event_id=<?php echo $eventId; ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                            <input type="hidden" id="selected_seats" name="selected_seats" value="">

                                            <div class="form-group">
                                                <label for="multi_category_id">Category for <span id="selected-count">0</span> Selected Seats</label>
                                                <select class="form-control" id="multi_category_id" name="multi_category_id">
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo $category->id; ?>"><?php echo escape($category->name); ?> (<?php echo formatCurrency($category->price); ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button type="submit" id="update_multiple_seats" name="update_multiple_seats" class="btn btn-primary btn-lg" disabled>
                                                    <i class="fas fa-save"></i> Save Changes
                                                </button>
                                                <button type="button" id="clear-selection" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Clear Selection
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Seating plan styles */
    .seating-grid {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .seating-table {
        border-collapse: separate !important;
        border-spacing: 3px !important;
        width: auto !important;
        margin: 0 auto;
    }

    .seating-table td,
    .seating-table th {
        padding: 0 !important;
        border: none !important;
    }

    .seat {
        cursor: pointer;
        text-align: center;
        font-size: 12px;
        width: 40px;
        height: 40px;
        transition: all 0.2s;
        padding: 10px 5px;
        display: table-cell;
        vertical-align: middle;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .seat:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        transform: scale(1.1);
        z-index: 10;
        position: relative;
    }

    .seat.selected {
        border: 3px solid #000 !important;
        font-weight: bold;
    }

    .row-label,
    .col-label {
        font-weight: bold;
        background-color: #f8f9fa;
        width: 40px;
        height: 40px;
        text-align: center;
        vertical-align: middle;
        border-radius: 4px;
    }

    .seat-reserved {
        background-color: #ffc107 !important;
    }

    .seat-sold {
        background-color: #dc3545 !important;
        color: white;
    }

    /* Generate colors for seat categories */
    <?php foreach ($categories as $index => $category): ?>.seat-cat-<?php echo $category->id; ?> {
        background-color: <?php echo getColorForIndex($index); ?>;
    }

    <?php endforeach; ?>
</style>

<!-- Include admin seating plan script -->
<script src="<?php echo SITE_URL; ?>/assets/js/admin-seating-plan.js"></script>

<script>
    // Make PHP constants available to JavaScript
    const SITE_URL = '<?php echo SITE_URL; ?>';
    const CSRF_TOKEN = '<?php echo generateCSRFToken(); ?>';
    const EVENT_ID = <?php echo $eventId ?? 'null'; ?>;
    const USER_ID = <?php echo $_SESSION['user_id'] ?? 'null'; ?>;
    const HAS_SEAT_PLAN = <?php echo $hasSeatPlan ? 'true' : 'false'; ?>;

    // Function to release the lock with retry mechanism
    async function releaseLock(retryCount = 3, retryDelay = 500) {
        if (!EVENT_ID || !HAS_SEAT_PLAN) return true;

        const formData = {
            csrf_token: CSRF_TOKEN,
            user_id: USER_ID
        };

        for (let i = 0; i < retryCount; i++) {
            try {
                const response = await fetch(`${SITE_URL}/admin/release_lock.php?event_id=${EVENT_ID}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        console.log('Lock released successfully');
                        return true;
                    }
                }

                const errorData = await response.json().catch(() => ({
                    error: 'Unknown error'
                }));
                console.error(`Failed to release lock (attempt ${i + 1}/${retryCount}):`, errorData.error);

                // Wait before retrying, with exponential backoff
                if (i < retryCount - 1) {
                    await new Promise(resolve => setTimeout(resolve, retryDelay * Math.pow(2, i)));
                }
            } catch (e) {
                console.error(`Error releasing lock (attempt ${i + 1}/${retryCount}):`, e);

                // Wait before retrying, with exponential backoff
                if (i < retryCount - 1) {
                    await new Promise(resolve => setTimeout(resolve, retryDelay * Math.pow(2, i)));
                }
            }
        }

        return false;
    }

    // Function to release lock synchronously (for beforeunload)
    function releaseLockSync() {
        if (!EVENT_ID || !HAS_SEAT_PLAN) return true;

        const formData = {
            csrf_token: CSRF_TOKEN,
            user_id: USER_ID
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', `${SITE_URL}/admin/release_lock.php?event_id=${EVENT_ID}`, false);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');

        try {
            xhr.send(JSON.stringify(formData));
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    return response.success === true;
                } catch (e) {
                    console.error('Failed to parse release lock response:', e);
                    return false;
                }
            }
            return false;
        } catch (e) {
            console.error('Failed to release lock synchronously:', e);
            return false;
        }
    }

    // Function to handle navigation after lock release
    async function handleNavigation(url = null) {
        // Skip lock release for create layout form
        if (!HAS_SEAT_PLAN || (event && event.target && event.target.closest('.create-layout-form'))) {
            if (url) {
                window.location.href = url;
            }
            return true;
        }

        const released = await releaseLock();
        if (released) {
            if (url) {
                window.location.href = url;
            }
            return true;
        } else {
            alert('Failed to release lock. Please try again or contact an administrator if the problem persists.');
            return false;
        }
    }

    // Keep the lock alive with periodic updates
    function keepLockAlive() {
        if (!EVENT_ID || !HAS_SEAT_PLAN) return;

        fetch(`${SITE_URL}/admin/seating_plan.php?event_id=${EVENT_ID}`, {
            method: 'HEAD',
            headers: {
                'X-CSRF-Token': CSRF_TOKEN
            }
        }).catch(error => {
            console.error('Failed to keep lock alive:', error);
            // If we fail to keep the lock alive, try to release it
            releaseLock().catch(console.error);
        });
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Handle all navigation links
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('click', async function(e) {
                if (!HAS_SEAT_PLAN || this.closest('.create-layout-form')) {
                    return true;
                }
                e.preventDefault();
                await handleNavigation(this.href);
            });
        });

        // Handle form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                if (!HAS_SEAT_PLAN || this.classList.contains('create-layout-form')) {
                    return true;
                }
                e.preventDefault();
                if (await handleNavigation()) {
                    this.submit();
                }
            });
        });

        // Handle browser back button
        window.addEventListener('popstate', async function(e) {
            if (!await handleNavigation()) {
                e.preventDefault();
                window.history.pushState(null, '', window.location.href);
            }
        });

        // Handle page visibility change
        document.addEventListener('visibilitychange', async function() {
            if (document.visibilityState === 'hidden') {
                await releaseLock();
            }
        });

        // Handle page unload
        window.addEventListener('beforeunload', function(e) {
            releaseLockSync();
        });

        // Keep the lock alive every 5 minutes
        const keepAliveInterval = setInterval(keepLockAlive, 5 * 60 * 1000);

        // Clear interval when page is unloaded
        window.addEventListener('unload', function() {
            clearInterval(keepAliveInterval);
        });
    });
</script>

<?php
// Helper function to generate colors for seat categories
function getColorForIndex($index)
{
    $colors = [
        '#c8e6c9', // Light green
        '#bbdefb', // Light blue
        '#ffccbc', // Light orange
        '#d1c4e9', // Light purple
        '#f8bbd0', // Light pink
        '#b2dfdb', // Light teal
        '#e6ee9c', // Light yellow-green
    ];

    return $colors[$index % count($colors)];
}

// Include the footer
include '../views/footer.php';
?>