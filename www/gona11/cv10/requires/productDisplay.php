<?php require_once __DIR__ . '/../database/ProductsDB.php'?>
<?php 
$loggedIn = false;
$privilege = 0;
if (isset($_COOKIE['loginSuccess'])) {
    $loggedIn = true;
}


?>
<?php 
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

    if(isset($_SESSION["editItemSuccess"])) {
        $editItemSuccess = $_SESSION["editItemSuccess"];
        unset($_SESSION["editItemSuccess"]);
    }
    if(isset($_SESSION["editPrivilegeSuccess"])) {
        $editPrivilegeSuccess = $_SESSION["editPrivilegeSuccess"];
        unset($_SESSION["editPrivilegeSuccess"]);
    }
    if($loggedIn && isset($_SESSION["privilege"])) {
        $privilege = $_SESSION["privilege"];
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
    <?php if(isset($editItemSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $editItemSuccess;?></div>
    <?php endif; ?>
    <?php if(isset($editPrivilegeSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $editPrivilegeSuccess;?></div>
    <?php endif; ?>

    <?php if($loggedIn) : ?>
    <div class="row">
        <div class="mt-3 ml-3">
            <p>Select page to display</p>
            <div>
                <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
                    <a class="btn btn-secondary mb-3" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>

        <div class="col-lg-12">
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
                            <?php if($loggedIn && $privilege >=2): ?>
                                <a href="./edit-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn buy_button btn-warning m-1">Edit product</a>
                                <a href="./delete-item.php?good_id=<?php echo $product['good_id']; ?>" class="btn buy_button btn-danger m-1">Delete</a>
                            <?php endif;?>
                        </div>
                        
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="mt-3 flex">
            <h3>This eshop is avalible only for logged in users</h3>
            <div class="row ml-2 mt-4">
                <a href="login.php" class="btn btn-primary mr-3 pl-4 pr-4">Log in</a>
                <a href="register.php" class="btn btn-secondary pl-4 pr-4">Register</a>
            </div>
        </div>
    <?php endif;?>
</div>
