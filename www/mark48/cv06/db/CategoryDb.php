<?php

require_once 'DbPdo.php';
require_once 'classes/Category.php';

class CategoryDb
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }


    public function find()
    {
        $sql = "SELECT * FROM cv06_categories";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];


        foreach ($rows as $row) {
            $categories[] = new Category(
                $row['category_id'],
                $row['name'],
                $row['number'],

            );
        }

        return $categories;
    }
}
