<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class ShippingDB extends Database
{
    protected $tableName = 'shipping_method';

    public function fetchById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}