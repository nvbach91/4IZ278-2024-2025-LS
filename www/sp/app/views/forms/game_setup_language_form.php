<form action="<?php echo BASE_URL . "/game_setup"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 500px; margin: auto;">
    <div class="d-flex align-items-center gap-3 mb-3">
        <select name="lang_from" id="lang_from" required class="form-select">
            <?php foreach ($languages as $lang): ?>
                <option value="<?php echo htmlspecialchars($lang['code']); ?>">
                    <?php echo htmlspecialchars($lang['icon'] . " " . $lang['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <span class="fw-bold">&rarr;</span>

        <select name="lang_to" id="lang_to" required class="form-select">
            <?php foreach ($languages as $lang): ?>
                <option value="<?php echo htmlspecialchars($lang['code']); ?>">
                    <?php echo htmlspecialchars($lang['icon'] . " " . $lang['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Next</button>

    <?php if (isset($_GET['error']) && $_GET['error'] == "same-language"): ?>
        <div class="alert alert-danger mt-3">
            <strong><?php echo "The two languages can't be the same."; ?></strong>
        </div>
    <?php endif; ?>
</form>