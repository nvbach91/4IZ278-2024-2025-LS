<?php include __DIR__ . '/header.php';
include_once __DIR__ . '/../database/UsersDB.php';

if (!isset($_COOKIE['name']) || $_SESSION['privilege'] < 3) {
    header('Location: /4IZ278/DU/du06/index.php');
    exit;
}


$usersDB = new UsersDB();
$users = $usersDB->find([]);

$isSubmettedForm = !empty($_POST);

if ($isSubmettedForm) {
    $privilege = htmlspecialchars($_POST['privilege']);

    $id = htmlspecialchars($_POST['id']);
    $usersDB->changeUserPrivilege($id, $privilege);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users = $usersDB->find([]);
}

?>
<!-- Page Content-->
<div class="container">
    <?php foreach ($users as $user) : ?>
        <form class="form-signup" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label><?php echo $user['email'] ?></label>
                <select id="inputState" name="privilege" class="form-control">
                    <option value="1" <?php echo $user['privilege'] == 1 ? 'selected' : '' ?>>1</option>
                    <option value="2" <?php echo $user['privilege'] == 2 ? 'selected' : '' ?>>2</option>
                    <option value="3" <?php echo $user['privilege'] == 3 ? 'selected' : '' ?>>3</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $user['User_id']; ?>">
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    <?php endforeach; ?>
</div>
<?php include __DIR__ . '/footer.php'; ?>