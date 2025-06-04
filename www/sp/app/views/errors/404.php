<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container mt-5 text-center">
    <h1 class="display-4 text-danger">404 - Not Found</h1>
    <p class="lead">The page you’re looking for doesn’t exist.</p>
    <a href="<?php echo BASE_URL . "/home"; ?>" class="btn btn-primary mt-3">Back to Home</a>
</div>

<?php

include __DIR__ . "/../partials/foot.html";

?>