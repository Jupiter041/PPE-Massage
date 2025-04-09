-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 05 avr. 2025 à 08:06
-- Version du serveur : 10.11.11-MariaDB-0+deb12u1
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `massage`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptes_utilisateurs`
--

CREATE TABLE `comptes_utilisateurs` (
  `compte_id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` smallint(6) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comptes_utilisateurs`
--

INSERT INTO `comptes_utilisateurs` (`compte_id`, `nom_utilisateur`, `mot_de_passe`, `role`, `email`) VALUES
(1, 'admin', '$2y$10$RNqwm9wgkcZl6MN.CuNB5.yp8ZkmWjCDtZRh74kFpfj/pOicIOJqS', 1, 'sylvain.pivois@outlook.com'),
(2, 'employe1', 'employe123', 2, ''),
(3, 'employe2', 'employe456', 2, ''),
(4, 'client1', 'client123', 3, ''),
(5, 'client2', 'client456', 3, ''),
(6, 'adminI', '$2y$10$mQCrkN62uUWdcn.AcKsEF.Kh3fau4kqPdN27bsZVsiG/ENqhxJvRO', 3, 'sylvain.pivois@outlook.fr'),
(8, 'pepsiman', '$2y$10$SMGNnwtmW9llctWxq3hjouqCaRHXbRk0OGSkQxJYbC0hJ3aJMbLRW', 3, 'pepsi@cool.fr'),
(9, 'justine', '$2y$10$4snO1V8drI6.Pukd74eP0.15ddLuxtn8QpKm4lM05w5cSjt3vmG6a', 3, 'justine@email.com'),
(10, 'admin', '$2y$10$RNqwm9wgkcZl6MN.CuNB5.yp8ZkmWjCDtZRh74kFpfj/pOicIOJqS', 3, 'test@test.fr');

