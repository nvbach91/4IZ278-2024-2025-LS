<?php
$linkUrl = BASE_URL;

if ($_SESSION['privilege'] == 3) {
    $linkUrl .= "/admin";
}
?>

<form action="<?php echo htmlspecialchars($linkUrl . '/edit_word?id=' . $_GET['id']); ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 700px; margin: auto;">
    <input type="hidden" name="word_id" value="<?php echo (int)$word['word_id']; ?>">
    <input type="hidden" name="last_updated" value="<?php echo htmlspecialchars($word['last_updated']); ?>">

    <!-- === Word === -->
    <div class="mb-3">
        <label for="word" class="form-label">Word</label>
        <input type="text" name="word" required class="form-control"
            value="<?php echo htmlspecialchars($word['word']); ?>">
    </div>

    <!-- === Pick language === -->
    <div class="mb-3">
        <label for="lang_code" class="form-label">Language</label>
        <select name="lang_code" id="lang_code" required class="form-select">
            <?php foreach ($languages as $language): ?>
                <option value="<?php echo htmlspecialchars($language['code']); ?>" <?php if($language['code'] == $word['lang_code']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($language['icon']) . " " . htmlspecialchars($language['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- === Concept(s) === -->
    <div id="concept-fields" class="mb-4">
        <label class="form-label d-block">Concept(s)</label>
        <?php foreach ($assignedConcepts as $concept): ?>
        <div class="concept-entry border rounded p-3 mb-3">
            <label class="form-label">Already linked:</label>
            <select name="existing_concepts[]" class="form-select mb-2">
                <option value="">-- None --</option>
                <?php foreach ($conceptDB->fetchAll() as $c): ?>
                    <option value="<?php echo htmlspecialchars($c['concept_id']); ?>"
                        <?php if ($c['concept_id'] == $concept['concept_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($c['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label class="form-label">New concept name</label>
            <input type="text" name="concepts[]" class="form-control mb-2">
            <label class="form-label">Description</label>
            <input type="text" name="descriptions[]" class="form-control mb-2">
            <button type="button" class="btn btn-outline-danger btn-sm mt-1" onclick="removeConcept(this)">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>

    <button type="button" class="btn btn-secondary mb-3" onclick="addConceptField()">Add another concept</button>

    <!-- === Errors === -->
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger">
            <strong><?php echo htmlspecialchars($error); ?></strong>
        </div>
    <?php endforeach; ?>

    <!-- === Success messages === -->
    <?php foreach ($successMessages as $message): ?>
        <div class="alert alert-success">
            <strong><?php echo htmlspecialchars($message); ?></strong>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary w-100">Save changes</button>
</form>

<script src="<?php echo BASE_URL . "/public/js/add-concepts.js"; ?>"></script>