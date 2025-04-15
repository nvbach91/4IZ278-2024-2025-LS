<?php
require_once 'db-connection.php';
require_once 'db-operations.php'; 
?>

<?php 
abstract class Database implements DatabaseOperations {
    protected $connection;
    protected $tableName;

    public function __construct() {
        $this->connection = DatabaseConnection::getPDOConnection();
    }

    public function fetch($args) {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function find() {
        $sql = "SELECT * FROM $this->tableName";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function countRecords() {
        $sql = "SELECT COUNT(*) AS numberOfRecords FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll()[0]['numberOfRecords'];
    }

    public function getPageCountProducts($numberPerPage, $offset) {
        $sql = "SELECT * FROM $this->tableName
        ORDER BY good_id ASC
        LIMIT $numberPerPage
        OFFSET $offset;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function addProduct($name,$price,$description,$img) {
        $sql = "INSERT INTO $this->tableName (name, price, description, img)
        VALUES (:name,:price, :description, :img);";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':img' => $img
        ]);
    }

    public function getItemById($id) {
        $sql = "SELECT * FROM $this->tableName WHERE good_id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);
        return $statement->fetchAll();
    }
    
    public function getItemsByIds(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM $this->tableName WHERE good_id IN ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array_values($ids));
        return $stmt->fetchAll();
    }
    public function editItem($id, $name, $price, $description, $img) {
        $sql = "UPDATE $this->tableName
                SET name = :name, price = :price, description = :description, img = :img
                WHERE good_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':img' => $img,
            ':id' => $id
        ]);
    }

    public function deleteItem($id) {
        $sql = "DELETE FROM $this->tableName WHERE good_id = $id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
}
?>