<?php

require_once __DIR__ . '/Database.php';

class DatabaseOperation {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getConnection() {
        return $this->db;
    }

    public function fetchAllGoods() {
        $stmt = $this->db->query("SELECT * FROM cv10_goods ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function fetchGoodById($good_id) {
        $stmt = $this->db->prepare("SELECT * FROM cv10_goods WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addGood($name, $description, $price, $img) {
        $stmt = $this->db->prepare("INSERT INTO cv10_goods (name, description, price, img) VALUES (:name, :description, :price, :img)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        return $stmt->execute();
    }

    public function updateGood($good_id, $name, $description, $price, $img) {
        $stmt = $this->db->prepare("UPDATE cv10_goods SET name = :name, description = :description, price = :price, img = :img WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        return $stmt->execute();
    }

    public function deleteGood($good_id) {
        $stmt = $this->db->prepare("DELETE FROM cv10_goods WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>