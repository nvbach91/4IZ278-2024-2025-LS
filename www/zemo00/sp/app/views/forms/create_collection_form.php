<div class="container my-5">
    <!-- === Pick language === -->
    <form action="<?php echo BASE_URL . "/create_collection"; ?>" method="GET" class="mb-4 border p-4 rounded bg-light">
        <div class="mb-3">
            <label for="lang" class="form-label">Language</label>
            <select name="lang" class="form-select" required>
                <option value="">-- NONE --</option>
                <?php foreach ($languages as $language): ?>
                    <option value="<?php echo htmlspecialchars($language['code']); ?>" 
                        <?php if ($lang === $language['code']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($language['icon']) . " " . htmlspecialchars($language['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-primary">Select language</button>
        <?php if (!empty($langError)): ?>
            <div class="text-danger mt-2">
                <strong><?php echo $langError; ?></strong>
            </div>
        <?php endif; ?>
    </form>

    <?php if (isset($words) && !empty($words)):
        // === Setup for sorting and pagination ===
        $sortLink = BASE_URL;
        $pageLink = BASE_URL . "/create_collection?lang=" . urlencode($lang) . "&";

        if ($_SESSION['privilege'] == 3) {
            $sortLink .= "/admin";
        }
        $sortLink .= "/create_collection?lang=" . urlencode($lang);

        require __DIR__ . "/../components/words_filter.php";
        require __DIR__ . "/../components/words_pagination.php";
    ?>

    <!-- === Main collection form === -->
    <form action="<?php echo BASE_URL . "/create_collection"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm mb-5" style="max-width: 900px; margin: auto;">

        <!-- === Word list === -->
        <div class="table-responsive mb-4">
            <h5>Available Words</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Word</th>
                        <th>Language</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($words as $word): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($word['word']); ?></td>
                            <td><?php echo htmlspecialchars($word['icon']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success add-word-btn"
                                    data-id="<?php echo htmlspecialchars($word['word_id']); ?>"
                                    data-word="<?php echo htmlspecialchars($word['word']); ?>"
                                    data-lang="<?php echo htmlspecialchars($word['lang_code']); ?>">
                                    Add
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- === Selected words === -->
        <div class="table-responsive mb-4">
            <h5>Selected Words</h5>
            <table class="table table-striped" id="selected-words-table">
                <thead class="table-light">
                    <tr>
                        <th>Word</th>
                        <th>Language</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- === Pick name === -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required
                value="<?php echo htmlspecialchars($name); ?>">
        </div>

        <!-- === Pick an icon === -->
        <div class="mb-3">
            <label for="icon" class="form-label">Icon</label>
            <div class="input-group">
                <input type="text" name="icon" id="emoji-input" readonly class="form-control"
                    value="<?php echo htmlspecialchars($icon); ?>">
                <button type="button" id="emoji-button" class="btn btn-warning">Pick an icon</button>
            </div>
        </div>


        <!-- === Submit button === -->
        <button type="submit" class="btn btn-primary w-100">Create collection</button>
    </form>

    <?php endif; ?>
    <!-- === Errors === -->
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger">
            <strong><?php echo htmlspecialchars($error); ?></strong>
        </div>
    <?php endforeach; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script src="<?php echo BASE_URL . "/public/js/emoji-picker.js"; ?>"></script>
<script src="<?php echo BASE_URL . "/public/js/selected-table.js"; ?>"></script>