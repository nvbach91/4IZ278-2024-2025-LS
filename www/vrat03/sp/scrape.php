<?php
set_time_limit(0);
$pdo = new PDO("mysql:host=localhost;dbname=sp", "root", "");
$start = isset($_GET['start']) ? (int)$_GET['start'] : null;
$end = isset($_GET['end']) ? (int)$_GET['end'] : null;

if (!$start || !$end || $start > $end) {
    die("Zadej správný rozsah pomocí ?start=ID1&end=ID2");
}

echo "<h2>Scrapování her z BGG (ID $start až $end)</h2>";
echo "<ul>";

for ($id = $start; $id <= $end; $id++) {
    $url = "https://boardgamegeek.com/xmlapi2/thing?id=$id&stats=1";
    $xml = @simplexml_load_file($url);

    if (!$xml || !isset($xml->item)) {
        echo "<li>ID $id žádná data</li>";
        flush(); ob_flush();
        continue;
    }

    $item = $xml->item;
    $name = '';
    foreach ($item->name as $nameTag) {
        if ((string)$nameTag['type'] === 'primary') {
            $name = (string)$nameTag['value'];
            break;
        }
    }
    $minplayers = (int)$item->minplayers['value'];
    $maxplayers = (int)$item->maxplayers['value'];
    $playtime = (int)$item->playingtime['value'];
    $description = strip_tags((string)$item->description);
    $image_thumb = (string)$item->thumbnail;
    $image = (string)$item->image;

    $stmt = $pdo->prepare("SELECT product_id FROM sp_eshop_products WHERE product_id = ?");
    $stmt->execute([$id]);
    $existingProduct = $stmt->fetch();

    if (!$existingProduct) {
        $price = rand(100,1500);
        $quantity = rand(1,15);
        $stmt = $pdo->prepare("INSERT INTO sp_eshop_products 
            (product_id, name, price, img, img_thumb, quantity, description, minplayers, maxplayers, playtime) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id, $name, $price, $image, $image_thumb, $quantity, $description, $minplayers, $maxplayers, $playtime]);
        $product_id = $id;

        foreach ($item->link as $link) {
            if ((string)$link['type'] === 'boardgamecategory') {
                $cat_name = (string)$link['value'];
                $cat_id = (int)$link['id'];
    
                $stmt = $pdo->prepare("SELECT category_id FROM sp_eshop_categories WHERE category_id = ?");
                $stmt->execute([$cat_id]);
                $cat = $stmt->fetch();
    
                if (!$cat) {
                    $stmt = $pdo->prepare("INSERT INTO sp_eshop_categories (category_id, name) VALUES (?, ?)");
                    $stmt->execute([$cat_id, $cat_name]);
                }
    
                $stmt = $pdo->prepare("INSERT INTO sp_eshop_product_category (product_id, category_id) VALUES (?, ?)");
                $stmt->execute([$product_id, $cat_id]);
            }
        }
            
        echo "<li>ID $id – $name OK</li>";
    } else {
        echo "<li>ID $id – $name již existuje</li>";    
    }
    flush(); ob_flush();
}

echo "</ul>";
?>