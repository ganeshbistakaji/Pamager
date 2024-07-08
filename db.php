<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// hostname
$dbHost = "localhost";

// Database username
$dbUser = "root";

// database password
$dbPass = "";

// Database name
$dbName = "Pamager";

// Creating Connection to Database
try {
    $con = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo $e->getMessage();
}
