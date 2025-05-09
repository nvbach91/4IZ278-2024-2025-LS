<?php require_once __DIR__ . '/database/GoodsDB.php'; ?>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$goodsDB = new GoodsDB();
$numberOfItemsPerPage = 10;
$numberOfRecords = $goodsDB->countAll();
$numberOfPages = ceil($numberOfRecords / $numberOfItemsPerPage);
$goodsDatabase = $goodsDB->fetchPage($numberOfItemsPerPage, $page);

?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($goodsDatabase as $item): ?>
            <tr>
                <td><?= $item['good_id']; ?></td>
                <td><?= $item['name']; ?></td>
                <td><?= $item['price']; ?></td>
                <td>
                    <a class="btn btn-secondary card-link" href="editPessimistic.php?id=<?php echo urlencode($item['good_id']); ?>">Edit Pessimistic</a>
                    <a class="btn btn-secondary card-link" href="editOptimistic.php?id=<?php echo urlencode($item['good_id']); ?>">Edit Optimistic</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<ul class="pagination">
      <?php for ($i = 1; $i <= $numberOfPages; $i++): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
      <?php endfor; ?>
    </ul>