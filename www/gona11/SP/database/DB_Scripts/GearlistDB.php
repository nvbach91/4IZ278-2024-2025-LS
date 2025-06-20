<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class GearlistDB extends Database {
    protected $tableName = "gearlist";

    public function getAllGearlists($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":user_id" => $id
        ]);
        return $statement->fetchAll();
    }

    public function getGearlist($id) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id_gearlist = :id_gearlist";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id_gearlist" => $id
        ]);
        return $statement->fetch();
    }

    public function getGearlistOwner($id) {
        $sql = "SELECT user_id FROM {$this->tableName} WHERE id_gearlist = :id_gearlist";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id_gearlist" => $id
        ]);
        return $statement->fetchColumn();
    }

    public function deleteGearlist($id) {
        $sql = "DELETE FROM {$this->tableName} WHERE id_gearlist = :id_gearlist";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":id_gearlist" => $id
        ]);
    }

    public function createGearlist($userId, $name, $description) {
        $sql = "INSERT INTO {$this->tableName} (user_id, name, description, created_at) VALUES (:user_id, :name, :description, :created_at)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":user_id" => $userId,
            ":name" => $name,
            ":description" => $description,
            ":created_at" => date('Y-m-d H:i:s')
        ]);
        return $this->connection->lastInsertId();
    }
}