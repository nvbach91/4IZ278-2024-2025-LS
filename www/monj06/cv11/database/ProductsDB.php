<?php
require_once __DIR__ . '/Database.php';

class ProductsDB extends Database
{
    protected $tableName = 'cv06_products';

    function findByCategory($category_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE category_id=$category_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    public function findById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE product_id = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    function getRange($numberOfItemsPerPage, $pageNumber)
    {
        $offset = $numberOfItemsPerPage * ($pageNumber - 1);
        $sql  = "SELECT * FROM $this->tableName
         ORDER BY product_id ASC
         LIMIT $numberOfItemsPerPage
         OFFSET $offset
         ;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    function getCategoryRange($numberOfItemsPerPage, $pageNumber, $category_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE category_id=$category_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $products = $statement->fetchAll();
        return array_slice($products, $numberOfItemsPerPage * ($pageNumber - 1), 5);
    }
    public function countRecordsCategory($category_id)
    {
        $sql = "SELECT COUNT(*) AS numberOfRecordsByCategory from $this->tableName WHERE category_id=$category_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    public function removeById($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE product_id = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
    public function EditItemById($id, $name, $price, $img, $category, $user)
    {
        $sql = "UPDATE $this->tableName SET `name` = '$name', `price` = $price, `img` = '$img', `category_id` = $category, `user_id` = $user WHERE `product_id` = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
}
