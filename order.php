<?php
session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

if (isset($_POST["submit"])) {
    $delivery_address = $_POST["delivery_address"];
    $comment = $_POST["comment"];
    $total_price = 0;

    try {
        //creation de la requete SQL
        $sql = "SELECT * FROM food";

        //execution de la requete
        $food_results = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $nb = 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    for ($i = 0; $i < count($_SESSION["shop_cart"]); $i++) {
        foreach ($food_results as $result) {
            if ($result["id"] === $_SESSION["shop_cart"][$i]["id"]) {
                $total_price += $result["price"] * $_SESSION["shop_cart"][$i]["quantity"];
            }
        }
    }

    try {
        //creation de la requete SQL
        $sql = "INSERT INTO food_order (user_id, delivery_address, comment, price, status) VALUES (:user_id, :delivery_address, :comment, :price, :status)";

        //execution de la requete
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":user_id" => $_SESSION["shop_id"],
            ":delivery_address" => $delivery_address,
            ":comment" => $comment,
            ":price" => $total_price,
            ":status" => "En attente"
        ));

        $food_order_id = $conn->lastInsertId();

        for ($i = 0; $i < count($_SESSION["shop_cart"]); $i++) {
            $sql = "INSERT INTO in_order (food_order_id, food_id, quantity) VALUES (:food_order_id, :food_id, :quantity)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(
                ":food_order_id" => $food_order_id,
                ":food_id" => $_SESSION["shop_cart"][$i]["id"],
                ":quantity" => $_SESSION["shop_cart"][$i]["quantity"]
            ));
        }

        $_SESSION["shop_cart"] = array();
        header("Location: index");
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider la commande | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="wrapper">
            <div>
                <h1 class="text-4xl font-bold text-center mb-8">Valider la commande</h1>
                <p class="text-center mb-12">Vous n'êtes plus qu'à quelques clics de vous régaler !</p>
            </div>
            <div class="flex justify-center">
                <div class="card w-[32rem] bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Adresse de livraison</span>
                            </label>
                            <input type="text" name="delivery_address" id="delivery_address" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Commentaire</span>
                            </label>
                            <textarea class="textarea textarea-bordered w-full h-40 max-h-64 max-w-xl mb-4" name="comment" id="comment"></textarea>
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Commander" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>