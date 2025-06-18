<?php 
    require_once __DIR__ . '/../database/DB_Scripts/GearlistItemDB.php';
    require_once __DIR__ . '/../database/DB_Scripts/GearlistDB.php';

    session_start();

    $loggedIn = false;
    if (isset($_COOKIE["loginSuccess"])) {
        $loggedIn = true;
    }

    $gearlistId = isset($_GET["id"]) ? (int)$_GET["id"] : null;
    $userId = (int)$_SESSION["user_id"];

    if (!$gearlistId) {
        $_SESSION["deleteGearlistError"] = "Neplatné ID gearlistu.";
        header("Location: ../gearlists.php");
        exit();
    }

    $gearlistItemDB = new GearlistItemDB();
    $gearlistDB = new GearlistDB();

    $gearlistOwnerId = $gearlistDB->getGearlistOwner($gearlistId);
    if($userId !== $gearlistOwnerId || !$loggedIn) {
        $_SESSION["deleteGearlistError"] = "Nemáte oprávnění odstranit tento gearlist.";
        header("Location: ../gearlists.php");
        exit();
    }

    $gearlistItemDB->deleteItemsByGearlistId($gearlistId);
    $gearlistDB->deleteGearlist($gearlistId);
    $_SESSION["deleteSuccess"] = "Gearlist byl úspěšně odstraněn.";
    header("Location: ../gearlists.php");
    exit();
?>