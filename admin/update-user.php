<?php session_start();
include('partials/menu.php');

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM user WHERE id = :id";
    $results = $conn->prepare($sql);
    $id = $_GET["id"];

    $results->bindParam(":id", $id);
    $results->execute();

    $user = $results->fetch();

    $current_first_name = $user["first_name"];
    $current_last_name = $user["last_name"];
    $current_email = $user["email"];
    $current_password = $user["password"];
    $current_phone = $user["phone"];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["phone"])) {
    try {
        //creation de la requete SQL
        $sql = "UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, phone = :phone WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_GET["id"];

        $results->bindParam(":id", $id);
        $results->bindParam(":first_name", $_POST["first_name"]);
        $results->bindParam(":last_name", $_POST["last_name"]);
        $results->bindParam(":email", $_POST["email"]);
        $results->bindParam(":password", $_POST["password"]);
        $results->bindParam(":phone", $_POST["phone"]);
        $results->execute();

        //redirection
        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>L'utisateur a été modifié avec succès !</span></div>";
        header("Location: manage-user.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier un utilisateur | Miamiam</title>
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
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo $current_first_name ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo $current_last_name ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Adresse email</span>
                            </label>
                            <input type="email" name="email" id="email" value="<?php echo $current_email ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Mot de passe</span>
                            </label>
                            <input type="text" name="password" id="password" value="<?php echo $current_password ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <label class="label">
                                <span class="label-text">Numéro de téléphone</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="<?php echo $current_phone ?>" class="input input-bordered w-full max-w-xs mb-4" required />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Modifier" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</body>