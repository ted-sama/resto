<!DOCTYPE html>
<html lang="en" data-theme="light">


<body>
    <header class="bg-amber-50 w-full top-0 z-50 sticky">
        <div class="flex items-center space-x-8 px-8">
            <a href="/">
                <img src="assets/logo/miamiam_logo.svg" class=" w-28" alt="">
            </a>
            <div class="flex w-full justify-between">
                <ul class="flex space-x-6">
                    <li><a href="categories" class="text-center font-semibold uppercase">Catégories</a></li>
                    <li><a href="foods" class="text-center font-semibold uppercase">La carte</a></li>
                    <li><a href="contact" class="text-center font-semibold uppercase">Contact</a></li>
                </ul>
                <ul class="flex space-x-6">
                    <li>
                        <a href="checkout">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </a>
                    </li>
                    <?php if (isset($_SESSION["shop_email"])) { ?>
                        <li>
                            <a href="account">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>

                            </a>
                        </li>
                        <li><a href="logout" class="text-center font-semibold uppercase">Déconnexion</a></li>
                    <?php } else { ?>
                        <li><a href="signin" class="text-center font-semibold uppercase">Inscription</a></li>
                        <li><a href="login" class="text-center font-semibold uppercase">Connexion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </header>
</body>

</html>