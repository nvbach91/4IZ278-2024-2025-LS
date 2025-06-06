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
                <h2><?php echo htmlspecialchars($product['name']) ?></h2>
                <h4><?php echo htmlspecialchars($product['price']) ?> USD</h4>
                <h5>Available: <?php echo ($product['stock'] > 0) ? 'Yes' : 'No'; ?></h5>
                <h4>Description</h4>
                <p><?php echo htmlspecialchars($product['description']) ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="border p-3 h-100">
                <h5>Specifications</h5>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Brand</th>
                            <td><?php echo htmlspecialchars($product['brand']); ?></td>
                        </tr>
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

        <?php if (isset($_SESSION['id'])): ?>
            <div class="col-md-4 text-center">
                <button class="btn btn-success mt-3" onclick="window.location.href='buy.php?id=<?php echo $product['id']; ?>'">
                    Add to Cart
                </button>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php require 'incl/footer.php'; ?>
