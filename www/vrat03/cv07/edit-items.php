<?php include __DIR__.'/includes/head.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php
session_start();
$productsDB = new ProductsDB();
$products = $productsDB->fetchAll([]);
?>



<div class="container">
    <div class="row">
    <a class="btn btn-primary" href="/add-item.php">Add item</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Název</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $item):?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_id']); ?></td>    
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']) . " Kč"; ?></td>
                        <td>
                            <a class="btn btn-primary" href="/edit-item.php?id=<?php echo $item['product_id']; ?>">Edit</a>
                            <a class="btn btn-danger" href="/delete-item.php?id=<?php echo $item['product_id']; ?>">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>