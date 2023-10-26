<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

if (isset($_POST["order_id"])) {
    $order_id = $_POST["order_id"];

    try {
        $sql = "UPDATE food_order SET status = :status WHERE id = :order_id";

        $results = $conn->prepare($sql);
        $results->bindParam(":status", $_POST["status"]);
        $results->bindParam(":order_id", $order_id);
        $results->execute();

        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>Commande mise à jour avec succès !</span></div>";
        header("Location: order-info?id=$order_id");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
