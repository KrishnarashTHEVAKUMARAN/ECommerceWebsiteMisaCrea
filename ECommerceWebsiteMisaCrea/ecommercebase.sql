-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 juin 2020 à 17:47
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommercebase`
--

CREATE DATABASE IF NOT EXISTS `ecommercebase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ecommercebase`;

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(60) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `price` float(255,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`) VALUES
(1, 'pina colada', 'Un cadeau &agrave; offrir pour sa fille, sa m&egrave;re et/ou sa femme. Un cadeau qui montrera votre affection pour cette personne.', 7.00),
(2, 'Carta DeL Papel', 'Une carte anniversaire de bonne qualit&eacute; &agrave; offrir &agrave; ses proches avec des relief en 3D.', 8.00),
(3, 'Sapin Red Santa', 'Un sapin rouge ordinaire de qualit&eacute; &agrave; offrir pour vos enfants pour f&ecirc;ter no&euml;l.', 12.00),
(4, 'TwoSantaBX', 'test pour voir ', 13.89);

-- --------------------------------------------------------

--
-- Structure de la table `recuperation`
--

CREATE TABLE `recuperation` (
  `id` int(255) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `code` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `age` int(40) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `login` varchar(20) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `confirmkey` varchar(255) NOT NULL,
  `confirme` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `age`, `sexe`, `login`, `mail`, `mdp`, `confirmkey`, `confirme`) VALUES
(1, 'Admin', 'E-Commerce', 18, 'm', 'admin', 'ecommercetest92@gmail.com', 'testcommerce', '', 1),
(2, 'User', 'deux', 24, 'm', 'user2', 'usertwo@ji.com', 'Usertwo2', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recuperation`
--
ALTER TABLE `recuperation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `recuperation`
--
ALTER TABLE `recuperation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
