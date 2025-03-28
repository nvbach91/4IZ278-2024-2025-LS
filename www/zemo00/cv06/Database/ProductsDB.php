<?php

require_once __DIR__ . "/Database.php";

class ProductsDB extends Database {

    protected $tableName = 'Products';

    public function changePrice($price, $id) {
        $args = [
            'update' => "price = :price",
            'conditions' => ["product_id = :product_id"]
        ];
        $this->update($args);
    }

    public function fetchRandomProducts($limit = 3){
        $sql = "SELECT * FROM $this->tableName
                    ORDER BY RAND() LIMIT :limit";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

}

?>