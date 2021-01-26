<?php

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

function findUserById($id){
    global $db;
	$stmt = $db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute (array($id)); 
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function CreateUser($username,$password){
    global $db;
	$stmt = $db->prepare("INSERT INTO users(username, password) VALUES(?,?)");
$stmt->execute (array($username,$password)); 
return findUserById($db->lastInsertId());
}

function ChangeUserPassword($username, $password){
    global $db;
	$stmt = $db->prepare("UPDATE users SET password=? WHERE username=?");
    $stmt->execute (array($password,$username)); 

}

function findUserByUsername($username){
    global $db;
	$stmt = $db->prepare("SELECT * FROM users WHERE username=?");
$stmt->execute (array($username)); 
return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCurrentUser(){
    if(isset($_SESSION['userId'])){
        return findUserById($_SESSION['userId']);
    }
    return null;
}