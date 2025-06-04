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
                    <?php echo htmlspecialchars($language['icon']) . " " . htmlspecialchars($language['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="concept-fields" class="mb-3">
        <label class="form-label d-block">Concept(s)</label>
        <div class="concept-entry border rounded p-3 mb-3">
            <div class="mb-2">
                <label class="form-label">Choose existing</label>
                <select name="existing_concepts[]" class="form-select">
                    <option value="">-- None --</option>
                    <?php foreach ($conceptDB->fetchAll() as $concept): ?>
                        <option value="<?php echo htmlspecialchars($concept['concept_id']); ?>">
                            <?php echo htmlspecialchars($concept['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">New concept name</label>
                <input type="text" name="concepts[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="descriptions[]" class="form-control">
            </div>

            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeConcept(this)">Remove</button>
        </div>
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

    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-3">
        <button type="button" class="btn btn-secondary" onclick="addConceptField()">Add another concept</button>
    </div>

    <button type="submit" class="btn btn-primary">Add Word</button>
</form>

<script src="<?php echo BASE_URL . "/public/js/add-concepts.js"; ?>"></script>