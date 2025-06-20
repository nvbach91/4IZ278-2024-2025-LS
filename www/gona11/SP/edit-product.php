<?php require __DIR__ . "/includes/head.php"; ?>
<?php require __DIR__ . "/requires/navbar.php"; ?> 
<?php require_once __DIR__ . '/database/DB_Scripts/ProductDB.php'?>
<?php require_once __DIR__ . '/database/DB_Scripts/CategoryDB.php'; ?>

<?php 
    $loggedIn = false;
    $privilegeLevel = 0;
    if (isset($_COOKIE['loginSuccess'])) {
        $loggedIn = true;
        $privilegeLevel = $_SESSION['privilege'] ?? 1;
    }

    $productId = isset($_GET["id"]) ? (int)$_GET["id"] : null;
    $productDB = new ProductDB();
    $product = $productDB->getProductById($productId);

    $categoryDB = new CategoryDB();
    $categories = $categoryDB->getAllCategories();

    $isSubmittedForm = !empty($_POST);
    if($isSubmittedForm) {
        $id = htmlspecialchars(trim($_POST['id_product']));
        $name = htmlspecialchars(trim($_POST['name']));
        $price = htmlspecialchars(trim($_POST['price']));
        $category = htmlspecialchars(trim($_POST['category']));
        $weight = htmlspecialchars(trim($_POST['weight']));
        $stock = htmlspecialchars(trim($_POST['stock']));
        $description = htmlspecialchars(trim($_POST['description']));
        $image = htmlspecialchars(trim($_POST['image']));
    
        $errors = [];
    
        if(empty($name)) {
            $errors['name'] = "Zadejte jméno produktu";
        }
    
        if(empty($price)) {
            $errors['price'] = "Zadejte cenu produktu";
        }
    
        if(!ctype_digit($price) || $price <= 0) {
            $errors['price'] = "Cena musí být celé kladné číslo (1 a více)";
        }

        if(empty($weight)) {
            $errors['weight'] = "Zadejte váhu produktu";
        }

        if(empty($stock)) {
            $errors['stock'] = "Zadejte skladovou zásobu produktu";
        }

        if(!ctype_digit($stock) || $stock < 0) {
            $errors['stock'] = "Skladová zásoba musí být celé nezáporné číslo (0 nebo více)";
        }
    
        if(empty($description)) {
            $errors['description'] = "Vyplňte popis produktu";
        }
    
        if(empty($errors)) {
            $productDB->editProduct(
                $id,
                $name,
                $price,
                $category,
                $weight,
                $stock,
                $description,
                $image
            );
            $_SESSION["editProductSuccess"] = "Produkt byl úspěšně upraven.";
            header('Location: ./products.php?category=' . $category);
            exit();
        }
    }
?>

<div class="container">
    <?php if ($loggedIn && $privilegeLevel > 1): ?>
        <h1 class="m-3 text-align">Úprava produktu <?php echo $product['name']; ?></h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="mb-3">
            <label class="form-label">ID produktu</label>
            <input type="text" 
                    class="form-control" 
                    name="id_product" 
                    value="<?php echo htmlspecialchars($product["id_product"]); ?>" 
                    readonly>
        </div>    
        
        <div class="mb-3">
                <label class="form-label">Název produktu</label>
                <input type="text" 
                        class="form-control" 
                        name="name" 
                        value="<?php echo htmlspecialchars($product["name"]); ?>" 
                        required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cena (Kč)</label>
                <input type="number"
                        class="form-control"
                        name="price"
                        value="<?php echo htmlspecialchars($product["price"]); ?>" 
                        required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategorie</label>
                <select class="form-control" name="category" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id_category']); ?>"
                            <?php if ($category['id_category'] == $product['category']) echo 'selected'; ?>
                        >
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Hmotnost (gramy)</label>
                <input type="number"
                        class="form-control"
                        name="weight" 
                        value="<?php echo htmlspecialchars($product["weight"]); ?>" 
                        required>
            </div>
            <div class="mb-3">
                <label class="form-label">Skladem</label>
                <input type="number"
                        class="form-control" 
                        name="stock"
                        value="<?php echo htmlspecialchars($product["stock"]); ?>" 
                        required>
            </div>
            <div class="mb-3">
                <label class="form-label">Popis</label>
                <textarea class="form-control"
                        name="description"><?php echo htmlspecialchars($product["description"]); ?>
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Odkaz na obrázek produktu</label>
                <input class="form-control border p-2 mb-2 bg-light text-dark rounded-2 shadow-sm"
                        type="text" 
                        value="<?php echo htmlspecialchars($product["image"]); ?>"
                        name="image"
                >
            </div>
            <button type="submit" class="btn btn-primary">Uložit změny</button>
    <?php else: ?>
        <div class="alert alert-danger mt-3">Nemáte oprávnění pro přístup k této stránce.</div>
        <a class="btn btn-primary m-3" href="./index.php">Zpět na hlavní stránku</a>
    <?php endif; ?>
</div>
    
