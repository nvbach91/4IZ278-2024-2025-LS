<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class OrderStatusDB extends Database {
    protected $tableName = "orderstatus";

    public function getStatusName($statusId) {
        $sql = "SELECT name FROM {$this->tableName} WHERE id_order_status = :statusId";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":statusId" => $statusId]);
        return $statement->fetchColumn();
    }


}