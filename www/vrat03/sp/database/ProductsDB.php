<?php require_once __DIR__.'/Database.php';?>
<?php

class ProductsDB extends Database {
    protected $tableName = 'sp_eshop_products';

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
        $sql .= " LIMIT ?, ?;"; // Ensure proper spacing before LIMIT
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
        $sql = "SELECT MIN(minplayers) AS minPlaytime FROM $this->tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetch()['minPlaytime'];
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

    public function updateProduct($id, $name, $price, $imgURL, $category) {
        $sql = "UPDATE eshop_products SET name = ?, price = ?, img = ?, category_id = ? WHERE product_id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$name, $price, $imgURL, $category, $id]);
    }

    public function addProduct($name, $price, $imgURL, $category) {
        $sql = "INSERT INTO eshop_products (name, price, img, category_id) VALUES (?, ?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        return $statement->execute([$name, $price, $imgURL, $category]);
    }
}
?>