<?php

/**
 * Event detail page
 */

// Initialize the application
require_once 'includes/init.php';

// Get the event ID from the URL
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize models
$eventModel = new EventDb();
$seatModel = new SeatDb();

// Load the event data
$event = $eventModel->getEventById($eventId);

// Redirect if event not found
if (!$event) {
    setFlashMessage('error', 'Event not found.');
    redirect(SITE_URL);
}

// Load seating data
$seats = $seatModel->getSeatsForEvent($eventId);
$dimensions = $seatModel->getSeatingDimensions($eventId);
$categories = $seatModel->getAllSeatCategories();

// Set default dimensions if not provided
if (!$dimensions || !is_array($dimensions)) {
    $dimensions = [
        'rows' => 0,
        'cols' => 0
    ];
}

/**
 * Check if seating plan is available
 * 
 * @param array $dimensions The seating dimensions array
 * @return bool True if seating plan is available
 */
function hasSeatingPlan($dimensions)
{
    return isset($dimensions['rows']) && isset($dimensions['cols']) &&
        $dimensions['rows'] > 0 && $dimensions['cols'] > 0;
}

// Organize seats into a grid
$seatingGrid = [];
for ($row = 1; $row <= $dimensions['rows']; $row++) {
    $seatingGrid[$row] = [];
    for ($col = 1; $col <= $dimensions['cols']; $col++) {
        $seatingGrid[$row][$col] = null;
    }
}

foreach ($seats as $seat) {
    $seatingGrid[$seat->row_index][$seat->col_index] = $seat;
}

// Process seat reservation
$errors = [];
$successMessage = '';

