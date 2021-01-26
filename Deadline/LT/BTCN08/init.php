<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

$BASE_URL = 'http://localhost:8080'; // http://localhost:8080
//Connect to MySQL
try{
    $db = new PDO('mysql:host=localhost;dbname=btcn08;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "! Connection failed !" . $e->getMessage();
    }   

    
    // Load Composer's autoloader
require 'vendor/autoload.php';
require_once 'functions.php';
$currentUser = getCurrentUser();