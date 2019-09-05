-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 05 sep. 2019 à 15:15
-- Version du serveur :  5.7.24
-- Version de PHP :  7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `site`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `montant` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `montant`, `date_enregistrement`, `etat`) VALUES
(1, 4, 301, '2015-07-10 14:44:46', 'en cours de traitement'),
(2, 5, 40, '2019-09-04 16:32:07', 'en cours de traitement'),
(3, 5, 20, '2019-09-04 16:34:10', 'en cours de traitement'),
(4, 5, 0, '2019-09-04 16:34:58', 'en cours de traitement'),
(5, 5, 0, '2019-09-04 16:35:22', 'en cours de traitement'),
(6, 5, 49, '2019-09-05 10:32:01', 'en cours de traitement'),
(7, 5, 45, '2019-09-05 17:09:42', 'en cours de traitement');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

DROP TABLE IF EXISTS `details_commande`;
CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_commande` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `quantite` int(3) NOT NULL,
  `prix` int(3) NOT NULL,
  PRIMARY KEY (`id_details_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(1, 1, 2, 1, 15),
(2, 1, 6, 1, 49),
(3, 1, 8, 3, 79),
(4, 2, 1, 2, 20),
(5, 3, 1, 1, 20),
(6, 6, 3, 1, 29),
(7, 6, 1, 1, 20),
(8, 7, 2, 3, 15);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(5, 'admin', 'admin', 'admin', 'admin', 'admin@admin.admin', 'm', 'Paris', 75015, 'Rue de la madelaine', 1),
(6, 'amaury', '21081992', 'lapeyre', 'amaury', 'dorianarm@hotmail.com', 'm', 'lyon', 69100, '85 rue alexandre', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `reference` varchar(20) CHARACTER SET utf8 NOT NULL,
  `categorie` varchar(20) CHARACTER SET utf8 NOT NULL,
  `titre` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `photo` varchar(250) CHARACTER SET utf8 NOT NULL,
  `prix` int(3) NOT NULL,
  `stock` int(3) NOT NULL,
  PRIMARY KEY (`id_produit`),
  UNIQUE KEY `reference` (`reference`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `photo`, `prix`, `stock`) VALUES
(1, '11-d-23', 'Xbox', 'GTA V', 'Jeu d\'action-aventure en monde ouvert, Grand Theft Auto (GTA) V vous place dans la peau de trois personnages in&eacute;dits : Michael, Trevor et Franklin. Ces derniers ont &eacute;lu domicile &agrave; Los Santos, ville de la r&eacute;gion de San Andreas. Braquages et missions font partie du quotidien du joueur qui pourra &eacute;galement cohabiter avec 15 autres utilisateurs dans cet univers persistant s\'il joue sur PS3/Xbox 360 ou 29 s\'il joue sur PS4/Xbox One/PC.', 'photo/11-d-23_gtav_xb1_fob_eng_2.jpg', 19, 53),
(2, '66-f-15', 'Ps4', 'God Of War 4', 'Dans ce nouvel &eacute;pisode de God Of War, le h&eacute;ros &eacute;voluera dans un monde aux inspirations nordiques, tr&egrave;s forestier et montagneux. Dans ce beat-them-all, un enfant accompagnera le h&eacute;ros principal, pouvant apprendre des actions du joueur, et m&ecirc;me gagner de l\'exp&eacute;rience.', 'photo/66-f-15_1381708_max_1.jpg', 15, 230),
(3, '88-g-77', 'Switch', 'The Legend of Zelda: Breath of the Wild', '', 'photo/88-g-77_1008559_max.jpg', 29, 63),
(4, '55-b-38', 'PC', 'World of Warcraft', '', 'photo/55-b-38_1749548_max.jpg', 20, 3),
(5, '31-p-33', 'Xbox', 'Gears of War 4', '', 'photo/31-p-33_799851_max.jpg', 25, 80),
(6, '56-a-65', 'Xbox', 'Halo 4', '', 'photo/56-a-65_halo_5_1.jpg', 49, 73),
(7, '63-s-63', 'Switch', 'Octopath Traveler', '', 'photo/63-s-63_1521035_max.jpg', 59, 120);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
