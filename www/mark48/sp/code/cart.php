<?php

/**
 * Cart page - displays all reserved tickets with a 15-minute reservation timer
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'You must be logged in to view your cart.');
    redirect(SITE_URL . '/login.php');
}

// Check if we have reserved seats
if (!isset($_SESSION['reserved_seats']) || empty($_SESSION['reserved_seats'])) {
    setFlashMessage('info', 'Your cart is empty. Please select seats first.');
    redirect(SITE_URL);
}

// Initialize models
$seatModel = new SeatDb();
$eventModel = new EventDb();

// Check reservation timestamp
$reservationTime = isset($_SESSION['reservation_timestamp']) ? $_SESSION['reservation_timestamp'] : time();
$currentTime = time();
$timeElapsed = $currentTime - $reservationTime;
$timeLeft = 900 - $timeElapsed; // 15 minutes = 900 seconds

// If reservation expired, clear reserved seats and redirect
if ($timeLeft <= 0) {
    // Free up reserved seats
    foreach ($_SESSION['reserved_seats'] as $seatId) {
        $seatModel->changeSeatStatus((int)$seatId, 'free');
    }

    // Clear session data
    unset($_SESSION['reserved_seats']);
    unset($_SESSION['reservation_timestamp']);

    setFlashMessage('error', 'Your reservation has expired. Please select seats again.');
    redirect(SITE_URL);
}

// Process remove seat action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove_seat') {
    $seatToRemove = isset($_POST['seat_id']) ? (int)$_POST['seat_id'] : 0;

    if ($seatToRemove) {
        // Free up the seat
        $seatModel->changeSeatStatus($seatToRemove, 'free');

        // Remove from session
        $key = array_search($seatToRemove, $_SESSION['reserved_seats']);
        if ($key !== false) {
            unset($_SESSION['reserved_seats'][$key]);

            // Reindex the array
            $_SESSION['reserved_seats'] = array_values($_SESSION['reserved_seats']);
        }

        // If no seats left, clear reservation
        if (empty($_SESSION['reserved_seats'])) {
            unset($_SESSION['reserved_seats']);
            unset($_SESSION['reservation_timestamp']);

            setFlashMessage('info', 'Your cart is now empty.');
            redirect(SITE_URL);
        }

        // Redirect to refresh page
        redirect(SITE_URL . '/cart.php');
    }
}

// Load reserved seats and group by event
$reservedSeatIds = $_SESSION['reserved_seats'];
$reservedSeats = [];
$eventSeats = []; // Seats grouped by event
$totalPrice = 0;

// Load seat details and group by event
foreach ($reservedSeatIds as $seatId) {
    $seat = $seatModel->getSeatById((int)$seatId);
    if ($seat && $seat->status === 'reserved') {
        $reservedSeats[] = $seat;
        $totalPrice += $seat->price;

        // Group by event
        if (!isset($eventSeats[$seat->event_id])) {
            $eventSeats[$seat->event_id] = [
                'event' => $eventModel->getEventById($seat->event_id),
                'seats' => [],
                'total' => 0
            ];
        }

        $eventSeats[$seat->event_id]['seats'][] = $seat;
        $eventSeats[$seat->event_id]['total'] += $seat->price;
    }
}

// If no valid reserved seats, redirect
if (empty($reservedSeats)) {
    unset($_SESSION['reserved_seats']);
    unset($_SESSION['reservation_timestamp']);
    setFlashMessage('error', 'No valid seat reservations found.');
    redirect(SITE_URL);
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Your Cart</h1>
                <div class="reservation-time">
                    <div class="alert alert-warning">
                        <strong>Reservation Time Left:</strong> <span id="time-left"><?php echo floor($timeLeft / 60); ?>:<?php echo str_pad($timeLeft % 60, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?php foreach ($eventSeats as $eventId => $eventData): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Your Tickets</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($eventData['event']): ?>
                            <h4><?php echo escape($eventData['event']->title); ?></h4>
                            <p>
                                <strong>Date:</strong> <?php echo formatDate($eventData['event']->start_datetime); ?><br>
                                <strong>Location:</strong> <?php echo escape($eventData['event']->location); ?>
                            </p>

                            <div class="mb-3">
                                <a href="<?php echo SITE_URL; ?>event.php?id=<?php echo $eventId; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> Add More Seats
                                </a>
                            </div>
                        <?php endif; ?>

                        <h5>Selected Seats:</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Seat</th>
                                    <th>Category</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventData['seats'] as $seat): ?>
                                    <tr>
                                        <td>Row <?php echo $seat->row_index; ?>, Seat <?php echo $seat->col_index; ?></td>
                                        <td><?php echo escape($seat->category_name); ?></td>
                                        <td class="text-right"><?php echo $seat->price; ?> CZK</td>
                                        <td class="text-center">
                                            <form method="post" action="cart.php">
                                                <input type="hidden" name="action" value="remove_seat">
                                                <input type="hidden" name="seat_id" value="<?php echo $seat->id; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Event Total</th>
                                    <th class="text-right"><?php echo $eventData['total']; ?> CZK</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Order Summary</h3>
                </div>
                <div class="card-body">
                    <p>Your seats are reserved for 15 minutes. Please complete your purchase before the timer expires.</p>

                    <div class="summary my-3">
                        <h5>Total Items: <?php echo count($reservedSeats); ?></h5>
                        <h4>Total Price: <?php echo $totalPrice; ?> CZK</h4>
                    </div>

                    <div class="text-center">
                        <a href="<?php echo SITE_URL; ?>checkout.php" class="btn btn-primary btn-lg btn-block">
                            Proceed to Checkout
                        </a>
                    </div>

                    <div class="mt-3">
                        <a href="<?php echo SITE_URL; ?>" class="btn btn-secondary btn-block">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set up the countdown timer
        var timeLeft = <?php echo $timeLeft; ?>;
        var timerElement = document.getElementById('time-left');

        var timer = setInterval(function() {
            timeLeft--;

            if (timeLeft <= 0) {
                clearInterval(timer);
                alert('Your reservation has expired. The page will reload.');
                window.location.reload();
            }

            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            // Add leading zero to seconds if needed
            if (seconds < 10) {
                seconds = '0' + seconds;
            }

            timerElement.textContent = minutes + ':' + seconds;

            // Flash the timer when less than 1 minute remains
            if (timeLeft < 60) {
                timerElement.parentElement.classList.toggle('bg-danger');
                timerElement.parentElement.classList.toggle('text-white');
            }
        }, 1000);
    });
</script>

<?php
// Include the footer
include 'views/footer.php';
?>