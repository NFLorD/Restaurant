-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 14 mars 2019 à 21:55
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `number` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `date`, `number`, `email`, `password`, `customer_id`) VALUES
(17, 'Fasano', '2019-03-15 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$Xo5umbH5bUerzoUHHjb1TeMlVU94OGQ4PP.rvdI7Tug0x8IusQIVi', NULL),
(18, 'Fasano', '2019-03-16 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$LCXCMXJOP0Cj1RhunVIOb.puyAtByvsorew6VtZlc8qhqhEQZFT5G', NULL),
(19, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$ANbj5yDufiGtMicgRNWVBuD912Xj2f3ZRTCumVXxo1s.3uk89yFhS', NULL),
(20, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$7jGvRyGx0jaZN7DBJtyMfeGgknpSynWIjox9B98ehuVFt.Y452Zga', NULL),
(21, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$oRZRRxFC51Hr7CTepj41le/NihE37xKFLYZlbQOYv.zfi./kyrx7m', NULL),
(22, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$Az3aaHAwXlQ0hVAxN5EjUuTr20ad1WzZq7.J/wB4Ytj2MhqXnGKxS', NULL),
(23, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$TbtBxsbfXA.9fVjQzPdrr.nzZBr5KmYSwGWYpKgz4sCTO24Ut6GES', NULL),
(24, 'Fasano', '2019-03-17 12:00:00', 2, 'fasano.nm@gmail.com', '$2y$10$SR2p8mQvZs4rTho1kU4b4.nus0NF8DWc46y.AO9SWUTts7WPeB0g2', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
