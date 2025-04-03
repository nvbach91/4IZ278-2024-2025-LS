<?php
require_once __DIR__ . '/database.php';

class CategoryDB extends Database {
    protected $tableName = 'categories';
    

public function getCategories() {
        return $this->find();
    }
}