<?php
require_once __DIR__ . '/../database-config/ProductsDB.php';
require_once __DIR__ . '/../pages/layouts/head.php';

$filters = [
    'category' => $_GET['category'] ?? null,
    'genre' => $_GET['genre'] ?? null,
    'min_age' => $_GET['min_age'] ?? null,
    'max_price' => $_GET['max_price'] ?? null,
];

$productsDB = new ProductsDB();
$products = $productsDB->fetchFiltered($filters);
?>

<div class="container-fluid mt-4">
    <div class="row">
        <aside class="col-md-3 mb-4">
            <h4>Vyhledávání</h4>
            <form method="GET" class="mb-3">
                <div class="mb-2">
                    <label for="max_price" class="form-label">Maximální cena</label>
                    <input type="number" class="form-control" name="max_price" id="max_price" value="<?= htmlspecialchars($maxPrice ?? '') ?>">
                </div>
                <div class="mb-2">
                    <label for="category" class="form-label">Kategorie</label>
                    <input type="number" class="form-control" name="category" id="category" value="<?= htmlspecialchars($category ?? '') ?>">
                </div>
                <div class="mb-2">
                    <label for="genre" class="form-label">Žánr</label>
                    <input type="number" class="form-control" name="genre" id="genre" value="<?= htmlspecialchars($genre ?? '') ?>">
                </div>
                <div class="mb-2">
                    <label for="min_age" class="form-label">Min. věk</label>
                    <input type="number" class="form-control" name="min_age" id="min_age" value="<?= htmlspecialchars($minAge ?? '') ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Filtrovat</button>
            </form>
        </aside>

        <section class="col-md-9">
            <h2 class="mb-4">Katalog her</h2>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                        <img src="/~adaj12/test/assets/img/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p><strong>Cena:</strong> <?= number_format($product['price'], 2) ?> Kč</p>
                                <p><small>Žánr: <?= htmlspecialchars($product['genre_name'] ?? '-') ?></small><br>
                                   <small>Kategorie: <?= htmlspecialchars($product['category_name'] ?? '-') ?></small><br>
                                   <small>Věk: <?= $product['min_age'] ?>+</small></p>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Přidat do košíku</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<?php require_once __DIR__ . '/../pages/layouts/footer.php'; ?>
