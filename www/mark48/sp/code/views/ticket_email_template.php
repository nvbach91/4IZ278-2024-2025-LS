<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .ticket-card {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background: #fff;
        }

        .event-title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        .qr-placeholder {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            margin: 20px 0;
        }

        .ticket-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }

        .ticket-status {
            display: inline-block;
            padding: 5px 10px;
            background: #28a745;
            color: white;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="ticket-card">
        <h2 class="event-title"><?php echo htmlspecialchars($ticket->event_title); ?></h2>

        <div class="info-row">
            <div class="info-label">Date:</div>
            <?php echo date('F j, Y g:i A', strtotime($ticket->start_datetime)); ?>
        </div>

        <div class="info-row">
            <div class="info-label">Location:</div>
            <?php echo htmlspecialchars($ticket->location); ?>
        </div>

        <div class="info-row">
            <div class="info-label">Seat:</div>
            Row <?php echo $ticket->row_index; ?>, Seat <?php echo $ticket->col_index; ?>
        </div>

        <div class="info-row">
            <div class="info-label">Category:</div>
            <?php echo htmlspecialchars($ticket->category_name); ?> - <?php echo $ticket->price; ?> CZK
        </div>

        <div class="info-row">
            <div class="info-label">Ticket ID:</div>
            <?php echo $ticket->id; ?>
        </div>

        <div class="info-row">
            <div class="info-label">Order ID:</div>
            #<?php echo $ticket->order_id; ?>
        </div>

        <?php if ($ticket->uuid): ?>
            <img src="https://api.gokasa.eu/public/qrcode?text=<?php echo $ticket->uuid; ?>" alt="Barcode" class="img-fluid mb-3">
        <?php else: ?>
            <div class="qr-placeholder">
                <p>QR Code</p>
                <small>Ticket ID: <?php echo $ticket->id; ?></small>
            </div>
        <?php endif; ?>

        <div class="ticket-status">VALID</div>

        <div class="ticket-footer">
            Please bring this ticket along with a valid ID to the event. This ticket is valid for one person only and is non-transferable.
            The barcode will be scanned at the entrance.
        </div>
    </div>
</body>

</html>