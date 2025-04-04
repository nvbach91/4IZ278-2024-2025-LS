<?php

require __DIR__ . "/incl/head.php";

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');

    if($name === ''){
        $error = 'A name is required';
    } else {
        setcookie('name', $name, time() + 3600, '/');

        header('Location: index.php');
        exit;
    }
}

?>
<div class="form-container">
<h2>Login</h2>
<form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label class="label" for="name">Name:</label>
    <input class="input" type="text" name="name" id="name">
    <button class="button" type="submit">Login</button>
    <?php if($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
</form>
</div>





<?php

include __DIR__ . "/incl/foot.html";

?>