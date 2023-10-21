-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 21 oct. 2023 à 23:45
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `resto`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'Administrateur', 'admin', 'admin'),
(3, 'Sanji VINSMOKE', 'svinsmoke', 'namicherie'),
(8, 'Cédric GROLET', 'cgrolet', 'trompeoeil');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(250) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(9, 'Asiatique', 'sushi.jpg', 'True', 'True'),
(10, 'Burgers', 'burgers.jpg', 'True', 'True'),
(11, 'Africain', 'african.jpg', 'True', 'True'),
(12, 'Desserts', 'desserts.jpg', 'True', 'True'),
(13, 'Pizzas', 'Pepperoni_1.jpg', 'True', 'True');

-- --------------------------------------------------------

--
-- Structure de la table `food`
--

DROP TABLE IF EXISTS `food`;
CREATE TABLE IF NOT EXISTS `food` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `food_FK_1` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `food`
--

INSERT INTO `food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(6, 'Miam Tacos', 'Le tacos indémodable', '6.90', 'tacos.webp', 10, 'False', 'True'),
(7, 'Chicken Tank', '500 grammes de pur poulet ! Grrrr !', '11.90', 'mega_burger.jpg', 10, 'False', 'True'),
(5, 'Original Pepperoni', 'Tomate, Fromage, Pepperonis, les choses simples...', '12.90', 'Pepperoni_1.jpg', 13, 'False', 'True'),
(8, 'Gomen Ramen', 'Je suis japonais, arigato.', '7.90', 'ramen.jpg', 9, 'False', 'True'),
(10, 'La Hawaïenne', 'La bonne vieille hawaïenne, à la sauce Miamiam', '12.90', 'pizza-hawai.jpg', 13, 'False', 'True'),
(11, 'La Classic', 'Une pizza qui pizze', '11.90', 'pizza-simple.jpg', 13, 'True', 'True'),
(12, '4 Fromages', 'Pizza + fromage = miam', '12.90', 'pizza-4-fromages.jpg', 13, 'False', 'True'),
(13, 'Gâteau aux fruits rouges', 'Fraise, framboise, myrtille, on va bien renta le gâteau !', '4.00', 'fraise-framboise-myrtille.jpg', 12, 'False', 'True'),
(14, 'Cheesecake à la fraise', 'Un bon vieux cheesecake avec son coulis à la fraise', '4.00', 'cheesecake-fraise.jpg', 12, 'False', 'True'),
(15, 'Chikwangue', 'On va prendre un morceau de kwangaaa', '5.00', 'kwanga.jpg', 11, 'False', 'True'),
(16, 'Alocos', 'A déguster sans modération', '5.00', 'alocos.jpg', 11, 'False', 'True');

-- --------------------------------------------------------

--
-- Structure de la table `food_order`
--

DROP TABLE IF EXISTS `food_order`;
CREATE TABLE IF NOT EXISTS `food_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) NOT NULL,
  `user_id` int NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `food_order`
--

INSERT INTO `food_order` (`id`, `price`, `user_id`, `delivery_address`, `order_date`, `status`, `comment`) VALUES
(1, '0.00', 1, '13 rue Guy Moquet, Magny', '0000-00-00 00:00:00', 'Livrée', 'livre bien sans sauce katsu chef'),
(2, '25.80', 1, 'Rue du caca', '0000-00-00 00:00:00', 'Livrée', 'livre bien sans mayo'),
(3, '21.70', 1, 'Rue des Pirouettes', '2023-10-18 18:57:43', 'Annulée', 'fanta pomme cassis'),
(4, '20.70', 2, '7 rue des Mésanges, Eragny', '2023-10-18 22:58:22', 'Livrée', 'j\'ai hâte de me régaler, faites en sorte que ca ne soit pas un noir qui fasse ma commande, merci, c\'était ma plus grande peur'),
(5, '20.90', 1, '21 Rue du Chenapan, Paris', '2023-10-21 23:42:40', 'Livrée', 'Blindez le coulis sur le cheesecake svp');

-- --------------------------------------------------------

--
-- Structure de la table `in_order`
--

DROP TABLE IF EXISTS `in_order`;
CREATE TABLE IF NOT EXISTS `in_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `food_order_id` int NOT NULL,
  `food_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `in_order`
--

INSERT INTO `in_order` (`id`, `food_order_id`, `food_id`, `quantity`) VALUES
(1, 1, 7, 1),
(2, 1, 5, 1),
(3, 2, 5, 2),
(4, 3, 6, 2),
(5, 3, 8, 1),
(6, 4, 6, 3),
(7, 5, 7, 1),
(8, 5, 16, 1),
(9, 5, 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` char(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `phone`, `first_name`, `last_name`) VALUES
(1, 'teddynsoki@gmail.com', 'ted1', '0783716403', 'Teddy', 'Nsoki'),
(2, 'hournig@gmail.com', 'nig', '0647791674', 'Hour', 'Nig');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
