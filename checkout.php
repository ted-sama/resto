<?php session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM food";

    //execution de la requete
    $food_results = $conn->query($sql)->fetchAll();
    $nb = 1;
} catch (PDOException $e) {
    echo $e->getMessage();
}

$total_price = 0;
if (!empty($food_results) && !empty($_SESSION["shop_cart"])) {
    for ($i = 0; $i < count($_SESSION["shop_cart"]); $i++) {
        foreach ($food_results as $result) {
            if ($result["id"] === $_SESSION["shop_cart"][$i]["id"] && $_SESSION["shop_cart"][$i]["quantity"] > 0 && $result["price"] > 0) {
                $total_price += $result["price"] * $_SESSION["shop_cart"][$i]["quantity"];
            }
        }
    }
}

$quantity = null;
$cart_item = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="mb-12">
            <h2 class="mt-12 text-4xl font-bold">Votre panier</h2>
        </div>
        <div class="grid grid-cols-3">
            <table class="table col-span-2">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Nom</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION["shop_cart"] as $item) {
                        foreach ($food_results as $result) {
                            if ($result["id"] === $item["id"]) {
                                $quantity = $item["quantity"];
                                $cart_item = $result;
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
                                            <img src="assets/food/<?php echo $cart_item["image_name"]; ?>" alt="Image du plat" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $cart_item["title"]; ?>
                            </td>
                            <td>
                                <div class="flex items-center space-x-4">
                                    <a href="remove-from-cart?quantity=1&id=<?php echo $cart_item["id"]; ?>" class="btn btn-sm btn-square" <?php if ($quantity <= 1) { ?> disabled <?php } ?> title="Baisser la quantité">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                        </svg>
                                    </a>
                                    <span><?php echo $quantity; ?></span>
                                    <a href="add-more?quantity=1&id=<?php echo $cart_item["id"]; ?>" class="btn btn-sm btn-square" title="Augmenter la quantité">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-black">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php echo number_format(($cart_item["price"] * $quantity), 2); ?> €
                            </td>
                            <td>
                                <a href="delete-from-cart?id=<?php echo $cart_item["id"]; ?>" class="btn btn-sm btn-square" title="Supprimer du panier">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-black">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="ml-12">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between">
                            <h2 class="text-2xl font-bold">Total à payer</h2>
                            <h2 class="text-2xl font-bold"><?php echo number_format($total_price, 2); ?> €</h2>
                        </div>
                        <div class="card-actions justify-center mt-32">
                            <a href="order" class="btn btn-primary w-full">Payer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>