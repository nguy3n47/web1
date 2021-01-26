<?php
$BASE_URL = 'http://localhost:8080';
//Connect to MySQL
try{
    $db = new PDO('mysql:host=localhost;dbname=dkhp;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "! Connection failed !" . $e->getMessage();
    }   
require_once 'function.php';