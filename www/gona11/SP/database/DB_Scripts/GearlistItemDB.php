<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class GearlistItemDB extends Database {
    protected $tableName = "gearlistitem";

    public function getGearlistItems($gearlistId) {
        $sql = "SELECT * FROM {$this->tableName} WHERE gearlist = :id_gearlist";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":id_gearlist" => $gearlistId
        ]);
        return $statement->fetchAll();
    }

    public function addProductItem($gearlistId, $productId, $quantity, $note) {
        $sql = "INSERT INTO {$this->tableName} (gearlist, product, quantity, note) VALUES (:gearlist_id, :product_id, :quantity, :note)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":gearlist_id" => $gearlistId,
            ":product_id" => $productId,
            ":quantity" => $quantity,
            ":note" => $note
        ]);
    }

    public function addCustomItem($gearlistId, $customItemId, $quantity, $note) {
        $sql = "INSERT INTO {$this->tableName} (gearlist, custom_item, quantity, note) VALUES (:gearlist_id, :custom_item_id, :quantity, :note)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":gearlist_id" => $gearlistId,
            ":custom_item_id" => $customItemId,
            ":quantity" => $quantity,
            ":note" => $note
        ]);
    }

    public function deleteItemsByGearlistId($gearlistId) {
        $sql = "DELETE FROM {$this->tableName} WHERE gearlist = :id_gearlist";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":id_gearlist" => $gearlistId
        ]);
    }

    public function deleteCustomItemsById($customItemId) {
        $sql = "DELETE FROM {$this->tableName} WHERE custom_item = :id_custom_item";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([
            ":id_custom_item" => $customItemId
        ]);
    }
}