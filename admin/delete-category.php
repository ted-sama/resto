<?php session_start();
require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "DELETE FROM category WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    //redirection
    $_SESSION["delete"] = "<div class='alert alert-success fade-alert mb-5'><span>La catégorie a été supprimé avec succès !</span></div>";
    header("Location: manage-category.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
