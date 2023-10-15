<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category";
    $cat_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_GET["category"])) {
    $category_id = $_GET["category"];
    try {
        //creation de la requete SQL
        $sql = "SELECT food.*, category.title AS cat_title FROM category INNER JOIN food ON category.id = food.category_id WHERE category.id = :cat_id";

        //execution de la requete
        $results = $conn->prepare($sql);
        $results->bindParam(":cat_id", $category_id);
        $results->execute();
        $nb = 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    try {
        //creation de la requete SQL
        $sql = "SELECT food.*, category.title AS cat_title FROM category INNER JOIN food ON category.id = food.category_id";

        //execution de la requete
        $results = $conn->query($sql)->fetchAll();
        $nb = 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Gestion des plats</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Gestion des plats</h1>
            <?php
            if (isset($_SESSION["add"])) {
                echo $_SESSION["add"];
                unset($_SESSION["add"]);
            }
            if (isset($_SESSION["delete"])) {
                echo $_SESSION["delete"];
                unset($_SESSION["delete"]);
            }
            if (isset($_SESSION["update"])) {
                echo $_SESSION["update"];
                unset($_SESSION["update"]);
            }
            ?>
            <a href="add-food.php" class="btn btn-primary mb-5">Ajouter des plats</a>
            <select name="category" class="select select-bordered w-full max-w-xs mb-4" onchange="handleSelect(this)">
                <option <?php if (!isset($_GET["category"])) { ?> selected <?php } ?> value="manage-alacarte.php">Toutes les catégories</option>
                <?php foreach ($cat_results as $result) { ?>
                    <option <?php if (isset($_GET["category"]) && $_GET["category"] === $result["id"]) { ?> selected <?php } ?> value="manage-alacarte.php?category=<?php echo $result["id"]; ?>"><?php echo $result["title"]; ?></option>
                <?php } ?>
            </select>
            <script>
                function handleSelect(e) {
                    window.location = e.value;
                }
            </script>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>A l'affiche</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) { ?>
                        <tr>
                            <td>
                                <?php echo $nb++; ?>
                            </td>
                            <td>
                                <div>
                                    <div class="avatar">
                                        <div class="w-16 rounded">
                                            <img src="../assets/food/<?php echo $result["image_name"]; ?>" alt="Image de la catégorie" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $result["title"]; ?>
                            </td>
                            <td>
                                <?php echo $result["description"]; ?>
                            </td>
                            <td>
                                <?php echo $result["price"]; ?>
                            </td>
                            <td>
                                <?php echo $result["cat_title"]; ?>
                            </td>
                            <td>
                                <?php echo $result["featured"]; ?>
                            </td>
                            <td>
                                <?php echo $result["active"]; ?>
                            </td>
                            <td>
                                <div class="space-y-1">
                                    <a href="update-food.php?id=<?php echo $result["id"]; ?>" class="btn btn-primary">Modifier</a>
                                    <a href="delete-food.php?id=<?php echo $result["id"]; ?>" class="btn btn-error">Supprimer</a>
                                </div>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<?php include('partials/footer.php'); ?>