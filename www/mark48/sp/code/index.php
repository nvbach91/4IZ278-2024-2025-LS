<?php

/**
 * Main entry point for the ticketing application
 */

// Initialize the application
require_once 'includes/init.php';

// Initialize models
$eventModel = new EventDb();

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6; // Number of events per page
$page = max(1, $page); // Ensure page is at least 1

// Handle search
$searchResults = null;
$isSearching = false;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchResults = $eventModel->searchEvents($_GET['search']);
    $isSearching = true;
}

// Get event types for filter
$eventTypes = $eventModel->getAllEventTypes();

// Filter by event type and get paginated events
$typeFilter = null;
$paginatedData = null;

if (isset($_GET['type']) && !empty($_GET['type'])) {
    $typeId = (int)$_GET['type'];
    $typeFilter = $typeId;
    $paginatedData = $eventModel->getPaginatedEventsByType($typeId, $page, $perPage);
} else {
    // Get paginated events
    $paginatedData = $eventModel->getPaginatedEvents($page, $perPage);
}

// Extract events and total count
$paginatedEvents = $paginatedData['events'];
$totalEvents = $paginatedData['total'];

// Calculate total pages
$totalPages = ceil($totalEvents / $perPage);

// Adjust current page if it exceeds total pages
$page = min($page, max(1, $totalPages));

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <h1 class="mb-4">Upcoming Events</h1>

    <!-- Search and filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="get" action="index.php" class="form-inline">
                <div class="input-group w-100">
                    <input type="text" name="search" class="form-control" placeholder="Search events..." value="<?php echo isset($_GET['search']) ? escape($_GET['search']) : ''; ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="get" action="index.php" class="form-inline">
                <div class="input-group w-100">
                    <select name="type" class="form-control">
                        <option value="">All event types</option>
                        <?php foreach ($eventTypes as $type): ?>
                            <option value="<?php echo $type['id']; ?>" <?php echo (isset($_GET['type']) && $_GET['type'] == $type['id']) ? 'selected' : ''; ?>>
                                <?php echo escape($type['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash messages -->
    <?php displayFlashMessages(); ?>

    <!-- Search results -->
    <?php if ($searchResults !== null): ?>
        <div class="mb-4">
            <h2>Search Results</h2>
            <?php if (empty($searchResults)): ?>
                <p>No events found matching your search.</p>
            <?php else: ?>
                <p>Found <?php echo count($searchResults); ?> events matching your search.</p>
                <div class="row">
                    <?php foreach ($searchResults as $event): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo escape($event->title); ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo escape($event->event_type_name); ?></h6>
                                    <p class="card-text"><?php echo escape(substr($event->description, 0, 100)) . '...'; ?></p>
                                    <p class="card-text">
                                        <strong>Location:</strong> <?php echo escape($event->location); ?><br>
                                        <strong>Date:</strong> <?php echo formatDate($event->start_datetime); ?>
                                    </p>
                                    <a href="event.php?id=<?php echo $event->id; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Event listing - only show if not searching -->
    <?php if (!$isSearching): ?>
        <div class="row">
            <?php if (empty($paginatedEvents)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No upcoming events at the moment. Please check back later.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($paginatedEvents as $event): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo escape($event->title); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo escape($event->event_type_name); ?></h6>
                                <p class="card-text"><?php echo escape(substr($event->description, 0, 100)) . '...'; ?></p>
                                <p class="card-text">
                                    <strong>Location:</strong> <?php echo escape($event->location); ?><br>
                                    <strong>Date:</strong> <?php echo formatDate($event->start_datetime); ?>
                                </p>
                                <a href="event.php?id=<?php echo $event->id; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous page link -->
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $typeFilter ? '&type=' . $typeFilter : ''; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <!-- Page numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo $typeFilter ? '&type=' . $typeFilter : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next page link -->
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $typeFilter ? '&type=' . $typeFilter : ''; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
// Include the footer
include 'views/footer.php';
?>