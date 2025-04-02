<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php 
if(isset($_POST['name'])) {
    setcookie("name", $_POST['name'], time() + 3600, "/");
    header("Location: index.php");
    exit;
}
?>
<main class="container">
    <form action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" class="form-register">
        <h1>Login</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" name="name" placeholder="Name">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>