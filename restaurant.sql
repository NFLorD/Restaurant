-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 13 Mars 2019 à 17:22
-- Version du serveur :  5.7.24-0ubuntu0.16.04.1
-- Version de PHP :  7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `restaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phonenumber` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `phonenumber`, `email`, `password`) VALUES
(1, 'Nicolas', 'Fasano', '0623309121', 'fasano.nm@gmail.com', '$2y$10$KuIQ33jTQbFgJIMZzAWQ.eubj8qmwIbNaDz2Z9E2MvM.lqes66TyG'),
(2, 'Jeannot', 'Fasano', '0000000000', 'mongolito@gmail.con', '$2y$10$d79DCTWJXf5d6Aw60VyAFOxtwkpkI7zQIxST65iUM9KDjooIiRYXK');

-- --------------------------------------------------------

--
-- Structure de la table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(30) NOT NULL,
  `price` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `description`, `image`, `type`, `price`) VALUES
(1, 'Random burger', 'It\'s got steaks and bacon !', NULL, 'dish', '10.99'),
(2, 'Moules frites', 'Des moules et des frites.', NULL, 'dish', '17.99'),
(3, 'Coquilles Saint-Jacques', 'Accompagnées de leur petite salade de mesclun', NULL, 'dish', '22.99'),
(8, 'Salade niçoise', 'Tomates, poivrons verts « corne de bœuf », ail, oignons rouges ou cébettes, fèvettes, céleri, petits artichauts violets, concombres, œufs durs, filets d\'anchois (à l\'huile d\'olive ou salés) ou thon au naturel, olives noires niçoises, et huile d\'olive.', NULL, 'appetizer', '8.99'),
(14, 'Tarte tatin', 'Pommes flambées au rhum, sucre de canne', NULL, 'dessert', '9.50'),
(15, 'Banana split', 'L\'excellence de la gastronomie française !', NULL, 'dessert', '8.00');

-- --------------------------------------------------------

--
-- Structure de la table `favourite_dishes`
--

CREATE TABLE `favourite_dishes` (
  `customer_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `number` int(11) NOT NULL,
  `phonenumber` varchar(10) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `date`, `number`, `phonenumber`, `customer_id`) VALUES
(4, 'Fasano', '2019-03-05 12:15:00', 2, '0623309121', 1),
(6, 'Fasano', '2019-03-16 01:01:00', 1, '0623309121', NULL),
(7, 'Fasano', '2019-03-15 00:00:00', 1, '0623309121', NULL),
(8, 'Fasano', '2019-03-22 00:00:00', 2, '0623309121', 1),
(12, 'Tabano', '2019-01-01 00:00:00', 1, '000', NULL),
(13, 'Albert', '2019-03-15 12:59:00', 1, '0000000000', NULL),
(15, 'Fasano', '2019-03-15 00:00:00', 2, '0623309121', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `favourite_dishes`
--
ALTER TABLE `favourite_dishes`
  ADD PRIMARY KEY (`customer_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
