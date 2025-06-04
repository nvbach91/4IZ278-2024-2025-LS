<form action="<?php echo BASE_URL . "/edit_collection?collection_id=" . urlencode($collectionId); ?>" method="POST" class="edit-word-form bg-white p-4 rounded shadow-sm" style="max-width: 700px; margin: auto;">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="<?php echo htmlspecialchars($collection['name']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="icon" class="form-label">Icon</label>
        <div class="input-group">
            <input type="text" name="icon" id="emoji-input" readonly
                   value="<?php echo htmlspecialchars($collection['icon'] ?? ''); ?>" class="form-control">
            <button type="button" id="emoji-button" class="btn btn-warning">Pick an icon</button>
        </div>
    </div>

    <div id="word_list" class="mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Word</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($words as $word): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($word['word']); ?></td>
                        <td class="text-center">
                            <input type="checkbox" name="word_ids[]" value="<?php echo htmlspecialchars($word['word_id']); ?>"
                                <?php if (in_array($word['word_id'], $currentWordIds)) echo 'checked'; ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-primary w-100">Apply changes</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/emoji-picker.js"; ?>"></script>