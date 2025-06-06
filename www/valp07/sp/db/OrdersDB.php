<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class OrdersDB extends Database
{
    protected $tableName = 'orders';

    public function findOrderByID($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function findOrdersWithItemsByUserId($userId)
    {
        $sql = "
        SELECT 
            o.id AS order_id,
            o.created_at,
            o.status,
            p.name AS product_name,
            oi.price,
            oi.quantity
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.user_id = :user_id
        ORDER BY o.created_at DESC
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function editOrder($id, $status)
    {
        $sql = "UPDATE $this->tableName SET status = :status WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id,
            'status' => $status
        ]);
    }


    public function create($args)
    {

        $stmt = $this->pdo->prepare("
        INSERT INTO addresses (address1, address2, address3, city, state, county, postal_code)
        VALUES (:address1, :address2, :address3, :city, :state, :county, :postal_code)
    ");
        $stmt->execute([
            'address1' => $args['address1'],
            'address2' => $args['address2'] ?? null,
            'address3' => $args['address3'] ?? null,
            'city' => $args['city'],
            'state' => $args['state'],
            'county' => $args['county'] ?? null,
            'postal_code' => $args['postal_code']
        ]);
        $addressId = $this->pdo->lastInsertId();

        $sql = "INSERT INTO $this->tableName (user_id, status, payment_method, address_id)
            VALUES (:user_id, :status, :payment_method, :address_id)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $args['user_id'],
            'status' => $args['status'],
            'payment_method' => $args['payment_method'],
            'address_id' => $addressId
        ]);

        return $this->pdo->lastInsertId();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
    public function findAll()
    {
        $sql = "
        SELECT 
            o.id AS order_id, 
            o.created_at, 
            o.status, 
            o.payment_method, 
            a.address1,
            a.address2,
            a.address3,
            a.city,
            a.state,
            a.county,
            a.postal_code,
            u.email AS user_email,
            oi.id AS item_id,
            oi.product_id,
            oi.quantity,
            oi.price,
            p.name AS product_name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        LEFT JOIN addresses a ON o.address_id = a.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        ORDER BY o.created_at DESC, o.id
    ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>