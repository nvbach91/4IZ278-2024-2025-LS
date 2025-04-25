<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class ProductsDB extends Database {
    protected $tableName = 'cv07_goods';
    public function findProductByID($id) {
        $sql = "SELECT * FROM $this->tableName WHERE good_id = :good_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['good_id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function editProduct($args) {
        $sql = "UPDATE $this->tableName SET name = :name, price = :price, description = :description WHERE good_id = :good_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'good_id' => $args['good_id'],
            'name' => $args['name'], 
            'price' => $args['price'], 
            'description' => $args['description'],
        ]);
    }
    public function create($args) {
        $sql = "INSERT INTO $this->tableName (name, price, description) VALUES (:name, :price, :description)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'], 
            'price' => $args['price'], 
            'description' => $args['description'],
        ]);
    }
    public function delete($id) {
        $sql = "DELETE FROM $this->tableName WHERE good_id = :good_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['good_id' => $id]);
    }
}

?>