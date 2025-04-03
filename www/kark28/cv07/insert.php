<?php
require __DIR__ . '/database/ProductDB.php';
require __DIR__ . '/database/CategoryDB.php';

$productsDB = new ProductDB;
$catDB = new CategoryDB();
$cats = $catDB->getCategories();

$isSubmittedForm = !empty($_POST);
$errors = [];
$success = '';

var_dump($_POST);

if ($isSubmittedForm) {
    $url = htmlspecialchars(trim($_POST['basic-url']));
    $name = htmlspecialchars(trim($_POST['name']));
    $price = htmlspecialchars(trim($_POST['price']));
    $category_id = htmlspecialchars($_POST['category']);
    $desc = htmlspecialchars($_POST['desc']);
 
    $alertMessage = [];


    if (empty($errors)) {
      $productsDB->insert($url, $name, $price, $category_id, $desc);
  }
        }     

?>
<?php include __DIR__ . '/includes/header.php'; ?>
<main style="width:80%; margin:auto" class="container">
<h1>Add new item</h1>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<div class="mb-3">
<label for="basic-url" class="form-label">URL for image of the product</label>
  <div class="input-group">
    <span class="input-group-text" id="basic-addon3">https://</span>
    <input type="text" class="form-control" name="basic-url" aria-describedby="basic-addon3 basic-addon4">
  </div>
  </div>

  <div class="mb-3">
    <label for="name" class="form-label">Name of the product</label>
    <input type="text" class="form-control" name="name">
  </div>

  <div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <div class="input-group">
    <span class="input-group-text" id="basic-addon3">$</span>
    <input type="text" class="form-control" name="price" aria-describedby="basic-addon3 basic-addon4">
  </div>
  </div>
  <div class="mb-3">
  <label for="select" class="form-label">Category</label>
  <select class="form-select" name="category">
    <?php foreach($cats as $cat): ?>
  <option value="<?php echo $cat['category_id'];?>"><?php echo $cat['name']; ?></option>
<?php endforeach ?>
</select>
  </div>

  <div class="mb-3">
  <label for="desc" class="form-label">Description</label>
  <textarea class="form-control" name="desc" rows="3"></textarea>
</div>

<br>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a href="index.php">Back to homepage</a>
<br>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>