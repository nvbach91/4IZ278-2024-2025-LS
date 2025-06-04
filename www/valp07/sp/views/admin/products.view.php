<?php require __DIR__ . '/../../incl/header.php'; ?>
<main class="container pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="my-4">Shop Name</h1>
                <div class="container my-4">
                    <div class="border p-4 rounded">
                        <form method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by name or description" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                <button type="submit" name="search_submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                        <form method="GET">
                            <input type="hidden" name="filter_submit" value="1">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="brand" value="Apple" id="brandApple"
                                            <?php if (isset($_GET['brand']) && $_GET['brand'] === 'Apple') echo 'checked'; ?>>
                                        <label class="form-check-label" for="brandApple">Apple</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="brand" value="Samsung" id="brandSamsung"
                                            <?php if (isset($_GET['brand']) && $_GET['brand'] === 'Samsung') echo 'checked'; ?>>
                                        <label class="form-check-label" for="brandSamsung">Samsung</label>
                                    </div>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="screenSize" class="form-label">Screen Size:
                                        <span id="screenSizeValue"><?php echo isset($_GET['screen_size']) ? htmlspecialchars($_GET['screen_size']) : 5.5; ?></span>"
                                    </label>
                                    <input type="range" class="form-range" name="screen_size" min="4" max="7" step="0.1" id="screenSize"
                                        value="<?php echo isset($_GET['screen_size']) ? htmlspecialchars($_GET['screen_size']) : 5.5; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($):
                                        <span id="priceValue"><?php echo isset($_GET['price']) ? htmlspecialchars($_GET['price']) : 1000; ?></span>
                                    </label>
                                    <input type="range" class="form-range" name="price" min="100" max="2000" step="50" id="price"
                                        value="<?php echo isset($_GET['price']) ? htmlspecialchars($_GET['price']) : 1000; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="ram" class="form-label">RAM (GB):
                                        <span id="ramValue"><?php echo isset($_GET['ram']) ? htmlspecialchars($_GET['ram']) : 8; ?></span>
                                    </label>
                                    <input type="range" class="form-range" name="ram" min="2" max="16" step="1" id="ram"
                                        value="<?php echo isset($_GET['ram']) ? htmlspecialchars($_GET['ram']) : 8; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="storage" class="form-label">Storage (GB):
                                        <span id="storageValue"><?php echo isset($_GET['storage']) ? htmlspecialchars($_GET['storage']) : 128; ?></span>
                                    </label>
                                    <input type="range" class="form-range" name="storage" min="32" max="512" step="32" id="storage"
                                        value="<?php echo isset($_GET['storage']) ? htmlspecialchars($_GET['storage']) : 128; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="battery" class="form-label">Battery (mAh):
                                        <span id="batteryValue"><?php echo isset($_GET['battery']) ? htmlspecialchars($_GET['battery']) : 4000; ?></span>
                                    </label>
                                    <input type="range" class="form-range" name="battery" min="2000" max="6000" step="100" id="battery"
                                        value="<?php echo isset($_GET['battery']) ? htmlspecialchars($_GET['battery']) : 4000; ?>">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="createProduct.php" class="btn btn-outline-warning w-100">Create Product</a>
                </div>
            </div>
            <div class="col-lg-9">

                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100" onclick="window.location.href='product.php?id=<?php echo $product['id']; ?>'">
                                <div class="card-body">
                                    <img src="<?php echo $product['image'] ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                                    <h4 class="card-title"><?php echo $product['name']; ?></h4>
                                    <h5><?php echo number_format($product['price'], 2), ' ', GLOBAL_CURRENCY; ?></h5>
                                    <p class="card-text"><?php echo $product['description']; ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div onclick="event.stopPropagation();">
                                            <form action="deleteProduct.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<nav aria-label="Page navigation" class="container my-4">
    <ul class="pagination justify-content-center">
        <?php
        $basePath = strtok($_SERVER['REQUEST_URI'], '?');
        $queryParams = $_GET;
        function buildPageUrl($pageNum, $basePath, $queryParams)
        {
            $queryParams['page'] = $pageNum;
            return htmlspecialchars($basePath . '?' . http_build_query($queryParams));
        }
        ?>

        <?php if ($pageNumber > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo buildPageUrl($pageNumber - 1, $basePath, $queryParams); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($i == $pageNumber) ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo buildPageUrl($i, $basePath, $queryParams); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($pageNumber < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo buildPageUrl($pageNumber + 1, $basePath, $queryParams); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sliders = [{
                id: "screenSize",
                span: "screenSizeValue"
            },
            {
                id: "price",
                span: "priceValue"
            },
            {
                id: "ram",
                span: "ramValue"
            },
            {
                id: "storage",
                span: "storageValue"
            },
            {
                id: "battery",
                span: "batteryValue"
            },
        ];

        sliders.forEach(({
            id,
            span
        }) => {
            const input = document.getElementById(id);
            const output = document.getElementById(span);
            if (input && output) {
                output.textContent = input.value;
                input.addEventListener("input", () => {
                    output.textContent = input.value;
                });
            }
        });
    });
</script>
<?php require __DIR__ . '/../../incl/footer.php'; ?>