<?php require_once __DIR__ . '/database/DB_Scripts/UserDB.php'?>

<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/requires/navbar.php'; ?>
<?php
    $userDB = new UserDB(); 
    $users = $userDB->getAllUsers();
    if (!$users) {
        $_SESSION["openUserFail"] = "Uživatelé nemohli být zobrazeni.";
        header("Location: index.php");
        exit();
    }

    if(isset($_SESSION["editPrivilegeSuccess"])) {
        $editPrivilegeSuccess = $_SESSION["editPrivilegeSuccess"];
        unset($_SESSION["editPrivilegeSuccess"]);
    }

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $id = htmlspecialchars(trim($_POST['id_user']));
        $newPrivilegeLevel = htmlspecialchars(trim($_POST['privilege_level']));
        $errors = [];
    
        if(empty($id)) {
            $errors['id'] = "Nelze identifikovat uživatele";
        }

        if(empty($newPrivilegeLevel)) {
            $errors['newPrivilegeLevel'] = "Zadejte úroveň přístupu uživatele";
        }
    
        if(empty($errors)) {
            $userDB->editPrivilegeLevel($id, $newPrivilegeLevel);
            $_SESSION["editPrivilegeSuccess"] = "Privilegium bylo upraveno. Změny se projeví po příštím přihlášení uživatele";
            header("Location: users.php");
            exit();
        }
    }
?>

<div class="container mb-5">
    <?php if(isset($errors['id'])) : ?>
        <div class="alert alert-danger mt-3"><?php echo $errors['id'];?></div>
    <?php endif; ?>

    <?php if(isset($errors['newPrivilegeLevel'])) : ?>
        <div class="alert alert-danger mt-3"><?php echo $errors['newPrivilegeLevel'];?></div>
    <?php endif; ?>

    <?php if(isset($editPrivilegeSuccess)) : ?>
        <div class="alert alert-success mt-3"><?php echo $editPrivilegeSuccess;?></div>
    <?php endif; ?>

    
    <h1 class="text-center mt-3 mb-5">Uživatelé</h1>
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION["openUserFail"])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION["openUserFail"]; unset($_SESSION["openUserFail"]); ?>
                </div>
            <?php endif; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Email</th>
                        <th>Úroveň přístupu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id_user']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="d-flex align-items-center" style="gap:5px;">
                                    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($user['id_user']); ?>">
                                    <select name="privilege_level" class="form-select form-select-sm">
                                        <option value="1" <?php if ($user['privilege_level'] == 1) echo 'selected'; ?>>Uživatel</option>
                                        <option value="2" <?php if ($user['privilege_level'] == 2) echo 'selected'; ?>>Správce</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary ml-4">Uložit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="container">
                <a href="./admin.php" class="btn btn-primary">Zpět</a>
            </div>
        </div>
    </div>