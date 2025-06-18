<?php 
    require __DIR__ . '/includes/head.php'; 
    require __DIR__ . '/requires/navbar.php'; 
    require_once __DIR__ . '/database/DB_Scripts/ProductDB.php';
    require_once __DIR__ . '/database/DB_Scripts/GearlistDB.php';
    require_once __DIR__ . '/database/DB_Scripts/GearlistItemDB.php';
    require_once __DIR__ . '/database/DB_Scripts/CustomItemDB.php';

    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    if(isset($_SESSION["createGearlistSuccess"])) {
        $createGearlistSuccess = $_SESSION["createGearlistSuccess"];
        unset($_SESSION["createGearlistSuccess"]);
    }

    $gearlistId = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $gearlistDB = new GearlistDB();
    $gearlist = $gearlistDB->getGearlist($gearlistId);

    $userId = (int)$_SESSION['user_id'];

    $productDB = new ProductDB();

    $customItemDB = new CustomItemDB();
    $customItems = $customItemDB->getAllItems($userId);

    $gearlistItemDB = new GearlistItemDB();
    $gearlistItems = $gearlistItemDB->getGearlistItems($gearlistId);

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $userId = htmlspecialchars(trim($_POST['user_id']));
        $gearlistId = htmlspecialchars(trim($_POST['gearlist_id']));
        $quantity = htmlspecialchars(trim($_POST['quantity']));
        $note = htmlspecialchars(trim($_POST['note']));

        if (!empty($_POST['product_id']) && $_POST['product_id'] !== 'null') {
            $productId = htmlspecialchars(trim($_POST['product_id']));
        } else {
            $productId = null;
        }

        if (!empty($_POST['custom_item_id']) && $_POST['custom_item_id'] !== 'null') {
            $customItemId = htmlspecialchars(trim($_POST['custom_item_id']));
        } else {
            $customItemId = null;
        }

        $errors = [];
    
        if(empty($userId)) {
            $errors['userId'] = "Nelze identifikovat uživatele";
        }

        if(empty($gearlistId)) {
            $errors['gearlistId'] = "Gearlist nelze identifikovat";
        }

        if(empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
            $errors['quantity'] = "Zadejte platné množství položky";
        }
    
        if(empty($errors)) {
            if($productId == null) {
                $gearlistItemDB->addCustomItem($gearlistId, $customItemId, $quantity, $note);
            } elseif($customItemId == null) {
                $gearlistItemDB->addProductItem($gearlistId, $productId, $quantity, $note);
            } else {
                $errors['item'] = "Musíte vybrat buď produkt nebo vlastní položku";
            }
            $_SESSION["addSuccess"] = "Položka byla úspěšně přidána do gearlistu.";
            header("Location: ./gearlist.php?id=" . $gearlistId);
            exit();
        }
    }

    
    $totalWeight = 0;
    foreach ($gearlistItems as $gearlistItem) {
        if (!empty($gearlistItem['product']) && is_null($gearlistItem['custom_item'])) {
            $item = $productDB->getProductById($gearlistItem['product']);
        } elseif (!empty($gearlistItem['custom_item']) && is_null($gearlistItem['product'])) {
            $item = $customItemDB->getCustomItem($gearlistItem['custom_item']);
        } else {
            $item = null;
        }
        if ($item && isset($item['weight'])) {
            $totalWeight += $item['weight'] * $gearlistItem['quantity'];
        }
    }


?>

<div class="container mt-5">
    <?php if(isset($createGearlistSuccess)) :?>
        <div class="alert alert-success mt-3"><?php echo $createGearlistSuccess;?></div>
    <?php endif; ?>
    <?php if($loggedIn): ?>
        <h1 class="text-center mb-4">Gearlist</h1>
        <div class="row">
            <!-- Levá třetina: info a akce -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm mb-4">
                    <h3 class="mb-3"><?php echo htmlspecialchars($gearlist['name']);?></h3>
                    <p><b>Počet položek:</b> <?php echo count($gearlistItems); ?> ks</p>
                    <p><b>Celková váha:</b> <?php echo htmlspecialchars($totalWeight)?> gramů</p>
                    <p><b>Popis:</b> <?php echo htmlspecialchars($gearlist['description']); ?></p>
                    <button type="button"
                            class="btn btn-primary w-100 mt-3"
                            data-bs-toggle="modal"
                            data-bs-target="#addItemModal">
                        Přidat položku do gearlistu
                    </button>
                </div>
            </div>
            <!-- Pravé dvě třetiny: položky v tabulce -->
            <div class="col-md-8">
                <h4 class="mb-3">Položky v gearlistu</h4>
                <?php if(count($gearlistItems) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Název</th>
                                    <th>Množství</th>
                                    <th>Váha (g/ks)</th>
                                    <th>Poznámka</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($gearlistItems as $gearlistItem): 
                                    if (!empty($gearlistItem['product']) && is_null($gearlistItem['custom_item'])) {
                                        $item = $productDB->getProductById($gearlistItem['product']);
                                    } elseif (!empty($gearlistItem['custom_item']) && is_null($gearlistItem['product'])) {
                                        $item = $customItemDB->getCustomItem($gearlistItem['custom_item']);
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($gearlistItem['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($item['weight']); ?></td>
                                        <td><?php echo !is_null($gearlistItem['note']) ? htmlspecialchars($gearlistItem['note']) : '-'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Gearlist je prázdný.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="modal fade p-5" id="addItemModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-5">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                        <input type="hidden" name="gearlist_id" value="<?php echo htmlspecialchars($gearlistId); ?>">

                        <div class="mb-2">
                            <label for="product_id">Vyberte produkt z katalogu:</label>
                            <select class="form-select" name="product_id">
                                <option value="null">-- žádný --</option>
                                <?php foreach ($productDB->getAllProducts() as $product): ?>
                                    <option value="<?php echo htmlspecialchars($product['id_product']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="custom_item_id">Nebo vyber vlastní předmět:</label>
                            <select class="form-select" name="custom_item_id">
                                <option value="null">-- žádný --</option>
                                <?php foreach ($customItems as $customItem): ?>
                                    <option value="<?php echo htmlspecialchars($customItem['id_custom_item']); ?>">
                                        <?php echo htmlspecialchars($customItem['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="quantity">Množství:</label>
                            <input type="number" class="form-control" name="quantity" value="1" min="1" required>
                        </div>

                        <div class="mb-2">
                            <label for="note">Poznámka:</label>
                            <textarea class="form-control" name="note" placeholder="Zde můžete přidat poznámku k položce"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Přidat do gearlistu</button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <h3 class="text-center mt-3 mb-5">Pro přístup k tomuto gearlistu musíte být přihlášeni</h3>
        <div>
            <a class="btn btn-primary" href="./login.php">Přihlásit se</a>
            <a class="btn btn-secondary" href="./register.php">Registrovat se</a>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/foot.php'; ?>