<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM category WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    $category = $results->fetch();

    $current_title = $category["title"];
    $current_image_name = $category["image_name"];
    $current_featured = $category["featured"];
    $current_active = $category["active"];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["title"]) && isset($_POST["featured"]) && isset($_POST["active"])) {
    if ($_FILES['file']['name'] != "") {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($file_tmp_name, "../assets/category/$file_name");
        $new_image_name = $file_name;
    } else {
        $new_image_name = $current_image_name;
    }

    try {
        //creation de la requete SQL
        $sql = "UPDATE category SET title = :title, image_name = :image_name, featured = :featured, active = :active WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_GET["id"];

        $results->bindParam(":id", $id);
        $results->bindParam(":title", $_POST["title"]);
        $results->bindParam(":image_name", $new_image_name);
        $results->bindParam(":featured", $_POST["featured"]);
        $results->bindParam(":active", $_POST["active"]);
        $results->execute();

        //redirection
        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>La catégorie a été modifiée avec succès !</span></div>";
        header("Location: manage-category.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier la catégorie | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Modifier la catégorie</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div>
                            <label class="label">
                                <span class="label-text">Image actuelle de la catégorie</span>
                            </label>
                            <div class="avatar">
                                <div class="w-16 rounded">
                                    <img src="../assets/category/<?php echo $current_image_name; ?>" alt="Image de la catégorie" />
                                </div>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <label class="label">
                                <span class="label-text">Nom de la catégorie</span>
                            </label>
                            <input type="text" name="title" id="title" required value="<?php echo $current_title ?>" class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Image de la catégorie</span>
                            </label>
                            <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs" />
                            <div class="mb-4">
                                <label class="label">
                                    <span class="label-text">A l'affiche</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Oui</span>
                                    <input type="radio" name="featured" value="True" class="radio checked:bg-purple-700" <?php if ($current_featured === "True") { ?> checked <?php } ?> />
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Non</span>
                                    <input type="radio" name="featured" value="False" class="radio checked:bg-purple-700" <?php if ($current_featured === "False") { ?> checked <?php } ?> />
                                </label>

                                <label class="label">
                                    <span class="label-text">Actif</span>
                                </label>

                                <label class="label cursor-pointer">
                                    <span class="label-text">Oui</span>
                                    <input type="radio" name="active" value="True" class="radio checked:bg-purple-700" <?php if ($current_active === "True") { ?> checked <?php } ?> />
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Non</span>
                                    <input type="radio" name="active" value="False" class="radio checked:bg-purple-700" <?php if ($current_active === "False") { ?> checked <?php } ?> />
                                </label>
                            </div>
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Modifier" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</body>