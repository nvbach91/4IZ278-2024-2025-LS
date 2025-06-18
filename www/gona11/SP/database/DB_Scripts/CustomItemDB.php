<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class CustomItemDB extends Database {
    protected $tableName = "customItem";

    public function getCustomItem($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id_custom_item = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetch();
    }

    public function getAllItems($userId) {
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":user_id" => $userId
        ]);
        return $statement->fetchAll();
    }

    public function createCustomItem($userId, $name, $description, $weight) {
        $sql = "INSERT INTO {$this->tableName} (user_id, name, description, weight) VALUES (:user_id, :name, :description, :weight)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":user_id" => $userId,
            ":name" => $name,
            ":description" => $description,
            ":weight" => $weight
        ]);
    }

    public function getCustomItemOwner($id) {
        $sql = "SELECT user_id FROM {$this->tableName} WHERE id_custom_item = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id" => $id
        ]);
        return $statement->fetchColumn();
    }

    public function deleteCustomItem($id) {
        $sql = "DELETE FROM {$this->tableName} WHERE id_custom_item = :id";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":id" => $id
        ]);
    }
}