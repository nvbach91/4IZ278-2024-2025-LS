<?php


require_once __DIR__ . "/../views/partials/head.php";

?>

<div class="container my-4">
    <form action="<?php echo BASE_URL . "/admin/add_language"; ?>" method="POST" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="<?php echo htmlspecialchars($_POST['code'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" name="icon" id="emoji-input" class="form-control" readonly value="<?php echo htmlspecialchars($_POST['icon'] ?? ''); ?>">
            <button type="button" id="emoji-button" class="btn btn-outline-secondary mt-2">Pick a flag</button>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success mt-3">
                <strong><?php echo htmlspecialchars($successMessage); ?></strong><br>
                <a href="<?php echo BASE_URL . "/admin/add_language"; ?>" class="btn btn-link p-0">Add another language</a>
            </div>
        <?php endif; ?>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/emoji-picker.js"; ?>"></script>

<?php include __DIR__ . "/../partials/foot.html"; ?>