<?php require_once __DIR__ . '/database/ProductDB.php'; 
$productDB = new ProductDB();

$noItemsPerPage = 5;
$noRecords = $productDB->count();
$noPages = ceil($noRecords / $noItemsPerPage);

$pageNum = isset($_GET['page']) ? $_GET['page'] : 1;


?>


<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>

        
        <!-- Page Content-->
        <div class="container">
       
            <div class="row">
                <div class="col-lg-3">
                    <h1 class="my-4">Shop Name</h1>
                    <?php include __DIR__ . "/components/categoryDisplay.php"; ?>
                </div>
                <div class="col-lg-9">
              
                    <?php include __DIR__ . "/components/carouselDisplay.php" ;?>
                    <br>
                     <a class="btn btn-primary" href="insert.php">Add new item</a>
                     <br><br>
                 <div class="row">    
                    <?php require __DIR__ . "/components/itemDisplay.php"; ?>
                </div>
                 <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-center">
                            <?php for ($i = 1; $i <= $noPages; $i++) { 
                                if ($pageNum == $i) {?>
                                 <li class="page-item active" aria-current="page"><span class="page-link"><?php echo $i; ?></span></li>
                            <?php } else { ?>
        <li class="page-item" aria-current="page"><a class="page-link" href="./index.php?page=<?php echo $i; ?>">
            <?php echo $i; ?>
        </a></li>
    <?php }} ?>
                        </ul>
                    </nav>
            </div>
       </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
       