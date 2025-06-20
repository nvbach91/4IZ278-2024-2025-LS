<?php
require_once __DIR__ . '/Database.php';

class ProductsDB {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function fetchBrands() {
        return $this->pdo->query("SELECT id, name FROM brands ORDER BY name")->fetchAll();
    }

    public function fetchBrandsWithCounts(): array {
        $stmt = $this->pdo->query("
            SELECT b.id, b.name, COUNT(p.id) AS product_count
            FROM brands b
            LEFT JOIN products p ON p.brand_id = b.id
            GROUP BY b.id
            ORDER BY b.name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchFilteredProducts(
        $brandId, $minPrice, $maxPrice,
        $minRam, $maxRam,
        $minBattery, $maxBattery,
        $minYear, $maxYear,
        $minDisplay, $maxDisplay,
        $limit = null, $offset = null
    ) {
        $query = "SELECT p.id, p.name, p.price, p.image FROM products p WHERE (p.deactivated IS NULL OR p.deactivated = 0)";
        $params = [];

        if ($brandId) {
            $query .= " AND p.brand_id = ?";
            $params[] = $brandId;
        }
        if ($minPrice !== '') {
            $query .= " AND p.price >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice !== '') {
            $query .= " AND p.price <= ?";
            $params[] = $maxPrice;
        }
        if ($minRam !== '') {
            $query .= " AND p.ram >= ?";
            $params[] = $minRam;
        }
        if ($maxRam !== '') {
            $query .= " AND p.ram <= ?";
            $params[] = $maxRam;
        }
        if ($minBattery !== '') {
            $query .= " AND p.battery_capacity >= ?";
            $params[] = $minBattery;
        }
        if ($maxBattery !== '') {
            $query .= " AND p.battery_capacity <= ?";
            $params[] = $maxBattery;
        }
        if ($minYear !== '') {
            $query .= " AND p.release_year >= ?";
            $params[] = $minYear;
        }
        if ($maxYear !== '') {
            $query .= " AND p.release_year <= ?";
            $params[] = $maxYear;
        }
        if ($minDisplay !== '' && $maxDisplay !== '') {
            $query .= " AND p.display_size BETWEEN ? AND ?";
            $params[] = $minDisplay;
            $params[] = $maxDisplay;
        } elseif ($minDisplay !== '') {
            $query .= " AND p.display_size >= ?";
            $params[] = $minDisplay;
        } elseif ($maxDisplay !== '') {
            $query .= " AND p.display_size <= ?";
            $params[] = $maxDisplay;
        }

        $query .= " ORDER BY p.name";

        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT ? OFFSET ?";
            $params[] = (int)$limit;
            $params[] = (int)$offset;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function fetchProductById($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, b.name AS brand_name
            FROM products p
            JOIN brands b ON p.brand_id = b.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function countFilteredProducts(
        $brandId, $minPrice, $maxPrice,
        $minRam, $maxRam,
        $minBattery, $maxBattery,
        $minYear, $maxYear,
        $minDisplay, $maxDisplay
    ) {
        $query = "SELECT COUNT(*) FROM products p WHERE (p.deactivated IS NULL OR p.deactivated = 0)";
        $params = [];

        if ($brandId) {
            $query .= " AND p.brand_id = ?";
            $params[] = $brandId;
        }
        if ($minPrice !== '') {
            $query .= " AND p.price >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice !== '') {
            $query .= " AND p.price <= ?";
            $params[] = $maxPrice;
        }
        if ($minRam !== '') {
            $query .= " AND p.ram >= ?";
            $params[] = $minRam;
        }
        if ($maxRam !== '') {
            $query .= " AND p.ram <= ?";
            $params[] = $maxRam;
        }
        if ($minBattery !== '') {
            $query .= " AND p.battery_capacity >= ?";
            $params[] = $minBattery;
        }
        if ($maxBattery !== '') {
            $query .= " AND p.battery_capacity <= ?";
            $params[] = $maxBattery;
        }
        if ($minYear !== '') {
            $query .= " AND p.release_year >= ?";
            $params[] = $minYear;
        }
        if ($maxYear !== '') {
            $query .= " AND p.release_year <= ?";
            $params[] = $maxYear;
        }
        if ($minDisplay !== '' && $maxDisplay !== '') {
            $query .= " AND p.display_size BETWEEN ? AND ?";
            $params[] = $minDisplay;
            $params[] = $maxDisplay;
        } elseif ($minDisplay !== '') {
            $query .= " AND p.display_size >= ?";
            $params[] = $minDisplay;
        } elseif ($maxDisplay !== '') {
            $query .= " AND p.display_size <= ?";
            $params[] = $maxDisplay;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
