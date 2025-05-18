<?php
require_once __DIR__.'/Database.php';

class ProductsDB {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function fetchBrands() {
        $stmt = $this->pdo->query("SELECT id, name FROM brands ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchFilteredProducts($brandId, $maxPrice) {
        $query = "SELECT p.id, p.name, p.price, p.image FROM products p WHERE (p.deactivated IS NULL OR p.deactivated = 0)";
        $params = [];

        if (!empty($brandId)) {
            $query .= " AND p.brand_id = ?";
            $params[] = $brandId;
        }

        if (!empty($maxPrice)) {
            $query .= " AND p.price <= ?";
            $params[] = $maxPrice;
        }

        $query .= " ORDER BY p.name";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchProductById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, b.name AS brand_name FROM products p JOIN brands b ON p.brand_id = b.id WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
