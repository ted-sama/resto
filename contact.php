<?php
session_start();
require("connection.php");

if (isset($_POST["submit"])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    mail("teddynsoki@gmail.com", "Contact de $first_name $last_name", $message);
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
                <h1 class="text-4xl font-bold text-center mb-8">Contactez nous</h1>
                <p class="text-center mb-12">Vous avez une question ? Vous souhaitez nous faire part d'une remarque ? N'hésitez pas à nous contacter via le formulaire ci-dessous.</p>
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
                                <span class="label-text">Message</span>
                            </label>
                            <textarea class="textarea textarea-bordered w-full h-64 max-h-64 max-w-xl mb-4" name="message" id="message" required></textarea>
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Envoyer" class="btn btn-primary" />
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