-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 26 nov. 2024 à 07:36
-- Version du serveur : 10.11.4-MariaDB-1~deb12u1
-- Version de PHP : 8.2.7

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
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `compte_id` int(11) NOT NULL,
  `civilite` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`client_id`, `email`, `telephone`, `compte_id`, `civilite`) VALUES
(1, 'client1@exemple.com', '0123456789', 4, ''),
(2, 'client2@exemple.com', '0987654321', 5, '');

--
-- Déclencheurs `clients`
--
DELIMITER $$
CREATE TRIGGER `log_after_delete_client` AFTER DELETE ON `clients` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('clients', 'DELETE', CONCAT('Client supprimé - ID: ', OLD.client_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_client` AFTER INSERT ON `clients` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('clients', 'INSERT', CONCAT('Nouveau client créé - ID: ', NEW.client_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_client` AFTER UPDATE ON `clients` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('clients', 'UPDATE', CONCAT('Client modifié - ID: ', NEW.client_id));
END
$$
DELIMITER ;

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
(1, 'admin', '$2y$10$pggxJTNX802JOZUqBhYEJ.AHZZhzbfFeQTe2c8Gg7sHOa8XQsNgC6', 1, 'sylvain.pivois@outlook.com'),
(2, 'employe1', 'employe123', 2, ''),
(3, 'employe2', 'employe456', 2, ''),
(4, 'client1', 'client123', 3, ''),
(5, 'client2', 'client456', 3, ''),
(6, 'adminI', '$2y$10$mQCrkN62uUWdcn.AcKsEF.Kh3fau4kqPdN27bsZVsiG/ENqhxJvRO', 3, 'sylvain.pivois@outlook.fr'),
(8, 'pepsiman', '$2y$10$SMGNnwtmW9llctWxq3hjouqCaRHXbRk0OGSkQxJYbC0hJ3aJMbLRW', 3, 'pepsi@cool.fr'),
(9, 'justine', '$2y$10$4snO1V8drI6.Pukd74eP0.15ddLuxtn8QpKm4lM05w5cSjt3vmG6a', 3, 'justine@email.com'),
(10, 'admin', '$2y$10$RNqwm9wgkcZl6MN.CuNB5.yp8ZkmWjCDtZRh74kFpfj/pOicIOJqS', 3, 'test@test.fr');

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
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `action` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `date_log` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 1, 1, '2024-11-25 07:25:40');

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
  `client_id` int(11) NOT NULL,
  `preference_praticien` char(1) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `heure_reservation`, `commentaires`, `duree`, `salle_id`, `type_id`, `employe_id`, `client_id`, `preference_praticien`, `date_creation`) VALUES
(1, '2024-10-05 14:00:00', 'Massage relaxant demandé.', 60, 1, 1, 1, 1, NULL, '2024-11-26 07:16:04'),
(2, '2024-10-05 15:30:00', 'Demande de Shiatsu spécifique.', 90, 2, 2, 2, 2, NULL, '2024-11-26 07:16:04');

--
-- Déclencheurs `reservations`
--
DELIMITER $$
CREATE TRIGGER `after_reservation_insert` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    DELETE FROM panier 
    WHERE compte_id = (SELECT compte_id FROM clients WHERE client_id = NEW.client_id)
    AND type_massage_id = NEW.type_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_client_reservation_insert` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    DECLARE count_client INT;
    
    SELECT COUNT(*) INTO count_client
    FROM reservations 
    WHERE client_id = NEW.client_id 
    AND DATE(heure_reservation) = DATE(NEW.heure_reservation)
    AND ((heure_reservation BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE))
    OR (DATE_ADD(heure_reservation, INTERVAL duree MINUTE) BETWEEN NEW.heure_reservation AND DATE_ADD(NEW.heure_reservation, INTERVAL NEW.duree MINUTE)));
    
    IF count_client > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Le client a déjà une réservation sur ce créneau horaire';
    END IF;
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
DELIMITER $$
CREATE TRIGGER `log_after_delete_reservation` AFTER DELETE ON `reservations` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('reservations', 'DELETE', CONCAT('Réservation supprimée - ID: ', OLD.reservation_id, ' - Client ID: ', OLD.client_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_insert_reservation` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('reservations', 'INSERT', CONCAT('Nouvelle réservation - ID: ', NEW.reservation_id, ' - Client ID: ', NEW.client_id));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_after_update_reservation` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('reservations', 'UPDATE', CONCAT('Réservation modifiée - ID: ', NEW.reservation_id, ' - Client ID: ', NEW.client_id));
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
(1, 'Massage Suédois', 'Un massage classique qui aide à détendre les muscles.', 70.00, '2024-10-04 10:33:14', '2024-10-08 10:41:52'),
(2, 'Shiatsu', 'Massage bas sur la mdecine traditionnelle japonaise.', 70.00, '2024-10-04 10:33:14', '2024-10-18 07:58:36'),
(3, 'Massage à la Raclette', 'Massage basé sur de la raclette chaude.', 60.01, '2024-10-04 10:33:14', '2024-11-12 09:23:16'),
(4, 'Massage aux pierres chaudes', 'Utilise des pierres chauffées pour apaiser les tensions.', 90.00, '2024-10-04 10:33:14', '2024-10-04 10:33:14'),
(39, 'Test', 'description test', 69.00, '2024-10-15 06:03:00', '2024-10-15 06:20:45'),
(43, 'TestSQLInjection', 'SELECT * FROM types_massages WHERE id  1 OR 1 = 1', 14.02, '2024-10-15 06:25:29', '2024-10-18 10:54:37'),
(59, 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 14.00, '2024-10-18 08:13:20', '2024-10-18 08:13:20'),
(60, 'test', 'alert(&#39;XSS&#39;)', 15.00, '2024-10-18 10:53:44', '2024-10-18 10:53:44'),
(62, 'ffffff', 'fffffffffffffffff', 1452.00, '2024-11-08 15:39:51', '2024-11-08 15:39:51');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `compte_id` (`compte_id`);

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
  ADD KEY `client_id` (`client_id`);

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
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comptes_utilisateurs`
--
ALTER TABLE `comptes_utilisateurs`
  MODIFY `compte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `employe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `panier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Salle`
