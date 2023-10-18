<?php include('partials/menu.php'); ?>

<?php session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login");
    exit;
}

require("../connection.php");

try {
    //creation de la requete SQL
    $sql = "SELECT COUNT(*) FROM admin";

    //execution de la requete
    $adminCount = $conn->query($sql)->fetchColumn();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //creation de la requete SQL
    $sql = "SELECT COUNT(*) FROM user";

    //execution de la requete
    $userCount = $conn->query($sql)->fetchColumn();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //creation de la requete SQL
    $sql = "SELECT COUNT(*) FROM category";

    //execution de la requete
    $categoryCount = $conn->query($sql)->fetchColumn();
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    //creation de la requete SQL
    $sql = "SELECT COUNT(*) FROM food";

    //execution de la requete
    $foodCount = $conn->query($sql)->fetchColumn();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!doctype html>
<html>

<head>
    <title>Tableau de bord | Miamiam</title>
</head>

<body>
    <main class="mx-auto min-h-screen max-w-screen-xl px-12 py-8">
        <div class="wrapper">
            <h1 class="text-2xl text-center mb-5">Bienvenue, <?php echo $_SESSION["fullname"] ?></h1>
            <?php
            if (isset($_SESSION["add"])) {
                echo $_SESSION["add"];
                unset($_SESSION["add"]);
            }
            if (isset($_SESSION["delete"])) {
                echo $_SESSION["delete"];
                unset($_SESSION["delete"]);
            }
            if (isset($_SESSION["update"])) {
                echo $_SESSION["update"];
                unset($_SESSION["update"]);
            }
            if (isset($_SESSION["update-password"])) {
                echo $_SESSION["update-password"];
                unset($_SESSION["update-password"]);
            }
            ?>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-black dark:bg-black/40 p-8 h-48 rounded-lg">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>

                        <div>
                            <p class="font-medium">Administrateurs</p>
                            <h2 class="text-4xl font-medium">
                                <?php echo $adminCount ?>
                            </h2>
                        </div>
                    </div>
                    <a href="manage-admin" class="btn btn-sm btn-primary mt-6">Gérer</a>
                </div>
                <div class="bg-black dark:bg-black/40 p-8 h-48 rounded-lg">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>

                        <div>
                            <p class="font-medium">Utilisateurs</p>
                            <h2 class="text-4xl font-medium">
                                <?php echo $userCount ?>
                            </h2>
                        </div>
                    </div>
                    <a href="manage-user" class="btn btn-sm btn-primary mt-6">Gérer</a>
                </div>
                <div class="bg-black dark:bg-black/40 p-8 h-48 rounded-lg">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>


                        <div>
                            <p class="font-medium">Catégories</p>
                            <h2 class="text-4xl font-medium">
                                <?php echo $categoryCount ?>
                            </h2>
                        </div>
                    </div>
                    <a href="manage-category" class="btn btn-sm btn-primary mt-6">Gérer</a>
                </div>
                <div class="bg-black dark:bg-black/40 p-8 h-48 rounded-lg">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mr-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>


                        <div>
                            <p class="font-medium">Plats</p>
                            <h2 class="text-4xl font-medium">
                                <?php echo $foodCount ?>
                            </h2>
                        </div>
                    </div>
                    <a href="manage-alacarte" class="btn btn-sm btn-primary mt-6">Gérer</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>


<?php include('partials/footer.php'); ?>