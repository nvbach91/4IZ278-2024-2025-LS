<?php require_once 'Database.php'; ?>
<?php 

class ProductDB extends Database {
    protected $tableName = 'cv06_products';

    public function findByCategory($category_id) {
        $query = "SELECT * FROM cv06_products WHERE category_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll();
    }

    public function findAll() {
        $query = "SELECT * FROM cv06_products";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll();
    }
}

?>