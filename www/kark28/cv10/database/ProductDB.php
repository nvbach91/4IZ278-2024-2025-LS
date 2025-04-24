<?php
require_once __DIR__ . '/database.php';

class ProductDB extends Database {
    protected $tableName = 'products';
    
    public function findByCategory($category_id) {
        return $this->findBy('category_id', $category_id);
    }

    public function getDiscounted() {
        $sql = "SELECT * FROM `products` WHERE discounted_price IS NOT NULL";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function count() {
        $sql = "SELECT COUNT(product_id) FROM products";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function fetchPage($limit, $offset) {
        $sql = "SELECT * FROM $this->tableName ORDER BY product_id DESC LIMIT ? OFFSET ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $limit, PDO::PARAM_INT);
        $statement->bindValue(2, $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByID($id) {
        return $this->findBy('product_id', $id);
    }

    public function fetchVar($question_marks, $ids) {
        $stmt = $this->connection->prepare("SELECT * FROM $this->tableName WHERE product_id IN ($question_marks) ORDER BY name");
        $stmt->execute(array_values($ids));
        return $stmt->fetchAll();
    }

    public function getTotalPrice($question_marks, $ids) {
        $stmt_sum = $this->connection->prepare("SELECT SUM(price) FROM $this->tableName WHERE product_id IN ($question_marks)");
        $stmt_sum->execute(array_values($ids));
        return $stmt_sum->fetchColumn();
    }
    public function insert($url, $name, $price, $category_id, $desc) {
        $sql = "INSERT INTO $this->tableName (`img_url`, `product_id`, `name`, `price`, `category_id`, `discounted_price`, `description`) 
      VALUES ('$url', NULL, '$name', '$price', '$category_id', NULL, '$desc')";
       $statement = $this->connection->prepare($sql);
       $statement->execute();
    }

    public function update($url, $name, $price, $category_id, $desc, $id) {
        $sql = "UPDATE `products` SET `img_url` = '$url', `name` = '$name', `price` = '$price', `category_id` = '$category_id', `description` = '$desc' WHERE `products`.`product_id` = $id";
     $statement = $this->connection->prepare($sql);
    $statement->execute();
    }
   
}

?>