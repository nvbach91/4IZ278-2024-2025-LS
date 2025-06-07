<?php

if (!isset($_POST['email'])) {
    http_response_code(401);
    $url = BASE_URL . "/error_401";
    header("Location: $url");
    exit;
}

$email = $_POST['email'];

require __DIR__ . "/../app/utils/mailing.php";
require __DIR__ . "/../app/models/UserDB.php";

$userDB = new UserDB();

$token = bin2hex(random_bytes(32));
$userDB->refreshToken($email, $token);

sendRefreshTokenMail($email, $token);


require __DIR__. "/../app/views/partials/head.php";

?>

<h3>A refreshed verification link has been sent to your email.</h3>

<?php

require __DIR__. "/../app/views/partials/foot.html";

?>