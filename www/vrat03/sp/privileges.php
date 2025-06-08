<?php require_once __DIR__ . '/prefix.php'; ?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>
<?php
$log = AppLogger::getLogger();

if(!isset($_SESSION)) {   
    session_start(); 
        
}

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_after_login'] = getURL();
    $log->warning('Unauthorized access attempt by unauthenticated user', [
        'requested_url' => getURL()
    ]);
    header('Location: '.$urlPrefix.'/login.php');
    exit();
}
$loggedUserPrivilege = $_SESSION['user']['privilege'];

function hasPrivilege($requiredPrivilege) {
    global $urlPrefix;
    global $loggedUserPrivilege;
    global $log;
    if (isset($_SESSION['user']['privilege']) && $loggedUserPrivilege < $requiredPrivilege){
        $_SESSION['redirect_after_login'] = getURL();
        $log->warning('Unauthorized access attempt', [
            'requested_url' => getURL(),
            'user_id' => $_SESSION['user']['id'],
            'required_privilege' => $requiredPrivilege,
            'user_privilege' => $loggedUserPrivilege
        ]);
        header('Location: '.$urlPrefix.'/login.php');
        exit();    
    }
}

function getURL(){
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else 
        $link = "http";

    $link .= "://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
    return $link;
}

?>