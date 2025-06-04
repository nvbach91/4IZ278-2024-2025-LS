<div class="container my-4">
    <?php if ($successMessage !== null && $successMessage === ''): ?>
        <div class="alert alert-warning">
            <h5>The record has been modified by another user since you started updating</h5>
            <?php foreach ($language as $column => $value): ?>
                <p><strong><?php echo htmlspecialchars($column); ?>:</strong> <?php echo htmlspecialchars($value); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL . "/admin/edit_language?code={$language['code']}"; ?>" method="POST" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($language['name']); ?>">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="<?php echo htmlspecialchars($language['code']); ?>">
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <input type="text" name="icon" id="emoji-input" class="form-control" readonly value="<?php echo htmlspecialchars($language['icon']); ?>">
            <button type="button" id="emoji-button" class="btn btn-outline-secondary mt-2">Pick a flag</button>
        </div>
        <input type="hidden" name="last_updated" value="<?php echo htmlspecialchars($language['last_updated']); ?>">
        <button type="submit" class="btn btn-primary">Save</button>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>

        <?php if ($successMessage !== null && !empty($successMessage)): ?>
            <div class="alert alert-success mt-3">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/emoji-picker.js"; ?>"></script>

<?php
require __DIR__ . "/../partials/foot.html";
?>