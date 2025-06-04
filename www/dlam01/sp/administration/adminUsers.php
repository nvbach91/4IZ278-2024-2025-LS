<?php
require_once __DIR__ . '/../database/UsersDB.php';
session_start();
unset($_SESSION['errors']);
if (!isset($_SESSION['privilege']) || $_SESSION['privilege'] < 3) {
    header("Location: index.php");
    exit;
}
$usersDB = new UsersDB();
$users = $usersDB->fetch(null);

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchQuery !== '') {
    $users = array_filter($users, function ($user) use ($searchQuery) {
        return isset($user['email']) && stripos($user['email'], $searchQuery) !== false;
    });
}
?>
<?php include __DIR__ . "\../includes/header.php"; ?>
<?php if (isset($_SESSION["success"])): ?>
    <div class='alert alert-success' role='alert'>
        <?php echo $_SESSION["success"]; ?>
    </div>
<?php endif; ?>
<div class="text-start my-4" style="margin-left: 50px;">
    <a href="adminProducts.php" class="btn btn-primary btn-lg mx-2">Manage Products</a>
    <a href="adminUsers.php" class="btn btn-primary btn-lg mx-2">Manage Users</a>
</div>
<div class="container">
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php
    $itemsPerPage = 20;
    $totalItems = count($users);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedUsers = array_slice($users, $offset, $itemsPerPage);
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Privilege</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginatedUsers as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['privilege']); ?></td>
                    <td>
                        <a href="editUser.php?id=<?php echo urlencode($user['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteUser.php?id=<?php echo urlencode($user['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>&search=<?php echo urlencode($searchQuery); ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<div style="margin-bottom: 30px"></div>
<?php include __DIR__ . "\../includes/footer.php"; ?>