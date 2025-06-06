<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class CategoriesDB extends Database
{
    protected $tableName = 'categories';

    public function fetchById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}