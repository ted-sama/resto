<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

if (isset($_POST["title"]) && isset($_POST["featured"]) && isset($_POST["active"]) && isset($_FILES['file'])) {
    try {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($file_tmp_name, "../assets/category/$file_name");

        //creation de la requete SQL
        $sql = "INSERT INTO category (title, image_name, featured, active) VALUES (:title, :image_name, :featured, :active)";
        $results = $conn->prepare($sql);
        $title = $_POST["title"];
        $image_name = $file_name;
        $featured = $_POST["featured"];
        $active = $_POST["active"];

        $results->bindParam(":title", $title);
        $results->bindParam(":image_name", $image_name);
        $results->bindParam(":featured", $featured);
        $results->bindParam(":active", $active);
        $results->execute();

        //redirection
        $_SESSION["add"] = "<div class='alert alert-success fade-alert mb-5'><span>La catégorie a été créée avec succès !</span></div>";
        header("Location: manage-category.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter une catégorie | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Ajouter une catégorie</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <label class="label">
                                <span class="label-text">Nom de la catégorie</span>
                            </label>
                            <input type="text" name="title" id="title" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Image de la catégorie</span>
                            </label>
                            <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs mb-4" required />

                            <div class="mb-4">
                                <label class="label">
                                    <span class="label-text">A l'affiche</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Oui</span>
                                    <input type="radio" name="featured" value="True" class="radio checked:bg-purple-700" />
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Non</span>
                                    <input type="radio" name="featured" value="False" class="radio checked:bg-purple-700" checked />
                                </label>

                                <label class="label">
                                    <span class="label-text">Actif</span>
                                </label>

                                <label class="label cursor-pointer">
                                    <span class="label-text">Oui</span>
                                    <input type="radio" name="active" value="True" class="radio checked:bg-purple-700" checked />
                                </label>
                                <label class="label cursor-pointer">
                                    <span class="label-text">Non</span>
                                    <input type="radio" name="active" value="False" class="radio checked:bg-purple-700" />
                                </label>
                            </div>

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