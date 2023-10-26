<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

if (isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    try {
        //creation de la requete SQL
        $sql = "SELECT password FROM admin WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_GET["id"];

        $results->bindParam(":id", $id);
        $results->execute();

        $id_password = $results->fetchColumn();

        if ($_POST["current_password"] == $id_password) {
            $sql = "UPDATE admin SET password = :password WHERE id = :id";
            $results = $conn->prepare($sql);

            $results->bindParam(":password", $_POST["new_password"]);
            $results->bindParam(":id", $id);
            $results->execute();

            $_SESSION["update-password"] = "<div class='alert alert-success fade-alert mb-5'><span>Le mot de passe a été modifié avec succès !</span></div>";
            header("Location: manage-admin.php");
        } else {
            $_SESSION["update-password"] = "<div class='alert alert-error fade-alert mb-5'><span>Le mot de passe est incorrect !</span></div>";
            header("Location: manage-admin.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier le mot de passe | Miamiam</title>
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Modifier le mot de passe</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Mot de passe actuel</span>
                            </label>
                            <input type="password" name="current_password" id="current_password" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Nouveau mot de passe</span>
                            </label>
                            <input type="password" name="new_password" id="new_password" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Confirmer le nouveau mot de passe</span>
                            </label>
                            <input type="password" name="confirm_password" id="confirm_password" class="input input-bordered w-full max-w-xs mb-4" required />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Modifier le mot de passe" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>