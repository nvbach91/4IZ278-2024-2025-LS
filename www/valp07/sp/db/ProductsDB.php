<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class ProductsDB extends Database
{
    protected $tableName = 'products';
    public function unlockProduct($productId)
    {
        $sql = "UPDATE products SET locked_by = NULL, locked_at = NULL WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $productId]);
    }
    public function countRecords(string $tableName): int
    {
        $sql = "SELECT COUNT(*) FROM {$tableName}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
    public function hasOrders($productId): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM order_items WHERE product_id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchColumn() > 0;
    }

    public function deleteFromCart($productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE product_id = :id");
        $stmt->execute(['id' => $productId]);
    }
    public function getAllWithPagination($limit, $offset)
    {
        $sql = "SELECT * FROM products ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function deleteProductOnly($productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
    }

    public function getAllPaginated(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = "SELECT COUNT(*) FROM {$this->tableName}";
        $countStmt = $this->pdo->query($countSql);
        $total = $countStmt->fetchColumn();

        return [
            'products' => $products,
            'total' => $total
        ];
    }
    public function searchProducts(string $query, int $limit, int $offset): array
    {
        $sql = "SELECT * FROM products 
        WHERE name LIKE :nameQuery OR description LIKE :descQuery 
        ORDER BY id ASC 
        LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $searchTerm = '%' . $query . '%';
        $stmt->bindValue(':nameQuery', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':descQuery', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE name LIKE :nameQuery OR description LIKE :descQuery");
        $countStmt->bindValue(':nameQuery', $searchTerm, PDO::PARAM_STR);
        $countStmt->bindValue(':descQuery', $searchTerm, PDO::PARAM_STR);
        $countStmt->execute();
        $total = $countStmt->fetchColumn();

        return [
            'products' => $products,
            'total' => $total
        ];
    }
    public function getLockInfo($productId)
    {
        $stmt = $this->pdo->prepare("SELECT locked_by, locked_at FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function lockProduct($productId, $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET locked_by = :user_id, locked_at = NOW() WHERE id = :id");
        return $stmt->execute([
            'user_id' => $userId,
            'id' => $productId
        ]);
    }
    public function findProductByID($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function editProduct($args)
    {
        $sql = "UPDATE $this->tableName SET image = :image, name = :name, description = :description, brand = :brand, price = :price, stock = :stock WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'image' => $args['image'],
            'id' => $args['id'],
            'name' => $args['name'],
            'description' => $args['description'],
            'brand' => $args['brand'],
            'price' => $args['price'],
            'stock' => $args['stock'],
        ]);
    }
    public function create($args)
    {
        $sql = "INSERT INTO $this->tableName (image, name, description, brand, price, stock) VALUES (:image, :name, :description,:brand, :price, :stock)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'image' => $args['image'],
            'name' => $args['name'],
            'description' => $args['description'],
            'brand' => $args['brand'],
            'price' => $args['price'],
            'stock' => $args['stock'],

        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
    public function findProductsByIDs(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
        $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($ids);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createAndReturnId($args)
    {
        $sql = "INSERT INTO $this->tableName (image, name, description, brand, price, stock)
            VALUES (:image, :name, :description, :brand, :price, :stock)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'image' => $args['image'],
            'name' => $args['name'],
            'description' => $args['description'],
            'brand' => $args['brand'],
            'price' => $args['price'],
            'stock' => $args['stock'],
        ]);

        return $this->pdo->lastInsertId();
    }
    public function findPhonesBySpecsWithCount($specs, $limit = null, $offset = null)
    {
        $conditions = [];
        $params = [];

        if (isset($specs['screen_size'])) {
            $conditions[] = 'phones.screen_size >= :screen_size';
            $params['screen_size'] = $specs['screen_size'];
        }
        if (isset($specs['ram'])) {
            $conditions[] = 'phones.ram >= :ram';
            $params['ram'] = $specs['ram'];
        }
        if (isset($specs['storage'])) {
            $conditions[] = 'phones.storage >= :storage';
            $params['storage'] = $specs['storage'];
        }
        if (isset($specs['battery'])) {
            $conditions[] = 'phones.battery >= :battery';
            $params['battery'] = $specs['battery'];
        }
        if (!empty($specs['brand'])) {
            $conditions[] = 'products.brand = :brand';
            $params['brand'] = $specs['brand'];
        }
        if (!empty($specs['in_stock'])) {
            $conditions[] = 'products.stock > 0';
        }
        if (isset($specs['price'])) {
            $conditions[] = 'products.price <= :price';
            $params['price'] = $specs['price'];
        }

        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }

        $sql = "
        SELECT 
            products.*, 
            COUNT(*) OVER() AS total_count
        FROM phones
        INNER JOIN products ON phones.product_id = products.id
        $whereClause
    ";

        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }

        $statement = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $paramType = is_int($value) || is_float($value) ? PDO::PARAM_STR : PDO::PARAM_STR;
            if ($key === 'limit' || $key === 'offset') {
                $paramType = PDO::PARAM_INT;
            }
            $statement->bindValue(":$key", $value, $paramType);
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $totalCount = 0;
        if (!empty($results)) {
            $totalCount = $results[0]['total_count'];
            foreach ($results as &$row) {
                unset($row['total_count']);
            }
        }

        return [
            'products' => $results,
            'total' => $totalCount
        ];
    }
}

?>