<?php require_once 'Database.php'; ?>
<?php 

class ProductDB extends Database {
    protected $tableName = 'cv07_products';

    public function findByCategory($category_id) {
        $query = "SELECT * FROM cv07_products WHERE category_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll();
    }

    public function findAll() {
        $query = "SELECT * FROM cv07_products";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll();
    }

    public function countProducts() {
        $sql = "SELECT COUNT(*) FROM $this->tableName";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function countByCategory($categoryId) {
        $sql = "SELECT COUNT(*) FROM $this->tableName WHERE category_id = :categoryId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function findPaginated($limit, $offset) {
        $sql = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findByCategoryPaginated($categoryId, $limit, $offset) {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = :categoryId LIMIT :limit OFFSET :offset";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function findByIds(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM $this->tableName WHERE product_id IN ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_values($ids));
        return $stmt->fetchAll();
    
    }
    public function insert($name, $description, $price, $img, $categoryId) {
        $sql = "INSERT INTO $this->tableName (name, description, price, img, category_id) 
                VALUES (:name, :description, :price, :img, :category_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'img' => $img,
            'category_id' => $categoryId
        ]);
    }
    public function updateProduct($id, $name, $description, $price, $img, $categoryId) {
        $sql = "UPDATE $this->tableName 
                SET name = :name, description = :description, price = :price, img = :img, category_id = :category_id 
                WHERE product_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'img' => $img,
            'category_id' => $categoryId,
            'id' => $id
        ]);
    }
    public function delete($id) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    
}

?>