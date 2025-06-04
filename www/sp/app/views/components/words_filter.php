<?php

$linkUrl = BASE_URL;

if ($_SESSION['privilege'] == 3) {
    $linkUrl .= "/admin";
}

?>

<?php if (in_array($_SESSION['privilege'], [2, 3])): ?>
    <a href="<?php echo $linkUrl . "/add_word"; ?>" class="btn btn-success mb-3">Add a word</a>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($linkUrl . "/words"); ?>" method="GET" class="row g-3 mb-4">
    <div class="col-md-6">
        <label for="sort" class="form-label">Sort by:</label>
        <select name="sort" id="sort" class="form-select">
            <?php foreach ($wordDB->sortingColumns as $column): ?>
                <option value="<?php echo $column; ?>" <?php if ($sort === $column) echo 'selected'; ?>>
                    <?php echo ucfirst($column); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="direction" class="form-label">Order:</label>
        <select name="direction" id="direction" class="form-select">
            <option value="asc" <?php if ($direction === 'asc') echo 'selected'; ?>>Ascending</option>
            <option value="desc" <?php if ($direction === 'desc') echo 'selected'; ?>>Descending</option>
        </select>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Apply</button>
    </div>
</form>