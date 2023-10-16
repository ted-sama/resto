<?php
session_start();
require("connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category WHERE active = 'True'";

    //execution de la requete
    $cat_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET["category"])) {
    $category_id = $_GET["category"];
    try {
        //creation de la requete SQL
        $sql = "SELECT * FROM food WHERE category_id = :cat_id AND active = 'True'";

        //execution de la requete
        $food_results = $conn->prepare($sql);
        $food_results->bindParam(":cat_id", $category_id);
        $food_results->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    try {
        //creation de la requete SQL
        $sql = "SELECT * FROM food WHERE active = 'True'";

        //execution de la requete
        $food_results = $conn->query($sql)->fetchAll();
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
    <title>La carte | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="mb-12">
            <h2 class="mt-32 text-4xl font-bold">La carte</h2>
        </div>
        <div class="flex space-x-6">
            <a href="foods" class="btn btn-outline btn-accent btn-sm" <?php if (!isset($_GET["category"])) { ?> disabled <?php } ?>>Tout les plats</a>
            <?php foreach ($cat_results as $result) { ?>
                <a href="foods?category=<?php echo $result["id"] ?>" class="btn btn-outline btn-accent btn-sm" <?php if (isset($_GET["category"]) && $_GET["category"] === $result["id"]) { ?> disabled <?php } ?>><?php echo $result["title"] ?></a>
            <?php } ?>
        </div>
        <div class="grid grid-cols-3 gap-x-8 gap-y-10 items-center mt-12">
            <?php foreach ($food_results as $result) { ?>
                <div class="card h-[28rem] bg-base-100 shadow-xl">
                    <figure class="h-48"><img src="assets/food/<?php echo $result["image_name"]; ?>" alt="Shoes" class="object-cover" /></figure>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $result["title"]; ?></h2>
                        <p><?php echo $result["description"]; ?></p>
                        <div class="card-actions justify-between items-center">
                            <h2 class="text-xl font-medium"><?php echo $result["price"]; ?>€</h2>
                            <a href="foods?food=<?php echo $result["id"]; ?>" class="btn btn-primary">Plus de détails</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>