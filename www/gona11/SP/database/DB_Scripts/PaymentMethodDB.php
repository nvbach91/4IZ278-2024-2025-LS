<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class PaymentMethodDB extends Database {
    protected $tableName = "paymentmethod";

    public function getMethodPrice($methodId) {
        $sql = "SELECT price FROM {$this->tableName} WHERE method_id = :methodId";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":methodId" => $methodId]);
        return $statement->fetch();
    }

    public function getAllMethods() {
        $sql = "SELECT * FROM {$this->tableName}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getMethodName($id) {
        $sql = "SELECT name FROM {$this->tableName} WHERE id_payment_method = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":id" => $id]);
        return $statement->fetchColumn();
    }
}