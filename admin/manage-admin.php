<?php include('partials/menu.php'); ?>

<?php session_start();
require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM admin";

    //execution de la requete
    $results = $conn->query($sql)->fetchAll();
    $nb = 1;
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<script>

</script>

    <!doctype html>
    <html>

    <head>
        <title>Administration du site</title>
    </head>

    <body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Administration du site</h1>
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
            if (isset($_SESSION["update-password"])) {
                echo $_SESSION["update-password"];
                unset($_SESSION["update-password"]);
            }
            ?>
            <a href="add-admin.php" class="btn btn-primary mb-5">Ajouter des utilisateurs</a>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom Nom</th>
                    <th>Utilisateur</th>
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
                            <?php echo $result["full_name"]; ?>
                        </td>
                        <td>
                            <?php echo $result["username"]; ?>
                        </td>
                        <td>
                            <div class="space-y-1">
                                <a href="update-admin.php?id=<?php echo $result["id"]; ?>"
                                   class="btn btn-primary">Modifier</a>
                                <a href="update-password.php?id=<?php echo $result["id"]; ?>"
                                   class="btn btn-secondary">Modifier le mot de
                                    passe</a>
                                <a href="delete-admin.php?id=<?php echo $result["id"]; ?>" class="btn btn-error">Supprimer</a>
                            </div>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    </body>

    </html>


<?php include('partials/footer.php'); ?>