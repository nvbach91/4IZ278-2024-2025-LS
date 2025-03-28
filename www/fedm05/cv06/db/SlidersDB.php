<?php
require_once __DIR__ . '/DatabaseConnection.php';

class SlidersDB
{
    protected $tableName = 'cv06_sliders';
    public function find()
    {
        $sql = "SELECT * FROM $this->tableName";
        $statement = DatabaseConnection::getInstance()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }
}
