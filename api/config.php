<?php
$username = "root";
$host = "";
$password = "";
$db = "roujan";
header('Content-Type: application/json');
/*header('Access-Control-Allow-Methods: GET, POST, PUT');*/


$connection = mysqli_connect($dbhost, $dbusername, $dbpassword, $db);
mysqli_query($connection, "SET NAMES utf8");
?>