// Check if user already has reserved seats for this event
$userReservedSeats = [];
if (isLoggedIn() && isset($_SESSION['reserved_seats']) && !empty($_SESSION['reserved_seats'])) {
    foreach ($_SESSION['reserved_seats'] as $reservedSeatId) {
        $reservedSeat = $seatModel->getSeatById((int)$reservedSeatId);
        if ($reservedSeat && $reservedSeat->event_id == $eventId) {
            $userReservedSeats[] = $reservedSeatId;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    // Check CSRF token
    if (!checkCSRFToken()) {
        $errors[] = 'Invalid form submission.';
    } else {
        // Get selected seats
        $selectedSeatIds = isset($_POST['selected_seats']) ? explode(',', $_POST['selected_seats']) : [];

        if (empty($selectedSeatIds)) {
            $errors[] = 'No seats selected.';
        } else {
            // Reserve seats
            $reservedSeats = 0;
            foreach ($selectedSeatIds as $seatId) {
                if ($seatModel->reserveSeat((int)$seatId)) {
                    $reservedSeats++;
                }
            }

            if ($reservedSeats > 0) {
                // Combine with previously reserved seats for the same event
                $allReservedSeats = [];

                // Add previously reserved seats from other events AND this event
                if (isset($_SESSION['reserved_seats'])) {
                    foreach ($_SESSION['reserved_seats'] as $prevSeatId) {
                        $prevSeat = $seatModel->getSeatById((int)$prevSeatId);
                        if ($prevSeat) {
                            // Keep all existing reserved seats
                            $allReservedSeats[] = $prevSeatId;
                        }
                    }
                }

                // Add newly selected seats (avoid duplicates)
                foreach ($selectedSeatIds as $seatId) {
                    if (!in_array($seatId, $allReservedSeats)) {
                        $allReservedSeats[] = $seatId;
                    }
                }

                // Update session with all reserved seats
                $_SESSION['reserved_seats'] = $allReservedSeats;

                // Set or update reservation timestamp
                $_SESSION['reservation_timestamp'] = time();

                // Redirect to cart page
                redirect(SITE_URL . '/cart.php');
            } else {
                $errors[] = 'Failed to reserve seats. They may have been taken by someone else.';
            }
        }
    }
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1><?php echo escape($event->title); ?></h1>
            <p class="lead"><?php echo escape($event->event_type_name); ?></p>

            <div class="event-details my-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date:</strong> <?php echo formatDate($event->start_datetime); ?></p>
                        <p><strong>End:</strong> <?php echo formatDate($event->end_datetime); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Location:</strong> <?php echo escape($event->location); ?></p>
                    </div>
                </div>
            </div>

            <div class="event-description mb-4">
                <h3>Description</h3>
                <p><?php echo nl2br(escape($event->description)); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Seat Categories</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($categories as $category): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo escape($category->name); ?>
                                <span class="badge badge-primary badge-pill"><?php echo escape($category->price); ?> CZK</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Seating Plan</h2>
                </div>
                <div class="card-body">
                    <?php displayErrors($errors); ?>

                    <?php displaySuccessMessage($successMessage); ?>

                    <div class="seat-legend">
                        <div class="legend-item">
                            <div class="legend-color free"></div>
                            <span>Available</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color reserved"></div>
                            <span>Reserved</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color sold"></div>
                            <span>Sold</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color selected"></div>
                            <span>Selected</span>
                        </div>
                        <?php if (!empty($userReservedSeats)): ?>
                            <div class="legend-item">
                                <div class="legend-color user-reserved"></div>
                                <span>In Your Cart</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="seating-plan">
                        <?php if (hasSeatingPlan($dimensions)): ?>
                            <?php for ($row = 1; $row <= $dimensions['rows']; $row++): ?>
                                <div class="seat-row">
                                    <div class="row-label"><?php echo $row; ?></div>
                                    <?php for ($col = 1; $col <= $dimensions['cols']; $col++): ?>
                                        <?php
                                        $seat = $seatingGrid[$row][$col];
                                        if ($seat):
                                            $categoryName = $seat->category_name;
                                            $price = $seat->price;
                                            $status = $seat->status;
                                        ?>
                                            <div class="seat <?php echo escape($status); ?>"
                                                data-seat-id="<?php echo $seat->id; ?>"
                                                data-price="<?php echo $price; ?>"
                                                data-toggle="tooltip"
                                                title="<?php echo escape($categoryName); ?> - <?php echo $price; ?> CZK">
                                                <?php echo $row . '-' . $col; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-gap"></div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <i class="fa fa-info-circle text-info mb-3" style="font-size: 2rem;"></i>
                                    <h5 class="card-title">No Seating Plan Available</h5>
                                    <p class="card-text">This event does not have a seating plan configured yet.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (isLoggedIn() && hasSeatingPlan($dimensions)): ?>
                        <div class="text-center mt-4">
                            <form method="post" action="event.php?id=<?php echo $eventId; ?>" id="checkout_form">
                                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                <input type="hidden" name="selected_seats" id="selected_seats" value="">

                                <div class="form-group">
                                    <h4>Selected Seats: <span id="seat_count">0</span></h4>
                                    <h4>Total Price: <span id="total_price">0.00 CZK</span></h4>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg" id="checkout_button">
                                    Proceed to Checkout
                                </button>
                                <div id="selection-info" class="alert alert-info mt-3" style="display: none;">
                                    <small>Click on available seats to select them. Selected seats will be highlighted and the total will be calculated automatically.</small>
                                </div>
                            </form>
                        </div>
                    <?php elseif (isLoggedIn()): ?>
                        <!-- Don't show anything when logged in but no seating plan -->
                    <?php else: ?>
                        <div class="text-center mt-4">
                            <div class="alert alert-info">
                                Please <a href="login.php">login</a> to select seats.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include event-specific scripts and styles -->
<link rel="stylesheet" href="assets/css/seating-plan.css">
<style>
    /* Checkout button style */
    #checkout_button {
        transition: all 0.3s ease;
        opacity: 0.7;
        cursor: pointer;
    }

    #checkout_button.active {
        opacity: 1;
        transform: scale(1.05);
        background-color: #0056b3;
        border-color: #004085;
    }

    #checkout_button:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* Add pointer cursor to selectable seats */
    .seat.free {
        cursor: pointer;
    }
</style>
<script>
    // Pass user's already reserved seats to JavaScript
    var userReservedSeats = [<?php echo implode(',', $userReservedSeats); ?>];
</script>
<script src="assets/js/seating-plan.js"></script>

<?php
// Include the footer
include 'views/footer.php';
?>