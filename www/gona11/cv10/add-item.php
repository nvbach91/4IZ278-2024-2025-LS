<?php require_once __DIR__ . '/database/ProductsDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
<?php require __DIR__ . '/requires/navbar.php'?>
<?php 
    $loggedIn = false;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
    }

    if($loggedIn && isset($_SESSION["privilege"])) {
        $privilege = $_SESSION["privilege"];
    }

    $productDB = new ProductsDB();
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $name = htmlspecialchars(trim($_POST['name']));
        $description = htmlspecialchars(trim($_POST['description']));
        $img = htmlspecialchars(trim($_POST['img']));
        $price = htmlspecialchars(trim($_POST['price']));

        $errors = [];

        if(empty($name)) {
            $errors['name'] = "Enter name of the product";
        }

        if(empty($price)) {
            $errors['price'] = "Enter image";
        }

        if(!ctype_digit($price)) {
            $errors['price'] = "Price must be a number";
        }

        if(empty($description)) {
            $errors['description'] = "Enter description";
        }

        if(empty($img)) {
            $errors['img'] = "Enter image";
        }

        if(empty($errors)) {
            $productDB->addProduct($name, $price, $description, $img);
            $_SESSION["addItemSuccess"] = "Item was succesfully added!";
            header('Location: ./index.php');
            exit();
        }
    }
    ?>
    <div class="container">
        <?php if($loggedIn && $privilege >= 2) : ?>
            <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <h1 class="ml-4 mt-2">Add a new product</h1>
                <?php if(isset($errors['name'])) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $errors['name'];?></div>
                <?php endif; ?>
                <div class="form-group m-3">
                    <label class="ml-3 mb-0">Name</label>
                    <input 
                        class="form-control m-3"
                        name="name">
                </div>

                <?php if(isset($errors['price'])) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $errors['price'];?></div>
                <?php endif; ?>
                <div class="form-group m-3">
                    <label class="ml-3 mb-0">Price</label>
                    <input 
                        class="form-control m-3"
                        name="price">
                </div>

                <?php if(isset($errors['description'])) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $errors['description'];?></div>
                <?php endif; ?>
                <div class="form-group m-3">
                    <label class="ml-3 mb-0">Description</label>
                    <textarea
                        class="form-control m-3 p-0"
                        name="description">
                    </textarea>
                </div>

                <?php if(isset($errors['img'])) : ?>
                    <div class="alert alert-danger mt-3"><?php echo $errors['img'];?></div>
                <?php endif; ?>
                <div class="form-group m-3">
                    <label class="ml-3 mb-0">Link for image</label>
                    <input 
                        class="form-control m-3"
                        name="img">
                </div>
                <button class="btn btn-primary m-4 pl-5 pr-5" type="submit">Add item</button>
            </form>
        <?php elseif(!$loggedIn): ?>
            <div class="mt-3 flex">
                <h3>Page "Add item" is avalible only for logged in users</h3>
                <div class="row ml-2 mt-4">
                    <a href="login.php" class="btn btn-primary mr-3 pl-4 pr-4">Log in</a>
                    <a href="register.php" class="btn btn-secondary pl-4 pr-4">Register</a>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-3 flex">
                <h3>Access denied.</h3>
                <p>Reason: You do not have the privilege to access this page.</p>
                <div class="row ml-2 mt-4">
                    <a href="index.php" class="btn btn-primary mr-3 pl-4 pr-4">Back to products</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
<?php include __DIR__ . '/includes/foot.php'?>