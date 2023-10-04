<?php session_start();
require("connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category";

    //execution de la requete
    $results = $conn->query($sql)->fetchAll();
    $nb = 1;
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="mb-8">
            <h1 class="text-4xl">Les catégories</h1>
        </div>
        <div class="grid grid-cols-3 gap-14">
            <?php foreach ($results as $result) { ?>
                <a href="#" class="transition ease-in-out hover:shadow-2xl duration-300">
                    <div class="rounded-md object-cover w-full h-96"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.85) 100%), url('images/category/<?php echo $result["image_name"]; ?>') no-repeat; background-size: cover;">
                        <div class="flex relative h-full">
                            <h2 class="text-2xl text-white font-semibold absolute bottom-0 p-4">
                                <?php echo $result["title"]; ?>
                            </h2>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>