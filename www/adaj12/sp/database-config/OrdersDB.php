<?php
require_once "Database.php";

class OrdersDB extends Database {
    protected $tableName = "orders";

    // Všechny objednávky uživatele
    public function getOrdersByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE user_id = ? ORDER BY date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Položky jedné objednávky
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

    // Celková cena objednávky
    public function getOrderTotal($orderId) {
        $stmt = $this->pdo->prepare("SELECT SUM(quantity * price) AS total FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    // Vrací všechny objednávky + jméno uživatele (pro admina)
    public function fetchAllWithUser() {
        $sql = "SELECT orders.*, users.name AS user_name
                FROM orders
                LEFT JOIN users ON orders.user_id = users.id
                ORDER BY orders.date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Povinná metoda pro interface
    public function fetchAll() {
        return $this->pdo->query("SELECT * FROM {$this->tableName}")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Povinná metoda pro interface
    public function fetchFiltered($filters) {
        return $this->fetchAll();
    }

    // Kompatibilita s user.php
    public function findByUserId($userId) {
        return $this->getOrdersByUserId($userId);
    }

    // Odpojí uživatele od objednávky
    public function detachUserFromOrder($orderId) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET user_id = NULL WHERE id = ?");
        $stmt->execute([$orderId]);
    }

    // Upravit status objednávky
    public function updateStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    // Upravit dodací adresu
    public function updateAddress($orderId, $address) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET shipping_address = ? WHERE id = ?");
        $stmt->execute([$address, $orderId]);
    }
}
