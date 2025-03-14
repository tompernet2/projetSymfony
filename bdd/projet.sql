-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 14 mars 2025 à 14:35
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `login`, `mdp`, `nom`, `prenom`, `statut`) VALUES
(1, 'admin', 'admin', 'Pernet', 'Tom', 0),
(2, 'toto', 'toto', 'toto', 'toto', 1),
(3, 'titi', 'titi', 'titi', 'titi', 1),
(4, 'castaing', 'castaing', 'castaing', 'castaing', 0),
(5, 'castaing1', 'castaing1', 'castaing', 'castaing1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int DEFAULT NULL,
  `date_debut` date NOT NULL,
  `nbre_heures` int NOT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inscription_max` int NOT NULL,
  `nb_inscription` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_404021BFF347EFB` (`produit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id`, `produit_id`, `date_debut`, `nbre_heures`, `departement`, `inscription_max`, `nb_inscription`) VALUES
(18, 6, '2025-03-14', 5, 'PARIS', 2, 1),
(19, 3, '2025-03-31', 10, 'Taverny', 1, 0),
(20, 12, '2025-03-10', 4, 'Taverny', 5, 0),
(21, 3, '2025-03-22', 7, 'PARIS', 4, 0);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employe_id` int DEFAULT NULL,
  `formation_id` int DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E90F6D61B65292` (`employe_id`),
  KEY `IDX_5E90F6D65200282E` (`formation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `employe_id`, `formation_id`, `statut`) VALUES
(19, 2, 18, 'refusée'),
(20, 2, 19, 'refusée'),
(21, 3, 19, 'refusée'),
(22, 3, 18, 'validée'),
(23, 2, 20, 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `libelle`) VALUES
(3, 'Formation Python débutant'),
(4, 'Formation Python avancé'),
(5, 'Formation SQL pour les débutants'),
(6, 'Formation SQL avancé'),
(7, 'Développement web avec HTML, CSS et JavaScript'),
(8, 'Formation complète JavaScript'),
(9, 'Introduction à Java'),
(10, 'Développement avancé en Java'),
(11, 'Programmation en C pour débutants'),
(12, 'Programmation orientée objet en C++');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `FK_404021BFF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D61B65292` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`id`),
  ADD CONSTRAINT `FK_5E90F6D65200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
