<?php
require_once __DIR__ . '/Database.php';

class ProductsDB {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function fetchAll() {
        $sql = "SELECT * FROM cv10_goods ORDER BY created_at DESC";
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }

    public function fetchById($good_id) {
        $sql = "SELECT * FROM cv10_goods WHERE good_id = :good_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['good_id' => $good_id]);
        return $statement->fetch();
    }

    public function create($args) {
        $sql = "
            INSERT INTO cv10_goods (name, description, price, img)
            VALUES (:name, :description, :price, :img)
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'],
            'description' => $args['description'],
            'price' => $args['price'],
            'img' => $args['img']
        ]);
    }

    public function delete($good_id) {
        $sql = "DELETE FROM cv10_goods WHERE good_id = :good_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['good_id' => $good_id]);
    }
}
?>