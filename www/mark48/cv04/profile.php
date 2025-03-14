<?php
require "head.php";

session_start();
require 'classes/User.php';

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    // Clear session after loading and displaying data
    session_unset();
    session_destroy();
} else {
    header('Location: index.php');
    exit();
}
?>

<main>

    <h1>Profile</h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text"><?php echo $user->name ?></p>
            <p class="card-text">Email: <?php echo $user->email ?></p>
        </div>
    </div>

</main>

<?php
require "footer.php";
?>