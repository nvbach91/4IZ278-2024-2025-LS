<?php
require_once "Database.php";

class ProductsDB extends Database {
    protected $tableName = "products";

    public function fetchFiltered($filters) {
        $where = [];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = 'p.category_id = :category';
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['genre'])) {
            $where[] = 'p.genre_id = :genre';
            $params[':genre'] = $filters['genre'];
        }
        if (!empty($filters['min_age'])) {
            $where[] = 'p.min_age >= :min_age';
            $params[':min_age'] = $filters['min_age'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'p.price <= :max_price';
            $params[':max_price'] = $filters['max_price'];
        }

        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT p.*, g.name AS genre_name, c.name AS category_name
            FROM {$this->tableName} p
            LEFT JOIN genres g ON p.genre_id = g.id
            LEFT JOIN categories c ON p.category_id = c.id
            $whereSql
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
