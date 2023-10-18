<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM food_order ORDER BY order_date DESC";

    //execution de la requete
    $orders = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des commandes | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Gestion des commandes</h1>
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
            <table class="table col-span-2">
                <thead>
                    <tr>
                        <th>Numéro de commande</th>
                        <th>Date</th>
                        <th>Prix</th>
                        <th>Adresse de livraison</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td>
                                <?php echo $order["id"]; ?>
                            </td>
                            <td>
                                <?php echo $order["order_date"]; ?>
                            </td>
                            <td>
                                <?php echo $order["price"]; ?> €
                            </td>
                            <td>
                                <?php echo $order["delivery_address"]; ?>
                            </td>
                            <td>
                                <?php if ($order["status"] === "En attente") { ?>
                                    <div class="badge badge-warning gap-2">
                                        <?php echo $order["status"]; ?>
                                    </div>
                                <?php } else if ($order["status"] === "En cours de livraison") { ?>
                                    <div class="badge badge-primary gap-2">
                                        <?php echo $order["status"]; ?>
                                    </div>
                                <?php } else if ($order["status"] === "Livrée") { ?>
                                    <div class="badge badge-success gap-2">
                                        <?php echo $order["status"]; ?>
                                    </div>
                                <?php } else if ($order["status"] === "Annulée") { ?>
                                    <div class="badge badge-error gap-2">
                                        <?php echo $order["status"]; ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="order-info.php?id=<?php echo $order["id"]; ?>" class="btn btn-sm btn-primary">Gérer</a>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<?php include('partials/footer.php'); ?>