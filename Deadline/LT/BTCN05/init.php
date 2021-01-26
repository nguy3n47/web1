<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ERROR | E_PARSE);

require_once 'functions.php';
$currentUser = getCurrentUser();