<?php

/**
 * E-Ticket page - displays a single ticket
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'You must be logged in to view tickets.');
    redirect(SITE_URL . 'login.php');
}

// Get ticket ID from URL
$ticketId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize models
$orderModel = new OrderDb();

// Get ticket details
$ticket = $orderModel->getTicketById($ticketId);

// Verify that the ticket exists and belongs to the current user
if (!$ticket) {
    setFlashMessage('error', 'Ticket not found.');
    redirect(SITE_URL . 'orders.php');
}

// Get order details to verify ownership
$order = $orderModel->getOrderById($ticket->order_id);
if (!$order || $order->user_id != $_SESSION['user_id']) {
    setFlashMessage('error', 'Access denied.');
    redirect(SITE_URL . 'orders.php');
}

// Handle email form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email) {
        // Get the HTML content of the ticket
        ob_start();
        include 'views/ticket_email_template.php';
        $html_content = ob_get_clean();

        // Send the email
        if (sendTicketEmail($email, $ticket, $html_content)) {
            setFlashMessage('success', 'Ticket has been sent to your email.');
        } else {
            setFlashMessage('error', 'Failed to send email. Please try again.');
        }
    } else {
        setFlashMessage('error', 'Please enter a valid email address.');
    }
    redirect(SITE_URL . 'ticket.php?id=' . $ticketId);
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>E-Ticket</h1>
        <div>
            <a href="<?php echo SITE_URL; ?>order_detail.php?id=<?php echo $ticket->order_id; ?>" class="btn btn-secondary mr-2">
                Back to Order
            </a>
            <button onclick="window.print();" class="btn btn-primary mr-2">
                <i class="fa fa-print"></i> Print Ticket
            </button>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#emailModal">
                <i class="fa fa-envelope"></i> Send to Email
            </button>
        </div>
    </div>

    <?php displayFlashMessages(); ?>

    <div class="card ticket-card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-3"><?php echo escape($ticket->event_title); ?></h2>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p>
                                <strong>Date:</strong><br>
                                <?php echo formatDate($ticket->start_datetime); ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Location:</strong><br>
                                <?php echo escape($ticket->location); ?>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p>
                                <strong>Seat:</strong><br>
                                Row <?php echo $ticket->row_index; ?>, Seat <?php echo $ticket->col_index; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Category:</strong><br>
                                <?php echo escape($ticket->category_name); ?> - <?php echo $ticket->price; ?> CZK
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Ticket ID:</strong><br>
                                <?php echo $ticket->id; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Order ID:</strong><br>
                                #<?php echo $ticket->order_id; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-center">
                    <div class="qr-code-placeholder" style="width: 200px; height: 200px; background-color: #f8f9fa; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 1px dashed #dee2e6;">
                        <div>
                            <p class="mb-0">QR Code</p>
                            <small>Ticket ID: <?php echo $ticket->id; ?></small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <span class="badge badge-success">VALID</span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <p class="text-muted small">
                        Please bring this ticket along with a valid ID to the event. This ticket is valid for one person only and is non-transferable.
                        The barcode will be scanned at the entrance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Ticket to Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="Enter email address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="send_email" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media print {

        header,
        footer,
        .btn,
        .no-print {
            display: none !important;
        }

        body {
            padding: 0;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
        }

        .card {
            border: 1px solid #000;
        }
    }
</style>

<?php
// Include the footer
include 'views/footer.php';
?>