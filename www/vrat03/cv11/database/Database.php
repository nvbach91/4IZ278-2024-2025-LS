<?php require __DIR__.'/database-config.php';?>
<?php

class Database{
    public $connection;
    protected $tableName;
    public function  __construct() {
        $this->connection = new PDO(
            'mysql:host=' . DB_SERVER_URL . ';' . 'dbname=' . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD,
        );
        $this->connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE, 
            PDO::FETCH_ASSOC,
        );
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}

?>