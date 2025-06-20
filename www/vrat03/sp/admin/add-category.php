<?php include __DIR__ . '/../prefix.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require_once __DIR__.'/../utils/Validator.php'; ?>
<?php require_once __DIR__.'/../database/CategoriesDB.php'; ?>
<?php require_once __DIR__ . '/../utils/Logger.php'; ?>
<?php

hasPrivilege(2);
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$categoriesDB = new CategoriesDB();
$log = AppLogger::getLogger();
$errors = [];

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $errors['success'] = 'Category added successfully.';
}
if (isset($_GET['id'])) {
    $categoryID = (int)$_GET['id'];
    $category = $categoriesDB->fetchCategoryById($categoryID);
    if($category) {
        $name = $category['name'];
    }
}

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on add-category.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $validator = new Validator();
        $name = htmlspecialchars(trim($_POST['name'])); 

        $validator->validateRequiredField('name', $name);
        $exists = $categoriesDB->getCategoryByName($name);
        if ($exists) {
            $errors['alert'] = 'Category with this name already exists. (Category ID: '.$exists['category_id'].')';
        } else if(!$validator->hasErrors() || empty( $errors)) {
            $categoryId = $categoriesDB->addCategory($name);
            $log->info('Category added', [
                'category_id' => $categoryId,
                'name' => $name
            ]);
            header('Location:'.$urlPrefix.'/admin/add-category.php?id='.$categoryId.'&success=1');
            exit;
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>
<?php require __DIR__.'/../includes/head.php';?>

<div class="container">
    <h1 class="my-4">Add Category</h1>
    <div class="row">

        <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['success']; ?>
        </div>
        <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['alert']; ?>
        </div>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

            <?php $csrf->insertToken(); ?>
            
            <div id="alertName" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['name'] ?? ''; ?>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control"  name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            </div>
            <button type="submit" id="submitButton" class="btn btn-primary d-flex align-items-center">
                <span class="material-symbols-outlined">save</span>
                Add Category
            </button>
        </form>
    </div>
</div>

<script type="module" src="../js/handle-category.js"></script>
<?php require __DIR__.'/../includes/foot.php';?>