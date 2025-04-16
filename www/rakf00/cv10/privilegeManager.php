<?php

function getPrivilege($session){
    if($session == "3"){
        return "admin";
    }
    if($session == "2"){
        return "manager";
    }
    if($session == "1"){
        return "user";
    }
}


?>