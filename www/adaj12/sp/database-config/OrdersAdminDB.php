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

    // Povinné metody pro interface
    public function fetchAll() {
        return $this->fetchAllWithUser();
    }

    public function fetchFiltered($filters) {
        return $this->fetchAllWithUser();
    }

    // Upravit status objednávky
    public function updateStatus($orderId, $status) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }

    // Upravit dodací adresu 
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
}
