<?php require_once __DIR__.'/Database.php';?>
<?php

class ProductsDB extends Database {
    protected $tableName = 'eshop_products';

    public function fetchByCategoryID($category_id) {
        $sql="SELECT * FROM $this->tableName WHERE category_id = :category_id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$category_id]);
        return $statement->fetchAll();
    }

    public function fetchWithOffset($offset, $numberOfItemsPerPage) {
        $sql = "SELECT * FROM $this->tableName LIMIT :offset, :numberOfItemsPerPage;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['offset' => $offset, 'numberOfItemsPerPage' => $numberOfItemsPerPage]);
        return $statement->fetchAll();
    }

    public function fetchProductByID($id) {
        $sql = "SELECT * FROM $this->tableName WHERE product_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function fetchByCategoryIDWithOffset($category_id, $offset, $numberOfItemsPerPage) {
        $sql = "SELECT * FROM $this->tableName WHERE category_id = :category_id LIMIT :offset, :numberOfItemsPerPage";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['category_id' => $category_id, 'offset' => $offset, 'numberOfItemsPerPage' => $numberOfItemsPerPage]);
        return $statement->fetchAll();
    }

    public function fetchCheapest($numberOfProducts) {
        $sql = "SELECT * FROM $this->tableName ORDER BY price ASC LIMIT ?;";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$numberOfProducts]);
        return $statement->fetchAll();
    }

    public function countRecordsWithID($category_id){
        $sql="SELECT COUNT(*) AS numberOfRecords FROM $this->tableName WHERE category_id = :category_id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['category_id' => $category_id]);
        return $statement->fetchAll()[0]['numberOfRecords'];
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['id' => $id]);
    }

    public function updateProduct($id, $name, $price, $imgURL, $category) {
        $sql = "UPDATE eshop_products SET name = ?, price = ?, img = ?, category_id = ? WHERE product_id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$this->tableName, $name, $price, $imgURL, $category, $id]);
    }

    public function addProduct($name, $price, $imgURL, $category) {
        $sql = "INSERT INTO eshop_products (name, price, img, category_id) VALUES (?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([$name, $price, $imgURL, $category]);
    }
}
?>