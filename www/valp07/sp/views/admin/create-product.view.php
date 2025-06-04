<?php require __DIR__ . '/../../incl/header.php'; ?>

<div class="container-fluid p-4">
    <form action="" method="POST">
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="border p-3 h-100 d-flex justify-content-center align-items-center">
                    <img src="<?php echo $product['image']; ?>" alt="Product Image" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="border p-3 h-100">
                    <h2><textarea name="name" class="form-control" rows="2"><?php echo htmlspecialchars($product['name']); ?></textarea></h2>
                    <h4><textarea name="price" class="form-control" rows="1"><?php echo htmlspecialchars($product['price']); ?></textarea></h4>
                    <h5><textarea name="stock" class="form-control" rows="1"><?php echo htmlspecialchars($product['stock']); ?></textarea></h5>
                    <textarea name="image" class="form-control" rows="5"><?php echo htmlspecialchars($product['image']); ?></textarea>
                    <h4>Description</h4>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
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
                                <td><input type="text" class="form-control" name="brand" value="<?php echo htmlspecialchars($product['brand']); ?>"></td>
                            </tr>
                            <?php foreach ($productDetails as $key => $value): ?>
                                <tr>
                                    <th><?php echo htmlspecialchars(ucfirst($key)); ?></th>
                                    <td>
                                        <input type="text" class="form-control" name="specs[<?php echo htmlspecialchars($key); ?>]" value="<?php echo htmlspecialchars($value); ?>">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4 text-center">
                <button type="submit" class="btn btn-primary mt-3">Save</button>
            </div>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../../incl/footer.php'; ?>
