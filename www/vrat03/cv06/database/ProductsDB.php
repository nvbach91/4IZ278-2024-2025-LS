<?php require_once __DIR__.'/Database.php';?>
<?php

class ProductsDB extends Database {
    protected $tableName = 'products';

    public function fetchByCategoryID($category_id) {
        $sql="SELECT * FROM $this->tableName WHERE category_id = :category_id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':category_id', $category_id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchCheapest($numberOfProducts) {
        $sql = "SELECT * FROM $this->tableName ORDER BY price ASC LIMIT :numberOfProducts;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':numberOfProducts', $numberOfProducts, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>