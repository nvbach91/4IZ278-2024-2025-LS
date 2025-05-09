<?php

// GET / POST / PUT / DELETE
$data = file_get_contents('https://jsonplaceholder.typicode.com/posts');
// convert to php array

$posts = json_decode($data, true);

// var_dump($posts);


require __DIR__ . '/vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('MY_SUPER_LOG');
$log->pushHandler(new StreamHandler('./logs/main.log.txt', Level::Warning));

// add records to the log
$log->warning('Some warning');
$log->error('Some error');
$log->log(Level::Error, 'Some log');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['userId']; ?></td>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo $post['title']; ?></td>
                    <td><?php echo $post['body']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>