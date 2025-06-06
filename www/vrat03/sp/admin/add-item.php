<?php include __DIR__ . '/../prefix.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require_once __DIR__.'/../utils/Validator.php'; ?>
<?php require_once __DIR__ . '/../database/ProductsDB.php'; ?>
<?php require_once __DIR__.'/../database/CategoriesDB.php'; ?>
<?php require_once __DIR__.'/../database/ProductCategoryDB.php'; ?>
<?php require_once __DIR__ . '/../utils/Logger.php'; ?>
<?php

hasPrivilege(2);
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$productsDB = new ProductsDB();
$categoriesDB = new CategoriesDB();
$productCategoryDB = new ProductCategoryDB();
$log = AppLogger::getLogger();
$errors = [];

$allCategories = $categoriesDB->fetchAll([]);


if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on add-item.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {    
        $validator = new Validator();
        $name = htmlspecialchars(trim($_POST['name']));
        $price = htmlspecialchars(trim($_POST['price']));
        $imgURL = htmlspecialchars(trim($_POST['img']));
        $imgThumbURL = htmlspecialchars(trim($_POST['img_thumb']));
        $quantity = htmlspecialchars(trim($_POST['quantity']));
        $description = htmlspecialchars(trim($_POST['description']));
        $minPlayers = htmlspecialchars(trim($_POST['minplayers']));
        $maxPlayers = htmlspecialchars(trim($_POST['maxplayers']));
        $playtime = htmlspecialchars(trim($_POST['playtime']));
        $productCategoriesID = isset($_POST['categories']) ? $_POST['categories'] : [];
        $allCategories = $categoriesDB->fetchAll([]);

        $validator->validateRequiredField('name', $name);
        $validator->validateNumberField('price', $price);
        $validator->validateURLField('imgURL', $imgURL);
        $validator->validateURLField('imgThumbURL', $imgThumbURL);
        $validator->validateNumberField('quantity', $quantity);
        $validator->validateNumberField('minPlayers', $minPlayers);
        $validator->validateNumberField('maxPlayers', $maxPlayers);
        $validator->validateNumberField('playtime', $playtime);
        $validator->validateRequiredField('categories', $productCategoriesID);

        if(!$validator->hasErrors()) {
            $productID = $productsDB->addProduct($name, $price, $imgURL, $imgThumbURL, $quantity, $description, $minPlayers, $maxPlayers, $playtime);
            foreach ($productCategoriesID as $categoryID) {
                $productCategoryDB->addCategoryToProductByProductID($productID, $categoryID);
            }
            $log->info('New product added', [
                'product_id' => $productID,
                'name' => $name,
                'price' => $price,
                'imgURL' => $imgURL,
                'imgThumbURL' => $imgThumbURL,
                'quantity' => $quantity,
                'description' => $description,
                'minPlayers' => $minPlayers,
                'maxPlayers' => $maxPlayers,
                'playtime' => $playtime,
                'categories' => $productCategoriesID
            ]);
            $errors['success'] = 'Product added successfully.';
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>
<?php require __DIR__.'/../includes/head.php';?>

<div class="container">
    <h1 class="my-4">Add item</h1>
    <div class="row">

        <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['success']; ?>
        </div>
        <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['alert']; ?>
        </div>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

            <?php $csrf->insertToken(); ?>

            <div id="alertName" class="alert alert-danger" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['name']; ?>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
            </div>
            

            <div id="alertPrice" class="alert alert-danger" style="display: <?php echo isset($errors['price']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['price']; ?>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo isset($price) ? $price : ''; ?>">
            </div>

            <div id="alertImgURL" class="alert alert-danger" style="display: <?php echo isset($errors['imgURL']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['imgURL']; ?>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Image URL</label>
                <input type="text" class="form-control" id="imgURL" name="img" value="<?php echo isset($imgURL) ? $imgURL : ''; ?>">
            </div>

            <div id="alertImgThumbURL" class="alert alert-danger" style="display: <?php echo isset($errors['imgThumbURL']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['imgThumbURL']; ?>
            </div>
            <div class="mb-3">
                <label for="img_thumb" class="form-label">Thumbnail Image URL</label>
                <input type="text" class="form-control" id="imgThumbURL" name="img_thumb" value="<?php echo isset($imgThumbURL) ? $imgThumbURL : ''; ?>">
            </div>

            <div id="alertQuantity" class="alert alert-danger" style="display: <?php echo isset($errors['quantity']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['quantity']; ?>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="textarea" name="description" rows="4"><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>

            <div id="alertMinPlayers" class="alert alert-danger" style="display: <?php echo isset($errors['minPlayers']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['minPlayers']; ?>
            </div>
            <div class="mb-3">
                <label for="minplayers" class="form-label">Minimum Players</label>
                <input type="number" class="form-control" id="minPlayers" name="minplayers" value="<?php echo isset($minPlayers) ? $minPlayers : ''; ?>">
            </div>


            <div id="alertMaxPlayers" class="alert alert-danger" style="display: <?php echo isset($errors['maxPlayers']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['maxPlayers']; ?>
            </div>
            <div class="mb-3">
                <label for="maxplayers" class="form-label">Maximum Players</label>
                <input type="number" class="form-control" id="maxPlayers" name="maxplayers" value="<?php echo isset($maxPlayers) ? $maxPlayers : ''; ?>">
            </div>

            <div id="alertPlaytime"class="alert alert-danger" style="display: <?php echo isset($errors['playtime']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['playtime']; ?>
            </div>
            <div class="mb-3">
                <label for="playtime" class="form-label">Playtime (minutes)</label>
                <input type="number" class="form-control" id="playtime" name="playtime" value="<?php echo isset($playtime) ? $playtime : ''; ?>">
            </div>

            <div id="alertCategories" class="alert alert-danger" style="display: <?php echo isset($errors['categories']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['categories']; ?>
            </div>

            <p class="form-label">Categories:</p>
            <button class="btn btn-primary d-flex align-items-center" type="button" id="categoryButton" onclick="toggleCategoriesDropdown()">
                <span class="material-symbols-outlined">category</span>
                Show categories
            </button>
            <div class="mb-3">
                <div class="dropdown" id="categoryDropdown">
                    <?php
                    foreach ($allCategories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" id="cat_<?php echo $category['category_id']; ?>" value="<?php echo $category['category_id']; ?>"
                                <?php echo (isset($productCategoriesID) && in_array($category['category_id'], $productCategoriesID)) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="cat_<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" id="submitButton" class="btn btn-success d-flex align-items-center" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
                <span class="material-symbols-outlined">save</span>
                Save changes
            </button>
        </form>
    </div>
</div>


<?php require __DIR__.'/../includes/foot.php';?>
<script type="module" src="../js/handle-item.js"></script>
<script src="../js/dropdown.js"></script>
<script src="../js/textarea-resize.js"></script>