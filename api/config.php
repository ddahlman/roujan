<?php
$username = "root";
$host = "";
$password = "";
$database = "roujan";
header('Content-Type: application/json');

$db = mysqli_connect($host, $username, $password, $database);
mysqli_query($db, "SET NAMES utf8");
?>