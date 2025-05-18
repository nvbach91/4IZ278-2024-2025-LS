<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class ProductsDB extends Database
{
    protected $tableName = 'products';
    public function findProductByID($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function editProduct($args)
    {
        $sql = "UPDATE $this->tableName SET name = :name, description = :description, brand = : brand, price = :price, stock = :stock WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'name' => $args['name'],
            'description' => $args['description'],
            'brand' => $args['brand'],
            'price' => $args['price'],
            'stock' => $args['stock'],
        ]);
    }
    public function create($args)
    {
        $sql = "INSERT INTO $this->tableName (name, description, brand, price, stock) VALUES (:name, :description,:brand, :price, :stock)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
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
}

?>