--
-- Déclencheurs `comptes_utilisateurs`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_compte` AFTER DELETE ON `comptes_utilisateurs` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'DELETE', CONCAT('Compte supprimé - ID: ', OLD.compte_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_compte` AFTER INSERT ON `comptes_utilisateurs` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'INSERT', CONCAT('Nouveau compte créé - ID: ', NEW.compte_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_compte` AFTER UPDATE ON `comptes_utilisateurs` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'UPDATE', CONCAT('Compte modifié - ID: ', NEW.compte_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `employe_id` int(11) NOT NULL,
  `type_employe` smallint(6) DEFAULT NULL,
  `horaire_travail` datetime DEFAULT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`employe_id`, `type_employe`, `horaire_travail`, `compte_id`) VALUES
(1, 2, '2024-10-01 09:00:00', 2),
(2, 2, '2024-10-01 10:00:00', 3);

--
-- Déclencheurs `employe`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_employe` AFTER DELETE ON `employe` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('employe', 'DELETE', CONCAT('Employé supprimé - ID: ', OLD.employe_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_employe` AFTER INSERT ON `employe` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('employe', 'INSERT', CONCAT('Nouvel employé créé - ID: ', NEW.employe_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_employe` AFTER UPDATE ON `employe` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('employe', 'UPDATE', CONCAT('Employé modifié - ID: ', NEW.employe_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `en_attente`
--

CREATE TABLE `en_attente` (
  `en_attente_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `duree` int(11) NOT NULL,
  `heure_reservation` datetime NOT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `employe_id` int(11) DEFAULT NULL,
  `preference_praticien` char(1) DEFAULT NULL,
  `commentaires` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `action` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `date_log` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logs`
--

INSERT INTO `logs` (`log_id`, `table_name`, `action`, `description`, `date_log`) VALUES
(1, 'types_massages', 'UPDATE', 'Type de massage modifié - ID: 1', '2025-01-11 11:03:52'),
(2, 'types_massages', 'INSERT', 'Nouveau type de massage créé - ID: 63', '2025-01-11 11:04:09'),
(3, 'types_massages', 'DELETE', 'Type de massage supprimé - ID: 63', '2025-01-11 11:04:20'),
(4, 'types_massages', 'INSERT', 'Nouveau type de massage créé - ID: 64', '2025-01-11 11:06:49'),
(5, 'types_massages', 'UPDATE', 'Type de massage modifié - ID: 64', '2025-01-11 11:07:07'),
(6, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:07:27'),
(7, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:11:47'),
(8, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:12:02'),
(9, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:12:46'),
(10, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:14:30'),
(11, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-02-02 08:16:24'),
(12, 'types_massages', 'INSERT', 'Nouveau type de massage créé - ID: 65', '2025-02-02 08:22:37'),
(13, 'types_massages', 'UPDATE', 'Type de massage modifié - ID: 65', '2025-02-02 08:22:45'),
(14, 'types_massages', 'DELETE', 'Type de massage supprimé - ID: 65', '2025-02-02 08:22:51'),
(15, 'types_massages', 'INSERT', 'Nouveau type de massage créé - ID: 66', '2025-02-02 09:43:29'),
(16, 'types_massages', 'DELETE', 'Type de massage supprimé - ID: 66', '2025-02-02 09:43:35'),
(17, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 2', '2025-02-02 09:50:47'),
(18, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 3', '2025-02-02 09:52:24'),
(19, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 4', '2025-02-02 10:07:26'),
(20, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 5', '2025-02-02 10:12:00'),
(21, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 6', '2025-02-02 10:23:29'),
(22, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 7', '2025-02-02 10:26:57'),
(23, 'panier', 'DELETE', 'Article supprimé du panier - ID: 2', '2025-02-02 18:22:41'),
(24, 'panier', 'DELETE', 'Article supprimé du panier - ID: 3', '2025-02-02 18:22:41'),
(25, 'panier', 'DELETE', 'Article supprimé du panier - ID: 4', '2025-02-02 18:22:41'),
(26, 'panier', 'DELETE', 'Article supprimé du panier - ID: 6', '2025-02-02 18:22:45'),
(27, 'panier', 'DELETE', 'Article supprimé du panier - ID: 7', '2025-02-02 18:22:47'),
(28, 'panier', 'DELETE', 'Article supprimé du panier - ID: 1', '2025-02-02 18:22:56'),
(29, 'panier', 'DELETE', 'Article supprimé du panier - ID: 5', '2025-02-02 18:22:56'),
(30, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 8', '2025-02-02 18:23:01'),
(31, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 9', '2025-02-02 18:23:04'),
(32, 'panier', 'DELETE', 'Article supprimé du panier - ID: 8', '2025-02-02 18:23:08'),
(33, 'panier', 'DELETE', 'Article supprimé du panier - ID: 9', '2025-02-02 18:23:08'),
(34, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 10', '2025-02-02 19:42:58'),
(35, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 11', '2025-02-02 19:43:01'),
(36, 'panier', 'DELETE', 'Article supprimé du panier - ID: 10', '2025-02-02 19:43:15'),
(37, 'panier', 'DELETE', 'Article supprimé du panier - ID: 11', '2025-02-02 19:43:15'),
(38, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 12', '2025-02-02 20:20:52'),
(39, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 13', '2025-02-02 20:20:57'),
(40, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 14', '2025-02-02 20:21:53'),
(41, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 15', '2025-02-02 20:21:57'),
(42, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 16', '2025-02-02 20:22:05'),
(43, 'panier', 'DELETE', 'Article supprimé du panier - ID: 16', '2025-02-02 20:22:11'),
(44, 'panier', 'DELETE', 'Article supprimé du panier - ID: 13', '2025-02-03 07:51:40'),
(45, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 17', '2025-02-03 07:51:53'),
(46, 'panier', 'DELETE', 'Article supprimé du panier - ID: 12', '2025-02-03 07:52:03'),
(47, 'panier', 'DELETE', 'Article supprimé du panier - ID: 17', '2025-02-03 07:52:03'),
(48, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 18', '2025-02-13 18:36:28'),
(49, 'panier', 'DELETE', 'Article supprimé du panier - ID: 18', '2025-02-13 18:37:21'),
(50, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 19', '2025-02-13 18:37:29'),
(51, 'reservations', 'INSERT', 'Nouvelle réservation - ID: 3 - Client ID: 1', '2025-02-13 18:41:01'),
(52, 'panier', 'DELETE', 'Article supprimé du panier - ID: 19', '2025-02-13 18:41:01'),
(53, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 20', '2025-02-13 18:48:36'),
(54, 'reservations', 'INSERT', 'Nouvelle réservation - ID: 4 - Client ID: 1', '2025-02-15 14:43:34'),
(55, 'panier', 'DELETE', 'Article supprimé du panier - ID: 20', '2025-02-15 14:43:34'),
(56, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 21', '2025-02-15 14:45:38'),
(57, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 22', '2025-02-15 14:45:43'),
(58, 'panier', 'DELETE', 'Article supprimé du panier - ID: 22', '2025-02-15 15:00:24'),
(59, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 23', '2025-02-16 16:24:16'),
(60, 'panier', 'DELETE', 'Article supprimé du panier - ID: 21', '2025-02-16 16:24:20'),
(61, 'panier', 'DELETE', 'Article supprimé du panier - ID: 23', '2025-02-16 16:24:25'),
(62, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 24', '2025-02-16 16:24:28'),
(100, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 100', '2025-04-05 08:03:59');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `panier_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `type_massage_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`panier_id`, `compte_id`, `type_massage_id`, `quantite`, `date_ajout`) VALUES
(1, 1, 3, 1, '2025-04-01 12:22:38'),
(14, 10, 3, 1, '2025-02-02 19:21:53'),
(15, 10, 43, 1, '2025-02-02 19:21:57'),
(24, 1, 1, 1, '2025-02-16 15:24:28'),
(100, 1, 2, 1, '2025-04-05 06:03:59');

--
-- Déclencheurs `panier`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_panier` AFTER DELETE ON `panier` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'DELETE', CONCAT('Article supprimé du panier - ID: ', OLD.panier_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_panier` AFTER INSERT ON `panier` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'INSERT', CONCAT('Nouvel article ajouté au panier - ID: ', NEW.panier_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_panier` AFTER UPDATE ON `panier` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'UPDATE', CONCAT('Article du panier modifié - ID: ', NEW.panier_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `heure_reservation` datetime DEFAULT NULL,
  `commentaires` text DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `salle_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `employe_id` int(11) NOT NULL,
  `preference_praticien` char(1) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  `compte_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `heure_reservation`, `commentaires`, `duree`, `salle_id`, `type_id`, `employe_id`, `preference_praticien`, `date_creation`, `compte_id`) VALUES
(1, '2024-10-05 14:00:00', 'Massage relaxant demandé.', 60, 1, 1, 1, NULL, '2024-11-26 07:16:04', 1),
(2, '2024-10-05 15:30:00', 'Demande de Shiatsu spécifique.', 90, 2, 2, 2, NULL, '2024-11-26 07:16:04', 1),
(3, '2025-02-14 18:41:01', 'Réservation créée depuis le panier', 60, 1, 2, 1, NULL, '2025-02-13 18:41:01', 1),
(4, '2025-02-16 14:43:34', 'Réservation créée depuis le panier', 60, 1, 1, 1, NULL, '2025-02-15 14:43:34', 1);

--
-- Déclencheurs `reservations`
--
DELIMITER $$
CREATE TRIGGER `after_reservation_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    DELETE FROM panier 
    WHERE compte_id = NEW.compte_id
    AND type_massage_id = NEW.type_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_employe_reservation_insert` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    DECLARE count_employe INT;
    
    SELECT COUNT(*) INTO count_employe
    FROM reservations 
    WHERE employe_id = NEW.employe_id 
    AND DATE(heure_reservation) = DATE(NEW.heure_reservation)
    AND ((heure_reservation BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE))
    OR (DATE_ADD(heure_reservation, INTERVAL duree MINUTE) BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE)));
    
    IF count_employe > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'L''employé est déjà occupé sur ce créneau horaire';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_reservation_delete` BEFORE DELETE ON `reservations` FOR EACH ROW BEGIN
    IF OLD.heure_reservation < NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Impossible de supprimer une réservation passée';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_reservation_insert` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    DECLARE count_reservations INT;
    
    SELECT COUNT(*) INTO count_reservations
    FROM reservations 
    WHERE salle_id = NEW.salle_id 
    AND DATE(heure_reservation) = DATE(NEW.heure_reservation)
    AND ((heure_reservation BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE))
    OR (DATE_ADD(heure_reservation, INTERVAL duree MINUTE) BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE)));
    
    IF count_reservations > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La salle est déjà réservée pour ce créneau horaire';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_reservation_update` BEFORE UPDATE ON `reservations` FOR EACH ROW BEGIN
    IF OLD.heure_reservation < NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Impossible de modifier une réservation passée';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Salle`
--

CREATE TABLE `Salle` (
  `salle_id` int(11) NOT NULL,
  `nom_salle` varchar(50) DEFAULT NULL,
  `disponibilite` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Salle`
--

INSERT INTO `Salle` (`salle_id`, `nom_salle`, `disponibilite`) VALUES
(1, 'Salle de massage 1', 1),
(2, 'Salle de massage 2', 1),
(3, 'Salle de massage 3', 0);

--
-- Déclencheurs `Salle`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_salle` AFTER DELETE ON `Salle` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'DELETE', CONCAT('Salle supprimée - ID: ', OLD.salle_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_salle` AFTER INSERT ON `Salle` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'INSERT', CONCAT('Nouvelle salle créée - ID: ', NEW.salle_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_salle` AFTER UPDATE ON `Salle` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'UPDATE', CONCAT('Salle modifiée - ID: ', NEW.salle_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `types_massages`
--

CREATE TABLE `types_massages` (
  `type_id` int(11) NOT NULL,
  `nom_type` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `types_massages`
--

INSERT INTO `types_massages` (`type_id`, `nom_type`, `description`, `prix`, `created_at`, `updated_at`) VALUES
(1, 'Massage Suédois', 'Un massage classique qui aide à détendre les muscles.', 70.01, '2024-10-04 10:33:14', '2025-01-11 10:03:52'),
(2, 'Shiatsu', 'Massage bas sur la mdecine traditionnelle japonaise.', 70.00, '2024-10-04 10:33:14', '2024-10-18 07:58:36'),
(3, 'Massage à la Raclette', 'Massage basé sur de la raclette chaude.', 60.01, '2024-10-04 10:33:14', '2024-11-12 09:23:16'),
(4, 'Massage aux pierres chaudes', 'Utilise des pierres chauffées pour apaiser les tensions.', 90.00, '2024-10-04 10:33:14', '2024-10-04 10:33:14'),
(39, 'Test', 'description test', 69.00, '2024-10-15 06:03:00', '2024-10-15 06:20:45'),
(43, 'TestSQLInjection', 'SELECT * FROM types_massages WHERE id  1 OR 1 = 1', 14.02, '2024-10-15 06:25:29', '2024-10-18 10:54:37'),
(59, 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 14.00, '2024-10-18 08:13:20', '2024-10-18 08:13:20'),
(60, 'test', 'alert(&#39;XSS&#39;)', 15.00, '2024-10-18 10:53:44', '2024-10-18 10:53:44'),
(62, 'ffffff', 'fffffffffffffffff', 1452.00, '2024-11-08 15:39:51', '2024-11-08 15:39:51'),
(64, 'Huiles Divines', 'massage avec de aux huiles divines', 150.00, '2025-01-11 11:06:49', '2025-01-11 10:07:07');

--
-- Déclencheurs `types_massages`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_type_massage` AFTER DELETE ON `types_massages` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'DELETE', CONCAT('Type de massage supprimé - ID: ', OLD.type_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_type_massage` AFTER INSERT ON `types_massages` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'INSERT', CONCAT('Nouveau type de massage créé - ID: ', NEW.type_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_type_massage` AFTER UPDATE ON `types_massages` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'UPDATE', CONCAT('Type de massage modifié - ID: ', NEW.type_id));
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comptes_utilisateurs`
--
ALTER TABLE `comptes_utilisateurs`
  ADD PRIMARY KEY (`compte_id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`employe_id`),
  ADD UNIQUE KEY `compte_id` (`compte_id`);

--
-- Index pour la table `en_attente`
--
ALTER TABLE `en_attente`
  ADD PRIMARY KEY (`en_attente_id`),
  ADD KEY `compte_id` (`compte_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`panier_id`),
  ADD KEY `compte_id` (`compte_id`),
  ADD KEY `type_massage_id` (`type_massage_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `salle_id` (`salle_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `employe_id` (`employe_id`),
  ADD KEY `reservations_ibfk_4` (`compte_id`);

--
-- Index pour la table `Salle`
--
ALTER TABLE `Salle`
  ADD PRIMARY KEY (`salle_id`);

--
-- Index pour la table `types_massages`
--
ALTER TABLE `types_massages`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comptes_utilisateurs`
--
ALTER TABLE `comptes_utilisateurs`
  MODIFY `compte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `employe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `en_attente`
--
ALTER TABLE `en_attente`
  MODIFY `en_attente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `panier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `Salle`
--
ALTER TABLE `Salle`
  MODIFY `salle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `types_massages`
--
ALTER TABLE `types_massages`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `employe_ibfk_2` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`);

--
-- Contraintes pour la table `en_attente`
--
ALTER TABLE `en_attente`
  ADD CONSTRAINT `en_attente_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `en_attente_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types_massages` (`type_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`type_massage_id`) REFERENCES `types_massages` (`type_id`),
  ADD CONSTRAINT `panier_ibfk_3` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `panier_ibfk_4` FOREIGN KEY (`type_massage_id`) REFERENCES `types_massages` (`type_id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`salle_id`) REFERENCES `Salle` (`salle_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types_massages` (`type_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`employe_id`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `reservations_ibfk_5` FOREIGN KEY (`salle_id`) REFERENCES `Salle` (`salle_id`),
  ADD CONSTRAINT `reservations_ibfk_6` FOREIGN KEY (`type_id`) REFERENCES `types_massages` (`type_id`),
  ADD CONSTRAINT `reservations_ibfk_7` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`employe_id`),
  ADD CONSTRAINT `reservations_ibfk_8` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Ajout d'une colonne panier_id dans la table en_attente
ALTER TABLE `en_attente` 
ADD COLUMN `panier_id` int(11),
ADD CONSTRAINT `en_attente_ibfk_3` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`panier_id`) ON DELETE CASCADE;
