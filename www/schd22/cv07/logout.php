<?php
// Zrušíme cookie
setcookie('name', '', time() - 3600);
header('Location: index.php');
exit();