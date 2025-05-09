<?php

require __DIR__ . "/incl/head.html";

require_once __DIR__ . "/utilities/auth.php";

require_once __DIR__ . "/Database/GoodsDB.php";


$goodsDB = new GoodsDB();

$itemsPerPage = 10;
$count = $goodsDB->getCount();

$numOfPages = ceil($count/$itemsPerPage);


if (isset($_SESSION['flash_message'])) {
    echo "<script>alert('" . addslashes($_SESSION['flash_message']) . "');</script>";
    unset($_SESSION['flash_message']);
}

?>
<div>
    <a href="create-item.php" class="button">Add a new product</a>

    <?php if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 3): ?>
        <a href="user-privileges.php" class="button">Manage User Privileges</a>
    <?php endif; ?>
</div>
<div class="pagination">
    <?php for($i = 0; $i < $numOfPages; $i++): 
        $offset = $i * $itemsPerPage;?>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?offset=<?php echo $offset; ?>"><?php echo $i+1; ?></a>
    <?php endfor; ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="row">
                <?php require __DIR__ . "/components/GoodsDisplay.php" ?>
            </div>
        </div>
    </div>
</div>

<?php

include __DIR__ . "/incl/foot.html";

?>