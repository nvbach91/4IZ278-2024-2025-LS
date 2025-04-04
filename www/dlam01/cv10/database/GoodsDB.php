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

    public function fetchPage($numberOfItemsPerPage, $page){
        $offset = ($page - 1) * $numberOfItemsPerPage;
        $sql = "SELECT * FROM $this->tableName LIMIT :offset, :limit;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $statement->bindValue(':limit', (int)$numberOfItemsPerPage, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($goodId)
    {
        $sql = "DELETE FROM $this->tableName WHERE good_id = :goodId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':goodId', (int)$goodId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function update($goodId,$name,$price,$description,$img)
    {
        $sql = "UPDATE $this->tableName SET name = :name, price = :price, description = :description, img = :img WHERE good_id = :goodId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':goodId', (int)$goodId, PDO::PARAM_INT);
        $statement->bindValue(':price', $price, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':img', $img, PDO::PARAM_STR);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();
    }

    public function insert($name,$price,$description,$img)
    {
        $sql = "INSERT INTO $this->tableName (name,price,description,img) VALUES (:name,:price,:description,:img);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':price', $price, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':img', $img, PDO::PARAM_STR);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();
    }

    public function fetchById($goodId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE good_id = :goodId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':goodId', (int)$goodId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
?>