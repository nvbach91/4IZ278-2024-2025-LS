<?php

require_once 'DbPdo.php';
require_once 'classes/Product.php';

class ProductDb
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }


    public function find()
    {
        $sql = "SELECT * FROM cv06_products";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];


        foreach ($rows as $row) {
            $products[] = new Product(
                $row['product_id'],
                $row['name'],
                $row['price'],
                $row['img'],
                $row['category_id']
            );
        }

        return $products;
    }

    public function findByCategoryId($id)
    {
        $sql = "SELECT * FROM cv06_products WHERE category_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($rows as $row) {
            $products[] = new Product(
                $row['product_id'],
                $row['name'],
                $row['price'],
                $row['img'],
                $row['category_id']
            );
        }

        return $products;
    }
}
