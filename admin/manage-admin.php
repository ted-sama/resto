<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

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

<!doctype html>
<html>

<head>
    <title>Administration du site | Miamiam</title>
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div class="mb-12">
                <h2 class="mt-12 text-4xl font-bold">Administration du site</h2>
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
                                    <a href="update-admin.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-primary">Modifier</a>
                                    <a href="update-password.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-secondary">Modifier le mot de
                                        passe</a>
                                    <a href="delete-admin.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-error">Supprimer</a>
                                </div>
                            <td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>