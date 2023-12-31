<?php session_start();

if (isset($_SESSION["username"])) {
    header("Location: index");
    exit;
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    require("../connection.php");

    try {
        // requete sql pour trouver l'utilisateur
        $sql = "SELECT * FROM admin WHERE username = :username";

        // execution de la requete
        $results = $conn->prepare($sql);
        $results->execute(['username' => $username]);
        $user = $results->fetch();

        // si l'utilisateur existe
        if ($user) {
            // verifier le mot de passe
            if ($password == $user['password']) {
                // authentification réussie
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['full_name'];
                header('Location: index');
                exit;
            } else {
                $error = "<div class='alert alert-error fade-alert mb-5'><span>Le nom d'utilisateur ou le mot de passe est incorrect</span></div>";
            }
        } else {
            $error = "<div class='alert alert-error fade-alert mb-5'><span>Le nom d'utilisateur ou le mot de passe est incorrect</span></div>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html data-theme="miamiam-light">

<head>
    <title>Connexion administrateur | Miamiam</title>
    <link rel="stylesheet" href="../css/output.css">
</head>

<body>
    <?php if (isset($error)) : ?>
        <div><?php echo $error; ?></div>
    <?php endif; ?>

    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <div>
                <h1 class="text-4xl font-bold text-center mb-8">Se connecter</h1>
                <p class="text-center mb-12">Connectez vous pour accéder au fonctionnalités administrateur </p>
            </div>
            <div class="flex justify-center">
                <div class="card w-[32rem] bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Nom d'utilisateur</span>
                            </label>
                            <input type="text" name="username" id="username" required class="input input-bordered w-full max-w-xl mb-4" />
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
</body>

</html>