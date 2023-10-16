<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "DELETE FROM user WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    //redirection
    $_SESSION["delete"] = "<div class='alert alert-success fade-alert mb-5'><span>L'utilisateur a été supprimé avec succès !</span></div>";
    header("Location: manage-user.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}
