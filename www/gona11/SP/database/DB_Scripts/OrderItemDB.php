<?php require_once __DIR__ . "/../Database.php"?>

<?php 

class OrderItemDB extends Database {
    protected $tableName = "orderitem";

    public function insertOrderItem($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO {$this->tableName} (
                     `order`,
                    product,
                    quantity,
                    price_per_item) 
                VALUES (
                    :orderId,
                    :productId,
                    :quantity,
                    :price)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":orderId" => $orderId,
            ":productId" => $productId,
            ":quantity" => $quantity,
            ":price" => $price
        ]);
    }

    public function getProductsFromOrder($orderId) {
    $sql = "SELECT * FROM {$this->tableName} oi 
                JOIN product p ON oi.product = p.id_product 
                WHERE oi.order = :orderId";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":orderId" => $orderId]);
        return $statement->fetchAll();
    }
}
?>