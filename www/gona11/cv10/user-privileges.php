<?php require_once __DIR__ . '/database/UsersDB.php'?>
<?php include __DIR__ . '/includes/head.php'?>
    <?php require __DIR__ . '/requires/navbar.php'?>

    <?php
    $loggedIn = false;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
    }
    
    if($loggedIn && isset($_SESSION["privilege"])) {
        $privilege = $_SESSION["privilege"];
    }

    
    $usersDB = new UsersDB();
    $users = $usersDB->getAllUsers();
    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $newPrivileges = $_POST['privileges'];
        $errorTexts = [];
        foreach($users as $user) {
            $errorText = [];
            $userId = $user['user_id'];
            $oldPrivilege = $user['privilege'];
            $newPrivilege = isset($newPrivileges[$userId]) ? (int)trim($newPrivileges[$userId]) : null;

        
            if(!is_numeric($newPrivilege)) {
                $error = true;
                $errorText['privilege'] = "Privilege can only be a number";
            }
            if($newPrivilege === null) {
                $error = true;
                $errorText['privilege'] = "Privilege is required";
            }
            if($newPrivilege < 1 || $newPrivilege > 3) {
                $error = true;
                $errorText['privilege'] = "Privilege must be between 1 and 3";
            }
            $errorTexts[$userId] = $errorText;

            if(!empty($errorText)) {
                $errorText['privilege'] = "Privilege not updated";
            }
        
            if(empty($errorText) && $oldPrivilege != $newPrivilege) {
                var_dump($newPrivilege);
                var_dump($oldPrivilege);
                var_dump($userId);
                $usersDB->updateUserPrivilege($userId, $newPrivilege);
                $_SESSION["editPrivilegeSuccess"] = "One or more privilege successfully updated";
                header("Location: index.php");
                exit;
            }
        }
    }
    ?>
    <?php if($loggedIn) :?>
        <?php if($privilege >= 3): ?>
            <div class="flex">
                <h3 class="mt-3">Edit user priviliges</h3>
                <form class="form-signup flex-form container text-center" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="m-1 d-flex flex-row align-items-center justify-content-around w-50">
                        <p class="mr-5 font-weight-bold">User name</p>
                        <p class="mr-5 font-weight-bold">Email</p>
                        <p class="mr-5 font-weight-bold">Privilege</p>
                    </div>
                    <?php foreach($users as $user): ?>
                        <?php if(isset($errorTexts[$user['user_id']]['privilege'])) : ?>
                            <div class="alert alert-danger mt-3"><?php echo $errorTexts[$user['user_id']]['privilege'];?></div>
                        <?php endif; ?>
                    <div class="m-1 d-flex flex-row justify-content-between align-items-center w-50">
                        <p class="aling-self-center w-25"><?php echo $user['name']; ?></p>
                        <p class="aling-self-center w-25"><?php echo $user['email']; ?></p>
                        <input type="number" name="privileges[<?php echo $user['user_id']; ?>]" class="form-control w-25" value="<?php echo $user['privilege']; ?>" min="1" max="3" required>
                    </div>
                    <?php endforeach;?>
                    <button class="btn btn-primary pl-4 pr-4" type="submit">Edit</button>
                </form>
            </div>
        <?php else: ?>
            <div class="mt-3 flex">
                <h3>Access denied.</h3>
                <p>Reason: You do not have the privilege to access this page.</p>
                <div class="row ml-2 mt-4">
                    <a href="index.php" class="btn btn-primary mr-3 pl-4 pr-4">Back to products</a>
                </div>
            </div>
        <?php endif;?>
    <?php else: ?>
        <div class="mt-3 flex">
            <h3>Page "User privileges" is avalible only for logged in users</h3>
            <div class="row ml-2 mt-4">
                <a href="login.php" class="btn btn-primary mr-3 pl-4 pr-4">Log in</a>
                <a href="register.php" class="btn btn-secondary pl-4 pr-4">Register</a>
            </div>
        </div>
    <?php endif;?>
    

<?php include __DIR__ . '/includes/foot.php'?>