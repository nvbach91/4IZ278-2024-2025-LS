<?php require_once __DIR__.'/Database.php';?>
<?php require_once __DIR__.'/ProductsDB.php';?>
<?php

class OrderItemsDB extends Database {
    protected $tableName = 'sp_eshop_order_items';
    protected $productsDB;

    public function __construct() {
        parent::__construct();
        $this->productsDB = new ProductsDB();
    }

    public function addItemToOrder($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO $this->tableName (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity, 'price' => $price]);
    }

    public function addItemsToOrder($orderId, $items) {
        foreach ($items as $item) {
            $this->addItemToOrder($orderId, $item['id'], $item['quantity'], $item['price']);
        }
    }

    public function getItemsByOrderId($orderId) {
        $sql = "SELECT * FROM $this->tableName WHERE order_id = :order_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['order_id' => $orderId]);
        return $statement->fetchAll();
    }

    public function getItemsNamesByOrderId($orderId) {
        $sql = "SELECT oi.*, p.name 
                FROM $this->tableName oi 
                JOIN {$this->productsDB->getTableName()} p 
                ON oi.product_id = p.product_id 
                WHERE oi.order_id = :order_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['order_id' => $orderId]);
        return $statement->fetchAll();
    }
}

?>