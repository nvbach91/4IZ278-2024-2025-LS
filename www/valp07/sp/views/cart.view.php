<?php require __DIR__ . '/../incl/header.php'; ?>
<?php
$overallTotal = 0;
foreach ($cartItems as $cartItem) {
    $itemTotal = $cartItem['price'] * $cartItem['quantity'];
    $overallTotal += $itemTotal;
}
?>
<div class="container my-4">
    <div class="row">

        <div class="col-md-6">
            <div class="row g-3">

                <?php foreach ($cartItems as $cartItem): ?>
                    <div class="col-md-4">
                        <div class="border p-2 text-center">
                            <img src="<?php echo $cartItem['image'] ?>" class="img-fluid" alt="<?php echo $cartItem['name']; ?>">
                            <h5 class="mt-2"><?php echo $cartItem['name']; ?></h5>

                            <form method="post" action="buy.php?id=<?php echo $cartItem['id']; ?>">
                                <input type="hidden" name="source" value="cart">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <input
                                        name="quantity"
                                        type="number"
                                        class="form-control text-center mx-2"
                                        value="<?php echo (int) $cartItem['quantity']; ?>"
                                        style="width: 60px;"
                                        min="1"
                                        required />
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Update Quantity</button>
                            </form>


                            <p><?php echo number_format($cartItem['price'], 2), ' ', GLOBAL_CURRENCY; ?></p>
                            <p><strong>Total:</strong> <?php echo number_format($cartItem['price'] * $cartItem['quantity'], 2), ' ', GLOBAL_CURRENCY; ?></p>
                            <form method="post" action="remove.php?id=<?php echo $cartItem['id']; ?>" onsubmit="return confirm('Remove this item from cart?');">
                                <button type="submit" class="btn btn-sm btn-danger mt-2">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="col-md-6">
            <div class="container my-4">
                <form method="POST" action="create-order.php">
    <div class="d-grid gap-3">
        <div class="border p-3">
            <label class="form-label">Payment Method</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="paymentCash" value="cash" required>
                <label class="form-check-label" for="paymentCash">Cash</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="paymentCard" value="card">
                <label class="form-check-label" for="paymentCard">Card</label>
            </div>
        </div>

        <div class="border p-3">
            <h5>Shipping Address</h5>

            <div class="mb-3">
                <label for="address1" class="form-label">Address Line 1</label>
                <input type="text" class="form-control" id="address1" name="address1"
                    value="<?php echo htmlspecialchars($savedAddress['address1'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="address2" class="form-label">Address Line 2</label>
                <input type="text" class="form-control" id="address2" name="address2"
                    value="<?php echo htmlspecialchars($savedAddress['address2'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="address3" class="form-label">Address Line 3</label>
                <input type="text" class="form-control" id="address3" name="address3"
                    value="<?php echo htmlspecialchars($savedAddress['address3'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city"
                    value="<?php echo htmlspecialchars($savedAddress['city'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state"
                    value="<?php echo htmlspecialchars($savedAddress['state'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="county" class="form-label">County</label>
                <input type="text" class="form-control" id="county" name="county"
                    value="<?php echo htmlspecialchars($savedAddress['county'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code"
                    value="<?php echo htmlspecialchars($savedAddress['postal_code'] ?? ''); ?>" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="saveAddress" name="save_address">
                <label class="form-check-label" for="saveAddress">
                    Save this address to my profile for future orders
                </label>
            </div>
        </div>

        <div class="border p-3">
            <label class="form-label">Final Price</label>
            <div id="finalPrice" class="fw-bold">
                <p class="fw-bold">Total: <?php echo number_format($overallTotal, 2), ' ', GLOBAL_CURRENCY; ?></p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
    </div>
</form>

            </div>
        </div>

    </div>
</div>
<?php require __DIR__ . '/../incl/footer.php'; ?>