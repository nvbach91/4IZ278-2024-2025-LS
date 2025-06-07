<?php
require_once __DIR__ . '/../db/Database.php';

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }    public function getAllCategories()
    {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $result = $this->db->select($query);
        return is_array($result) ? $result : [];
    }

    public function getCategoriesByType($type)
    {
        $query = "SELECT * FROM categories WHERE type = :type ORDER BY name ASC";
        $result = $this->db->select($query, ['type' => $type]);
        return is_array($result) ? $result : [];
    }
    
    public function getCategoryTypes()
    {
        $query = "SELECT DISTINCT type FROM categories ORDER BY type ASC";
        $result = $this->db->select($query);
        return is_array($result) ? array_column($result, 'type') : [];
    }
}