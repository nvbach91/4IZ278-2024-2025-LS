<?php
require_once __DIR__ . '/database.php';

class ProductDB extends Database {
    protected $tableName = 'products';
    
    public function findByCategory($category_id) {
        return $this->findBy('category_id', $category_id);
    }

    public function getDiscounted() {
        $sql = "SELECT * FROM `products` WHERE discounted_price IS NOT NULL";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    
}

?>