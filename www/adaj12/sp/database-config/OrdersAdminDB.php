<?php
require_once "Database.php";

class OrdersAdminDB extends Database {
    protected $tableName = "orders";

    // Vrací všechny objednávky + jméno uživatele (pro admina)
    public function fetchAllWithUser() {
        $sql = "SELECT orders.*, users.name AS user_name
                FROM orders
                LEFT JOIN users ON orders.user_id = users.id
                ORDER BY orders.date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPageWithUser($limit, $offset) {
        $sql = "SELECT orders.*, users.name AS user_name
                FROM orders
                LEFT JOIN users ON orders.user_id = users.id
                ORDER BY orders.date DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->tableName}");
        return (int)$stmt->fetchColumn();
    }

    public function fetchAll() {
        return $this->fetchAllWithUser();
    }

    public function fetchFiltered($filters) {
        return $this->fetchAllWithUser();
    }

    // Položky jedné objednávky pro admina (název produktu + množství)
    public function getOrderItems($orderId) {
        $stmt = $this->pdo->prepare("
            SELECT oi.*, p.name 
            FROM order_items oi 
            JOIN products p ON oi.game_id = p.id 
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    public function updateShippingAddress($orderId, $name, $street, $postal_code, $city) {
        $stmt = $this->pdo->prepare("SELECT shipping_address FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$orderId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $address = [
            "name" => $name,
            "street" => $street,
            "city" => $city,
            "postal_code" => $postal_code
        ];

        if ($row && !empty($row['shipping_address'])) {
            $old = json_decode($row['shipping_address'], true);
            if (is_array($old)) {
                foreach (['email','phone','shipping_method','payment_method'] as $key) {
                    if (isset($old[$key])) $address[$key] = $old[$key];
                }
            }
        }

        $newJson = json_encode($address, JSON_UNESCAPED_UNICODE);
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET shipping_address = ? WHERE id = ?");
        $stmt->execute([$newJson, $orderId]);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
