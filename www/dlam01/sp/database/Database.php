<?php require_once __DIR__ . '/database-config.php'; ?>
<?php require_once __DIR__ . '/IDatabaseOperations.php'; ?>
<?php
abstract class Database implements IDatabaseOperations
{
    protected $connection;
    protected $tableName;
    public function __construct()
    {
        $this->connection = new PDO(
            'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD
        );
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    public function fetch($args)
    {
        $sql = "SELECT * FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>