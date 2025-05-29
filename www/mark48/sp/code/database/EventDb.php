<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/Event.php';

/**
 * Event database model
 */
class EventDb
{
    private $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all events
     * @param bool $includeEnded Whether to include ended events
     * @return array Events as Event objects
     */
    public function getAllEvents($includeEnded = false)
    {
        $sql = "SELECT DISTINCT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id";

        if (!$includeEnded) {
            $sql .= " WHERE e.end_datetime >= NOW()";
        }

        $sql .= " ORDER BY e.start_datetime ASC";

        $events = $this->db->fetchAll($sql);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Get event by ID
     * @param int $id Event ID
     * @return Event|null Event object or null if not found
     */
    public function getEventById($id)
    {
        $event = $this->db->fetch(
            "SELECT e.*, et.name as event_type_name 
             FROM sp_events e
             JOIN sp_event_types et ON e.event_type_id = et.id
             WHERE e.id = ?",
            [$id]
        );

        return $event ? new Event($event) : null;
    }

    /**
     * Get events by type
     * @param int $typeId Event type ID
     * @param bool $includeEnded Whether to include ended events
     * @return array Events as Event objects
     */
    public function getEventsByType($typeId, $includeEnded = false)
    {
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id
                WHERE e.event_type_id = ?";

        if (!$includeEnded) {
            $sql .= " AND e.end_datetime >= NOW()";
        }

        $sql .= " ORDER BY e.start_datetime ASC";

        $events = $this->db->fetchAll($sql, [$typeId]);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Create event
     * @param array $eventData Event data
     * @return int|false Event ID if successful, false otherwise
     */
    public function createEvent($eventData)
    {
        try {
            $this->db->query(
                "INSERT INTO sp_events (title, description, location, start_datetime, end_datetime, 
                                      event_type_id, created_by) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)",
                [
                    $eventData['title'],
                    $eventData['description'],
                    $eventData['location'],
                    $eventData['start_datetime'],
                    $eventData['end_datetime'],
                    $eventData['event_type_id'],
                    $eventData['created_by']
                ]
            );

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update event with optimistic locking
     * @param int $eventId Event ID
     * @param array $eventData Event data including version
     * @return bool|string True if successful, 'version_mismatch' if version mismatch, false otherwise
     */
    public function updateEvent($eventId, $eventData)
    {
        try {
            $this->db->beginTransaction();

            // Get current version
            $currentEvent = $this->getEventById($eventId);
            if (!$currentEvent) {
                $this->db->rollback();
                return false;
            }

            // Check version
            if ($currentEvent->version != $eventData['version']) {
                $this->db->rollback();
                return 'version_mismatch';
            }

            // Update with version increment
            $result = $this->db->query(
                "UPDATE sp_events 
                 SET title = ?, description = ?, location = ?, 
                     start_datetime = ?, end_datetime = ?, event_type_id = ?,
                     version = version + 1
                 WHERE id = ? AND version = ?",
                [
                    $eventData['title'],
                    $eventData['description'],
                    $eventData['location'],
                    $eventData['start_datetime'],
                    $eventData['end_datetime'],
                    $eventData['event_type_id'],
                    $eventId,
                    $eventData['version']
                ]
            );

            if ($result->rowCount() === 0) {
                $this->db->rollback();
                return 'version_mismatch';
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Delete event
     * @param int $id Event ID
     * @return bool True if deletion successful, false otherwise
     */
    public function deleteEvent($id)
    {
        // Ensure event exists
        if (!$this->getEventById($id)) {
            return false;
        }

        try {
            // Delete seats first (due to foreign key constraints)
            $this->db->query("DELETE FROM sp_seats WHERE event_id = ?", [$id]);

            // Delete event
            $this->db->query("DELETE FROM sp_events WHERE id = ?", [$id]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get all event types
     * @return array Event types
     */
    public function getAllEventTypes()
    {
        return $this->db->fetchAll("SELECT * FROM sp_event_types ORDER BY name");
    }

    /**
     * Get event type by ID
     * @param int $id Event type ID
     * @return array|null Event type data or null if not found
     */
    public function getEventTypeById($id)
    {
        return $this->db->fetch(
            "SELECT * FROM sp_event_types WHERE id = ?",
            [$id]
        );
    }

    /**
     * Create event type
     * @param array $typeData Event type data
     * @return int|false Event type ID if successful, false otherwise
     */
    public function createEventType($typeData)
    {
        try {
            $this->db->query(
                "INSERT INTO sp_event_types (name) VALUES (?)",
                [$typeData['name']]
            );
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update event type with optimistic locking
     * @param int $typeId Event type ID
     * @param array $typeData Event type data including version
     * @return bool|string True if successful, 'version_mismatch' if version mismatch, false otherwise
     */
    public function updateEventType($typeId, $typeData)
    {
        try {
            $this->db->beginTransaction();

            // Get current version
            $currentType = $this->getEventTypeById($typeId);
            if (!$currentType) {
                $this->db->rollback();
                return false;
            }

            // Check version
            if ($currentType['version'] != $typeData['version']) {
                $this->db->rollback();
                return 'version_mismatch';
            }

            // Update with version increment
            $result = $this->db->query(
                "UPDATE sp_event_types 
                 SET name = ?, version = version + 1 
                 WHERE id = ? AND version = ?",
                [
                    $typeData['name'],
                    $typeId,
                    $typeData['version']
                ]
            );

            if ($result->rowCount() === 0) {
                $this->db->rollback();
                return 'version_mismatch';
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Delete event type
     * @param int $typeId Event type ID
     * @return bool True if successful, false otherwise
     */
    public function deleteEventType($typeId)
    {
        try {
            $this->db->query(
                "DELETE FROM sp_event_types WHERE id = ?",
                [$typeId]
            );
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Search events
     * @param string $query Search query
     * @return array Events as Event objects
     */
    public function searchEvents($query)
    {
        $searchParam = "%$query%";

        $events = $this->db->fetchAll(
            "SELECT e.*, et.name as event_type_name 
             FROM sp_events e
             JOIN sp_event_types et ON e.event_type_id = et.id
             WHERE e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?
             ORDER BY e.start_datetime ASC",
            [$searchParam, $searchParam, $searchParam]
        );

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Get upcoming events with limit
     * @param int $limit Number of events to retrieve
     * @return array Upcoming events
     */
    public function getUpcomingEvents($limit = 5)
    {
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id
                WHERE e.start_datetime >= NOW()
                ORDER BY e.start_datetime ASC
                LIMIT ?";

        $events = $this->db->fetchAll($sql, [$limit]);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Get active events (not ended yet)
     * @return array Active events
     */
    public function getActiveEvents()
    {
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id
                WHERE e.end_datetime >= NOW()
                ORDER BY e.start_datetime ASC";

        $events = $this->db->fetchAll($sql);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Get events by type ID
     * @param int $typeId Event type ID
     * @return array Events with the specified type
     */
    public function getEventsByTypeId($typeId)
    {
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id
                WHERE e.event_type_id = ?
                ORDER BY e.start_datetime DESC";

        $events = $this->db->fetchAll($sql, [$typeId]);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        return $eventObjects;
    }

    /**
     * Get paginated events
     * @param int $page Page number
     * @param int $perPage Events per page
     * @param bool $includeEnded Whether to include ended events
     * @return array Array with 'events' and 'total' keys
     */
    public function getPaginatedEvents($page = 1, $perPage = 10, $includeEnded = false)
    {
        // Calculate offset
        $offset = ($page - 1) * $perPage;

        // Base SQL
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id";

        if (!$includeEnded) {
            $sql .= " WHERE e.end_datetime >= NOW()";
        }

        $sql .= " ORDER BY e.start_datetime ASC LIMIT ? OFFSET ?";

        $events = $this->db->fetchAll($sql, [$perPage, $offset]);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        // Get total count using the countEvents method
        $total = $this->countEvents($includeEnded);

        return [
            'events' => $eventObjects,
            'total' => $total
        ];
    }

    /**
     * Get paginated events by type
     * @param int $typeId Event type ID
     * @param int $page Page number
     * @param int $perPage Events per page
     * @param bool $includeEnded Whether to include ended events
     * @return array Array with 'events' and 'total' keys
     */
    public function getPaginatedEventsByType($typeId, $page = 1, $perPage = 10, $includeEnded = false)
    {
        // Calculate offset
        $offset = ($page - 1) * $perPage;

        // SQL for data query
        $sql = "SELECT e.*, et.name as event_type_name 
                FROM sp_events e
                JOIN sp_event_types et ON e.event_type_id = et.id
                WHERE e.event_type_id = ?";

        $params = [$typeId];

        if (!$includeEnded) {
            $sql .= " AND e.end_datetime >= NOW()";
        }

        $sql .= " ORDER BY e.start_datetime ASC LIMIT ? OFFSET ?";

        $params[] = $perPage;
        $params[] = $offset;

        $events = $this->db->fetchAll($sql, $params);

        // Convert to Event objects
        $eventObjects = [];
        foreach ($events as $event) {
            $eventObjects[] = new Event($event);
        }

        // Get total count using the countEventsByType method
        $total = $this->countEventsByType($typeId, $includeEnded);

        return [
            'events' => $eventObjects,
            'total' => $total
        ];
    }

    /**
     * Count total events
     * @param bool $includeEnded Whether to include ended events
     * @return int Total number of events
     */
    public function countEvents($includeEnded = false)
    {
        $sql = "SELECT COUNT(*) as count FROM sp_events";

        if (!$includeEnded) {
            $sql .= " WHERE end_datetime >= NOW()";
        }

        $result = $this->db->fetch($sql);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Count events by type
     * @param int $typeId Event type ID
     * @param bool $includeEnded Whether to include ended events
     * @return int Total number of events of the specified type
     */
    public function countEventsByType($typeId, $includeEnded = false)
    {
        $sql = "SELECT COUNT(*) as count FROM sp_events WHERE event_type_id = ?";

        if (!$includeEnded) {
            $sql .= " AND end_datetime >= NOW()";
        }

        $result = $this->db->fetch($sql, [$typeId]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Check if event is locked
     * @param int $eventId Event ID
     * @param int $userId Current user ID
     * @return bool True if event is locked by another user, false otherwise
     */
    public function isLocked($eventId, $userId)
    {
        try {
            $this->db->beginTransaction();

            // First clean up any stale locks
            $this->db->query(
                "UPDATE sp_events 
                 SET lock_timestamp = NULL, locked_by_user_id = NULL 
                 WHERE id = ? AND lock_timestamp < DATE_SUB(NOW(), INTERVAL 10 MINUTE)",
                [$eventId]
            );

            // Now check if it's locked by another user
            $event = $this->db->fetch(
                "SELECT lock_timestamp, locked_by_user_id 
                 FROM sp_events 
                 WHERE id = ? 
                 FOR UPDATE",  // Add row-level locking
                [$eventId]
            );

            if (!$event) {
                $this->db->rollback();
                return false;
            }

            // If there's no lock or it's our own lock, it's not considered locked
            if (!$event['lock_timestamp'] || !$event['locked_by_user_id'] || $event['locked_by_user_id'] == $userId) {
                $this->db->commit();
                return false;
            }

            // Check if the lock is still valid (not stale)
            $lockTime = strtotime($event['lock_timestamp']);
            $isStale = $lockTime < time() - (10 * 60); // 10 minutes

            $this->db->commit();
            return !$isStale;
        } catch (PDOException $e) {
            error_log("Error checking lock: " . $e->getMessage());
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Release event lock
     * @param int $eventId Event ID
     * @param int $userId User ID who owns the lock
     * @return bool True if lock released, false otherwise
     */
    public function releaseLock($eventId, $userId)
    {
        try {
            $this->db->beginTransaction();

            // Get current lock status with row lock
            $currentLock = $this->db->fetch(
                "SELECT locked_by_user_id, lock_timestamp 
                 FROM sp_events 
                 WHERE id = ? 
                 FOR UPDATE",
                [$eventId]
            );

            if (!$currentLock) {
                $this->db->rollback();
                return false;
            }

            error_log("Current lock status for event $eventId: " . json_encode($currentLock));

            // Only allow release if:
            // 1. We own the lock
            // 2. There is no lock
            // 3. The lock is stale (> 10 minutes old)
            $isOurLock = $currentLock['locked_by_user_id'] == $userId;
            $isNoLock = !$currentLock['locked_by_user_id'];
            $isStale = $currentLock['lock_timestamp'] &&
                strtotime($currentLock['lock_timestamp']) < time() - (10 * 60);

            if ($isOurLock || $isNoLock || $isStale) {
                $result = $this->db->query(
                    "UPDATE sp_events 
                     SET lock_timestamp = NULL, locked_by_user_id = NULL 
                     WHERE id = ? AND (locked_by_user_id = ? OR locked_by_user_id IS NULL OR 
                           lock_timestamp < DATE_SUB(NOW(), INTERVAL 10 MINUTE))",
                    [$eventId, $userId]
                );

                $rowCount = $result->rowCount();
                error_log("Release lock affected rows: $rowCount");

                if ($rowCount > 0) {
                    $this->db->commit();
                    return true;
                }
            }

            $this->db->rollback();
            return false;
        } catch (PDOException $e) {
            error_log("Error releasing lock: " . $e->getMessage());
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Acquire event lock
     * @param int $eventId Event ID
     * @param int $userId User ID requesting the lock
     * @return bool True if lock acquired, false if already locked
     */
    public function acquireLock($eventId, $userId)
    {
        try {
            error_log("Attempting to acquire lock for event $eventId by user $userId");
            $this->db->beginTransaction();

            // First clean up any stale locks
            $this->db->query(
                "UPDATE sp_events 
                 SET lock_timestamp = NULL, locked_by_user_id = NULL 
                 WHERE id = ? AND lock_timestamp < DATE_SUB(NOW(), INTERVAL 10 MINUTE)",
                [$eventId]
            );

            // Get current lock status with row lock
            $currentLock = $this->db->fetch(
                "SELECT locked_by_user_id, lock_timestamp 
                 FROM sp_events 
                 WHERE id = ? 
                 FOR UPDATE",
                [$eventId]
            );

            if (!$currentLock) {
                error_log("No event found with ID $eventId");
                $this->db->rollback();
                return false;
            }

            error_log("Current lock status before acquire for event $eventId: " . json_encode($currentLock));

            // Check if we can acquire the lock:
            // 1. No existing lock
            // 2. We already own the lock (refresh it)
            // 3. The lock is stale
            $isNoLock = !$currentLock['locked_by_user_id'];
            $isOurLock = $currentLock['locked_by_user_id'] == $userId;
            $isStale = !$currentLock['lock_timestamp'] ||
                strtotime($currentLock['lock_timestamp']) < time() - (10 * 60);

            error_log("Lock conditions - NoLock: " . ($isNoLock ? 'true' : 'false') .
                ", OurLock: " . ($isOurLock ? 'true' : 'false') .
                ", Stale: " . ($isStale ? 'true' : 'false'));

            if ($isNoLock || $isOurLock || $isStale) {
                // Update the lock with a fresh timestamp
                $result = $this->db->query(
                    "UPDATE sp_events 
                     SET lock_timestamp = NOW(), locked_by_user_id = ? 
                     WHERE id = ? AND (locked_by_user_id IS NULL OR locked_by_user_id = ? OR 
                           lock_timestamp < DATE_SUB(NOW(), INTERVAL 10 MINUTE))",
                    [$userId, $eventId, $userId]
                );

                $rowCount = $result->rowCount();
                error_log("Acquire lock affected rows: $rowCount");

                if ($rowCount > 0) {
                    $this->db->commit();
                    error_log("Successfully acquired lock for event $eventId by user $userId");
                    return true;
                } else {
                    error_log("Failed to acquire lock - no rows affected");
                }
            } else {
                error_log("Cannot acquire lock - event is locked by another user");
            }

            $this->db->rollback();
            return false;
        } catch (PDOException $e) {
            error_log("Error acquiring lock: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->db->rollback();
            return false;
        }
    }
}
