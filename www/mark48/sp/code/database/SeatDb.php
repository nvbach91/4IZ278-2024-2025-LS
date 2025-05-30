<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/Seat.php';


/**
 * Seat database model
 */
class SeatDb
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
     * Get all seat categories
     * @return array SeatCategory objects
     */
    public function getAllSeatCategories()
    {
        $categories = $this->db->fetchAll("SELECT * FROM sp_seat_categories ORDER BY price DESC");

        $categoryObjects = [];
        foreach ($categories as $category) {
            $categoryObjects[] = new SeatCategory($category);
        }

        return $categoryObjects;
    }

    /**
     * Get seat category by ID
     * @param int $id Seat category ID
     * @return SeatCategory|null Seat category object or null if not found
     */
    public function getSeatCategoryById($id)
    {
        $category = $this->db->fetch("SELECT * FROM sp_seat_categories WHERE id = ?", [$id]);
        return $category ? new SeatCategory($category) : null;
    }

    /**
     * Create seat category (updated implementation)
     * @param array $categoryData Associative array with category data
     * @return int|false Category ID if successful, false otherwise
     */
    public function createSeatCategory($categoryData)
    {
        try {
            $this->db->query(
                "INSERT INTO sp_seat_categories (name, price) 
                 VALUES (?, ?)",
                [
                    $categoryData['name'],
                    $categoryData['price']
                ]
            );
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update seat category with optimistic locking
     * @param int $categoryId Category ID
     * @param array $categoryData Category data including version
     * @return bool|string True if successful, 'version_mismatch' if version mismatch, false otherwise
     */
    public function updateSeatCategory($categoryId, $categoryData)
    {
        try {
            $this->db->beginTransaction();

            // Get current version
            $currentCategory = $this->getSeatCategoryById($categoryId);
            if (!$currentCategory) {
                $this->db->rollback();
                return false;
            }

            // Check version
            if ($currentCategory->version != $categoryData['version']) {
                $this->db->rollback();
                return 'version_mismatch';
            }

            // Update with version increment
            $result = $this->db->query(
                "UPDATE sp_seat_categories 
                 SET name = ?, price = ?, version = version + 1 
                 WHERE id = ? AND version = ?",
                [
                    $categoryData['name'],
                    $categoryData['price'],
                    $categoryId,
                    $categoryData['version']
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
     * Delete seat category
     * @param int $id Seat category ID
     * @return bool True if deletion successful, false otherwise
     */
    public function deleteSeatCategory($id)
    {
        // Ensure seat category exists
        if (!$this->getSeatCategoryById($id)) {
            return false;
        }

        // Check if there are seats with this category
        $seats = $this->db->fetch(
            "SELECT COUNT(*) as count FROM sp_seats WHERE seat_category_id = ?",
            [$id]
        );

        if ($seats && $seats['count'] > 0) {
            return false; // Cannot delete if seats use this category
        }

        try {
            $this->db->query("DELETE FROM sp_seat_categories WHERE id = ?", [$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get seats for event
     * @param int $eventId Event ID
     * @return array Seat objects
     */
    public function getSeatsForEvent($eventId)
    {
        $seats = $this->db->fetchAll(
            "SELECT s.*, sc.name as category_name, sc.price
             FROM sp_seats s
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             WHERE s.event_id = ?
             ORDER BY s.row_index, s.col_index",
            [$eventId]
        );

        $seatObjects = [];
        foreach ($seats as $seat) {
            $seatObjects[] = new Seat($seat);
        }

        return $seatObjects;
    }

    /**
     * Get seat by ID
     * @param int $id Seat ID
     * @return Seat|null Seat object or null if not found
     */
    public function getSeatById($id)
    {
        $seat = $this->db->fetch(
            "SELECT s.*, sc.name as category_name, sc.price
             FROM sp_seats s
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             WHERE s.id = ?",
            [$id]
        );

        return $seat ? new Seat($seat) : null;
    }

    /**
     * Create seat
     * @param int $eventId Event ID
     * @param int $rowIndex Row index
     * @param int $colIndex Column index
     * @param int $categoryId Seat category ID
     * @return Seat|false Seat object if successful, false otherwise
     */
    public function createSeat($eventId, $rowIndex, $colIndex, $categoryId)
    {
        // Check if seat already exists
        $existingSeat = $this->db->fetch(
            "SELECT id FROM sp_seats WHERE event_id = ? AND row_index = ? AND col_index = ?",
            [$eventId, $rowIndex, $colIndex]
        );

        if ($existingSeat) {
            return false; // Seat already exists
        }

        try {
            $this->db->query(
                "INSERT INTO sp_seats (event_id, row_index, col_index, seat_category_id, status) 
                 VALUES (?, ?, ?, ?, 'free')",
                [$eventId, $rowIndex, $colIndex, $categoryId]
            );
            $id = $this->db->lastInsertId();
            return $this->getSeatById($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Create multiple seats (seating layout) with pessimistic locking
     * @param int $eventId Event ID
     * @param int $rows Number of rows
     * @param int $cols Number of columns
     * @param int $categoryId Default seat category ID
     * @return int|false Number of seats created if successful, false if failed
     */
    public function createSeatingLayout($eventId, $rows, $cols, $categoryId)
    {
        try {
            $this->db->beginTransaction();

            $count = 0;

            // Delete existing seats for this event
            $this->db->query("DELETE FROM sp_seats WHERE event_id = ?", [$eventId]);

            // Create new seats
            for ($row = 1; $row <= $rows; $row++) {
                for ($col = 1; $col <= $cols; $col++) {
                    $this->db->query(
                        "INSERT INTO sp_seats (event_id, row_index, col_index, seat_category_id, status) 
                         VALUES (?, ?, ?, ?, 'free')",
                        [$eventId, $row, $col, $categoryId]
                    );
                    $count++;
                }
            }

            $this->db->commit();
            return $count;
        } catch (Exception $e) {
            error_log("Error creating seating layout: " . $e->getMessage());
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Update seat category
     * @param int $id Seat ID
     * @param int $categoryId New category ID
     * @return bool True if update successful, false otherwise
     */
    public function updateSeatCategoryById($id, $categoryId)
    {
        // Ensure seat exists
        $seat = $this->getSeatById($id);
        if (!$seat) {
            return false;
        }

        // Ensure category exists
        if (!$this->getSeatCategoryById($categoryId)) {
            return false;
        }

        try {
            $this->db->query(
                "UPDATE sp_seats SET seat_category_id = ? WHERE id = ?",
                [$categoryId, $id]
            );

            $seat->seat_category_id = $categoryId;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Update seat category for a range of seats with pessimistic locking
     * @param int $eventId Event ID
     * @param int $startRow Start row
     * @param int $endRow End row
     * @param int $startCol Start column
     * @param int $endCol End column
     * @param int $categoryId New category ID
     * @return int|string Number of seats updated if successful, 'locked' if layout is being modified
     */
    public function updateSeatCategoryRange($eventId, $startRow, $endRow, $startCol, $endCol, $categoryId)
    {
        try {
            // Ensure category exists
            if (!$this->getSeatCategoryById($categoryId)) {
                return 0;
            }

            // First count how many seats will be affected
            $countResult = $this->db->fetch(
                "SELECT COUNT(*) as count FROM sp_seats 
                 WHERE event_id = ? AND row_index >= ? AND row_index <= ? 
                 AND col_index >= ? AND col_index <= ?",
                [$eventId, $startRow, $endRow, $startCol, $endCol]
            );

            $count = $countResult ? (int)$countResult['count'] : 0;

            // Then update them
            $this->db->query(
                "UPDATE sp_seats 
                 SET seat_category_id = ? 
                 WHERE event_id = ? AND row_index >= ? AND row_index <= ? 
                 AND col_index >= ? AND col_index <= ?",
                [$categoryId, $eventId, $startRow, $endRow, $startCol, $endCol]
            );

            return $count;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Reserve seat
     * @param int $id Seat ID
     * @return bool True if reservation successful, false otherwise
     */
    public function reserveSeat($id)
    {
        // Get seat
        $seat = $this->getSeatById($id);
        if (!$seat) {
            return false;
        }

        // Can only reserve free seats
        if ($seat->status !== 'free') {
            return false;
        }

        try {
            $this->db->query(
                "UPDATE sp_seats SET status = 'reserved' WHERE id = ?",
                [$id]
            );

            $seat->status = 'reserved';
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Change seat status
     * @param int $id Seat ID
     * @param string $status New status
     * @return bool True if change successful, false otherwise
     */
    public function changeSeatStatus($id, $status)
    {
        // Validate status
        if (!in_array($status, ['free', 'reserved', 'sold'])) {
            return false;
        }

        // Get seat
        $seat = $this->getSeatById($id);
        if (!$seat) {
            return false;
        }

        try {
            $this->db->query(
                "UPDATE sp_seats SET status = ? WHERE id = ?",
                [$status, $id]
            );

            $seat->status = $status;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get seating dimensions for event
     * @param int $eventId Event ID
     * @return array|false Dimensions or false if no seats
     */
    public function getSeatingDimensions($eventId)
    {
        $result = $this->db->fetch(
            "SELECT MAX(row_index) as max_row, MAX(col_index) as max_col 
             FROM sp_seats 
             WHERE event_id = ?",
            [$eventId]
        );

        if (!$result || !$result['max_row'] || !$result['max_col']) {
            return false;
        }

        return [
            'rows' => (int)$result['max_row'],
            'cols' => (int)$result['max_col']
        ];
    }

    /**
     * Count seats by status for event
     * @param int $eventId Event ID
     * @return array Counts by status
     */
    public function countSeatsByStatus($eventId)
    {
        $counts = [
            'free' => 0,
            'reserved' => 0,
            'sold' => 0,
            'total' => 0
        ];

        $results = $this->db->fetchAll(
            "SELECT status, COUNT(*) as count 
             FROM sp_seats 
             WHERE event_id = ? 
             GROUP BY status",
            [$eventId]
        );

        foreach ($results as $row) {
            $counts[$row['status']] = (int)$row['count'];
            $counts['total'] += (int)$row['count'];
        }

        return $counts;
    }

    /**
     * Get seats by category ID
     * @param int $categoryId Seat category ID
     * @return array Seat objects with the specified category
     */
    public function getSeatsByCategoryId($categoryId)
    {
        $seats = $this->db->fetchAll(
            "SELECT s.*, sc.name as category_name, sc.price
             FROM sp_seats s
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             WHERE s.seat_category_id = ?
             ORDER BY s.event_id, s.row_index, s.col_index",
            [$categoryId]
        );

        $seatObjects = [];
        foreach ($seats as $seat) {
            $seatObjects[] = new Seat($seat);
        }

        return $seatObjects;
    }

    /**
     * Check if an event has a seating plan configured
     * @param int $eventId Event ID
     * @return bool|array False if no seating plan exists, or seating dimensions if it exists
     */
    public function getSeatingPlanForEvent($eventId)
    {
        // Check if any seats exist for this event
        $result = $this->db->fetch(
            "SELECT COUNT(*) as count FROM sp_seats WHERE event_id = ?",
            [$eventId]
        );

        if (!$result || $result['count'] == 0) {
            return false;
        }

        // Return seating dimensions
        return $this->getSeatingDimensions($eventId);
    }

    /**
     * Update seat categories for specific seats
     * @param int $eventId Event ID
     * @param array $seatCoordinates Array of seat coordinates [['row' => int, 'col' => int], ...]
     * @param int $categoryId New category ID
     * @return int|false Number of seats updated if successful, false otherwise
     */
    public function updateSeatCategories($eventId, $seatCoordinates, $categoryId)
    {
        try {
            $this->db->beginTransaction();

            // Ensure category exists
            if (!$this->getSeatCategoryById($categoryId)) {
                $this->db->rollback();
                return false;
            }

            // Build the WHERE clause for specific seats
            $conditions = [];
            $params = [];
            foreach ($seatCoordinates as $coord) {
                $conditions[] = "(row_index = ? AND col_index = ?)";
                $params[] = $coord['row'];
                $params[] = $coord['col'];
            }

            // Add event_id to params
            array_unshift($params, $eventId);

            // Update the seats
            $result = $this->db->query(
                "UPDATE sp_seats 
                 SET seat_category_id = ? 
                 WHERE event_id = ? AND (" . implode(' OR ', $conditions) . ")",
                array_merge([$categoryId], $params)
            );

            $this->db->commit();
            return $result->rowCount();
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }
}
