<?php

class ProductDB extends Database {
    protected $tableName = 'products';

    public function getProductsByCategory($categoryId){
        $sql = "SELECT * FROM $this->tableName WHERE category_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
}