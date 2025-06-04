<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class OrderItemsDB extends Database
{
    protected $tableName = 'order_items';

    public function fetchByOrderId($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE order_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($orderId, $productID, $quantity, $price)
    {
        $sql = "INSERT INTO $this->tableName (order_id, product_id, quantity, price) 
                VALUES (:orderId, :productID, :quantity, :price);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $statement->bindValue(':productID', $productID, PDO::PARAM_INT);
        $statement->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $statement->bindValue(':price', $price, PDO::PARAM_STR);
        return $statement->execute();
    }
}