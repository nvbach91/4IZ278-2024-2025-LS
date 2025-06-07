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


if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $categoryID = (int)$_POST['id'];
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryID = (int)$_GET['id'];
} else {
    header('Location: '.$urlPrefix.'/admin/edit-categories.php');
    exit();
}
if ($categoryID <= 0) {
    header('Location: '.$urlPrefix.'/admin/edit-categories.php');
    exit();
}
$category = $categoriesDB->fetchCategoryById($categoryID);
if (!$category) {
    header('Location: '.$urlPrefix.'/admin/edit-categories.php');
    exit();
}

$name = $category['name'];

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on edit-category.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $oldName = $name;
        $validator = new Validator();
        $name = htmlspecialchars(trim($_POST['name']));    

        $validator->validateRequiredField('name', $name);

        if(!$validator->hasErrors()) {
            if (isset($_POST['last_updated']) && $_POST['last_updated'] !== $category['last_updated']) {
                $errors['alert'] = 'This category has been modified by another user.';
            } else {
                $categoriesDB->updateCategory($categoryID, $name);
                $log->info('Category updated', [
                    'category_id' => $categoryID,
                    'old_name' => $oldName,
                    'new_name' => $name
                ]);
                $errors['success'] = 'Category updated successfully';
            }
            
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>
<?php require __DIR__.'/../includes/head.php'; ?>

<div class="container">
    <h1 class="my-4">Edit Category #<?php echo $category['category_id']?></h1>
    <div class="row">

        <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['success']; ?>
        </div>
        <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['alert']; ?>
        </div>

        <form method="POST" action="">
            <?php $csrf->insertToken(); ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($categoryID); ?>">
            <input type="hidden" name="last_updated" value="<?php echo $category['last_updated']; ?>">


            <div id="alertName" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
                <?php echo $errors['name'] ?? ''; ?>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <button type="submit" id="submitButton" class="btn btn-primary d-flex align-items-center" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
                <span class="material-symbols-outlined">save</span>
                Save changes
            </button>
        </form>
    </div>
</div>

<script type="module" src="../js/handle-category.js"></script>
<?php require __DIR__.'/../includes/foot.php';?>