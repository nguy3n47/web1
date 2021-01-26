<?php

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

function findUserById($id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function CreateUser($fullname, $email, $password){
    global $db;
    $stmt = $db->prepare("INSERT INTO users (email, password, fullname) VALUE (?, ?, ?)");
    $stmt->execute(array($email, $password, $fullname));
    return $db->lastInsertId();
}

function updateUser($user) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ?, hasAvatar = ? WHERE id = ?");
    $stmt->execute(array($user['fullname'], $user['phone'], $user['hasAvatar'], $user['id']));
    return $user;
}
  
function updateUserPassword($userId, $hashPassword) {
    global $db;
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute(array($hashPassword, $userId));
}

function ChangeUserPassword($email, $password){
    global $db;
	$stmt = $db->prepare("UPDATE users SET password=? WHERE email=?");
    $stmt->execute (array($password,$email)); 
}

function findUserByEmail($email) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(array(strtolower($email)));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function createPost($userId, $content) {
    global $db;
    $stmt = $db->prepare("INSERT INTO posts (userId, content, createdAt) VALUE (?, ?, CURRENT_TIMESTAMP())");
    $stmt->execute(array($userId, $content));
    return $db->lastInsertId();
}

function getNewFeedsForUserId($userId) {
    global $db;
    $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId WHERE p.userId = $userId ORDER BY createdAt DESC");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}


function getCurrentUser(){
    if(isset($_SESSION['userId'])){
        return findUserById($_SESSION['userId']);
    }
    return null;
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
    $width = ($max_height / $height) * $width;
    $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
    $height = ($max_width / $width) * $height;
    $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}