<?php
require("connection.php");

if (isset($_POST["submit"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["phone"]) && isset($_POST["first_name"]) && isset($_POST["last_name"])) {

    try {
        //creation de la requete SQL
        $sql = "INSERT INTO user (email, password, phone, first_name, last_name) VALUES (:email, :password, :phone, :first_name, :last_name)";
        $results = $conn->prepare($sql);
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        $results->bindParam(":email", $email);
        $results->bindParam(":password", $password);
        $results->bindParam(":phone", $phone);
        $results->bindParam(":first_name", $first_name);
        $results->bindParam(":last_name", $last_name);
        $results->execute();

        //redirection
        header("Location: index");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="wrapper">
            <div>
                <h1 class="text-4xl font-bold text-center mb-8">Créer un compte</h1>
                <p class="text-center mb-12">Rejoignez MiaMiam dès aujourd'hui et commandez des délicieux plats !</p>
            </div>
            <div class="flex justify-center">
                <div class="card w-[32rem] bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Numéro de téléphone</span>
                            </label>
                            <input type="tel" name="phone" id="phone" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Adresse Email</span>
                            </label>
                            <input type="email" name="email" id="email" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Mot de passe</span>
                            </label>
                            <input type="password" name="password" id="password" required class="input input-bordered w-full max-w-xl mb-4" />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Créer un compte" class="btn btn-primary" />
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