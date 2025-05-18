<?php require_once __DIR__ . '/../Database.php'?>
<?php 

class ProductDB extends Database {
    protected $tableName = 'Product';

    public function getAllProducts() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}

