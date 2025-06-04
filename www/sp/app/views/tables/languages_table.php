<?php

require_once __DIR__ . "/../../models/LanguageDB.php";

$sort = $_GET['sort'] ?? 'name';
$direction = $_GET['direction'] ?? 'asc';

$languageDB = new LanguageDB();
$languages = $languageDB->fetchSorted($sort, $direction);

?>

<?php if (empty($languages)): ?>
    <h3 class="text-center text-muted my-5">There are no languages in the database.</h3>
<?php else: ?>
    <table class="table table-bordered align-middle mt-4">
        <thead class="table-light">
            <tr>
                <th>Icon</th>
                <th>Name</th>
                <th>Code</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($languages as $language): ?>
                <tr>
                    <td><?php echo htmlspecialchars($language['icon'] ?? '') ?></td>
                    <td><?php echo htmlspecialchars($language['name']); ?></td>
                    <td><?php echo htmlspecialchars($language['code']); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . "/admin/edit_language?code=" . urlencode($language['code']); ?>" class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>