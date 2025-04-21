-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2025 at 08:10 PM
-- Server version: 10.11.11-MariaDB-0+deb12u1
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `massage`
--

-- --------------------------------------------------------

--
-- Table structure for table `comptes_utilisateurs`
--

CREATE TABLE `comptes_utilisateurs` (
  `compte_id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` smallint(6) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comptes_utilisateurs`
--

INSERT INTO `comptes_utilisateurs` (`compte_id`, `nom_utilisateur`, `mot_de_passe`, `role`, `email`) VALUES
(1, 'admincool', '$2y$10$OmDggzXRxhaTMSLmPMdWMuRsjPfBUsY9GrKRea3PDu7cHdmUuR/7C', 1, 'sylvain.pivois@outlook.com'),
(2, 'employe1', '$2y$10$OmDggzXRxhaTMSLmPMdWMuRsjPfBUsY9GrKRea3PDu7cHdmUuR/7C', 2, ''),
(3, 'employe2', '$2y$10$OmDggzXRxhaTMSLmPMdWMuRsjPfBUsY9GrKRea3PDu7cHdmUuR/7C', 2, ''),
(4, 'client1', 'client123', 3, ''),
(5, 'client2', 'client456', 3, ''),
(6, 'adminI', '$2y$10$mQCrkN62uUWdcn.AcKsEF.Kh3fau4kqPdN27bsZVsiG/ENqhxJvRO', 3, 'sylvain.pivois@outlook.fr'),
(8, 'pepsiman', '$2y$10$SMGNnwtmW9llctWxq3hjouqCaRHXbRk0OGSkQxJYbC0hJ3aJMbLRW', 3, 'pepsi@cool.fr'),
(9, 'justine', '$2y$10$4snO1V8drI6.Pukd74eP0.15ddLuxtn8QpKm4lM05w5cSjt3vmG6a', 3, 'justine@email.com'),
(10, 'client3', '$2y$10$RNqwm9wgkcZl6MN.CuNB5.yp8ZkmWjCDtZRh74kFpfj/pOicIOJqS', 3, 'test@test.fr'),
(100, 'coucou', '$2y$10$/CjEImt/jchDDPVjQA8Ewe6VsucHsVEDXQSSUQG/PJYVZkYXXKkmG', 3, 'cc@cc.cc'),
(101, 'employe3', '$2y$10$wdVQx0NfdxCIjfXF2LJuH.yn52lbkVWEmvZ3c.bhiNSkARQT.MxnC', 2, 'employe3@gmail.com'),
(104, '1', '$2y$10$i3SEoe2zka0jbNj1B6/ofOvynehplFPCwm6cAQv1pN2WavMOE65gS', 2, '1@1.1');

--
-- Triggers `comptes_utilisateurs`
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
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `employe_id` int(11) NOT NULL,
  `type_employe` smallint(6) DEFAULT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`employe_id`, `type_employe`, `compte_id`) VALUES
(1, 2, 2),
(2, 2, 3),
(100, 2, 101),
(103, 2, 104);

--
-- Triggers `employe`
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
-- Table structure for table `en_attente`
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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `panier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `en_attente`
--
DELIMITER $$
CREATE TRIGGER `verifier_disponibilite_en_attente` BEFORE INSERT ON `en_attente` FOR EACH ROW BEGIN
    DECLARE heure_fin DATETIME;

    -- Calcul de l’heure de fin du créneau demandé
    SET heure_fin = DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE);

    -- Vérifie si un employé ou une salle est déjà occupé(e) à ce créneau dans reservations
    IF EXISTS (
        SELECT 1 FROM reservations
        WHERE 
            (reservations.employe_id = NEW.employe_id OR reservations.salle_id = NEW.salle_id)
            AND NEW.heure_reservation < DATE_ADD(reservations.heure_reservation, INTERVAL reservations.duree MINUTE)
            AND heure_fin > reservations.heure_reservation
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Impossible d’ajouter à en_attente : salle ou employé déjà réservé à ce créneau';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `action` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `date_log` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
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
(100, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 100', '2025-04-05 08:03:59'),
(101, 'types_massages', 'INSERT', 'Nouveau type de massage créé - ID: 100', '2025-04-05 08:20:18'),
(102, 'panier', 'DELETE', 'Article supprimé du panier - ID: 15', '2025-04-05 15:44:43'),
(103, 'panier', 'DELETE', 'Article supprimé du panier - ID: 24', '2025-04-05 15:48:51'),
(104, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 1', '2025-04-07 09:20:16'),
(105, 'panier', 'DELETE', 'Article supprimé du panier - ID: 1', '2025-04-09 11:25:53'),
(106, 'panier', 'DELETE', 'Article supprimé du panier - ID: 100', '2025-04-09 11:25:53'),
(107, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 101', '2025-04-09 11:26:38'),
(108, 'panier', 'DELETE', 'Article supprimé du panier - ID: 101', '2025-04-09 11:39:57'),
(109, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 102', '2025-04-09 11:57:29'),
(110, 'panier', 'DELETE', 'Article supprimé du panier - ID: 102', '2025-04-09 11:58:24'),
(111, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 103', '2025-04-09 11:59:26'),
(112, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 104', '2025-04-09 11:59:50'),
(113, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 105', '2025-04-09 21:40:51'),
(114, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 106', '2025-04-09 21:43:15'),
(115, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 107', '2025-04-12 14:15:57'),
(116, 'panier', 'DELETE', 'Article supprimé du panier - ID: 104', '2025-04-12 14:16:02'),
(117, 'panier', 'DELETE', 'Article supprimé du panier - ID: 105', '2025-04-12 14:16:02'),
(118, 'panier', 'DELETE', 'Article supprimé du panier - ID: 106', '2025-04-12 14:16:02'),
(119, 'panier', 'DELETE', 'Article supprimé du panier - ID: 107', '2025-04-12 14:16:02'),
(120, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 108', '2025-04-12 14:16:06'),
(121, 'panier', 'DELETE', 'Article supprimé du panier - ID: 108', '2025-04-13 23:38:21'),
(122, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 109', '2025-04-13 23:38:58'),
(123, 'panier', 'DELETE', 'Article supprimé du panier - ID: 109', '2025-04-13 23:39:34'),
(124, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 110', '2025-04-13 23:40:22'),
(125, 'panier', 'DELETE', 'Article supprimé du panier - ID: 110', '2025-04-13 23:50:41'),
(126, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 111', '2025-04-13 23:51:25'),
(127, 'panier', 'DELETE', 'Article supprimé du panier - ID: 111', '2025-04-15 12:15:43'),
(128, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 112', '2025-04-15 12:20:33'),
(129, 'panier', 'DELETE', 'Article supprimé du panier - ID: 112', '2025-04-15 12:24:11'),
(130, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 113', '2025-04-15 12:24:33'),
(131, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 114', '2025-04-15 13:28:08'),
(132, 'panier', 'DELETE', 'Article supprimé du panier - ID: 103', '2025-04-15 13:31:03'),
(133, 'panier', 'DELETE', 'Article supprimé du panier - ID: 114', '2025-04-15 13:31:03'),
(134, 'panier', 'DELETE', 'Article supprimé du panier - ID: 14', '2025-04-15 13:31:08'),
(135, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 115', '2025-04-15 13:31:17'),
(136, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 116', '2025-04-15 13:31:40'),
(137, 'panier', 'DELETE', 'Article supprimé du panier - ID: 115', '2025-04-15 13:53:39'),
(138, 'panier', 'DELETE', 'Article supprimé du panier - ID: 116', '2025-04-15 13:53:39'),
(139, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 117', '2025-04-15 14:03:07'),
(140, 'panier', 'DELETE', 'Article supprimé du panier - ID: 117', '2025-04-15 14:06:08'),
(141, 'panier', 'DELETE', 'Article supprimé du panier - ID: 113', '2025-04-15 14:10:42'),
(142, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 118', '2025-04-15 14:10:50'),
(143, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 119', '2025-04-15 14:10:53'),
(144, 'panier', 'DELETE', 'Article supprimé du panier - ID: 118', '2025-04-15 14:10:58'),
(145, 'panier', 'DELETE', 'Article supprimé du panier - ID: 119', '2025-04-15 14:10:58'),
(146, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 2', '2025-04-15 22:48:37'),
(147, 'comptes_utilisateurs', 'INSERT', 'Nouveau compte créé - ID: 100', '2025-04-16 10:56:28'),
(148, 'comptes_utilisateurs', 'INSERT', 'Nouveau compte créé - ID: 101', '2025-04-16 14:19:48'),
(149, 'employe', 'INSERT', 'Nouvel employé créé - ID: 100', '2025-04-16 14:19:48'),
(150, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 3', '2025-04-17 12:15:34'),
(151, 'comptes_utilisateurs', 'INSERT', 'Nouveau compte créé - ID: 102', '2025-04-17 19:58:14'),
(152, 'employe', 'INSERT', 'Nouvel employé créé - ID: 101', '2025-04-17 19:58:14'),
(153, 'comptes_utilisateurs', 'INSERT', 'Nouveau compte créé - ID: 103', '2025-04-17 20:02:02'),
(154, 'employe', 'INSERT', 'Nouvel employé créé - ID: 102', '2025-04-17 20:02:02'),
(155, 'employe', 'DELETE', 'Employé supprimé - ID: 101', '2025-04-17 20:02:46'),
(156, 'employe', 'DELETE', 'Employé supprimé - ID: 102', '2025-04-17 20:02:46'),
(157, 'comptes_utilisateurs', 'DELETE', 'Compte supprimé - ID: 102', '2025-04-17 20:02:55'),
(158, 'comptes_utilisateurs', 'DELETE', 'Compte supprimé - ID: 103', '2025-04-17 20:02:55'),
(159, 'comptes_utilisateurs', 'INSERT', 'Nouveau compte créé - ID: 104', '2025-04-17 20:03:17'),
(160, 'employe', 'INSERT', 'Nouvel employé créé - ID: 103', '2025-04-17 20:03:17'),
(161, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 120', '2025-04-17 20:03:43'),
(162, 'types_massages', 'UPDATE', 'Type de massage modifié - ID: 100', '2025-04-17 20:05:25'),
(163, 'comptes_utilisateurs', 'UPDATE', 'Compte modifié - ID: 10', '2025-04-17 20:07:45'),
(164, 'panier', 'INSERT', 'Nouvel article ajouté au panier - ID: 121', '2025-04-17 20:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `panier_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `type_massage_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`panier_id`, `compte_id`, `type_massage_id`, `quantite`, `date_ajout`) VALUES
(120, 1, 1, 1, '2025-04-17 18:03:43'),
(121, 10, 2, 1, '2025-04-17 18:07:56');

--
-- Triggers `panier`
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
-- Table structure for table `reservations`
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
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `heure_reservation`, `commentaires`, `duree`, `salle_id`, `type_id`, `employe_id`, `preference_praticien`, `date_creation`, `compte_id`) VALUES
(1, '2024-10-05 14:00:00', 'Massage relaxant demandé.', 60, 1, 1, 1, NULL, '2024-11-26 07:16:04', 1),
(2, '2024-10-05 15:30:00', 'Demande de Shiatsu spécifique.', 90, 2, 2, 2, NULL, '2024-11-26 07:16:04', 1),
(3, '2025-02-14 18:41:01', 'Réservation créée depuis le panier', 60, 1, 2, 1, NULL, '2025-02-13 18:41:01', 1),
(4, '2025-02-16 14:43:34', 'Réservation créée depuis le panier', 60, 1, 1, 1, NULL, '2025-02-15 14:43:34', 1),
(100, '2025-04-18 15:50:00', 'testtesttest', 60, 2, 3, 1, 'F', '2025-04-09 11:25:53', 1),
(102, '2025-04-17 14:50:00', 'ftzeahjidUGIEUGQEQGEUIEQUQGHUISHIQHIZQIGH', 60, 3, 2, 2, 'F', '2025-04-09 11:39:57', 1),
(104, '2025-04-25 15:30:00', 'ouga bouga', 90, 3, 3, 2, 'F', '2025-04-09 11:58:24', 1),
(105, '2025-04-24 14:50:00', 'azertyuiopplkjhgvcxwazedfgbn', 60, 1, 3, 1, 'F', '2025-04-13 23:38:21', 1),
(106, '2025-04-25 15:30:00', 'sopjdiovhiwsdhvj', 90, 1, 4, 1, 'F', '2025-04-13 23:39:34', 1),
(107, '2025-04-24 14:50:00', 'azertyuioppoiuytreza', 90, 2, 60, 2, 'F', '2025-04-13 23:50:41', 1),
(108, '2025-04-24 16:50:00', 'azertyuiop', 60, 3, 100, 1, 'F', '2025-04-15 12:15:43', 1),
(109, '2025-04-24 13:00:00', 'azertghjklpoijhbv', 90, 1, 2, 2, 'F', '2025-04-15 12:24:11', 1),
(110, '2025-04-23 13:00:00', 'azertyuiop', 30, 1, 2, 1, 'F', '2025-04-15 14:06:08', 10);

--
-- Triggers `reservations`
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
-- Table structure for table `Salle`
--

CREATE TABLE `Salle` (
  `salle_id` int(11) NOT NULL,
  `nom_salle` varchar(50) DEFAULT NULL,
  `disponibilite` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Salle`
--

INSERT INTO `Salle` (`salle_id`, `nom_salle`, `disponibilite`) VALUES
(1, 'Salle de massage 1', 1),
(2, 'Salle de massage 2', 1),
(3, 'Salle de massage 3', 0);

--
-- Triggers `Salle`
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
-- Table structure for table `types_massages`
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
-- Dumping data for table `types_massages`
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
(64, 'Huiles Divines', 'massage avec de aux huiles divines', 150.00, '2025-01-11 11:06:49', '2025-01-11 10:07:07'),
(100, 'tèuehfiuqezhfu', 'zeoijreoigjoierjgjoi', 65258.01, '2025-04-05 08:20:18', '2025-04-17 18:05:25');

--
-- Triggers `types_massages`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `comptes_utilisateurs`
--
ALTER TABLE `comptes_utilisateurs`
  ADD PRIMARY KEY (`compte_id`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`employe_id`),
  ADD UNIQUE KEY `compte_id` (`compte_id`);

--
-- Indexes for table `en_attente`
--
ALTER TABLE `en_attente`
  ADD PRIMARY KEY (`en_attente_id`),
  ADD KEY `compte_id` (`compte_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `en_attente_ibfk_3` (`panier_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`panier_id`),
  ADD KEY `compte_id` (`compte_id`),
  ADD KEY `type_massage_id` (`type_massage_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `salle_id` (`salle_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `employe_id` (`employe_id`),
  ADD KEY `reservations_ibfk_4` (`compte_id`);

--
-- Indexes for table `Salle`
--
ALTER TABLE `Salle`
  ADD PRIMARY KEY (`salle_id`);

--
-- Indexes for table `types_massages`
--
ALTER TABLE `types_massages`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comptes_utilisateurs`
--
ALTER TABLE `comptes_utilisateurs`
  MODIFY `compte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `employe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `en_attente`
--
ALTER TABLE `en_attente`
  MODIFY `en_attente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `panier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `Salle`
--
ALTER TABLE `Salle`
  MODIFY `salle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `types_massages`
--
ALTER TABLE `types_massages`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `employe_ibfk_2` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`);

--
-- Constraints for table `en_attente`
--
ALTER TABLE `en_attente`
  ADD CONSTRAINT `en_attente_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `en_attente_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types_massages` (`type_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `en_attente_ibfk_3` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`panier_id`) ON DELETE CASCADE;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`type_massage_id`) REFERENCES `types_massages` (`type_id`),
  ADD CONSTRAINT `panier_ibfk_3` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `panier_ibfk_4` FOREIGN KEY (`type_massage_id`) REFERENCES `types_massages` (`type_id`);

--
-- Constraints for table `reservations`
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
