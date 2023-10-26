<?php session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

if (isset($_POST["full_name"]) && isset($_POST["username"]) && isset($_POST["password"])) {
    try {
        //creation de la requete SQL
        $sql = "INSERT INTO admin (full_name, username, password) VALUES (:full_name, :username, :password)";
        $results = $conn->prepare($sql);
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $results->bindParam(":full_name", $full_name);
        $results->bindParam(":username", $username);
        $results->bindParam(":password", $password);
        $results->execute();

        //redirection
        $_SESSION["add"] = "<div class='alert alert-success fade-alert mb-5'><span>L'utisateur a été ajouté avec succès !</span></div>";
        header("Location: manage-admin.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un administrateur | Miamiam</title>
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-2xl text-center mb-5">Ajouter un utilisateur</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Prénom NOM</span>
                            </label>
                            <input type="text" name="full_name" id="full_name" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Nom d'utilisateur</span>
                            </label>
                            <input type="text" name="username" id="username" required class="input input-bordered w-full max-w-xs mb-4" />
                            <label class="label">
                                <span class="label-text">Mot de passe</span>
                            </label>
                            <input type="password" name="password" id="password" required class="input input-bordered w-full max-w-xs mb-4" />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Ajouter" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>