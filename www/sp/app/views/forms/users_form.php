<form action="<?php echo BASE_URL . "/admin/users"; ?>" method="POST" class="bg-white p-4 rounded shadow-sm" style="max-width: 800px; margin: auto;">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Email</th>
                <th>Created</th>
                <th>Privilege</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <?php if (in_array($user['privilege'], [1, 2])): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <select name="privileges[<?php echo $user['user_id']; ?>]" class="form-select">
                                <option value="1" <?php if ($user['privilege'] == 1) echo 'selected'; ?>>1 - User</option>
                                <option value="2" <?php if ($user['privilege'] == 2) echo 'selected'; ?>>2 - Manager</option>
                            </select>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary w-100 mt-3">Apply changes</button>
</form>