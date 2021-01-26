<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

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
    $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ?, hasAvatar = ?, avatarImage = ? WHERE id = ?");
    $stmt->execute(array($user['fullname'], $user['phone'], $user['hasAvatar'], $user['avatarImage'], $user['id']));
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

function resetPassword($code, $password)
{
  global $db;
  $check = checkValidCodeResetPassword($code);
  if ($check) {
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET code=?, password=? WHERE code=?");
    $stmt->execute(array('', $hashPassword, $code));
    return true;
  }
  return false;
}

function findUserByEmail($email) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute(array(strtolower($email)));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function createPost($userId, $content, $postImage) {
    global $db;
    $stmt = $db->prepare("INSERT INTO posts (userId, content, createdAt, postImage) VALUE (?, ?, CURRENT_TIMESTAMP(), ?)");
    $stmt->execute(array($userId, $content, $postImage));
    return $db->lastInsertId();
}

function getNewFeedsForUserId($userId) {
    global $db;
    $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, u.avatarImage , p.content, p.createdAt, p.postImage FROM posts as p LEFT JOIN users as u ON u.id = p.userId WHERE p.userId = $userId ORDER BY createdAt DESC");
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

function sendEmail($to, $name, $subject, $content)
{

  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  //Server settings
  $mail->isSMTP();                                         // Send using SMTP
  $mail->CharSet    = 'UTF-8';
  $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                // Enable SMTP authentication
  $mail->Username   = 'nguy3n.web1.hcmus@gmail.com';       // SMTP username
  $mail->Password   = 'bmd1eTNu';                          // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
  $mail->Port       = 587;                                 // TCP port to connect to

  //Recipients
  $mail->setFrom('nguy3n.web1.hcmus@gmail.com', 'NGUY3N47');
  $mail->addAddress($to, $name);                           // Add a recipient

  // Content
  $mail->isHTML(true);                                     // Set email format to HTML
  $mail->Subject = $subject;
  $mail->Body    = $content;
  $mail->AltBody = $content;

  $mail->send();
  return true;
}

function generateRandomString($length)
{
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function sendCodeResetPassword($user)
{
  global $db, $BASE_URL;
  $code = generateRandomString(6);
  $stmt = $db->prepare("UPDATE users SET code=? WHERE id=?");
  $stmt->execute(array($code, $user['id']));

  $bodyContent = "We received a request to reset your password.<br />Enter the following password reset code:<br /> <strong>$code</strong><br />"."Alternatively, you can directly change your password.<br />". "<a href='$BASE_URL/reset-password.php?code=$code' style='background-color:#166fe5;border:1px ;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:160px;-webkit-text-size-adjust:none;mso-hide:all;' target='_blank'>Change Password</a>";
  sendEmail($user['email'], $user['fullname'], $code.' is your account recovery code', $bodyContent);
}

function checkValidCodeResetPassword($code)
{
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE code=?");
  $stmt->execute(array($code));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    return true;
  }
  return false;
}

function getEmailbyCode($code)
{
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE code=?");
  $stmt->execute(array($code));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  return $user['email'];
}