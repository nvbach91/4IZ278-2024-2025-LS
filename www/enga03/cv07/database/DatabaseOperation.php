<?php

require_once __DIR__ . '/Database.php';

class DatabaseOperation {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function fetchAllGoods($limit, $offset) {
        $stmt = $this->db->prepare("SELECT * FROM cv07_goods ORDER BY good_id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetchGoodById($good_id) {
        $stmt = $this->db->prepare("SELECT * FROM cv07_goods WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addGood($name, $description, $price, $img) {
        $stmt = $this->db->prepare("INSERT INTO cv07_goods (name, description, price, img) VALUES (:name, :description, :price, :img)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        return $stmt->execute();
    }

    public function updateGood($good_id, $name, $description, $price, $img) {
        $stmt = $this->db->prepare("UPDATE cv07_goods SET name = :name, description = :description, price = :price, img = :img WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        return $stmt->execute();
    }

    public function deleteGood($good_id) {
        $stmt = $this->db->prepare("DELETE FROM cv07_goods WHERE good_id = :good_id");
        $stmt->bindParam(':good_id', $good_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>