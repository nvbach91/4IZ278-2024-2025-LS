<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 
    require_once __DIR__ . '/database/DB_Scripts/GearlistDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    $gearlistDB = new GearlistDB();

    if(isset($_SESSION["openGearlistFail"])) {
        $openGearlistFail = $_SESSION["openGearlistFail"];
        unset($_SESSION["openGearlistFail"]);
    }

    if(isset($_SESSION["deleteGearlistError"])) {
        $deleteGearlistError = $_SESSION["deleteGearlistError"];
        unset($_SESSION["deleteGearlistError"]);
    }

    if(isset($_SESSION["deleteSuccess"])) {
        $deleteSuccess = $_SESSION["deleteSuccess"];
        unset($_SESSION["deleteSuccess"]);
    }

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $userId = htmlspecialchars(trim($_POST['user_id']));
        $name= htmlspecialchars(trim($_POST['name']));
        $note = htmlspecialchars(trim($_POST['note']));

        $errors = [];
    
        if(empty($userId)) {
            $errors['userId'] = "Nelze identifikovat uživatele";
        }

        if(empty($name)) {
            $errors['name'] = "Nový gearlist musí mít jméno";
        }
    
        if(empty($errors)) {
            $gearlistId = $gearlistDB->createGearlist($userId, $name, $note);
            $_SESSION["createGearlistSuccess"] = "Gearlist byl úspěšně vytvořen.";
            header("Location: ./gearlist.php?id=" . $gearlistId);
            exit();
        }
    }

?>

<div class="container mt-5 mb-5">
    <?php if(isset($openGearlisFail)) :?>
        <div class="alert alert-danger mt-3"><?php echo $openGearlisFail;?></div>
    <?php endif; ?>

    <?php if(isset($deleteGearlistError)) :?>
        <div class="alert alert-danger mt-3"><?php echo $deleteGearlistError;?></div>
    <?php endif; ?>

    <?php if(isset($deleteSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $deleteSuccess;?></div>
    <?php endif; ?>

<?php if($loggedIn): 
        $userId = $_SESSION['user_id'] ?? null;
        $gearlistDB = new GearlistDB();
        $gearlists = $gearlistDB->getAllGearlists($userId);    
    ?>
    <h1 class="text-center">Vaše Gearlisty</h1>
    <div class="row mt-4">

        <div class="col-md-4 mb-4">
            <div class="card p-4 shadow-sm mb-4">
                <h4 class="mb-3">Správa gearlistů</h4>
                <p>Zde můžete spravovat své gearlisty, vytvářet nové a mazat stávající.</p>
                <button type="button"
                    class="btn btn-primary w-100 mb-3"
                    data-bs-toggle="modal"
                    data-bs-target="#createGearlistModal">
                    Vytvořit nový gearlist
                </button>
            </div>
        </div>

        <div class="col-md-8">
            <?php if (count($gearlists) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Název</th>
                                <th>Vytvořeno</th>
                                <th>Poznámka</th>
                                <th>Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gearlists as $gearlist): 
                                $date = new DateTime($gearlist["created_at"]);
                                $date = $date->format("d.m.Y H:i:s");
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($gearlist["name"]); ?></td>
                                    <td><?php echo htmlspecialchars($date); ?></td>
                                    <td><?php echo htmlspecialchars($gearlist["description"]); ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm mb-1" href="gearlist.php?id=<?php echo htmlspecialchars($gearlist['id_gearlist']); ?>">Zobrazit</a>
                                        <a href="./scripts/deleteGearlist.php?id=<?php echo htmlspecialchars($gearlist['id_gearlist']); ?>" class="btn btn-danger btn-sm mb-1">Odstranit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>Nemáte žádné gearlisty.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal pro vytvoření gearlistu -->
    <div class="modal fade p-5" id="createGearlistModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-5">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <div class="mb-2">
                        <label for="name">Název gearlistu</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="note">Poznámka ke gearlistu</label>
                        <input type="text" name="note" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Vytvořit gearlist</button>
                </form>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h3 class="text-center mt-3 mb-5">Pro přístup ke svým gearlistům musíte být přihlášeni</h3>
        <div>
            <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
            <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
        </div>
    <?php endif; ?>

</div>

<?php require __DIR__ . '/includes/foot.php'; ?>