<?php
session_start();

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $quantity = $_GET["quantity"];

    $found = false;
    for ($i = 0; $i < count($_SESSION["shop_cart"]); $i++) {
        if ($_SESSION["shop_cart"][$i]["id"] == $id) {
            $_SESSION["shop_cart"][$i]["quantity"] += $quantity;
            $found = true;
        }
    }

    if (!$found) {
        array_push($_SESSION["shop_cart"], array("id" => $id, "quantity" => $quantity));
    }
}

if (isset($_GET["category"])) {
    $_SESSION["add"] = "<div class='alert alert-success fade-alert mb-5'><span>Le produit a été ajouté au panier avec succès !</span></div>";
    header("Location: foods?category=" . $_GET["category"]);
} else {
    $_SESSION["add"] = "<div class='alert alert-success fade-alert mb-5'><span>Le produit a été ajouté au panier avec succès !</span></div>";
    header("Location: foods");
}
