<?php
require_once "Database.php";

class ProductsDB extends Database {
    protected $tableName = "products";

    public function getByIds(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT * FROM products WHERE id IN ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vrací 1 produkt včetně názvů kategorie a žánru
    public function findById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT products.*, 
                    categories.name AS category_name, 
                    genres.name AS genre_name
             FROM products
             LEFT JOIN categories ON products.category_id = categories.id
             LEFT JOIN genres ON products.genre_id = genres.id
             WHERE products.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Filtruje + JOIN na názvy kategorií a žánrů
    public function fetchFiltered($filters, $limit = 10, $offset = 0) {
        $where = [];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = 'products.category_id = :category';
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['genre'])) {
            $where[] = 'products.genre_id = :genre';
            $params[':genre'] = $filters['genre'];
        }
        if (!empty($filters['min_age'])) {
            $where[] = 'products.min_age <= :min_age';
            $params[':min_age'] = $filters['min_age'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'products.price <= :max_price';
            $params[':max_price'] = $filters['max_price'];
        }

        $sql = "SELECT products.*, 
                       categories.name AS category_name, 
                       genres.name AS genre_name 
                FROM products
                LEFT JOIN categories ON products.category_id = categories.id
                LEFT JOIN genres ON products.genre_id = genres.id";
        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $sql .= " ORDER BY products.id DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = (int)$limit;
        $params[':offset'] = (int)$offset;

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            if ($key === ':limit' || $key === ':offset') {
                $stmt->bindValue($key, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $val);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFiltered($filters) {
        $where = [];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = 'products.category_id = :category';
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['genre'])) {
            $where[] = 'products.genre_id = :genre';
            $params[':genre'] = $filters['genre'];
        }
        if (!empty($filters['min_age'])) {
            $where[] = 'products.min_age <= :min_age';
            $params[':min_age'] = $filters['min_age'];
        }
        if (!empty($filters['max_price'])) {
            $where[] = 'products.price <= :max_price';
            $params[':max_price'] = $filters['max_price'];
        }

        $sql = "SELECT COUNT(*) FROM products";
        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    // Vrací všechny kategorie (id+name)
    public function fetchAllCategories() {
        $stmt = $this->pdo->query("SELECT id, name FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vrací všechny žánry (id+name)
    public function fetchAllGenres() {
        $stmt = $this->pdo->query("SELECT id, name FROM genres ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
