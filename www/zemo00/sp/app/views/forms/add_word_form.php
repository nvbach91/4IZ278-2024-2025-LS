<?php
$linkUrl = BASE_URL;

if ($_SESSION['privilege'] == 3) {
    $linkUrl .= "/admin";
}
?>

<form action="<?php echo htmlspecialchars($linkUrl . '/add_word'); ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
    <div class="mb-3">
        <label for="word" class="form-label">Word:</label>
        <input type="text" name="word" id="word" maxlength="32" required class="form-control">
    </div>

    <div class="mb-3">
        <label for="lang_code" class="form-label">Language:</label>
        <select name="lang_code" id="lang_code" required class="form-select">
            <?php foreach ($languages as $language): ?>
                <option value="<?php echo htmlspecialchars($language['code']); ?>">
                    <span style="font-family: serif;"><?php echo htmlspecialchars($language['icon']); ?></span>
                    <?php echo htmlspecialchars($language['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="existing-concepts" class="mb-3">
        <label class="form-label d-block">Existing concept(s)</label>
        <div class="concept-entry existing border rounded p-3 mb-3">
            <div class="mb-2">
                <label class="form-label">Choose existing</label>
                <select name="existing_concepts[]" class="form-select concept-search">
                </select>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeConcept(this)">Remove</button>
        </div>
    </div>

    <div id="new-concepts" class="mb-3">
        <label class="form-label d-block">New Concept(s)</label>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-3">
        <button type="button" class="btn btn-secondary" onclick="addExistingConcept()">Add Existing Concept</button>
        <button type="button" class="btn btn-secondary" onclick="addNewConcept()">Add New Concept</button>
    </div>

    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger">
            <strong><?php echo htmlspecialchars($error); ?></strong>
        </div>
    <?php endforeach; ?>

    <?php foreach ($successMessages as $message): ?>
        <div class="alert alert-success">
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Add Word</button>
</form>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/add-concepts.js"; ?>"></script>