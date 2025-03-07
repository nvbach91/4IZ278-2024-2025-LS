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
        <div class="profile-picture">
            <img src="<?php echo $user->avatar ?>" alt="user-profile-picture">
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $user->name ?></p>
            <p class="card-text">Email: <?php echo $user->email ?></p>
            <p class="card-text">Phone: <?php echo $user->phone ?></p>
            <p class="card-text">Gender: <?php echo $user->gender ?></p>
        </div>
    </div>

</main>

<?php
require "footer.php";
?>