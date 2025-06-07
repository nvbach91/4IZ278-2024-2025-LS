<!--filter-->
<form method="get" class="my-3">
    <label for="privilege" class="form-label">Filter by privilege:</label>
    <select name="privilege" id="privilege" class="form-select" onchange="this.form.submit()">
        <option value="0" <?php if ($privilegeFilter === '0') echo 'selected'; ?>>All</option>
        <option value="1" <?php if ($privilegeFilter === '1') echo 'selected'; ?>>Users</option>
        <option value="2" <?php if ($privilegeFilter === '2') echo 'selected'; ?>>Managers</option>
        <option value="3" <?php if ($privilegeFilter === '3') echo 'selected'; ?>>Admins</option>
    </select>
</form>

<?php if (empty($users)): ?>
    <h1 class='my-4'>No users found.</h1>
<?php else: ?>
    <h1 class='my-4'>Users</h1>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Privilege</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php include __DIR__.'/users-user.php'; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>