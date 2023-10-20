<?php
session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM food_order WHERE user_id = :user_id ORDER BY order_date DESC";

    //execution de la requete
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ":user_id" => $_SESSION["shop_id"]
    ));
    $orders = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="mb-12">
            <h2 class="mt-12 text-4xl font-bold">Mes commandes</h2>
        </div>
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
                            <a href="order-details?id=<?php echo $order["id"]; ?>" class="btn btn-sm btn-primary">Voir</a>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>