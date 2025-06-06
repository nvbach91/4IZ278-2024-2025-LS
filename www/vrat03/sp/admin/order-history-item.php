<?php include __DIR__.'/../prefix.php'; ?>
<?php $itemDB=$productsDB->fetchProductByID($item['product_id'])?>
<tr>
    <td>
        <a href="<?php echo $urlPrefix ?>/product.php?id=<?php echo urlencode($itemDB['product_id']); ?>">
            <?php echo htmlspecialchars($itemDB['name']); ?>
        </a>
    </td>
    <td><?php echo(htmlspecialchars($item['quantity'])) ?></td>
    <td><?php echo($item['price'] * $item['quantity']) ?> Kč</td>
</tr>