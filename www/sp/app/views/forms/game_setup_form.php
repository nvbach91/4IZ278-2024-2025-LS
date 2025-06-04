<form action="<?php echo BASE_URL . "/game"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 700px; margin: auto;">
    <input type="hidden" name="lang_from" value="<?php echo htmlspecialchars($lang_from); ?>">
    <input type="hidden" name="lang_to" value="<?php echo htmlspecialchars($lang_to); ?>">

    <!-- === Amount of questions === -->
    <div class="mb-3">
        <label for="amount" class="form-label">Questions</label>
        <input type="number" name="amount" min="5" required class="form-control">
    </div>
    <h3 class="mt-4">Collections</h3>
    <!-- === Create collection link === -->
    <?php if (empty($collections)): ?>
        <div class="alert alert-info">
            <p>You don't have any collections yet.</p>
            <a href="<?php echo BASE_URL . "/create_collection"; ?>" class="btn btn-primary mt-2">Create one</a>
        </div>
    <?php else: ?>
    <!-- === Collections table === -->
    <div id="collection-source" class="mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Amount of words</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($collections as $collection): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($collection['name']); ?></td>
                        <td><?php echo $collection['amount']; ?></td>
                        <td class="text-center">
                            <input type="checkbox" name="collection_ids[]"
                                value="<?php echo $collection['collection_id']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    
    <button type="submit" class="btn btn-primary w-100">Start game</button>
</form>
