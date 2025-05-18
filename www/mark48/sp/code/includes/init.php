<?php

/**
 * Application initialization
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load configuration
require_once __DIR__ . '/config.php';

// Load database connection
require_once __DIR__ . '/../database/Database.php';


// Load base models
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Seat.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Ticket.php';


// Load database models
require_once __DIR__ . '/../database/UserDb.php';
require_once __DIR__ . '/../database/EventDb.php';
require_once __DIR__ . '/../database/SeatDb.php';
require_once __DIR__ . '/../database/OrderDb.php';

// Define helper functions
/**
 * Redirect to a URL
 * @param string $url URL to redirect to
 */
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

/**
 * Check if user is logged in
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 * @return bool True if admin, false otherwise
 */
function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Generate CSRF token
 * @return string CSRF token
 */
function generateCSRFToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check CSRF token from POST request
 * @return bool True if valid token is present, false otherwise
 */
function checkCSRFToken()
{
    return isset($_POST['csrf_token']) && verifyCSRFToken($_POST['csrf_token']);
}

/**
 * Escape HTML to prevent XSS
 * @param string $str String to escape
 * @return string Escaped string
 */
function escape($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Format date
 * @param string $date Date to format
 * @param string $format Format string
 * @return string Formatted date
 */
function formatDate($date, $format = 'd.m.Y H:i')
{
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

/**
 * Flash messages
 * @param string $type Message type (success, error, info)
 * @param string $message Message text
 */
function setFlashMessage($type, $message)
{
    $_SESSION['flash_messages'][$type] = $message;
}

/**
 * Get and clear flash messages
 * @return array Flash messages
 */
function getFlashMessages()
{
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);
    return $messages;
}

/**
 * Display flash messages
 * Outputs HTML for all flash messages
 */
function displayFlashMessages()
{
    $flashMessages = getFlashMessages();
    foreach ($flashMessages as $type => $message):
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
        echo $message;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
    endforeach;
}

/**
 * Display form errors
 * Outputs HTML for form validation errors
 * @param array $errors Array of error messages
 */
function displayErrors($errors)
{
    if (!empty($errors)):
        echo '<div class="alert alert-danger">';
        echo '<ul class="mb-0">';
        foreach ($errors as $error):
            echo '<li>' . escape($error) . '</li>';
        endforeach;
        echo '</ul>';
        echo '</div>';
    endif;
}

/**
 * Display success message
 * Outputs HTML for a success message
 * @param string $message Success message to display
 */
function displaySuccessMessage($message)
{
    if (!empty($message)):
        echo '<div class="alert alert-success">';
        echo escape($message);
        echo '</div>';
    endif;
}

/**
 * Format currency amount
 * @param float $amount Amount to format
 * @param string $currency Currency symbol
 * @return string Formatted currency
 */
function formatCurrency($amount, $currency = '€')
{
    return number_format($amount, 2, ',', '.') . ' ' . $currency;
}

/**
 * Send ticket via email
 * @param string $to Recipient email address
 * @param Ticket $ticket Ticket object
 * @param string $html_content HTML content of the ticket
 * @return bool True if email sent successfully, false otherwise
 */
function sendTicketEmail($to, $ticket, $html_content)
{
    // Email headers
    $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: ' . 'event_ticketing_system' . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>',
        'X-Mailer: PHP/' . phpversion()
    );

    // Email subject
    $subject = "Your E-Ticket for " . $ticket->event_title;

    // Send email
    return mail($to, $subject, $html_content, implode("\r\n", $headers));
}