--
ALTER TABLE `Salle`
  MODIFY `salle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `types_massages`
--
ALTER TABLE `types_massages`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`);

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`compte_id`) REFERENCES `comptes_utilisateurs` (`compte_id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`type_massage_id`) REFERENCES `types_massages` (`type_id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`salle_id`) REFERENCES `Salle` (`salle_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `types_massages` (`type_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`employe_id`) REFERENCES `employe` (`employe_id`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Triggers pour la table comptes_utilisateurs
DELIMITER $
CREATE TRIGGER `log_after_insert_compte` AFTER INSERT ON `comptes_utilisateurs` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'INSERT', CONCAT('Nouveau compte créé - ID: ', NEW.compte_id));
END
$

CREATE TRIGGER `log_after_update_compte` AFTER UPDATE ON `comptes_utilisateurs` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'UPDATE', CONCAT('Compte modifié - ID: ', NEW.compte_id));
END
$

CREATE TRIGGER `log_after_delete_compte` AFTER DELETE ON `comptes_utilisateurs` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('comptes_utilisateurs', 'DELETE', CONCAT('Compte supprimé - ID: ', OLD.compte_id));
END
$

-- Triggers pour la table Salle
CREATE TRIGGER `log_after_insert_salle` AFTER INSERT ON `Salle` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'INSERT', CONCAT('Nouvelle salle créée - ID: ', NEW.salle_id));
END
$

CREATE TRIGGER `log_after_update_salle` AFTER UPDATE ON `Salle` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'UPDATE', CONCAT('Salle modifiée - ID: ', NEW.salle_id));
END
$

CREATE TRIGGER `log_after_delete_salle` AFTER DELETE ON `Salle` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('Salle', 'DELETE', CONCAT('Salle supprimée - ID: ', OLD.salle_id));
END
$

-- Triggers pour la table types_massages
CREATE TRIGGER `log_after_insert_type_massage` AFTER INSERT ON `types_massages` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'INSERT', CONCAT('Nouveau type de massage créé - ID: ', NEW.type_id));
END
$

CREATE TRIGGER `log_after_update_type_massage` AFTER UPDATE ON `types_massages` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'UPDATE', CONCAT('Type de massage modifié - ID: ', NEW.type_id));
END
$

CREATE TRIGGER `log_after_delete_type_massage` AFTER DELETE ON `types_massages` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('types_massages', 'DELETE', CONCAT('Type de massage supprimé - ID: ', OLD.type_id));
END
$

-- Triggers pour la table panier
CREATE TRIGGER `log_after_insert_panier` AFTER INSERT ON `panier` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'INSERT', CONCAT('Nouvel article ajouté au panier - ID: ', NEW.panier_id));
END
$

CREATE TRIGGER `log_after_update_panier` AFTER UPDATE ON `panier` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'UPDATE', CONCAT('Article du panier modifié - ID: ', NEW.panier_id));
END
$

CREATE TRIGGER `log_after_delete_panier` AFTER DELETE ON `panier` FOR EACH ROW
BEGIN
    INSERT INTO logs (table_name, action, description)
    VALUES ('panier', 'DELETE', CONCAT('Article supprimé du panier - ID: ', OLD.panier_id));
END
$
DELIMITER ;
