<?php

$currentUserId = $_SESSION['user_id'];
$timeout = 300;

$args = [
    'columns' => ['lock_user_id', 'lock_timestamp'],
    'conditions' => ["good_id = $goodId"]
];

$lockData = $goodsDB->fetch($args)[0];

$lockingUser = $lockData['lock_user_id'];
$lockTime = $lockData['lock_timestamp'] ? strtotime($lockData['lock_timestamp']) : 0;
$now = time();

if(is_null($lockingUser) || ($now - $lockTime) > $timeout || $lockingUser == $currentUserId){
    if($lockingUser != $currentUserId){
        $args = [
            'update' => 'lock_user_id = :user_id, lock_timestamp = NOW()',
            'conditions' => ['good_id = :id'],
            'user_id' => $currentUserId,
            'id' => $goodId
        ];
        $goodsDB->update($args);
    }
} else {
    die("This record is currently being edited by someone else. Try again later.");
}


?>