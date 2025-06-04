<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class OrderItemsDB extends Database {
    protected $tableName = 'order_items';

    public function findItemByID($id) {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function editItem($args) {
        $sql = "UPDATE $this->tableName 
                SET order_id = :order_id, 
                    product_id = :product_id, 
                    quantity = :quantity, 
                    price = :price 
                WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $args['id'],
            'order_id' => $args['order_id'],
            'product_id' => $args['product_id'],
            'quantity' => $args['quantity'],
            'price' => $args['price'],
        ]);
    }

    public function create($args) {
        $sql = "INSERT INTO $this->tableName 
                (order_id, product_id, quantity, price) 
                VALUES 
                (:order_id, :product_id, :quantity, :price)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'order_id' => $args['order_id'],
            'product_id' => $args['product_id'],
            'quantity' => $args['quantity'],
            'price' => $args['price'],
        ]);
        
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}
