<?php
$host = "db";
$dbname = "resto";
$dbusername = "root";
$dbpassword = "root";

$conn = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
