<?php
require_once __DIR__ . '/Database.php';

class OrderDB {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function getOrdersByUser(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT o.id, o.created_at, o.street, o.city, o.zip, o.country, o.payment_method, o.note, o.status,
                   SUM(oi.quantity * oi.price) AS total
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            WHERE o.user_id = ?
            GROUP BY o.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
