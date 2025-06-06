<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class OrdersDB extends Database
{
    protected $tableName = 'orders';

    public function fetchByUserId($userId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :userId;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($id, $userId, $status, $shippingMethodId, $shippingPrice, $totalPrice, $city, $street, $zipCode)
    {
        $sql = "INSERT INTO $this->tableName (id, user_id, date, status, shipping_method_id, shipping_price, total_price, city, street, zip_code) 
                VALUES (:id,:userId, :orderDate, :status, :shippingMethodId, :shippingPrice, :totalPrice, :city, :street, :zipCode);";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
        $statement->bindValue(':orderDate', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $statement->bindValue(':status', $status, PDO::PARAM_STR);
        $statement->bindValue(':shippingMethodId', (int)$shippingMethodId, PDO::PARAM_INT);
        $statement->bindValue(':shippingPrice', (float)$shippingPrice, PDO::PARAM_STR);
        $statement->bindValue(':totalPrice', (float)$totalPrice, PDO::PARAM_STR);
        $statement->bindValue(':city', $city, PDO::PARAM_STR);
        $statement->bindValue(':street', $street, PDO::PARAM_STR);
        $statement->bindValue(':zipCode', $zipCode, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function fetchById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function getHighestID()
    {
        $sql = "SELECT MAX(id) FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function setStatusById($id, $status)
    {
        $sql = "UPDATE $this->tableName SET status = :status WHERE id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':status', (int)$status, PDO::PARAM_INT);
        $statement->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $statement->execute();
    }
}