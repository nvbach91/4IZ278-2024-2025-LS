<?php

namespace Controllers;

require_once __DIR__ . '/../requireUser.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/UsersDB.php';
require_once __DIR__ . '/../db/OrdersDB.php';

use UsersDB;
use OrdersDB;
use DatabaseConnection;

class UserController
{
    public function profile()
    {
        $connection = DatabaseConnection::getPDOConnection();

        $userId = $_SESSION['id'];
        $usersDB = new UsersDB($connection);
        $ordersDB = new OrdersDB($connection);

        $user = $usersDB->getUserById($userId);
        $name = $user['name'];
        $email = $user['email'];
        $role = $user['role'];

        $orders = $ordersDB->findOrdersWithItemsByUserId($userId);
        $groupedOrders = [];

        foreach ($orders as $row) {
            $orderId = $row['order_id'];
            if (!isset($groupedOrders[$orderId])) {
                $groupedOrders[$orderId] = [
                    'order_id' => $orderId,
                    'created_at' => $row['created_at'],
                    'status' => $row['status'],
                    'items' => []
                ];
            }

            $groupedOrders[$orderId]['items'][] = [
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $row['quantity']
            ];
        }

        require __DIR__ . '/../views/profile.view.php';
    }
}
