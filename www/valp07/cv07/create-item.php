<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($name && $price !== false && $description) {
        $sql = "INSERT INTO cv07_goods (name, price, description) VALUES (:name, :price, :description)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'description' => $description
        ]);

        header('Location: index.php');
        exit();
    }
}
?>

<?php require 'incl/header.php'; ?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="my-4">Create New Item</h1>
            
            <form method="POST" action="create-item.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">Create Item</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require 'incl/footer.php'; ?>