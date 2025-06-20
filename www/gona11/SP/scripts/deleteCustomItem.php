<?php 
    require_once __DIR__ . '/../database/DB_Scripts/GearlistItemDB.php';
    require_once __DIR__ . '/../database/DB_Scripts/CustomItemDB.php';

    session_start();

    $customItemId = isset($_GET['id']) ? (int)$_GET['id'] : null;

    if (!$customItemId) {
        $_SESSION["deleteError"] = "Neplatné ID předmětu.";
        header("Location: ../custom-items.php");
        exit();
    }

    $gearlistItemDB = new GearlistItemDB();
    $customItemDB = new CustomItemDB();

    $customItemOwner = $customItemDB->getCustomItemOwner($customItemId);
    if($customItemOwner !== $_SESSION["user_id"]) {
        $_SESSION["deleteItemFail"] = "Nemáte oprávnění odstranit tento předmět.";
        header("Location: ../custom-items.php");
        exit();
    }

    $gearlistItemDB->deleteCustomItemsById($customItemId);
    $customItemDB->deleteCustomItem($customItemId);

    $_SESSION["deleteItemSuccess"] = "Předmět byl úspěšně odstraněn.";
    header("Location: ../my-items.php");
    exit();
?>