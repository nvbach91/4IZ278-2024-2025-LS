<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../database/CategoriesDB.php';
require_once __DIR__ . '/../database/ProductsDB.php';

session_start();
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->find([]);

$productsDB = new ProductsDB();


$required = array('name', 'cat', 'image', 'price');
$isSubmettedForm = !empty($_POST);
$errors = [];

if (!isset($_GET['good_id']) || empty($_GET['good_id'])) {
    echo 'Nebyl poskytnut parametr id zboží.';
    exit();
}
if ($_SESSION['privilege'] < 2) {
    echo 'Unauthorized access';
    exit;
}
if ($isSubmettedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $image = htmlspecialchars(trim($_POST['image']));
    $price = htmlspecialchars(trim($_POST['price']));
    $cat = htmlspecialchars(trim($_POST['cat']));

    if (!preg_match('/^[a-zA-Z]+\s[a-zA-Z]+$/', $name)) {
        $errors['name'] = 'Enter valid name';
    }
    if (!preg_match('/[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/', $image)) {
        $errors['image'] = 'Enter a valid URL';
    }
    if ($cat == 'Choose...') {
        $errors['cat'] = 'Choose a gender';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        }
    }

    if (empty($errors)) {
        $productsDB->EditItemById($_GET['good_id'], $name, $price, $image, (int)$cat);
    }
}
?>
<main class="container">
    <h1>Edit item</h1>
    <form class="form-signup" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . "?good_id=" . $_GET['good_id']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo !empty($_GET['good_id']) ? $productsDB->findById($_GET['good_id'])[0]['name'] : '' ?>">
        </div>
        <?php if (isset($errors['price'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['price']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Price*</label>
            <input class="form-control" name="price" value="<?php echo !empty($_GET['good_id']) ? $productsDB->findById($_GET['good_id'])[0]['price'] : '' ?>">
        </div>
        <?php if (isset($errors['image'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['image']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Image url*</label>
            <input class="form-control" name="image" value="<?php echo !empty($_GET['good_id']) ? $productsDB->findById($_GET['good_id'])[0]['img'] : '' ?>">
        </div>
        <?php if (isset($errors['cat'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['cat']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Category*</label>
            <select id="inputState" name="cat" class="form-control">
                <option <?php echo !isset($cat) ? 'selected' : '' ?>>Choose...</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id'] ?>" <?php echo !empty($_GET['good_id']) && $productsDB->findById($_GET['good_id'])[0]['category_id'] == $category['category_id'] ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if (empty($errors) && $isSubmettedForm) : ?>
            <div class="alert alert-success">
                <?php echo "Product updated successfully"; ?>
            </div>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>
<?php include __DIR__ . '/footer.php'; ?>