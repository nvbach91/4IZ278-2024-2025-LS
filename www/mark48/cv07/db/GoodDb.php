<?php

require_once "DbPdo.php";

class GoodDb
{

    private $connection;


    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM cv07_goods";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $goods = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $goods[] = new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img']);
        }

        return $goods;
    }

    public function getPaginated($limit, $offset)
    {
        $query = "SELECT * FROM cv07_goods LIMIT :limit OFFSET :offset";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $goods = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $goods[] = new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img']);
        }

        return $goods;
    }

    public function getTotalCount()
    {
        $query = "SELECT COUNT(*) as count FROM cv07_goods";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }

    public function getById($id)
    {
        $query = "SELECT * FROM cv07_goods WHERE good_id = :id LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img']);
        } else {
            return null;
        }
    }


    public function update(Good $good)
    {
        $query = "UPDATE cv07_goods 
              SET name = :name, price = :price, description = :description, img = :img 
              WHERE good_id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $good->name);
        $stmt->bindParam(':price', $good->price);
        $stmt->bindParam(':description', $good->description);
        $stmt->bindParam(':img', $good->img);
        $stmt->bindParam(':id', $good->good_id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function delete($id)
    {
        $query = "DELETE FROM cv07_goods WHERE good_id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Vloží nový produkt do databáze a vrátí jeho ID nebo false při chybě.
    public function create(Good $good)
    {
        $query = "INSERT INTO cv07_goods (name, price, description, img) VALUES (:name, :price, :description, :img)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $good->name);
        $stmt->bindParam(':price', $good->price);
        $stmt->bindParam(':description', $good->description);
        $stmt->bindParam(':img', $good->img);
        if ($stmt->execute()) {
            return $this->connection->lastInsertId();
        } else {
            return false;
        }
    }
}
