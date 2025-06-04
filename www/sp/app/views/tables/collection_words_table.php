<?php if (empty($words)): ?>
    <h3 class="text-center text-muted my-5">Hmm . . . no words . . .</h3>
<?php else: ?>
    <table class="table table-bordered align-middle mt-4">
        <thead class="table-light">
            <tr>
                <th>Word</th>
                <th>Language</th>
                <?php if (!empty($editUrl)): ?>
                    <th>Edit</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($words as $word): ?>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL . "/word?id=" . urlencode($word['word_id']); ?>">
                            <?php echo htmlspecialchars($word['word']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($word['icon']); ?></td>
                    <?php if (!empty($editUrl)): ?>
                        <td><a href="<?php echo $editUrl . "?id=" . urlencode($word['word_id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>