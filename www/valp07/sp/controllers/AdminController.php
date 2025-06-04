<?php

namespace Controllers;

require_once __DIR__ . '/../requireAdmin.php';
require_once __DIR__ . '/../db/DatabaseConnection.php';
require_once __DIR__ . '/../db/ProductsDB.php';
require_once __DIR__ . '/../db/PhonesDB.php';

use ProductsDB;
use PhonesDB;
use DatabaseConnection;

class AdminController
{
    private $connection;
    private $productsDB;
    private $phonesDB;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getPDOConnection();
        $this->productsDB = new ProductsDB($this->connection);
        $this->phonesDB = new PhonesDB($this->connection);
    }

    public function getSpecsFilters(): array
    {
        $filters = [];
        $fields = ['screen_size', 'ram', 'storage', 'battery', 'brand', 'price', 'in_stock'];

        foreach ($fields as $field) {
            if (!empty($_GET[$field])) {
                $filters[$field] = $_GET[$field];
            }
        }

        return $filters;
    }
    public function showProduct()
    {
        $connection = \DatabaseConnection::getPDOConnection();
        $productsDB = new \ProductsDB($connection);
        $phonesDB = new \PhonesDB($connection);

        $productId = $_GET['id'] ?? null;
        if (!$productId) {
            http_response_code(400);
            exit('Product ID is required.');
        }

        $product = $productsDB->findProductByID($productId);
        $productDetails = $phonesDB->findPhoneByID($productId);

        require __DIR__ . '/../views/admin/product.view.php';
    }
    public function showProducts()
    {
        $itemsPerPage = 6;
        $pageNumber = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($pageNumber - 1) * $itemsPerPage;

        $products = [];
        $totalRecords = 0;

        if (isset($_GET['search_submit']) && !empty($_GET['search'])) {
            $search = trim($_GET['search']);
            $results = $this->productsDB->searchProducts($search, $itemsPerPage, $offset);
        } elseif (isset($_GET['filter_submit'])) {
            $specs = [];
            foreach (['screen_size', 'ram', 'storage', 'battery', 'brand', 'price'] as $key) {
                if (!empty($_GET[$key])) {
                    $specs[$key] = is_numeric($_GET[$key]) ? +$_GET[$key] : $_GET[$key];
                }
            }
            if (!empty($_GET['in_stock'])) {
                $specs['in_stock'] = true;
            }

            $results = $this->productsDB->findPhonesBySpecsWithCount($specs, $itemsPerPage, $offset);
        } else {
            $results = $this->productsDB->getAllPaginated($itemsPerPage, $offset);
        }

        $products = $results['products'];
        $totalRecords = $results['total'];
        $totalPages = ceil($totalRecords / $itemsPerPage);

        require __DIR__ . '/../views/admin/products.view.php';
    }



    public function createProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = array_intersect_key($_POST, array_flip(['image', 'name', 'description', 'brand', 'price', 'stock']));
            $productId = $this->productsDB->createAndReturnId($productData);

            $specs = $_POST['specs'];
            $this->phonesDB->createPhone(array_merge(['product_id' => $productId], $specs));

            header("Location: ./product.php?id=$productId");
            exit;
        }

        $product = [
            'name' => 'Mock Phone',
            'price' => '499.99',
            'stock' => '20',
            'description' => 'This is a mock phone used for testing UI.',
            'brand' => 'MockBrand',
            'image' => '/images/mock-image.jpg'
        ];

        $productDetails = [
            'screen_size' => '6.5',
            'ram' => '8',
            'storage' => '128',
            'battery' => '4500'
        ];

        require __DIR__ . '/../views/admin/create-product.view.php';
    }

    public function manageOrders()
    {
        require_once __DIR__ . '/../requireAdmin.php';
        require_once __DIR__ . '/../db/DatabaseConnection.php';
        require_once __DIR__ . '/../db/OrdersDB.php';
        require_once __DIR__ . '/../db/UsersDB.php';
        require_once __DIR__ . '/../db/OrderItemsDB.php';

        $connection = \DatabaseConnection::getPDOConnection();
        $ordersDB = new \OrdersDB($connection);
        $orderItemsDB = new \OrderItemsDB($connection);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_item_id'])) {
                $orderItemsDB->delete($_POST['delete_item_id']);
                header("Location: orders.php");
                exit;
            }

            if (isset($_POST['order_id'], $_POST['status'])) {
                $ordersDB->editOrder($_POST['order_id'], $_POST['status']);
                header("Location: orders.php");
                exit;
            }
        }

        $orders = $ordersDB->findAll();
        $groupedOrders = [];
        $searchTerm = $_GET['search'] ?? '';

        if (!empty($searchTerm)) {
            $searchTerm = strtolower(trim($searchTerm));
            $orders = array_filter($orders, function ($order) use ($searchTerm) {
                return str_contains(strtolower($order['user_email']), $searchTerm)
                    || str_contains((string) $order['order_id'], $searchTerm);
            });
        }

        foreach ($orders as $row) {
            $id = $row['order_id'];
            if (!isset($groupedOrders[$id])) {
                $groupedOrders[$id] = [
                    'order_id' => $id,
                    'created_at' => $row['created_at'],
                    'status' => $row['status'],
                    'user_email' => $row['user_email'],
                    'payment_method' => $row['payment_method'],
                    'shipping_address' => $row['shipping_address'],
                    'items' => []
                ];
            }

            $groupedOrders[$id]['items'][] = [
                'item_id' => $row['item_id'],
                'product_name' => $row['product_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price']
            ];
        }

        require __DIR__ . '/../views/admin/orders.view.php';
    }
    public function manageUsers()
    {
        require_once __DIR__ . '/../db/DatabaseConnection.php';
        require_once __DIR__ . '/../db/UsersDB.php';

        $connection = \DatabaseConnection::getPDOConnection();
        $usersDB = new \UsersDB($connection);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_user_id'])) {
                $usersDB->delete($_POST['delete_user_id']);
                header("Location: users.php");
                exit;
            }

            if (isset($_POST['reset_user_id'])) {
                $usersDB->resetPassword($_POST['reset_user_id']);
                header("Location: users.php");
                exit;
            }

            if (isset($_POST['role_user_id'], $_POST['role'])) {
                $usersDB->changeRole($_POST['role_user_id'], $_POST['role']);
                header("Location: users.php");
                exit;
            }
        }
        $users = $usersDB->findAll();
        if (!empty($_GET['search'])) {
            $searchTerm = strtolower(trim($_GET['search']));
            $users = array_filter($users, function ($user) use ($searchTerm) {
                return str_contains(strtolower($user['name']), $searchTerm) ||
                    str_contains(strtolower($user['email']), $searchTerm);
            });
        }
        require __DIR__ . '/../views/admin/users.view.php';
    }
    public function deleteProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = (int)$_POST['product_id'];

            try {
                if ($this->productsDB->hasOrders($productId)) {
                    echo "Cannot delete this product because it has already been ordered.";
                    exit();
                }

                $this->connection->beginTransaction();

                $this->productsDB->deleteFromCart($productId);
                $this->phonesDB->deletePhone($productId);
                $this->productsDB->deleteProductOnly($productId);

                $this->connection->commit();

                header('Location: products.php');
                exit();
            } catch (\PDOException $e) {
                $this->connection->rollBack();
                echo "Failed to delete product: " . $e->getMessage();
            }
        } else {
            http_response_code(400);
            echo "Invalid request.";
        }
    }
}
