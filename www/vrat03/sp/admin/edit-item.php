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

if (isset($_POST['id'])) {
    $productID = (int)$_POST['id'];
} elseif (isset($_GET['id'])) {
    $productID = (int)$_GET['id'];
} else {
    header('Location: '.$urlPrefix.'/admin/edit-items.php');
    exit();
}
if ($productID <= 0) {
    header('Location: '.$urlPrefix.'/admin/edit-items.php');
    exit();
}
$product = $productsDB->fetchProductById($productID);
if (!$product) {
    header('Location: '.$urlPrefix.'/admin/edit-items.php');
    exit();
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $errors['success'] = 'Item updated successfully';
}

$name = $product['name'];
$price = $product['price'];
$imgURL = $product['img'];
$imgThumURL = $product['img_thumb'];
$quantity = $product['quantity'];
$description = $product['description'];
$minPlayers = $product['minplayers'];
$maxPlayers = $product['maxplayers'];
$playtime = $product['playtime'];
$productCategories = $productsDB->fetchCategoriesByProductID($productID);
$allCategories = $categoriesDB->fetchAll([]);


if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on edit-item.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $validator = new Validator();
        $name = htmlspecialchars(trim($_POST['name']));
        $price = htmlspecialchars(trim($_POST['price']));
        $imgURL = htmlspecialchars(trim($_POST['imgURL']));
        $imgThumbURL = htmlspecialchars(trim($_POST['imgThumbURL']));
        $quantity = htmlspecialchars(trim($_POST['quantity']));
        $description = htmlspecialchars(trim($_POST['description']));
        $minPlayers = htmlspecialchars(trim($_POST['minPlayers']));
        $maxPlayers = htmlspecialchars(trim($_POST['maxPlayers']));
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
            if (isset($_POST['last_updated']) && $_POST['last_updated'] !== $product['last_updated']) {
                $errors['alert'] = 'This item has been modified by another user.';
            } else {
                $productsDB->updateProduct($productID, $name, $price, $imgURL, $imgThumbURL, $quantity, $description, $minPlayers, $maxPlayers, $playtime);
                $productCategoryDB->removeAllCategoriesByProductID($productID);
                foreach ($productCategoriesID as $categoryID) {
                    $productCategoryDB->addCategoryToProductByProductID($productID, $categoryID);
                }
                $log->info('Product updated', [
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
                header('Location:'.$urlPrefix.'/admin/edit-item.php?id='.$productID.'&success=1');
                exit;
            }
            
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>
<?php require __DIR__.'/../includes/head.php';?>

<div class="container">
    <h1 class="my-4">Edit Item #<?php echo $productID ?></h1>
    <div class="row">

        <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['success']; ?>
        </div>
        <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['alert']; ?>
        </div>

        <?php if (isset($errors['modified'])): ?>
            <div class="alert alert-danger"><?php echo $errors['modified']; ?></div>
        <?php endif; ?>
        <form method="POST" action="">

            <?php $csrf->insertToken(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($productID); ?>">
            <input type="hidden" name="last_updated" value="<?php echo $product['last_updated']; ?>">
            
            <div id="alertName" class="alert alert-danger" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['name']; ?>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            
            <div id="alertPrice" class="alert alert-danger" style="display: <?php echo isset($errors['price']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['price']; ?>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>">
            </div>

            <div id="alertImgURL" class="alert alert-danger" style="display: <?php echo isset($errors['imgURL']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['imgURL']; ?>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Image URL</label>
                <input type="text" id="imgURL" class="form-control" name="imgURL" value="<?php echo htmlspecialchars($imgURL); ?>">
            </div>

            <div id="alertImgThumbURL" class="alert alert-danger" style="display: <?php echo isset($errors['imgThumbURL']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['imgThumbURL']; ?>
            </div>
            <div class="mb-3">
                <label for="imgThumbURL" class="form-label">Thumbnail Image URL</label>
                <input type="text" id="imgThumbURL" class="form-control" name="imgThumbURL" value="<?php echo htmlspecialchars($imgThumURL); ?>">
            </div>

            <div id="errorQuantity" class="alert alert-danger" style="display: <?php echo isset($errors['quantity']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['quantity']; ?>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="textarea" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
            </div>

            <div id="alertMinPlayers" class="alert alert-danger" style="display: <?php echo isset($errors['minPlayers']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['minPlayers']; ?>
            </div>
            <div class="mb-3">
                <label for="minPlayers" class="form-label">Minimum Players</label>
                <input type="number" id="minPlayers" class="form-control"  name="minPlayers" value="<?php echo htmlspecialchars($minPlayers); ?>">
            </div>


            <div id="alertMaxPlayers" class="alert alert-danger" style="display: <?php echo isset($errors['maxPlayers']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['maxPlayers']; ?>
            </div>
            <div class="mb-3">
                <label for="maxPlayers" class="form-label">Maximum Players</label>
                <input type="number" id="maxPlayers" class="form-control"  name="maxPlayers" value="<?php echo htmlspecialchars($maxPlayers); ?>">
            </div>

            <div id="alertPlaytime" class="alert alert-danger" style="display: <?php echo isset($errors['playtime']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['playtime']; ?>
            </div>
            <div class="mb-3">
                <label for="playtime" class="form-label">Playtime (minutes)</label>
                <input type="number" id="playtime" class="form-control"  name="playtime" value="<?php echo htmlspecialchars($playtime); ?>">
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
                    $productCategoryIDs = is_array($productCategories) && isset($productCategories[0]['category_id'])
                        ? array_map(function($cat) { return $cat['category_id']; }, $productCategories)
                        : $productCategories;
                    foreach ($allCategories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" id="cat_<?php echo $category['category_id']; ?>" value="<?php echo $category['category_id']; ?>"
                                <?php echo in_array($category['category_id'], $productCategoryIDs) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="cat_<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['name']); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button type="submit" id="submitButton" class="btn btn-success d-flex align-items-center">
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