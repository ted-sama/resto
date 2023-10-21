<?php
session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}

try {
    //creation de la requete SQL
    $sql = "SELECT * FROM user WHERE id = :id";
    $results = $conn->prepare($sql);
    $results->execute(array(
        ":id" => $_SESSION["shop_id"]
    ));

    $user = $results->fetch();

    $current_first_name = $user["first_name"];
    $current_last_name = $user["last_name"];
    $current_email = $user["email"];
    $current_phone = $user["phone"];
} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["phone"])) {
    try {
        //creation de la requete SQL
        $sql = "UPDATE user SET first_name = :first_name, last_name = :last_name, phone = :phone  WHERE id = :id";
        $results = $conn->prepare($sql);
        $id = $_SESSION["shop_id"];

        $results->bindParam(":id", $id);
        $results->bindParam(":first_name", $_POST["first_name"]);
        $results->bindParam(":last_name", $_POST["last_name"]);
        $results->bindParam(":phone", $_POST["phone"]);
        $results->execute();

        //redirection
        $_SESSION["update"] = "<div class='alert alert-success fade-alert mb-5'><span>Vos informations ont été modifié avec succès !</span></div>";
        header("Location: account.php");
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
    <title>Mes informations | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-20">
        <div class="wrapper">
            <div>
                <h1 class="text-4xl font-bold text-center mb-8">Modifier mes informations</h1>
            </div>
            <div class="flex justify-center">
                <div class="card w-[32rem] bg-base-100 shadow-xl">
                    <div class="card-body">
                        <form action="" method="POST">
                            <label class="label">
                                <span class="label-text">Adresse Email</span>
                            </label>
                            <p><?php echo $current_email ?></p>
                            <label class="label">
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo $current_first_name ?>" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo $current_last_name ?>" required class="input input-bordered w-full max-w-xl mb-4" />
                            <label class="label">
                                <span class="label-text">Numéro de téléphone</span>
                            </label>
                            <input type="tel" name="phone" id="phone" value="<?php echo $current_phone ?>" required class="input input-bordered w-full max-w-xl mb-4" />
                            <div class="card-actions justify-end">
                                <input type="submit" name="submit" value="Modifier" class="btn btn-primary" />
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