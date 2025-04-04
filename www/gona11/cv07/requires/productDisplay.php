<?php require_once __DIR__ . '/../database/ProductsDB.php'?>
<?php 
    session_start();
    if(isset($_SESSION["addItemSuccess"])) {
        $addItemSuccess = $_SESSION["addItemSuccess"];
        unset($_SESSION["addItemSuccess"]);
    }

    if(isset($_SESSION["loginSuccess"])) {
        $loginSuccess = $_SESSION["loginSuccess"];
        unset($_SESSION["loginSuccess"]);
    }

    if(isset($_SESSION["logoutSuccess"])) {
        $logoutSuccess = $_SESSION["logoutSuccess"];
        unset($_SESSION["logoutSuccess"]);
    }

    if(isset($_SESSION["deleteItemSuccess"])) {
        $deleteItemSuccess = $_SESSION["deleteItemSuccess"];
        unset($_SESSION["deleteItemSuccess"]);
    }

    $productDB = new ProductsDB();
    $numberPerPage = 10;
    $numberOfRecords = $productDB->countRecords();
    $numberOfPages = ceil($numberOfRecords / $numberPerPage);
    $remainingItemsOnLastPAge = $numberOfRecords % $numberPerPage;
    $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = $numberPerPage * ($pageNumber -1);
    $products = $productDB->getPageCountProducts($numberPerPage, $offset);
?>

<div class="container">
    <?php if(isset($addItemSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $addItemSuccess;?></div>
    <?php endif; ?>
    <?php if(isset($loginSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $loginSuccess;?></div>
    <?php endif; ?>
    <?php if(isset($logoutSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $logoutSuccess;?></div>
    <?php endif; ?>
    <?php if(isset($deleteItemSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $deleteItemSuccess;?></div>
    <?php endif; ?>
    <div class="row">
        <div class="mt-3 ml-3">
            <p>Select page to display</p>
            <div>
                <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
                    <a class="btn btn-secondary mb-3" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row mt-4">
                <?php foreach($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <a href="#!"><img class="card-img-top" src="<?php echo $product['img'];?>" alt="Image of product not avalible" /></a>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $product['name'];?></h4>
                            <h5><?php echo $product['price'];?> Czk</h5>
                            <p class="card-text"><?php echo $product['description'];?></p>
                        </div>
                        <div class="d-flex justify-content-center m-2">
                            <a href="./buy.php?good_id=<?php echo $product['good_id']; ?>" class="btn buy_button btn-primary m-1">Buy now!</a>
                            <a href="./delete-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn buy_button btn-danger m-1">Delete</a>
                        </div>
                        
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
