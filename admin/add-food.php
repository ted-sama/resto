<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT id as cat_id, title as cat_title FROM category";

    //execution de la requete
    $results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["category"]) && isset($_POST["featured"]) && isset($_POST["active"]) && isset($_FILES['file'])) {
    try {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($file_tmp_name, "../assets/food/$file_name");

        //creation de la requete SQL
        $sql = "INSERT INTO food (title, description, price, image_name, category_id, featured, active) VALUES (:title, :description, :price, :image_name, :category_id, :featured, :active)";
        $results = $conn->prepare($sql);
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $image_name = $file_name;
        $category_id = $_POST["category"];
        $featured = $_POST["featured"];
        $active = $_POST["active"];

        $results->bindParam(":title", $title);
        $results->bindParam(":description", $description);
        $results->bindParam(":price", $price);
        $results->bindParam(":image_name", $image_name);
        $results->bindParam(":category_id", $category_id);
        $results->bindParam(":featured", $featured);
        $results->bindParam(":active", $active);
        $results->execute();

        //redirection
        $_SESSION["add"] = "<div class='alert alert-success fade-alert mb-5'><span>La catégorie a été créée avec succès !</span></div>";
        header("Location: manage-alacarte.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un plat</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Ajouter un plat</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label class="label">
                                <span class="label-text">Nom du plat</span>
                            </label>
                            <input type="text" name="title" id="title" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Description du plat</span>
                            </label>
                            <input type="text" name="description" id="description" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Prix du plat</span>
                            </label>
                            <input type="text" name="price" id="price" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Image du plat</span>
                            </label>
                            <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Catégorie du plat</span>
                            </label>
                            <select name="category" class="select select-bordered w-full max-w-xs mb-4">
                                <option disabled selected>Catégorie</option>
                                <?php foreach ($results as $result) { ?>
                                    <option value="<?php echo $result["cat_id"]; ?>"><?php echo $result["cat_title"]; ?></option>
                                <?php } ?>
                            </select>
                            <label class="label">
                                <span class="label-text">A l'affiche</span>
                            </label>
                            <input type="text" name="featured" id="featured" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Actif</span>
                            </label>
                            <input type="text" name="active" id="active" required class="input input-bordered w-full max-w-xs mb-4" />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Ajouter" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>