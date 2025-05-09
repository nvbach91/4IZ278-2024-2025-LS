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
            $goods[] = new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img'], $row['timestamp'], $row['locked_by'], $row['locked_at']);
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
            $goods[] = new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img'], $row['timestamp']);
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
            return new Good($row['good_id'], $row['name'], $row['price'], $row['description'], $row['img'], $row['timestamp'], $row['locked_by'], $row['locked_at']);
        } else {
            return null;
        }
    }


    public function update(Good $good): bool
    {
        $query = "UPDATE cv07_goods
                  SET name = :name,
                      price = :price,
                      description = :description,
                      img = :img,
                      timestamp = NOW()
                  WHERE good_id = :id
                    AND 
                        timestamp = :timestamp";


        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name',        $good->name);
        $stmt->bindParam(':price',       $good->price);
        $stmt->bindParam(':description', $good->description);
        $stmt->bindParam(':img',         $good->img);
        $stmt->bindParam(':id',          $good->good_id, PDO::PARAM_INT);
        $stmt->bindParam(':timestamp', $good->timestamp);

        $stmt->execute();

        // Úspěšný update = jeden změněný řádek
        return $stmt->rowCount() > 0;
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

    public function lockProduct(int $goodId, string $userId): bool
    {
        $sql = "UPDATE cv07_goods
            SET locked_by = :userId,
                locked_at = NOW()
            WHERE good_id = :id
              AND (locked_by IS NULL OR locked_at < (NOW() - INTERVAL 10 MINUTE))";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':id', $goodId);
        $stmt->execute();

        return $stmt->rowCount() > 0; // true pokud zamčeno
    }

    public function unlockProduct(int $goodId, string $userId): void
    {
        $sql = "UPDATE cv07_goods
            SET locked_by = NULL, locked_at = NULL
            WHERE good_id = :id AND locked_by = :userId";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $goodId);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
