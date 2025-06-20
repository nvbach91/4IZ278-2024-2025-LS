<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php require_once __DIR__.'/database/CategoriesDB.php'; ?>
<?php
if(!isset($_SESSION)) { 
        session_start();
}
$productsDB = new ProductsDB();
$categoriesDB = new CategoriesDB();

$categories = $categoriesDB->fetchAll([]);

//products
$minPlaytime = $productsDB->minPlaytime();
$maxPlaytime = $productsDB->maxPlaytime();
$minPlayers = $productsDB->minPlayers();
$maxMinPlayers = $productsDB->maxMinPlayers();
$maxPlayers = $productsDB->maxPlayers();

//webpage
$categoriesWeb = $_GET['category'] ?? ["0"];
$maxPlaytimeWeb = $_GET['max-playtime'] ?? $maxPlaytime;
$minPlayersWeb = $_GET['min-players'] ?? $minPlayers;
$maxPlayersWeb = $_GET['max-players'] ?? $maxPlayers;

//pagination
$isSelectedPage = !empty($_GET['page']);
$numberOfItemsPerPage=12;
$numberOfRecords=$productsDB->countRecordsWithAllParams($categoriesWeb, $maxPlaytimeWeb, $minPlayersWeb, $maxPlayersWeb);
$numberOfPages=ceil($numberOfRecords/$numberOfItemsPerPage);
$remainingOnTheLastPage=$numberOfRecords%$numberOfItemsPerPage;
$webPageNumber=$isSelectedPage ? $_GET['page'] : 1;
$pageNumber = $webPageNumber > $numberOfPages ? 1 : $webPageNumber;
$offset=($pageNumber-1)*$numberOfItemsPerPage;
$productsWithPageOffset = $productsDB->fetchWithAllParams($offset, $numberOfItemsPerPage, $categoriesWeb, $maxPlaytimeWeb, $minPlayersWeb, $maxPlayersWeb);
?>


<?php include __DIR__.'/includes/head.php';?> 
<div class="container">
    <h1 class="my-4">Welcome!</h1>
    <div class="row">
        <div class="col-lg-3">
            <?php include __DIR__.'/index-filter.php'; ?>
        </div>
        <div class="col-lg-9">
            <div class="row" id="products">
                <?php include __DIR__.'/index-products.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/includes/foot.php';?>
<script src="js/dropdown.js"></script>