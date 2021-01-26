<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

//Connect to MySQL
try{
    $db = new PDO('mysql:host=localhost;dbname=btcn07;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "! Connection failed !" . $e->getMessage();
    }
require_once 'functions.php';
$currentUser = getCurrentUser();