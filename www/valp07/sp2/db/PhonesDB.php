<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class PhonesDB extends Database {
    protected $tableName = 'phones';
    public function findPhoneByID($product_id) {
        $sql = "SELECT * FROM $this->tableName WHERE product_id = :product_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['product_id' => $product_id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function editProduct($args) {
        $sql = "UPDATE $this->tableName SET product_id = :product_id, screen_size = :screen_size, ram = : ram, storage = :storage, battery = :battery WHERE product_id = :product_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'product_id' => $args['product_id'], 
            'screen_size' => $args['screen_size'],
            'ram' => $args['ram'],
            'storage' => $args['storage'], 
            'battery' => $args['battery'],
        ]);
    }
    public function create($args) {
        $sql = "INSERT INTO $this->tableName (product_id, screen_size, ram, storage, battery) VALUES (:product_id, :screen_size, :ram, :storage, :battery)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'product_id' => $args['product_id'], 
            'screen_size' => $args['screen_size'],
            'ram' => $args['ram'],
            'storage' => $args['storage'], 
            'battery' => $args['battery'],

        ]);
    }
    public function delete($id) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = :product_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['product_id' => $id]);
    }
}

?>