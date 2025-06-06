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

    public function editOrder($args)
    {
        $sql = "UPDATE $this->tableName 
                SET user_id = :user_id, 
                    status = :status, 
                    shipping_address = :shipping_address, 
                    payment_method = :payment_method 
                WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $args['id'],
            'user_id' => $args['user_id'],
            'status' => $args['status'],
            'shipping_address' => $args['shipping_address'],
            'payment_method' => $args['payment_method'],
        ]);
    }

    public function create($args)
    {
        $sql = "INSERT INTO $this->tableName 
                (user_id, status, shipping_address, payment_method) 
                VALUES 
                (:user_id, :status, :shipping_address, :payment_method)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $args['user_id'],
            'status' => $args['status'],
            'shipping_address' => $args['shipping_address'],
            'payment_method' => $args['payment_method'],
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}

?>