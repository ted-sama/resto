<?php
$host = "localhost";
$dbname = "resto";
$dbusername = "root";
$dbpassword = "root";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>