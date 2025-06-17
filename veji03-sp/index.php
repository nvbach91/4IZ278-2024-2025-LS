<?php
require_once __DIR__ . '/includes/init.php';

$brands = $productsDB->fetchBrands();

$brand = $_GET['brand'] ?? '';
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';
$minRam = $_GET['min_ram'] ?? '';
$maxRam = $_GET['max_ram'] ?? '';
$minBattery = $_GET['min_battery'] ?? '';
$maxBattery = $_GET['max_battery'] ?? '';
$minYear = $_GET['min_year'] ?? '';
$maxYear = $_GET['max_year'] ?? '';
$minDisplay = $_GET['min_display'] ?? '';
$maxDisplay = $_GET['max_display'] ?? '';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$products = $productsDB->fetchFilteredProducts(
    $brand, $minPrice, $maxPrice,
    $minRam, $maxRam,
    $minBattery, $maxBattery,
    $minYear, $maxYear,
    $minDisplay, $maxDisplay,
    $limit, $offset
);

$totalCount = $productsDB->countFilteredProducts(
    $brand, $minPrice, $maxPrice,
    $minRam, $maxRam,
    $minBattery, $maxBattery,
    $minYear, $maxYear,
    $minDisplay, $maxDisplay
);

$totalPages = ceil($totalCount / $limit);


?>

<?php include __DIR__.'/includes/head.php'; ?>
<?php include __DIR__.'/includes/navbar.php'; ?>

<main class="container products-container">
    <div class="row">
        <div class="col-md-3">
            <aside class="sidebar">
                <form method="GET">
                    <div class="filter-group">
                        <label for="brand" class="form-label">Značka</label>
                        <select class="form-select" name="brand" id="brand">
                            <option value="">Všechny</option>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?= $b['id'] ?>" <?= $brand == $b['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="form-label">Cena (Kč)</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_price" class="form-control" placeholder="min" value="<?= htmlspecialchars($minPrice) ?>">
                            <input type="number" name="max_price" class="form-control" placeholder="max" value="<?= htmlspecialchars($maxPrice) ?>">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="form-label">RAM (GB)</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_ram" class="form-control" placeholder="min" value="<?= htmlspecialchars($minRam) ?>">
                            <input type="number" name="max_ram" class="form-control" placeholder="max" value="<?= htmlspecialchars($maxRam) ?>">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="form-label">Baterie (mAh)</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_battery" class="form-control" placeholder="min" value="<?= htmlspecialchars($minBattery) ?>">
                            <input type="number" name="max_battery" class="form-control" placeholder="max" value="<?= htmlspecialchars($maxBattery) ?>">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="form-label">Rok vydání</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_year" class="form-control" placeholder="od" value="<?= htmlspecialchars($minYear) ?>">
                            <input type="number" name="max_year" class="form-control" placeholder="do" value="<?= htmlspecialchars($maxYear) ?>">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="form-label">Displej (palce)</label>
                        <div class="d-flex gap-2">
                            <input type="number" step="0.1" name="min_display" class="form-control" placeholder="min" value="<?= htmlspecialchars($minDisplay) ?>">
                            <input type="number" step="0.1" name="max_display" class="form-control" placeholder="max" value="<?= htmlspecialchars($maxDisplay) ?>">
                        </div>
                    </div>

                    <button class="btn btn-primary btn-search">Filtrovat</button>
                </form>
            </aside>
        </div>
        <div class="col-md-9">
            <section class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <h5><?= htmlspecialchars($product['name']) ?></h5>
                        <p><?= number_format($product['price'], 0, ',', ' ') ?> Kč</p>
                        <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-outline-success btn-sm">Zobrazit</a>
                    </div>
                <?php endforeach; ?>
            </section>

            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php
                        $query = $_GET;
                        $query['page'] = $i;
                        $url = '?' . http_build_query($query);
                        ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $url ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>


<?php include __DIR__.'/includes/footer.php'; ?>
