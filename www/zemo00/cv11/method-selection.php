<?php

include __DIR__ . "/incl/head.html";

$good_id = $_GET['good_id'] ?? null;

if(!$good_id) {
    die("Invalid product ID!");
}

?>

<div class="form-container">

<h3>Select a locking method</h3>

<hr>

<a href="edit-item.php?good_id=<?php echo $good_id; ?>&method=optimistic" class="button">Optimistic</a>
<hr>
<a href="edit-item.php?good_id=<?php echo $good_id; ?>&method=pessimistic" class="button" style="background-color: red;">Pessimistic</a>
<hr>

</div>

<?php

include __DIR__ . "/incl/foot.html";

?>