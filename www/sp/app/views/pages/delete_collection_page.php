<?php

require __DIR__ . "/../partials/head.php";
?>

<div class="container mt-5">
    <form action="" method="POST" class="text-center">
        <h2 class="mb-4 text-danger">Are you sure you want to delete your collection?</h2>
        <input type="hidden" name="yes" value="yes">
        <button type="submit" class="btn btn-danger">Yes, delete</button>
    </form>
</div>

<?php
include __DIR__ . "/../partials/foot.html";
?>