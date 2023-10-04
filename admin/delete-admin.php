<?php session_start();
require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "DELETE FROM admin WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    //redirection
    $_SESSION["delete"] = "<div class='alert alert-success fade-alert mb-5'><span>L'utisateur a été supprimé avec succès !</span></div>";
    header("Location: manage-admin.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>