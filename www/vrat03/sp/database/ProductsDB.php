<?php require_once __DIR__.'/Database.php';?>
<?php require_once __DIR__.'/CategoriesDB.php';?>
<?php

class ProductsDB extends Database {
    protected $tableName = 'sp_eshop_products';

    public function getTableName() {
        return $this->tableName;
    }

    public function fetchWithAllParams($offset, $numberOfItemsPerPage, $categories, $maxPlaytime, $minPlayers, $maxPlayers) {
        $params = [];
        $where = [];
        if (!in_array("0", $categories)) {
            $placeholders = implode(',', array_fill(0, count($categories), '?'));
            $join=  "JOIN sp_eshop_product_category ON $this->tableName.product_id = sp_eshop_product_category.product_id
                    JOIN sp_eshop_categories ON sp_eshop_product_category.category_id = sp_eshop_categories.category_id";
            $where[] = "sp_eshop_product_category.category_id IN ($placeholders)";
            $params = array_merge($params, $categories);
        }
        $where[] = 'playtime <= ?';
        $where[] = 'minplayers >= ?';
        $where[] = 'maxplayers <= ?';
        $sql = "SELECT DISTINCT $this->tableName.* FROM $this->tableName";
        if (isset($join)) {
            $sql .= " $join";
        }
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $sql .= " LIMIT ?, ?;";
        $statement = $this->connection->prepare($sql);
        $params = array_merge($params, [$maxPlaytime, $minPlayers, $maxPlayers, $offset, $numberOfItemsPerPage]);
        $statement->execute($params);
        return $statement->fetchAll();
    }

    public function fetchProductByID($id) {
        $sql = "SELECT * FROM $this->tableName WHERE product_id = :id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }
    
    public function maxPlaytime() {
        $sql = "SELECT MAX(playtime) AS maxPlaytime FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['maxPlaytime'];
    }

    public function minPlaytime() {
        $sql = "SELECT MIN(playtime) AS minPlaytime FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['minPlaytime'];
    }

    public function minPlayers() {
        $sql = "SELECT MIN(minplayers) AS minPlayers FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['minPlayers'];
    }

    public function maxMinPlayers() {
        $sql = "SELECT MAX(minplayers) AS maxMinPlayers FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['maxMinPlayers'];
    }
    
    public function maxPlayers() {
        $sql = "SELECT MAX(maxplayers) AS maxPlayers FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['maxPlayers'];
    }

    public function countRecordsWithAllParams($categories, $maxPlaytimeWeb, $minPlayersWeb, $maxPlayersWeb) {
        $params = [];
        $where = [];
        if (!in_array('0', $categories)) {
            $placeholders = implode(',', array_fill(0, count($categories), '?'));
            $join=  "JOIN sp_eshop_product_category ON $this->tableName.product_id = sp_eshop_product_category.product_id
                    JOIN sp_eshop_categories ON sp_eshop_product_category.category_id = sp_eshop_categories.category_id";
            $where[] = "sp_eshop_product_category.category_id IN ($placeholders)";
            $params = array_merge($params, $categories);
        }
        $where[] = 'playtime <= ?';
        $where[] = 'minplayers >= ?';
        $where[] = 'maxplayers <= ?';
        $sql = "SELECT COUNT(DISTINCT $this->tableName.product_id) AS numberOfRecords FROM $this->tableName";
        if (isset($join)) {
            $sql .= " $join";
        }
        $sql .= " WHERE " . implode(' AND ', $where);
        $statement = $this->connection->prepare($sql);
        $params = array_merge($params, [$maxPlaytimeWeb, $minPlayersWeb, $maxPlayersWeb]);
        $statement->execute($params);
        return $statement->fetch()['numberOfRecords'];
    }

    //product manipulation
    public function deleteProduct($id) {
        $sql = "DELETE FROM $this->tableName WHERE product_id = :id;";
        $statement = $this->connection->prepare($sql);
        return $statement->execute(['id' => $id]);
    }

    public function updateProduct($id, $name, $price, $img, $img_thumb, $quantity, $description, $minplayers, $maxplayers, $playtime) {
        $sql = "UPDATE sp_eshop_products SET name = ?, price = ?, img = ?, img_thumb = ?, quantity = ?, 
            description = ?, minplayers = ?, maxplayers = ?, playtime = ?, last_updated = NOW() WHERE product_id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$name, $price, $img, $img_thumb, $quantity, $description, $minplayers, $maxplayers, $playtime, $id]);
    }

    public function updateProductQuantity($id, $quantity) {
        $sql = "UPDATE sp_eshop_products SET quantity = ? WHERE product_id = ?";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([$quantity, $id]);
    }

    public function addProduct($name, $price, $img, $img_thumb, $quantity, $description, $minplayers, $maxplayers, $playtime) {
        $sql = "INSERT INTO sp_eshop_products 
            (name, price, img, img_thumb, quantity, description, minplayers, maxplayers, playtime) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$name, $price, $img, $img_thumb, $quantity, $description, $minplayers, $maxplayers, $playtime]);
        return $this->connection->lastInsertId();
    }

    public function fetchCategoriesByProductID($productID) {
        $sql = "SELECT sp_eshop_categories.* FROM sp_eshop_product_category
                JOIN sp_eshop_categories ON sp_eshop_product_category.category_id = sp_eshop_categories.category_id
                WHERE sp_eshop_product_category.product_id = :productID;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['productID' => $productID]);
        return $statement->fetchAll();
    }

    public function fetchProductsByCategoryIDs($categoryIDs, $limit, $excludeProductID) {
        $placeholders = implode(',', array_fill(0, count($categoryIDs), '?'));
        $sql = "SELECT * FROM $this->tableName
                JOIN sp_eshop_product_category ON $this->tableName.product_id = sp_eshop_product_category.product_id
                WHERE sp_eshop_product_category.category_id IN ($placeholders)
                AND $this->tableName.product_id != ?
                ORDER BY RAND()
                LIMIT ?;";
        $statement = $this->connection->prepare($sql);
        $params = array_merge($categoryIDs, [$excludeProductID, $limit]);
        $statement->execute($params);
        return $statement->fetchAll();
    }
}
?>