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
                <td><?= htmlspecialchars($product['genre_text']) ?></td>
                <td><?= htmlspecialchars($product['category_text']) ?></td>
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
                        data-genre_id="<?= $product['genre_id'] ?>"
                        data-category_id="<?= $product['category_id'] ?>"
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

    <?php if ($totalPages > 1): ?>
    <nav aria-label="Stránkování produktů">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

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
            <input type="text" class="form-control" name="description" id="modal_product_description" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Detailní popis</label>
            <textarea class="form-control" name="detail" id="modal_product_detail" required></textarea>
        </div>
        <div class="mb-2">
            <label class="form-label">Cena (Kč)</label>
            <input type="number" step="0.01" class="form-control" name="price" id="modal_product_price" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Obrázek (název souboru nebo URL)</label>
            <input type="text" class="form-control" name="image" id="modal_product_image" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Skladem</label>
            <input type="number" min="0" class="form-control" name="stock" id="modal_product_stock" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Minimální věk</label>
            <input type="number" min="0" class="form-control" name="min_age" id="modal_product_min_age" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Maximální věk</label>
            <input type="number" min="0" class="form-control" name="max_age" id="modal_product_max_age" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Tag</label>
            <input type="text" class="form-control" name="tag" id="modal_product_tag" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Žánr</label>
            <select class="form-select" name="genre_id" id="modal_product_genre_id" required>
                <option value="" disabled selected>Vyber žánr...</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <label class="form-label">Kategorie</label>
            <select class="form-select" name="category_id" id="modal_product_category_id" required>
                <option value="" disabled selected>Vyber kategorii...</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
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
