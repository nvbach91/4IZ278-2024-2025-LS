<?php require __DIR__ . '/../../incl/header.php'; ?>
<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
<div class="container-fluid p-4">
    <form action="saveProduct.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="border p-3 h-100 d-flex justify-content-center align-items-center">
                    <img src="<?php echo $product['image'] ?>" alt="Product Image" class="img-fluid">
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="border p-3 h-100">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <textarea name="name" id="name" class="form-control" rows="2"><?php echo htmlspecialchars($product['name']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <textarea name="price" id="price" class="form-control" rows="1"><?php echo htmlspecialchars($product['price']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <textarea name="stock" id="stock" class="form-control" rows="1"><?php echo htmlspecialchars($product['stock']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL</label>
                        <textarea name="image" id="image" class="form-control" rows="2"><?php echo htmlspecialchars($product['image']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
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
                                <th><label for="brand" class="form-label mb-0">Brand</label></th>
                                <td>
                                    <input type="text" class="form-control" name="brand" id="brand" value="<?php echo htmlspecialchars($product['brand']); ?>">
                                </td>
                            </tr>
                            <?php foreach ($productDetails as $key => $value): ?>
                                <tr>
                                    <th><label for="spec-<?php echo htmlspecialchars($key); ?>" class="form-label mb-0"><?php echo htmlspecialchars(ucfirst($key)); ?></label></th>
                                    <td>
                                        <input type="text" class="form-control" id="spec-<?php echo htmlspecialchars($key); ?>" name="specs[<?php echo htmlspecialchars($key); ?>]" value="<?php echo htmlspecialchars($value); ?>">
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