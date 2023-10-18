<?php
session_start();
require("connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category WHERE active = 'True'";

    //execution de la requete
    $results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="mb-12">
            <h2 class="mt-12 text-4xl font-bold">Catégories</h2>
        </div>
        <div class="grid grid-cols-3 gap-x-8 gap-y-10 items-center mt-12">
            <?php foreach ($results as $result) { ?>
                <div class="h-[20rem] rounded-lg bg-no-repeat bg-cover relative shadow-xl" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.85) 100%), url('assets/category/<?php echo $result["image_name"]; ?>') no-repeat; background-size: cover;">
                    <div class="absolute p-6 bottom-0">
                        <h2 class="text-4xl text-white font-semibold mb-4"><?php echo $result["title"]; ?></h2>
                        <a href="foods?category=<?php echo $result["id"]; ?>" class="btn btn-primary">Voir les plats</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>