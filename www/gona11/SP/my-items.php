<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 

    require_once __DIR__ . '/database/DB_Scripts/GearlistDB.php';
    require_once __DIR__ . '/database/DB_Scripts/CustomItemDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    if(isset($_SESSION["createItemSuccess"])) {
        $createItemSuccess = $_SESSION["createItemSuccess"];
        unset($_SESSION["createItemSuccess"]);
    }

    if(isset($_SESSION["deleteItemFail"])) {
        $deleteItemFail = $_SESSION["deleteItemFail"];
        unset($_SESSION["deleteItemFail"]);
    }

    if(isset($_SESSION["deleteItemSuccess"])) {
        $deleteItemFail = $_SESSION["deleteItemSuccess"];
        unset($_SESSION["deleteItemSuccess"]);
    }

    $userId = $_SESSION['user_id'];
    $gearlistDB = new GearlistDB();

    $customItemDB = new CustomItemDB();
    $customItems = $customItemDB->getAllItems($userId);

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $userId = htmlspecialchars(trim($_POST['user_id']));
        $name= htmlspecialchars(trim($_POST['name']));
        $description = htmlspecialchars(trim($_POST['description']));
        $weight = htmlspecialchars(trim($_POST['weight']));

        $errors = [];
    
        if(empty($userId)) {
            $errors['userId'] = "Nelze identifikovat uživatele";
        }

        if(empty($name)) {
            $errors['name'] = "Nový předmět musí mít jméno";
        }

        if(empty($weight) || !is_numeric($weight)) {
            $errors['weight'] = "Zadejte platnou váhu předmětu v gramech.";
        }
    
        if(empty($errors)) {
            $customItemDB->createCustomItem($userId, $name, $description, $weight);
            $_SESSION["createItemSuccess"] = "Předmět byl úspěšně vytvořen.";
            header("Location: ./my-items.php");
            exit();
        }
    }
?>

<div class="container mt-5">

    <?php if(isset($createItemSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($createItemSuccess);?></div>
    <?php endif; ?>

    <?php if(isset($deleteItemFail)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($deleteItemFail);?></div>
    <?php endif; ?>

    <?php if(isset($deleteItemSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($deleteItemSuccess);?></div>
    <?php endif; ?>

    <?php if($loggedIn): ?>
        <h1 class="text-center">Moje předměty</h1>
        <p class="lead text-center">Zde si můžete zobrazit a spravovat své vlastní předměty.</p>
        <div class="row mt-4">
            <?php foreach ($customItems as $item): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h4>
                            <p class="mb-1"><b>Váha:</b> <?php echo htmlspecialchars($item['weight']); ?> g</p>
                            <p class="mb-3"><b>Poznámka:</b> <?php echo htmlspecialchars($item['description']); ?></p>
                            <div class="mt-auto d-flex justify-content-end">
                                <a href="./scripts/deleteCustomItem.php?id=<?php echo htmlspecialchars($item['id_custom_item']);?>" class="btn btn-danger btn-sm">Odstranit předmět</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="container mt-3 mb-3">
            <button type="button"
                class="btn btn-primary mb-3"
                data-bs-toggle="modal"
                data-bs-target="#createItem">
                Vytvořit vlastní předmět
            </button>
        </div>

        <div class="modal fade p-5" id="createItem" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-5">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    
                        <div class="mb-2">
                            <label for="name">Název předmětu</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label for="note">Váha předmětu (g)</label>
                            <input type="number" name="weight" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label for="note">Poznámka k předmětu</label>
                            <input type="text" name="description" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Vytvořit předmět</button>
                    </form>
                </div>
            </div>
        </div>
        <?php else: ?>
            <h3 class="text-center mt-3 mb-5">Pro přístup k vlastním předmětům musíte být přihlášeni</h3>
            <div>
                <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
                <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
            </div>
        <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/foot.php'; ?>