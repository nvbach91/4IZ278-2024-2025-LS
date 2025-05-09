<?php
include __DIR__ . '/header.php';
require_once __DIR__ . '/../database/CategoriesDB.php';
require_once __DIR__ . '/../database/ProductsDB.php';
if ($_SESSION['privilege'] < 2) {
    echo 'Unauthorized access';
    exit;
}
$categoriesDB = new CategoriesDB();
$categories = $categoriesDB->find([]);

$productsDB = new ProductsDB();

$required = array('name', 'cat', 'image', 'price');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $image = htmlspecialchars(trim($_POST['image']));
    $price = htmlspecialchars(trim($_POST['price']));
    $cat = htmlspecialchars(trim($_POST['cat']));

    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
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
        $productsDB->insert([$name, $price, $image, (int)$cat]);
        header('Location: /4IZ278/DU/du06/index.php');
        exit();
    }
}
?>
<main class="container">
    <h1>Create item</h1>
    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <?php if (isset($errors['price'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['price']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Price*</label>
            <input class="form-control" name="price" value="<?php echo isset($price) ? $price : '' ?>">
        </div>
        <?php if (isset($errors['image'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['image']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Image url*</label>
            <input class="form-control" name="image" value="<?php echo isset($image) ? $image : '' ?>">
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
                    <option value="<?php echo $category['category_id'] ?>" <?php echo isset($cat) && $cat == $category['category_id'] ? 'selected' : '' ?>><?php echo $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>
<?php include __DIR__ . '/footer.php'; ?>