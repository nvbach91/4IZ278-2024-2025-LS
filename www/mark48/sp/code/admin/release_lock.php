<?php

/**
 * Release seating plan lock endpoint
 */

// Initialize the application
require_once '../includes/init.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// Check CSRF token
if (!checkCSRFToken()) {
    http_response_code(403);
    exit('Invalid security token');
}

// Get event ID
$eventId = isset($_POST['event_id']) ? (int)$_POST['event_id'] : null;

if (!$eventId) {
    http_response_code(400);
    exit('Missing event ID');
}

// Initialize event model
$eventModel = new EventDb();

// Release the lock
$eventModel->releaseLock($eventId, $_SESSION['user_id']);

// Return success
http_response_code(200);
exit('Lock released');
