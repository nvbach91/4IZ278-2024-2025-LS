<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class GoodsDB extends Database
{
    protected $tableName = 'cv07_goods';

    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function fetchPage($numberOfItemsPerPage, $page)
    {
        $offset = ($page - 1) * $numberOfItemsPerPage;
        $sql = "SELECT * FROM $this->tableName LIMIT :offset, :limit;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(':limit', (int)$numberOfItemsPerPage, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}