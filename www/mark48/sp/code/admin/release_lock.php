<?php

/**
 * Release seating plan lock endpoint
 */

// Initialize the application
require_once '../includes/init.php';

// Set headers for JSON response
header('Content-Type: application/json');

// Redirect if not logged in as admin
if (!isLoggedIn() || !isAdmin()) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

// Get event ID from query string
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;

if (!$eventId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing event ID']);
    exit;
}

// Get JSON data
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Basic validation
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

// Verify CSRF token
if (!isset($data['csrf_token'])) {
    error_log('CSRF Token missing in request');
    http_response_code(403);
    echo json_encode(['error' => 'Missing security token']);
    exit;
}

if (!verifyCSRFToken($data['csrf_token'])) {
    error_log('CSRF Token validation failed. Token: ' . $data['csrf_token']);
    error_log('Session Token: ' . ($_SESSION['csrf_token'] ?? 'not set'));
    http_response_code(403);
    echo json_encode(['error' => 'Invalid security token']);
    exit;
}

// Get user ID
$userId = (int)$data['user_id'];
if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

// Initialize models
$eventModel = new EventDb();

// Release the lock
try {
    $result = $eventModel->releaseLock($eventId, $userId);
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Failed to release lock']);
    }
} catch (Exception $e) {
    error_log('Error releasing lock: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to release lock']);
}
