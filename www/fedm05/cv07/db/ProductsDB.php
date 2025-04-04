<?php
require_once __DIR__ . '/DatabaseConnection.php';

class ProductsDB
{
    protected $tableName = 'cv07_goods';

    public function getProductCount()
    {
        $sql = "SELECT COUNT(*) FROM $this->tableName";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }
    public function getProductById($id)
    {
        $stmt = DatabaseConnection::getInstance()->prepare("SELECT * FROM $this->tableName WHERE good_id = ?");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getRelevantProducts($offset, $productsPerPage)
    {
        $stmt = DatabaseConnection::getInstance()->prepare("SELECT * FROM $this->tableName ORDER BY good_id DESC LIMIT $productsPerPage OFFSET ?");
        $stmt->bindValue(1, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $goods = $stmt->fetchAll();
        return $goods;
    }
    public function createProduct($product) {
        $sql = "INSERT INTO $this->tableName (name, price, description, img) VALUES (:name, :price, :description, :img)";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute([
            ':name' => $product['name'],
            ':price' => $product['price'],
            ':description' => $product['description'],
            ':img' => $product['img']
        ]);
    }
}
