<?php
session_start();
require("connection.php");

if (!isset($_SESSION["shop_email"])) {
    header("Location: login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte | Miamiam</title>
    <link rel="stylesheet" href="css/output.css" />
</head>

<body>
    <?php require("components/header.php"); ?>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="mb-12">
            <h2 class="mt-12 text-4xl font-bold">Heureux de vous revoir, <?php echo $_SESSION['shop_first_name'] ?> !</h2>
        </div>
        <div>

        </div>
    </main>
    <?php require("components/footer.php"); ?>
</body>

</html>