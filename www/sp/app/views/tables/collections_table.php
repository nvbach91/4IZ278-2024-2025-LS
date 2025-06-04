<?php if (empty($collections)): ?>
    <h3 class="text-center text-muted my-5">You don't have any collections.</h3>
<?php else: ?>
    <table class="table table-bordered align-middle mt-4">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Amount of words</th>
                <th>Created</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($collections as $collection): ?>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL . "/collection?collection_id=" . urlencode($collection['collection_id']); ?>">
                            <?php echo htmlspecialchars($collection['name']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($collection['amount']); ?></td>
                    <td><?php echo htmlspecialchars($collection['created_at']); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . "/edit_collection?collection_id=" . urlencode($collection['collection_id']); ?>" class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>