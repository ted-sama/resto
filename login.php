<?php
session_start();

if (isset($_SESSION["shop_email"])) {
    header("Location: index");
    exit;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require("connection.php");

    try {
        // requete sql pour trouver l'utilisateur
        $sql = "SELECT * FROM user WHERE email = :email";

        // execution de la requete
        $results = $conn->prepare($sql);
        $results->execute(['email' => $email]);
        $user = $results->fetch();

        // si l'utilisateur existe
        if ($user) {
            // verifier le mot de passe
            if ($password == $user['password']) {
                // authentification réussie
                $_SESSION['shop_id'] = $user['id'];
                $_SESSION['shop_email'] = $user['email'];
                $_SESSION['shop_password'] = $user['password'];
                $_SESSION['shop_phone'] = $user['phone'];
                $_SESSION['shop_first_name'] = $user['first_name'];
                $_SESSION['shop_last_name'] = $user['last_name'];
                $_SESSION['shop_cart'] = array();
                header('Location: index');
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
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
    <title>Se connecter | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="wrapper">
            <div>
                <h1 class="text-4xl font-bold text-center mb-8">Se connecter</h1>
                <p class="text-center mb-12">Connectez vous pour commander des plats succulents !</p>
            </div>
            <div class="flex justify-center">
                <div class="card w-[32rem] bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Adresse Email</span>
                            </label>
                            <input type="email" name="email" id="email" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Mot de passe</span>
                            </label>
                            <input type="password" name="password" id="password" required class="input input-bordered w-full max-w-xl mb-4" />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Se connecter" class="btn btn-primary" />
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