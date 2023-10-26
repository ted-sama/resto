<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT id, title FROM category";

    //execution de la requete
    $category_results = $conn->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM food WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    $food = $results->fetch();

    $current_title = $food["title"];
    $current_description = $food["description"];
    $current_price = $food["price"];
    $current_image_name = $food["image_name"];
    $current_category_id = $food["category_id"];
    $current_featured = $food["featured"];
    $current_active = $food["active"];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["featured"]) && isset($_POST["active"])) {
    if ($_FILES['file']['name'] != "") {
        $file_name = $_FILES['file']['name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        move_uploaded_file($file_tmp_name, "../assets/food/$file_name");
        $new_image_name = $file_name;
    } else {
        $new_image_name = $current_image_name;
    }

    try {
        //creation de la requete SQL
        $sql = "UPDATE food SET title = :title, description = :description, price = :price, image_name = :image_name, category_id = :category_id, featured = :featured, active = :active WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_GET["id"];

        $results->bindParam(":id", $id);
        $results->bindParam(":title", $_POST["title"]);
        $results->bindParam(":description", $_POST["description"]);
        $results->bindParam(":price", $_POST["price"]);
        $results->bindParam(":image_name", $new_image_name);
        $results->bindParam(":category_id", $_POST["category"]);
        $results->bindParam(":featured", $_POST["featured"]);
        $results->bindParam(":active", $_POST["active"]);
        $results->execute();

        //redirection
        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>Le plat a été modifié avec succès !</span></div>";
        header("Location: manage-alacarte.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier le plat | Miamiam</title>
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Modifier le plat</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div>
                            <label class="label">
                                <span class="label-text">Image actuelle du plat</span>
                            </label>
                            <div class="avatar">
                                <div class="w-16 rounded">
                                    <img src="../assets/food/<?php echo $current_image_name; ?>" alt="Image du plat" />
                                </div>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <label class="label">
                                <span class="label-text">Nom du plat</span>
                            </label>
                            <input type="text" name="title" id="title" required value="<?php echo $current_title ?>" class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Description du plat</span>
                            </label>
                            <input type="text" name="description" id="description" required value="<?php echo $current_description ?>" class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Prix du plat</span>
                            </label>
                            <input type="text" name="price" id="price" required value="<?php echo $current_price ?>" class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Image du plat</span>
                            </label>
                            <input type="file" name="file" class="file-input file-input-bordered w-full max-w-xs" />
                            <select name="category" class="select select-bordered w-full max-w-xs mb-4">
                                <option disabled>Catégorie</option>
                                <?php foreach ($category_results as $result) { ?>
                                    <option value="<?php echo $result["id"]; ?>" <?php if ($result["id"] === $current_category_id) { ?> selected <?php } ?>><?php echo $result["title"]; ?></option>
                                <?php } ?>
                            </select>
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
    <?php require("components/footer.php"); ?>
</body>