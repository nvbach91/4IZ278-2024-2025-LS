<?php require_once __DIR__ . '/prefix.php'; ?>
<tr>
    <td>
        <img class="cart-img" src="<?php echo htmlspecialchars($DBitem['img_thumb']) ?>" alt="<?php echo htmlspecialchars($DBitem['name']) ?>" />
    </td>
    <td><?php echo htmlspecialchars($DBitem['name']) ?></td>
    <td><?php echo htmlspecialchars($item['price'])." Kč" ?></td>
    <td>
        <div class="row justify-content-center flex-nowrap">
            <div class="col">
                <form method="POST" action="<?php echo $urlPrefix ?>/edit-cart-item.php">
                    <input type="hidden" name="id" value=<?php echo $item['id']; ?>>
                    <input type="hidden" name="action" value="remove">
                    <button class="btn btn-primary" type="submit">-</button>
                </form>
            </div>
            <div class="col text-center">
                <?php echo htmlspecialchars($item['quantity']) ?>
            </div>
            <div class="col">
                <form method="POST" action="<?php echo $urlPrefix ?>/edit-cart-item.php">
                    <input type="hidden" name="id" value=<?php echo $item['id']; ?>>
                    <input type="hidden" name="action" value="add">
                    <button class="btn btn-primary" type="submit">+</button>
                </form>
            </div>
        </div>
    </td>
    <td>
        <form method="POST" action="<?php echo $urlPrefix ?>/edit-cart-item.php" onsubmit="return confirm('Are you sure you want to remove <?php echo htmlspecialchars($DBitem['name']); ?> from the cart?');">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <input type="hidden" name="action" value="delete">
            <button class="btn btn-primary d-flex align-items-center" type="submit">
                <span class="material-symbols-outlined">delete</span>
                Remove
            </button>
        </form>
    </td>
</tr>