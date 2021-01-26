<?php

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

function findUserByUsername($username){
    $content = file_get_contents('./data');
    $users = unserialize($content);
    for ($i = 0; $i < sizeof($users); $i++){
        if($users[$i]['username'] == $username)
            return $users[$i];
    }
    return null;
}

function existsUsername($username){
    global $temp;
    $content = file_get_contents('./data');
    $users = unserialize($content);
    for ($i = 0; $i < sizeof($users); $i++){
        if($users[$i]['username'] == $username)
            return true;
    }
    return false;
}

function getCurrentUser(){
    if(isset($_SESSION['username'])){
        return findUserByUsername($_SESSION['username']);
    }
    return null;
}