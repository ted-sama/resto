<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

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
        //creation de la requete SQL
        $sql = "SELECT * FROM user WHERE id = :user_id";

        //execution de la requete
        $results = $conn->prepare($sql);
        $mon_id = $order["user_id"];
        $results->bindParam(":user_id", $mon_id);
        $results->execute();
        $user = $results->fetch();
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
    header("Location: manage-order");
    exit;
}

?>

<!doctype html>
<html>

<head>
    <title>Détails de la commande | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Détails de la commande</h1>
            <?php
            if (isset($_SESSION["update"])) {
                echo $_SESSION["update"];
                unset($_SESSION["update"]);
            }
            ?>
            <div class="grid grid-cols-3">
                <div class="col-span-1">
                    <h2 class="text-2xl">Commande n° <?php echo $order["id"]; ?></h2>
                    <div class="mt-2">
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
                    </div>
                    <div class="mt-6">
                        <div class="mb-4">
                            <p class="font-bold">Nom :</p>
                            <p><?php echo $user["first_name"]; ?> <?php echo $user["last_name"]; ?></p>
                        </div>
                        <div class="mb-4">
                            <p class="font-bold">Email :</p>
                            <p><?php echo $user["email"]; ?></p>
                        </div>
                        <div class="mb-4">
                            <p class="font-bold">Téléphone :</p>
                            <p><?php echo $user["phone"]; ?></p>
                        </div>
                        <div class="mb-4">
                            <p class="font-bold">Date :</p>
                            <p><?php echo $order["order_date"]; ?></p>
                        </div>
                        <div class="mb-4">
                            <p class="font-bold">Adresse :</p>
                            <p><?php echo $order["delivery_address"]; ?></p>
                        </div>
                        <div class="mb-4">
                            <p class="font-bold">Commentaire :</p>
                            <p><?php echo $order["comment"]; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 ml-12">
                    <div>
                        <h2 class="text-2xl">Modifier le statut</h2>
                        <form class="mt-4" action="update-order.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order["id"]; ?>">
                            <select name="status" class="select select-bordered w-full max-w-xs mb-4">
                                <option value="En attente" <?php if ($order["status"] === "En attente") echo "selected"; ?>>En attente</option>
                                <option value="En cours de livraison" <?php if ($order["status"] === "En cours de livraison") echo "selected"; ?>>En cours de livraison</option>
                                <option value="Livrée" <?php if ($order["status"] === "Livrée") echo "selected"; ?>>Livrée</option>
                                <option value="Annulée" <?php if ($order["status"] === "Annulée") echo "selected"; ?>>Annulée</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </form>
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
                                                    <img src="../assets/food/<?php echo $order_item["image_name"]; ?>" alt="Image de la catégorie" />
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
                                        <?php echo number_format(($order_item["price"] * $item["quantity"]), 2); ?> €
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h2 class="text-2xl">Prix total</h2>
                <h2 class="text-2xl"><?php echo number_format($total_price, 2); ?> €</h2>
            </div>
        </div>
    </main>
</body>

</html>


<?php include('partials/footer.php'); ?>