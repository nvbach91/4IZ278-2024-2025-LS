<?php

    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $img = trim($_POST['img'] ?? '');

    if ($name === '' || $price === '' || !is_numeric($price)) {
        $error = "Name and numeric price are required.";
    } else {
        
        $timestamp = $_POST['last_updated'] ?? '';

        $args = [
            'columns' => ['last_updated'],
            'conditions' => ["good_id = $goodId"]
        ];

        $currentGood = $goodsDB->fetch($args)[0] ?? null;

        if (!$currentGood) {
            die('Product not found.');
        }

        $currentTimestamp = $currentGood['last_updated'];

        if($timestamp == $currentTimestamp){
            $args = [
                'update' => 'name = :name, description = :description, price = :price, img = :img',
                'conditions' => ["good_id = :id"],
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'img' => $img,
                'id' => $goodId
            ];
            $goodsDB->update($args);

            header("Location: edit-item.php?good_id=$goodId&method=optimistic&success=1");
            exit;
        } else {
            $error = "This product was updated in the meantime. Your proposed changes are here:";
            $_SESSION['fail'] = true;
        }
        
    }

?>