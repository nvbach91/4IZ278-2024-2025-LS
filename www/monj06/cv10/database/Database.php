<?php
require_once __DIR__ . '/DatabaseOperations.php';
require_once __DIR__ . '/database-config.php';

abstract class Database implements DatabaseOperations
{
    // pristupny pouze v podrazenych tridach
    protected $connection;
    protected $tableName;

    public function __construct()
    {
        $this->connection = new PDO(
            "mysql:host=" . DB_SERVER_URL  . ';dbname=' . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD,
        );
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    public function find($args)
    {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
    public function insert($args)
    {
        $sql = "INSERT INTO $this->tableName (`name`, `price`, `img`, `category_id`)
        VALUES ('$args[0]','$args[1]','$args[2]','$args[3]');";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName 
        WHERE product_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
    }
    public function countRecords($args)
    {
        $sql = "SELECT COUNT(*) AS numberOfRecords from $this->tableName; ";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
