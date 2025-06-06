<?php require_once __DIR__.'/Database.php';?>
<?php

class CategoriesDB extends Database {
    protected $tableName = 'sp_eshop_categories';
    
    public function fetchCategoryById($categoryID) {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = ?;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$categoryID]);
        return $statement->fetch();
    }

    public function addCategory($name) {
        $sql = "INSERT INTO $this->tableName (name) VALUES (?);";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$name]);
        return $this->connection->lastInsertId();
    }

    public function updateCategory($categoryID, $name) {
        $sql = "UPDATE $this->tableName SET name = ?, last_updated = NOW() WHERE category_id = ?;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([$name, $categoryID]);
    }
}

?>