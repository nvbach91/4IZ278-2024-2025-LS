<?php

require __DIR__ . "/incl/head.php";

require_once __DIR__ . "/Database/GoodsDB.php";


$goodsDB = new GoodsDB();

$itemsPerPage = 10;
$count = $goodsDB->getCount();

$numOfPages = ceil($count/$itemsPerPage);




?>
<div>
    <a href="create-item.php" class="button">Add a new product</a>
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