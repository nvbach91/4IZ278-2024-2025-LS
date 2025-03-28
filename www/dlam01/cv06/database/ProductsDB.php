<?php require_once __DIR__ . '/Database.php'; ?>
<?php
class ProductsDB extends Database
{
    protected $tableName = 'cv06_products';

    public function fetchByCategory($category)
    {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = :category;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['category' => $category]);
        return $statement->fetchAll();
    }
}
?>