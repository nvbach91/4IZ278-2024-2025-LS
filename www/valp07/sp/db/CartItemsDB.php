<?php require_once __DIR__ . '/Database.php'; ?>
<?php

class CartItemsDB extends Database
{
    protected $tableName = 'cart_items';
    public function deleteByUserAndProduct($userId, $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }
    public function findCartByID($product_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE product_id = :product_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['product_id' => $product_id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function findCartItemsByUserID($user_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function editCart($args)
    {
        $sql = "UPDATE $this->tableName SET user_id = :user_id, product_id = :product_id, quantity = :quantity WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $args['id'],
            'user_id' => $args['user_id'],
            'product_id' => $args['product_id'],
            'quantity' => $args['quantity'],
        ]);
    }
    public function findByUserAndProduct($user_id, $product_id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :user_id AND product_id = :product_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function create($args)
    {
        $sql = "INSERT INTO $this->tableName (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'user_id' => $args['user_id'],
            'product_id' => $args['product_id'],
            'quantity' => $args['quantity'],

        ]);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
    public function deleteByUser($user_id)
    {
        $sql = "DELETE FROM $this->tableName WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
    }
}

?>