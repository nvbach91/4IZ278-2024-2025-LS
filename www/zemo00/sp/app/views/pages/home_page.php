<?php

require __DIR__ . "/../partials/head.php";

?>

<div class="container my-5 text-center">
    <h1 class="mb-4">Welcome</h1>
    <a href="<?php echo BASE_URL . "/game_setup_language"; ?>" class="btn btn-primary">Play game</a>

    <p class="lead mb-4">
        Lexio is a place where you can learn vocabulary by creating your own collections of words and practice translations in different languages.
    </p>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card text-start">
                <div class="card-header bg-primary text-white">
                    <strong>How to Get Started</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Create your own <strong>collection</strong> of words.</li>
                    <li class="list-group-item">Use your collection to <strong>play games</strong> and reinforce your memory.</li>
                    <li class="list-group-item">View your <strong>stats</strong> to track progress and performance.</li>
                    <li class="list-group-item"><strong>Repeat!</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php

include __DIR__ . "/../partials/foot.html";

?>