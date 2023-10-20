<?php
session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

if (isset($_GET["id"])) {
    $order_id = $_GET["id"];

    try {
        //creation de la requete SQL
        $sql = "SELECT * FROM food_order WHERE id = :order_id";

        //execution de la requete
        $results = $conn->prepare($sql);
        $results->bindParam(":order_id", $order_id);
        $results->execute();
        $order = $results->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    try {
        //creation de la requete SQL
        $sql = "SELECT * FROM in_order WHERE food_order_id = :order_id";

        //execution de la requete
        $results = $conn->prepare($sql);
        $results->bindParam(":order_id", $order_id);
        $results->execute();
        $order_items = $results->fetchAll();
        $nb = 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    try {
        $sql = "SELECT * FROM food";
        $food_results = $conn->query($sql)->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $total_price = 0;
    for ($i = 0; $i < count($order_items); $i++) {
        foreach ($food_results as $result) {
            if ($result["id"] === $order_items[$i]["food_id"]) {
                $total_price += $result["price"] * $order_items[$i]["quantity"];
            }
        }
    }
} else {
    header("Location: index");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos commandes | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="mb-12">
            <h2 class="mt-12 text-4xl font-bold">Détails de commande</h2>
            <h3 class="mt-2 text-xl font-semibold">Commande n° <?php echo $order["id"]; ?></h2>

        </div>
        <h2 class="text-2xl mt-12">Contenu de la commande</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item) {
                    foreach ($food_results as $result) {
                        if ($result["id"] === $item["food_id"]) {
                            $order_item = $result;
                        }
                    } ?>
                    <tr>
                        <td>
                            <?php echo $nb++; ?>
                        </td>
                        <td>
                            <div>
                                <div class="avatar">
                                    <div class="w-16 rounded">
                                        <img src="assets/food/<?php echo $order_item["image_name"]; ?>" alt="Image de la catégorie" />
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php echo $order_item["title"]; ?>
                        </td>
                        <td>
                            <?php echo $item["quantity"]; ?>
                        </td>
                        <td>
                            <?php echo $order_item["price"] * $item["quantity"]; ?> €
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="mt-8">
            <h2 class="text-2xl font-bold">Prix total</h2>
            <h2 class="text-2xl font-bold"><?php echo $total_price; ?> €</h2>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>