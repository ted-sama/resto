<?php
$route = $_SERVER['REQUEST_URI'];

if ($route === "/admin/" || $route === "/admin/index") {
    $route = "index";
} else if (str_contains($route, "user")) {
    $route = "users";
} else if (str_contains($route, "category")) {
    $route = "categories";
} else if (str_contains($route, "alacarte") || str_contains($route, "food")) {
    $route = "foods";
} else if (str_contains($route, "order")) {
    $route = "orders";
} else if (str_contains($route, "categories")) {
    $route = "categories";
} else {
    $route = "admin";
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="miamiam-light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/output.css" />
</head>

<body>
    <header class="bg-base-300 w-full top-0 z-50 sticky">
        <div class="flex items-center space-x-8 px-8">
            <img src="../assets/logo/miamiam_logo.svg" class=" w-28" alt="">
            <div class="flex w-full justify-between">
                <ul class="flex space-x-6">
                    <li>
                        <a href="index" class="text-center font-semibold uppercase">Tableau de bord</a>
                        <?php if ($route == "index") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                    <li>
                        <a href="manage-admin" class="text-center font-semibold uppercase">Administrateurs</a>
                        <?php if ($route == "admin") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                    <li>
                        <a href="manage-user" class="text-center font-semibold uppercase">Utilisateurs</a>
                        <?php if ($route == "users") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                    <li>
                        <a href="manage-category" class="text-center font-semibold uppercase">Catégories</a>
                        <?php if ($route == "categories") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                    <li>
                        <a href="manage-alacarte" class="text-center font-semibold uppercase">La carte</a>
                        <?php if ($route == "foods") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                    <li>
                        <a href="manage-order" class="text-center font-semibold uppercase">Commandes</a>
                        <?php if ($route == "orders") { ?>
                            <div class="w-full h-1 bg-primary rounded-md"></div>
                        <?php } ?>
                    </li>
                </ul>
                <a href="logout" class="text-center font-semibold uppercase">Déconnexion</a>
            </div>
        </div>
    </header>
</body>

</html>