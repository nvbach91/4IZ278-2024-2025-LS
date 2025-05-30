<?php

/**
 * Checkout page
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'You must be logged in to checkout.');
    redirect(SITE_URL . 'login.php');
}

// Check if we have reserved seats
if (!isset($_SESSION['reserved_seats']) || empty($_SESSION['reserved_seats'])) {
    setFlashMessage('error', 'No seats reserved. Please select seats first.');
    redirect(SITE_URL);
}

// Check reservation timestamp
if (isset($_SESSION['reservation_timestamp'])) {
    $reservationTime = $_SESSION['reservation_timestamp'];
    $currentTime = time();
    $timeElapsed = $currentTime - $reservationTime;
    $timeLeft = 900 - $timeElapsed; // 15 minutes = 900 seconds

    // If reservation expired, clear reserved seats and redirect
    if ($timeLeft <= 0) {
        // Initialize the seat model to free seats
        $seatModel = new SeatDb();

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
}

// Initialize models
$eventModel = new EventDb();
$seatModel = new SeatDb();
$orderModel = new OrderDb();

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

// Process checkout
$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!checkCSRFToken()) {
        $errors[] = 'Invalid form submission.';
    } else {
        // Get payment method
        $paymentMethod = $_POST['payment_method'] ?? '';

        if (empty($paymentMethod)) {
            $errors[] = 'Please select a payment method.';
        } elseif (!in_array($paymentMethod, ['test'])) {
            $errors[] = 'Invalid payment method.';
        }

        // Process order if no errors
        if (empty($errors)) {
            // Create order
            $order = $orderModel->createOrder($_SESSION['user_id'], $reservedSeatIds);

            if ($order) {
                // Create payment
                $paymentId = $orderModel->createPayment($order, $totalPrice, $paymentMethod);

                if ($paymentId) {
                    // Clear reserved seats from session
                    unset($_SESSION['reserved_seats']);
                    unset($_SESSION['reservation_timestamp']);

                    // Set success message and redirect to orders page
                    setFlashMessage('success', 'Your order has been placed successfully!');
                    redirect(SITE_URL . 'orders.php');
                } else {
                    $errors[] = 'Failed to process payment.';
                }
            } else {
                $errors[] = 'Failed to create order.';
            }
        }
    }
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <h1>Checkout</h1>

    <div class="row">
        <div class="col-md-8">
            <?php foreach ($eventSeats as $eventId => $eventData): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Tickets for <?php echo escape($eventData['event']->title); ?></h3>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Date:</strong> <?php echo formatDate($eventData['event']->start_datetime); ?><br>
                            <strong>Location:</strong> <?php echo escape($eventData['event']->location); ?>
                        </p>

                        <h5>Selected Seats:</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Seat</th>
                                    <th>Category</th>
                                    <th class="text-right">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventData['seats'] as $seat): ?>
                                    <tr>
                                        <td>Row <?php echo $seat->row_index; ?>, Seat <?php echo $seat->col_index; ?></td>
                                        <td><?php echo escape($seat->category_name); ?></td>
                                        <td class="text-right"><?php echo $seat->price; ?> CZK</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Event Total</th>
                                    <th class="text-right"><?php echo $eventData['total']; ?> CZK</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Order Summary</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Total Tickets:</h5>
                        <span><?php echo count($reservedSeats); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Total Price:</h4>
                        <h4><?php echo $totalPrice; ?> CZK</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Payment</h3>
                </div>
                <div class="card-body">
                    <?php displayErrors($errors); ?>

                    <?php displaySuccessMessage($successMessage); ?>

                    <form method="post" action="checkout.php">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                        <div class="form-group">
                            <label>Payment Method</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="payment_test" name="payment_method" value="test" class="custom-control-input" checked>
                                <label class="custom-control-label" for="payment_test">Test Payment (Always Succeeds)</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Complete Purchase</button>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small>Your seats are reserved for 15 minutes. Please complete your purchase before then.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any checkout page JavaScript here if needed
    });
</script>

<?php
// Include the footer
include 'views/footer.php';
?>