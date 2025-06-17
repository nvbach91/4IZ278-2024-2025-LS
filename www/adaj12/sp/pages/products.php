<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/php/productsHelpers.php';
require_once __DIR__ . '/../pages/layouts/head.php';

handleAddToCart();

$added = isset($_GET['added']);
$categories = getCategories();
$genres = getGenres();
$filters = getFilters();
$products = getProducts($filters);
?>

<?php if ($added): ?>
    <div class="alert alert-success">Produkt byl přidán do košíku.</div>
<?php endif; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <aside class="col-md-3 mb-4">
            <h4>Vyhledávání</h4>
            <form method="GET" class="mb-3">
                <div class="mb-2">
                    <label for="max_price" class="form-label">Maximální cena</label>
                    <input type="number" class="form-control" name="max_price" id="max_price"
                        value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
                </div>
                <div class="mb-2">
                    <label for="category" class="form-label">Kategorie</label>
                    <select class="form-control" name="category" id="category">
                        <option value="">-- Vše --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="genre" class="form-label">Žánr</label>
                    <select class="form-control" name="genre" id="genre">
                        <option value="">-- Vše --</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['id'] ?>" <?= (isset($_GET['genre']) && $_GET['genre'] == $genre['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genre['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="min_age" class="form-label">Min. věk</label>
                    <input type="number" class="form-control" name="min_age" id="min_age"
                        value="<?= htmlspecialchars($_GET['min_age'] ?? '') ?>">
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
                            <img src="/~adaj12/test/assets/img/<?= htmlspecialchars($product['image']) ?>" class="card-img-top product-card-img" alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p><strong>Cena:</strong> <?= number_format($product['price'], 2) ?> Kč</p>
                                <p>
                                    <small>Žánr: <?= htmlspecialchars($product['genre_name'] ?? '-') ?></small><br>
                                    <small>Kategorie: <?= htmlspecialchars($product['category_name'] ?? '-') ?></small><br>
                                    <small>Věk: <?= $product['min_age'] ?>+</small>
                                </p>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                    <input type="number" name="quantity" value="1" min="1" max="<?= (int)$product['stock'] ?>" class="form-control d-inline product-qty-input">
                                    <button type="submit" class="btn btn-primary btn-sm">Přidat do košíku</button>
                                </form>
                                <a href="game.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn btn-outline-secondary btn-sm ms-2">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<?php require_once __DIR__ . '/../pages/layouts/footer.php'; ?>
