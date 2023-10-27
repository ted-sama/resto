<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category";

    //execution de la requete
    $results = $conn->query($sql)->fetchAll();
    $nb = 1;
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!doctype html>
<html>

<head>
    <title>Gestion des catégories | Miamiam</title>
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div class="mb-12">
                <h2 class="mt-12 text-4xl font-bold">Gestion des catégories</h2>
            </div>
            <?php
            if (isset($_SESSION["add"])) {
                echo $_SESSION["add"];
                unset($_SESSION["add"]);
            }
            if (isset($_SESSION["delete"])) {
                echo $_SESSION["delete"];
                unset($_SESSION["delete"]);
            }
            if (isset($_SESSION["update"])) {
                echo $_SESSION["update"];
                unset($_SESSION["update"]);
            }
            ?>
            <a href="add-category.php" class="btn btn-primary mb-5">Ajouter des catégories</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>A l'affiche</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) { ?>
                        <tr>
                            <td>
                                <?php echo $nb++; ?>
                            </td>
                            <td>
                                <div>
                                    <div class="avatar">
                                        <div class="w-16 rounded">
                                            <img src="../assets/category/<?php echo $result["image_name"]; ?>" alt="Image de la catégorie" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $result["title"]; ?>
                            </td>
                            <td>
                                <?php echo $result["featured"]; ?>
                            </td>
                            <td>
                                <?php echo $result["active"]; ?>
                            </td>
                            <td>
                                <div class="space-y-1">
                                    <a href="update-category.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-primary">Modifier</a>
                                    <a href="delete-category.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-error">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>