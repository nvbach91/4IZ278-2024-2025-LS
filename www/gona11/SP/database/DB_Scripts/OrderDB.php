<?php require_once __DIR__ . "/../Database.php"?>
<?php 

class OrderDB extends Database {
    protected $tableName = "`order`";

    public function createOrder(
        $userId, 
        $shippingMethodId,
        $shippingMethodPrice,
        $paymentMethodId,
        $paymentMethodPrice,
        $billingAdress,
        $totalPrice
    ) {
        $sql = "INSERT INTO {$this->tableName} (
                    user,
                    status,
                    created_at,
                    shipping_method,
                    shipping_price,
                    payment_method,
                    payment_price,
                    billing_address,
                    total_price) 
                VALUES (
                    :userId,
                    :status,
                    :created_at,
                    :shippingMethodId,
                    :shippingMethodPrice,
                    :paymentMethodId,
                    :paymentMethodPrice,
                    :billingAddress,
                    :totalPrice)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":userId" => $userId,
            ":status" => 1,
            ":created_at" => date("Y-m-d H:i:s"),
            ":shippingMethodId" => $shippingMethodId,
            ":shippingMethodPrice" => $shippingMethodPrice,
            ":paymentMethodId" => $paymentMethodId,
            ":paymentMethodPrice" => $paymentMethodPrice,
            ":billingAddress" => $billingAdress,
            ":totalPrice" => $totalPrice
        ]);
        return $this->connection->lastInsertId();
    }

    public function getOrderById($id_order) {
        $sql = "SELECT * FROM {$this->tableName} WHERE id_order = :id_order";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":id_order" => $id_order]);
        return $statement->fetchALl();
    }

    public function getOrdersByUserId($userId) {
        $sql = "SELECT * FROM {$this->tableName} WHERE user = :userId";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":userId" => $userId]);
        return $statement->fetchAll();
    }

    public function updateOrderStatus($id_order, $status) {
        $sql = "UPDATE {$this->tableName} SET status = :status WHERE id_order = :id_order";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            ":status" => $status,
            ":id_order" => $id_order
        ]);
    }

    public function getAllOrders() {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY created_at DESC";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getOrderStatus($id_order) {
        $sql = "SELECT status FROM {$this->tableName} WHERE id_order = :id_order";
        $statement = $this->connection->prepare($sql);
        $statement->execute([":id_order" => $id_order]);
        return $statement->fetchColumn();
    }
}