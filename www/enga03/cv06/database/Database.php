<?php
require_once __DIR__ . '/database-config.php';
require_once __DIR__ . '/DatabaseOperation.php';

abstract class Database implements DatabaseOperation {
    protected $connection;
    protected $tableName;

    public function __construct($useDatabase = true) {
        $dsn = 'mysql:host=' . DB_SERVER_URL;
        if ($useDatabase) {
            $dsn .= ';dbname=' . DB_DATABASE;
        }

        $this->connection = new PDO(
            $dsn,
            DB_USERNAME,
            DB_PASSWORD
        );
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function fetch($args = []) {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute($args);
        return $statement->fetchAll();
    }
}
?>