<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

//Connect to MySQL
try{
    $db = new PDO('mysql:host=sql202.epizy.com;dbname=epiz_27092401_web1;charset=utf8', 'epiz_27092401', 'caoqbYIfCHv');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "! Connection failed !" . $e->getMessage();
    }
require_once 'functions.php';
$currentUser = getCurrentUser();