<?php
require_once __DIR__ . '/../db/Database.php';

class Ingredient
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }    public function getAllIngredients()
    {
        $query = "SELECT i.* 
                  FROM ingredients i 
                  WHERE i.deleted = 0 ";
        $result = $this->db->select($query);
        return is_array($result) ? $result : [];
    }
}
