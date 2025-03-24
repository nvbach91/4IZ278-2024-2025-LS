<?php
require_once __DIR__ . '/DatabaseConnection.php';

class CategoryDB
{
    protected $tableName = 'cv06_categories';
    public function find()
    {
        $sql = "SELECT * FROM $this->tableName";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
