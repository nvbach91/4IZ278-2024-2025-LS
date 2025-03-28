<?php
require_once __DIR__ . '/DatabaseConnection.php';

class ProductsDB
{
    protected $tableName = 'cv06_products';

    public function find()
    {
        $sql = "SELECT * FROM $this->tableName";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByCategory($category_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = $category_id";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
