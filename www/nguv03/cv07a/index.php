<?php
function countRecords($connection, $tableName) {
    $sql = "SELECT COUNT(*) AS numberOfRecords FROM $tableName;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll()[0]['numberOfRecords'];
};

const DB_SERVER_URL = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_DATABASE = 'cv07';
$connection = new PDO(
    'mysql:host=' . DB_SERVER_URL . ';dbname=' . DB_DATABASE,
    DB_USERNAME,
    DB_PASSWORD,
);
$connection->setAttribute(
    PDO::ATTR_DEFAULT_FETCH_MODE,
    PDO::FETCH_ASSOC,
);
// 20 per page, total 200 records
// 200/20 = 10 pages
// 20 on the last page
$numberOfItemsPerPage = 60;
$numberOfRecords = countRecords($connection, 'players');
$numberOfPages = ceil($numberOfRecords / $numberOfItemsPerPage);
$remainingItemsOnTheLastPage = $numberOfRecords % $numberOfItemsPerPage;
$pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = $numberOfItemsPerPage * ($pageNumber - 1);
$sql = "SELECT * FROM players
        ORDER BY player_id ASC
        LIMIT $numberOfItemsPerPage
        OFFSET $offset
        ;";
// 1 -> 0
// 2 -> 20
// 3 -> 40
$statement = $connection->prepare($sql);
$statement->execute();
$players = $statement->fetchAll();
// setcookie("name", "SOME COOKIE DATA", time() + 3600); # ted + 3600 sekund = 1 hodina
// session_start();
// $_COOKIE
// $_SESSION


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pagination</h1>
    <nav>
        <?php for($i = 0; $i < $numberOfPages; $i += 1) { ?>
            <a
                href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $i + 1; ?>"
            ><?php echo $i + 1; ?></a>
        <?php } ?>
    </nav>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($players as $player): ?>
            <tr>
                <td><?php echo $player['player_id']; ?></td>
                <td><?php echo $player['name']; ?></td>
                <td><?php echo $player['image']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>