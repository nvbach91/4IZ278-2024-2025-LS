<?php
require_once __DIR__ . '/../functions/php/adminProductsHelpers.php';
require_once __DIR__ . '/../pages/layouts/admin-head.php';
?>
<link rel="stylesheet" href="/~adaj12/test/assets/css/admin-products.css">

<div class="container my-5">
    <h2 class="mb-4">Správa produktů</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#productModal" id="addProductBtn">Přidat produkt</button>
    <table class="table table-bordered table-hover bg-white">
        <thead>
            <tr>
                <th>ID</th><th>Název</th><th>Popis</th><th>Detail</th><th>Cena</th><th>Obrázek</th><th>Skladem</th>
                <th>Min. věk</th><th>Max. věk</th><th>Tag</th><th>Žánr</th><th>Kategorie</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= htmlspecialchars($product['detail']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?> Kč</td>
                <td>
                    <?php if ($product['image']): ?>
                        <img src="/~adaj12/test/assets/img/<?= htmlspecialchars($product['image']) ?>" style="max-width:80px;max-height:60px;">
                    <?php endif; ?>
                </td>
                <td><?= (int)$product['stock'] ?></td>
                <td><?= (int)$product['min_age'] ?></td>
                <td><?= (int)$product['max_age'] ?></td>
                <td><?= htmlspecialchars($product['tag']) ?></td>
                <td><?= htmlspecialchars($product['genre_id']) ?></td>
                <td><?= htmlspecialchars($product['category_id']) ?></td>
                <td>
                    <button type="button" class="btn btn-outline-primary btn-sm edit-product-btn"
                        data-id="<?= $product['id'] ?>"
                        data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($product['description'], ENT_QUOTES) ?>"
                        data-detail="<?= htmlspecialchars($product['detail'], ENT_QUOTES) ?>"
                        data-price="<?= htmlspecialchars($product['price'], ENT_QUOTES) ?>"
                        data-image="<?= htmlspecialchars($product['image'], ENT_QUOTES) ?>"
                        data-stock="<?= (int)$product['stock'] ?>"
                        data-min_age="<?= (int)$product['min_age'] ?>"
                        data-max_age="<?= (int)$product['max_age'] ?>"
                        data-tag="<?= htmlspecialchars($product['tag'], ENT_QUOTES) ?>"
                        data-genre_id="<?= (int)$product['genre_id'] ?>"
                        data-category_id="<?= (int)$product['category_id'] ?>"
                        data-bs-toggle="modal"
                        data-bs-target="#productModal"
                    >Upravit</button>
                    <form method="post" action="products-delete.php" style="display:inline-block;" onsubmit="return confirm('Opravdu smazat?')">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Smazat</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal pro přidání produktu -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="products-save.php" class="modal-content" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Produkt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="modal_product_id">
        <div class="mb-2">
            <label class="form-label">Název</label>
            <input type="text" class="form-control" name="name" id="modal_product_name" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Krátký popis</label>
            <input type="text" class="form-control" name="description" id="modal_product_description">
        </div>
        <div class="mb-2">
            <label class="form-label">Detailní popis</label>
            <textarea class="form-control" name="detail" id="modal_product_detail"></textarea>
        </div>
        <div class="mb-2">
            <label class="form-label">Cena (Kč)</label>
            <input type="number" step="0.01" class="form-control" name="price" id="modal_product_price" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Obrázek (název souboru nebo URL)</label>
            <input type="text" class="form-control" name="image" id="modal_product_image">
        </div>
        <div class="mb-2">
            <label class="form-label">Skladem</label>
            <input type="number" min="0" class="form-control" name="stock" id="modal_product_stock" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Minimální věk</label>
            <input type="number" min="0" class="form-control" name="min_age" id="modal_product_min_age">
        </div>
        <div class="mb-2">
            <label class="form-label">Maximální věk</label>
            <input type="number" min="0" class="form-control" name="max_age" id="modal_product_max_age">
        </div>
        <div class="mb-2">
            <label class="form-label">Tag</label>
            <input type="text" class="form-control" name="tag" id="modal_product_tag">
        </div>
        <div class="mb-2">
            <label class="form-label">ID žánru</label>
            <input type="number" min="0" class="form-control" name="genre_id" id="modal_product_genre_id">
        </div>
        <div class="mb-2">
            <label class="form-label">ID kategorie</label>
            <input type="number" min="0" class="form-control" name="category_id" id="modal_product_category_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Uložit</button>
      </div>
    </form>
  </div>
</div>

<script src="/~adaj12/test/functions/javascript/admin-products-modal.js"></script>
<?php require_once __DIR__ . '/../pages/layouts/admin-footer.php'; ?>
