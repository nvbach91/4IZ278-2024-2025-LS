<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class CategoryDB extends Database {
    protected $tableName = "category";

    public function getCategoryName($category) {
        $sql = "SELECT name FROM {$this->tableName} WHERE id_category = :category";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":category" => $category
        ]);
        return $statement->fetch();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}