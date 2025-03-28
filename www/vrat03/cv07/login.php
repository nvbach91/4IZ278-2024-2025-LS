<?php include __DIR__.'/includes/head.php'; ?>
<?php

$isEnteredName = !empty($_POST);

if ($isEnteredName) {
    $name = htmlspecialchars(trim($_POST['name']));    
    setcookie('name', $name, time() + 3600);
    header('Location: ./index.php');
    exit();
}

?>

<div class="container">
    <div class="row">
        <form method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input name="name" class="form-control" id="name" value="<?php echo isset($name) ? $name : ''?>">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<?php include __DIR__.'/includes/foot.php'; ?>