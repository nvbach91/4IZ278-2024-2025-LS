<?php
require 'db/DatabaseConnection.php';
require 'db/ProductsDB.php';
session_start();

$connection = DatabaseConnection::getPDOConnection();


$good_id = filter_input(INPUT_GET, 'good_id', FILTER_VALIDATE_INT);
if (!$good_id) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8');

    if ($name && $price !== false && $description) {
        $sql = "UPDATE cv07_goods SET name = :name, price = :price, description = :description WHERE good_id = :good_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'good_id' => $good_id
        ]);
        
        header('Location: index.php');
        exit();
    }
}

$sql = "SELECT * FROM cv07_goods WHERE good_id = :good_id";
$stmt = $connection->prepare($sql);
$stmt->execute(['good_id' => $good_id]);
$item = $stmt->fetch();

if (!$item) {
    header('Location: index.php');
    exit();
}
?>

<?php require 'incl/header.php'; ?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="my-4">Edit Item</h1>
            
            <form method="POST" action="edit-item.php?good_id=<?php echo $good_id; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require 'incl/footer.php'; ?>
