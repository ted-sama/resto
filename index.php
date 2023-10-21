<?php
session_start();
require("connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM food WHERE featured = 'True' AND active = 'True'";

    //execution de la requete
    $featuredFood_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //select 3 random food
    $sql = "SELECT * FROM food WHERE active = 'True' ORDER BY RAND() LIMIT 3";

    //execution de la requete
    $randomFood_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category WHERE active = 'True' ORDER BY RAND() LIMIT 3";

    //execution de la requete
    $cat_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <section>
            <!-- featured food card -->
            <?php foreach ($featuredFood_results as $food_result) { ?>
                <div class="w-full h-[32rem] rounded-lg bg-no-repeat bg-cover relative" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.85) 100%), url('assets/food/<?php echo $food_result["image_name"]; ?>') no-repeat; background-size: cover;">
                    <div class="absolute p-12 bottom-0">
                        <h2 class="text-4xl text-white font-semibold mb-4"><?php echo $food_result["title"]; ?></h2>
                        <p class="text-white font-semibold mb-4"><?php echo $food_result["description"]; ?></p>
                        <a href="add-to-cart?quantity=1&id=<?php echo $food_result["id"]; ?>" class="btn btn-primary">Ajouter au panier</a>
                    </div>
                </div>
            <?php } ?>
        </section>
        <section>
            <!-- random food card -->
            <h2 class="mt-32 text-4xl font-medium">Plats du moment</h2>
            <div class="grid grid-cols-3 gap-8 items-center mt-12">
                <?php foreach ($randomFood_results as $result) { ?>
                    <div class="card h-[28rem] bg-base-100 shadow-xl">
                        <figure class="h-48"><img src="assets/food/<?php echo $result["image_name"]; ?>" alt="Shoes" class="object-cover" /></figure>
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $result["title"]; ?></h2>
                            <p><?php echo $result["description"]; ?></p>
                            <div class="card-actions justify-between items-center">
                                <h2 class="text-xl font-medium"><?php echo $result["price"]; ?>€</h2>
                                <a href="add-to-cart?quantity=1&id=<?php echo $result["id"]; ?>" class="btn btn-primary">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a href="foods" class="btn btn-outline btn-primary mt-6">Voir tout les plats</a>
        </section>
        <section>
            <!-- categories card -->
            <h2 class="mt-32 text-4xl font-medium">Catégories</h2>
            <div class="grid grid-cols-3 gap-8 items-center mt-12">
                <?php foreach ($cat_results as $cat_result) { ?>
                    <div class="h-[20rem] rounded-xl bg-no-repeat bg-cover relative shadow-xl" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.85) 100%), url('assets/category/<?php echo $cat_result["image_name"]; ?>') no-repeat; background-size: cover;">
                        <div class="absolute p-6 bottom-0">
                            <h2 class="text-4xl text-white font-semibold mb-4"><?php echo $cat_result["title"]; ?></h2>
                            <a href="foods?category=<?php echo $cat_result["id"]; ?>" class="btn btn-primary">Voir les plats</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a href="categories" class="btn btn-outline btn-primary mt-6">Voir toutes les catégories</a>
        </section>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>