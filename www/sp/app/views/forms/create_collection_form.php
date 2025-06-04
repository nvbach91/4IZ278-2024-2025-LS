<form action="<?php echo BASE_URL . "/create_collection"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 700px; margin: auto;">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label for="lang" class="form-label">Language</label>
        <select name="lang" id="lang" class="form-select" required>
            <?php foreach ($languages as $language): ?>
                <option value="<?php echo htmlspecialchars($language['code']); ?>">
                    <?php echo htmlspecialchars($language['icon']) . " " . htmlspecialchars($language['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <div class="input-group">
            <input type="text" name="icon" id="emoji-input" readonly class="form-control"
                value="<?php echo htmlspecialchars($_POST['icon'] ?? ''); ?>">
            <button type="button" id="emoji-button" class="btn btn-warning">Pick an icon</button>
        </div>
    </div>

    <div id="word_list" class="mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Language</th>
                    <th>Word</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($words as $word): ?>
                    <tr data-lang="<?php echo htmlspecialchars($word['lang_code']); ?>">
                        <td><?php echo htmlspecialchars($word['icon']); ?></td>
                        <td><?php echo htmlspecialchars($word['word']); ?></td>
                        <td class="text-center">
                            <label>
                                <input type="checkbox" name="word_ids[]" value="<?php echo htmlspecialchars($word['word_id']); ?>">
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary w-100">Create collection</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/emoji-picker.js"; ?>"></script>
<script src="<?php echo BASE_URL . "/public/js/create-collection.js"; ?>"></script>