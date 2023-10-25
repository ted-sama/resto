<?php session_start();
include('partials/menu.php');

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM admin WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    $admin = $results->fetch();

    $current_full_name = $admin["full_name"];
    $current_username = $admin["username"];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["username"]) && isset($_POST["full_name"])) {
    try {
        //creation de la requete SQL
        $sql = "UPDATE admin SET username = :username, full_name = :full_name  WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_GET["id"];

        $results->bindParam(":id", $id);
        $results->bindParam(":username", $_POST["username"]);
        $results->bindParam(":full_name", $_POST["full_name"]);
        $results->execute();

        //redirection
        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>L'utisateur a été modifié avec succès !</span></div>";
        header("Location: manage-admin.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier un administrateur | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Modifier un utilisateur</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form method="POST">
                            <label class="label">
                                <span class="label-text">Prénom NOM</span>
                            </label>
                            <input type="text" name="full_name" id="full_name" value="<?php echo $current_full_name ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Nom d'utilisateur</span>
                            </label>
                            <input type="text" name="username" id="username" value="<?php echo $current_username ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Modifier" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</body>