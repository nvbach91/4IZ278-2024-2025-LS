<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class ProductDB extends Database {
    protected $tableName = "product";

    public function getAllProducts() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function countRecords() {
        $sql = "SELECT COUNT(*) FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getPageCountProducts($numberPerPage, $offset, $category) {
        $sql = "SELECT * FROM $this->tableName
        WHERE category = $category
        ORDER BY good_id ASC
        LIMIT $numberPerPage
        OFFSET $offset;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getProductsByCategory($category) {
        $sql = "SELECT * FROM {$this->tableName} WHERE category = :category";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":category" => $category
        ]);
        return $statement->fetchAll();
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id_product = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetch();
    }

    public function getProductsByIds($ids) {
        if (empty($ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM {$this->tableName} WHERE id_product IN ($placeholders)";
        $statement = $this->connection->prepare($sql);
        $statement->execute($ids);
        return $statement->fetchAll();
    }

    public function checkAvailability($id) {
        $sql = "SELECT stock FROM {$this->tableName} WHERE id_product = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        $result = $statement->fetch();
        return $result ? (int)$result["stock"] : 0; 
    }

    public function updateProductStock($id, $quantity) {
        $sql = "UPDATE {$this->tableName} SET stock = stock - :quantity WHERE id_product = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":quantity" => $quantity,
            ":id" => $id
        ]);
    }

    public function editProduct(
        $id, 
        $name,
        $price,
        $category,
        $weight, 
        $stock,
        $description, 
        $image
    ) {
        $sql = "UPDATE {$this->tableName} SET 
                name = :name,
                price = :price,
                category = :category,
                weight = :weight,
                stock = :stock,
                description = :description,
                image = :image
                WHERE id_product = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":name" => $name,
            ":price" => $price,
            ":category" => $category,
            ":weight" => $weight,
            ":stock" => $stock,
            ":description" => $description,
            ":image" => $image,
            ":id" => $id
        ]);
    }
}

