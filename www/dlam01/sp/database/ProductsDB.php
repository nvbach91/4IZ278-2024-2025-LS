<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class ProductsDB extends Database
{
    protected $tableName = 'products';

    public function fetchAll()
    {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function count($animalID, $categoryID)
    {
        $sql = "SELECT COUNT(*) FROM $this->tableName WHERE 1=1 ";
        if ($animalID) {
            $sql .= " AND id IN (SELECT product_id FROM product_animals WHERE animal_id = :animalID)";
        }
        if ($categoryID) {
            $sql .= " AND category_id = :categoryID";
        }
        $statement = $this->connection->prepare($sql);
        if ($animalID) {
            $statement->bindValue(':animalID', (int)$animalID, PDO::PARAM_INT);
        }
        if ($categoryID) {
            $statement->bindValue(':categoryID', (int)$categoryID, PDO::PARAM_INT);
        }
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function fetchPage($numberOfItemsPerPage, $page, $animalID, $categoryID)
    {
        $offset = ($page - 1) * $numberOfItemsPerPage;
        $sql = "SELECT * FROM $this->tableName WHERE 1=1 ";

        if ($animalID) {
            $sql .= " AND id IN (SELECT product_id FROM product_animals WHERE animal_id = :animalID)";
        }
        if ($categoryID) {
            $sql .= " AND category_id = :categoryID";
        }
        $sql .= " LIMIT :offset, :limit;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(':limit', (int)$numberOfItemsPerPage, PDO::PARAM_INT);
        if ($animalID) {
            $statement->bindValue(':animalID', (int)$animalID, PDO::PARAM_INT);
        }
        if ($categoryID) {
            $statement->bindValue(':categoryID', (int)$categoryID, PDO::PARAM_INT);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($productId)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :productId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':productId', (int)$productId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function fetchById($productId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :productId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':productId', (int)$productId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function fetchByAnimalID($animalId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :productId IN (SELECT product_id FROM animal_products WHERE animal_id = :animalId);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':animalId', (int)$animalId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $description, $price, $image, $stock, $last_updated, $categoryId)
    {
        $sql = "UPDATE $this->tableName SET name = :name, description = :description, price = :price, image = :image, stock =:stock, last_updated = :last_updated, category_id = :categoryId WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':price', $price, PDO::PARAM_STR);
        $statement->bindValue(':image', $image, PDO::PARAM_STR);
        $statement->bindValue(':stock', $stock, PDO::PARAM_INT);
        $statement->bindValue(':last_updated', $last_updated, PDO::PARAM_STR);
        $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
}
}