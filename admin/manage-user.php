<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM user";

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
    <title>Gestion des utilisateurs | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Gestion des utilisateurs</h1>
            <?php
            if (isset($_SESSION["delete"])) {
                echo $_SESSION["delete"];
                unset($_SESSION["delete"]);
            }
            if (isset($_SESSION["update"])) {
                echo $_SESSION["update"];
                unset($_SESSION["update"]);
            }
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prénom Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
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
                                <?php echo $result["first_name"]; ?> <?php echo $result["last_name"]; ?>
                            </td>
                            <td>
                                <?php echo $result["email"]; ?>
                            </td>
                            <td>
                                <?php echo $result["phone"]; ?>
                            </td>
                            <td>
                                <div class="space-y-1">
                                    <a href="update-user.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-primary">Modifier</a>
                                    <a href="delete-user.php?id=<?php echo $result["id"]; ?>" class="btn btn-sm btn-error">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>


<?php include('partials/footer.php'); ?>