<?php require_once __DIR__ . '/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php require_once __DIR__.'/database/UsersDB.php'; ?>
<?php
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$productsDB = new ProductsDB();
$usersDB = new UsersDB();
$isCartSet = !empty($_SESSION['cart']);
if ($isCartSet) {
    $cartItems = $_SESSION['cart'];
}
$totalPrice = 0;
$user= isset($_SESSION['user']) ? $usersDB->fetchUserByID($_SESSION['user']['id']) : null;
?>

<?php include __DIR__.'/includes/head.php';?>

<div class="container">
    <div class="row">
        <div class="col">
        <?php if($isCartSet){?>
            <h2 class="my-4">Cart</h2>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item):
                        $DBitem = $productsDB->fetchProductByID($item['id']);
                        $totalPrice += $item['price'] * $item['quantity'];?>
                        <tr>
                            <td><?php echo htmlspecialchars($DBitem['name']) ?></td>
                            <td><?php echo htmlspecialchars($item['price'])." Kč" ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>    
            </table>
        <?php }else{ ?>
            <h2 class="my-4">Cart is empty</h2>
        <?php } ?>
        </div>
        <div class="col">
            <h2 class="my-4">User Information</h2>
            <?php if (isset($user)): ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?></p>
                <p><strong>Address:</strong> <?php echo isset($user['address']) ? htmlspecialchars($user['address']) :'' ; ?></p>
                <?php
                    $missing = empty($user['name']) || empty($user['email']) || empty($user['address']);
                    if ($missing):
                ?>
                    <div class="alert alert-warning mt-3">
                        Please complete your profile to finish the order.
                        <a href="<?php echo $urlPrefix ?>/account.php" class="btn btn-primary btn-sm ml-2">Edit Profile</a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo $urlPrefix ?>/account.php" class="btn btn-primary btn-sm ml-2">Edit Profile Info</a>        
                <?php endif; ?>
            <?php else: ?>
                <p>Please <a href="<?php echo $urlPrefix ?>/login.php">log in</a> to view your information.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12 text-end">
            <h3>Total: <?php echo $totalPrice; ?> Kč</h3>
            <?php
                $disabled = !$isCartSet || !isset($user) || $missing ? 'disabled' : '';
            ?>
            <form method="POST" action="<?php echo $urlPrefix ?>/buy.php">
                <?php $csrf->insertToken('buy'); ?>
                <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']?>">
                <button class="btn btn-success <?php echo $disabled; ?>" type="submit">
                    <span class="material-symbols-outlined align-middle">shop</span>    
                    Buy
                </button>
            </form>
        </div>
    </div> 
</div>

<?php include __DIR__.'/includes/foot.php';?>