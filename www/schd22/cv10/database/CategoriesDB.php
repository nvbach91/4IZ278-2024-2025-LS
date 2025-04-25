<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class CategoriesDB extends Database {
    protected $tableName = 'cv07_categories';
    public function create($args) {}

    public function getAllCategories() {
        $sql = "SELECT * FROM cv07_categories";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

?>