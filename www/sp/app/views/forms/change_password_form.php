<form action="<?php echo BASE_URL . "/change_password"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 500px; margin: auto;">
    <div class="mb-3">
        <label for="current" class="form-label">Current password</label>
        <input type="password" name="current" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">New password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="confirm" class="form-label">Confirm password</label>
        <input type="password" name="confirm" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Save changes</button>

    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger mt-3">
            <strong><?php echo $error; ?></strong>
        </div>
    <?php endforeach; ?>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success mt-3">
            <strong><?php echo $successMessage; ?></strong>
        </div>
    <?php endif; ?>
</form>