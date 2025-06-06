<?php require_once __DIR__.'/Database.php';?>
<?php

class ProductCategoryDB extends Database {
    protected $tableName = 'sp_eshop_product_category';  

    public function fetchCategoriesByProductID($productId) {
        $sql = "SELECT category_id FROM $this->tableName WHERE product_id = :productId;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['productId' => $productId]);
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function removeAllCategoriesByProductID($productID) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = :productID;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['productID' => $productID]);
    }

    public function addCategoryToProductByProductID($productID, $categoryID) {;
        $checkSql = "SELECT COUNT(*) FROM $this->tableName WHERE product_id = :productID AND category_id = :categoryID;";
        $checkStmt = $this->connection->prepare($checkSql);
        $checkStmt->execute(['productID' => $productID, 'categoryID' => $categoryID]);
        $exists = $checkStmt->fetchColumn();

        if ($exists>0) {
            return null;
        }

        $sql = "INSERT INTO $this->tableName (product_id, category_id) VALUES (:productID, :categoryID);";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['productID' => $productID, 'categoryID' => $categoryID]);
    }
}

?>