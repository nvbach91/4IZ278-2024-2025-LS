<?php require_once __DIR__.'/database/ProductsDB.php';?>

<?php
$productsDB = new ProductsDB();
$isSelectedCategory = !empty($_GET['category_id']);
$isSelectedPage = !empty($_GET['page']);

$numberOfItemsPerPage=9;
$numberOfRecords=$isSelectedCategory?
    $productsDB->countRecordsWithID($_GET['category_id'])
    :$productsDB->countRecords([]);

$numberOfPages=ceil($numberOfRecords/$numberOfItemsPerPage);
$remainingOnTheLastPage=$numberOfRecords%$numberOfItemsPerPage;

$pageNumber=$isSelectedPage ? $_GET['page'] : 1;
$offset=($pageNumber-1)*$numberOfItemsPerPage;

$productsWithPageOffset = 
    $isSelectedCategory ? 
    $productsDB->fetchByCategoryIDWithOffset($_GET['category_id'], $offset, $numberOfItemsPerPage) :
    $productsDB->fetchWithOffset($offset, $numberOfItemsPerPage);
?>

<?php include __DIR__.'/includes/head.php'; ?>
<!-- Page Content-->
<div class="container">
    <div class="row">
        
        <?php include __DIR__.'/includes/CategoryDisplay.php'; ?>  
        <div class="col-lg-9">
            <?php include __DIR__.'/includes/SlideDisplay.php'; ?>
            <?php include __DIR__.'/includes/ProductDisplay.php'; ?>
        </div>
    </div>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>