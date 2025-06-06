<?php require_once __DIR__.'/Database.php';?>
<?php require_once __DIR__.'/UsersDB.php'; ?>
<?php



class OrdersDB extends Database {
    
    protected $tableName = 'sp_eshop_orders';
    protected $usersDB;

    public function __construct() {
        parent::__construct();
        $this->usersDB = new UsersDB();
    }
    

    public function createOrder($userId) {
        $usersTable = $this->usersDB->getTableName();
        $sql = "INSERT INTO $this->tableName (user_id, completed, address)
            VALUES (:user_id, 0, (SELECT address FROM {$usersTable} WHERE user_id = :user_id_addr));";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId, 'user_id_addr' => $userId]);
        return $this->connection->lastInsertId();
    }
    
    public function fetchAll($args = []) {
        $sql = "SELECT * FROM $this->tableName ORDER BY date DESC;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getOrderByOrderId($orderId) {
        $sql = "SELECT * FROM $this->tableName WHERE order_id = :order_id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['order_id' => $orderId]);
        return $statement->fetch();
    }
    
    public function getOrdersByUserId($userId) {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :user_id ORDER BY date DESC;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId]);
        return $statement->fetchAll();
    }

    public function getOrdersByStatus($status) {
        $sql = "SELECT * FROM $this->tableName WHERE completed = :status ORDER BY date DESC;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $status]);
        return $statement->fetchAll();
    }

    public function getOrdersByUserIdAndStatus($userId, $status) {
        $sql = "SELECT * FROM $this->tableName WHERE user_id = :user_id AND completed = :status ORDER BY date DESC;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId, 'status' => $status]);
        return $statement->fetchAll();
    }

    public function fetchPagination($offset, $limit) {
        $sql = "SELECT * FROM $this->tableName ORDER BY date DESC LIMIT :offset, :limit;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['offset' => $offset, 'limit' => $limit]);
        return $statement->fetchAll();
    }

    public function fetchPaginationWithStatus($offset, $limit, $status) {
        $sql = "SELECT * FROM $this->tableName WHERE completed = :status ORDER BY date DESC LIMIT :offset, :limit;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $status, 'offset' => $offset, 'limit' => $limit]);
        return $statement->fetchAll();
    }

    public function getUserByOrderId($orderId) {
        $usersTable = $this->usersDB->getTableName();
        $sql = "SELECT u.* FROM $this->tableName o 
            JOIN $usersTable u ON o.user_id = u.user_id WHERE o.order_id = :order_id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['order_id' => $orderId]);
        return $statement->fetch();
    }

    public function countOrdersWithStatus($status) {
        $sql = "SELECT COUNT(*) FROM $this->tableName WHERE completed = :status;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $status]);
        return $statement->fetchColumn();
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE $this->tableName SET completed = :status WHERE order_id = :order_id;";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['status' => $status, 'order_id' => $orderId]);
    }
}

?>