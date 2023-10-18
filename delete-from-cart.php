<?php
session_start();

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    for ($i = 0; $i < count($_SESSION["shop_cart"]); $i++) {
        if ($_SESSION["shop_cart"][$i]["id"] == $id) {
            array_splice($_SESSION["shop_cart"], $i, 1);
        }
    }
}

header("Location: checkout");
exit;
