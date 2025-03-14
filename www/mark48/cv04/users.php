<?php

require_once 'classes/User.php';
require_once 'utils.php';


require 'head.php';

$users = fetchUsers();

?>

<h1>Users</h1>
<?php foreach ($users as $user) : ?>
    <div class="card">
        <div class="card-body">
            <p class="card-text"><?php echo $user->name ?></p>
            <p class="card-text">Email: <?php echo $user->email ?></p>
        </div>
    </div>
<?php endforeach;


require 'footer.php';
?>