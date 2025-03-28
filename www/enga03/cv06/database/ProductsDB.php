<?php
require_once __DIR__ . '/Database.php';

class ProductsDB extends Database {
    protected $tableName = 'cv06_products';

    public function fetchByCategory($category_id) {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = :category_id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['category_id' => $category_id]);
        return $statement->fetchAll();
    }
}
?>