<?php
require_once __DIR__ . '/db/DatabaseConnection.php';
require_once __DIR__ . '/db/ProductsDB.php';
require_once __DIR__ . '/db/UsersDB.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/db/PhonesDB.php';
session_start();
$productId = $_GET['id'];
$productsDB = new ProductsDB();
$connection = DatabaseConnection::getPDOConnection();
$usersDB = new UsersDB($connection);
$phonesDB = new PhonesDB($connection);
$product = $productsDB->findProductByID($productId);
$productDetails = $phonesDB->findPhoneByID($productId);
?>

<?php require 'incl/header.php'; ?>
<div class="container-fluid p-4">


    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="border p-3 h-100 d-flex justify-content-center align-items-center">
                <img src="<?php echo $product['image'] ?>" alt="Product Image" class="img-fluid">
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="border p-3 h-100">
                <h4>Descrition</h4>
                <p><?php echo $product['description'] ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="border p-3 h-100">
                <h5>Specifications</h5>
                <table class="table">
                    <tbody>
                        <?php foreach ($productDetails as $key => $value): ?>
                            <tr>
                                <th><?php echo htmlspecialchars($key); ?></th>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <button class="btn btn-success mt-3" onclick="window.location.href='buy.php?id=<?php echo $product['id']; ?>'">Add to Cart</button>
        </div>
    </div>

</div>
<?php require 'incl/footer.php'; ?>