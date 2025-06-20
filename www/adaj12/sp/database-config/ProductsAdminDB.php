<?php
require_once "Database.php";

class ProductsAdminDB extends Database {
    protected $tableName = "products";

    public function fetchAll() {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPage($limit, $offset) {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->tableName}");
        return (int)$stmt->fetchColumn();
    }

    public function fetchById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->tableName}
            (name, description, detail, price, image, stock, min_age, max_age, tag, genre_id, category_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['detail'],
            $data['price'],
            $data['image'],
            $data['stock'],
            $data['min_age'],
            $data['max_age'],
            $data['tag'],
            $data['genre_id'],
            $data['category_id'],
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE {$this->tableName} SET
            name = ?, description = ?, detail = ?, price = ?, image = ?, stock = ?,
            min_age = ?, max_age = ?, tag = ?, genre_id = ?, category_id = ?
            WHERE id = ?");
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['detail'],
            $data['price'],
            $data['image'],
            $data['stock'],
            $data['min_age'],
            $data['max_age'],
            $data['tag'],
            $data['genre_id'],
            $data['category_id'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function fetchFiltered($filters = []) {
        return $this->fetchAll();
    }
}
