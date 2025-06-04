<?php require __DIR__ . '/../incl/header.php'; ?>
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
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <input
                                        name="quantity"
                                        type="number"
                                        class="form-control text-center mx-2"
                                        value="<?php echo $cartItem['quantity']; ?>"
                                        style="width: 60px;"
                                        min="1"
                                        required />
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Update Quantity</button>
                            </form>

                            <p><?php echo number_format($cartItem['price'], 2), ' ', GLOBAL_CURRENCY; ?></p>
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
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter delivery address" required>
                        </div>


                        <?php
                        $total = 0;
                        foreach ($cartItems as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        ?>

                        <div class="border p-3">
                            <label class="form-label">Final Price</label>
                            <div id="finalPrice" class="fw-bold">
                                $<?php echo number_format($total, 2); ?>
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