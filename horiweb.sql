-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 mai 2024 à 18:41
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `horiweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `ban`
--

CREATE TABLE `ban` (
  `ID_user` double NOT NULL,
  `ID_notif` double NOT NULL,
  `Duration` time NOT NULL,
  `isTemporary` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `followers`
--

CREATE TABLE `followers` (
  `ID_user` double NOT NULL,
  `ID_follower` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `followers`
--

INSERT INTO `followers` (`ID_user`, `ID_follower`) VALUES
(6, 7),
(6, 7),
(8, 7),
(8, 7),
(6, 8),
(6, 8);

-- --------------------------------------------------------

--
-- Structure de la table `joint_comment`
--

CREATE TABLE `joint_comment` (
  `ID_post` double NOT NULL,
  `ID_comment` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joint_comment`
--

INSERT INTO `joint_comment` (`ID_post`, `ID_comment`) VALUES
(27, 28);

-- --------------------------------------------------------

--
-- Structure de la table `joint_like`
--

CREATE TABLE `joint_like` (
  `ID_post` double DEFAULT NULL,
  `ID_user` double DEFAULT NULL,
  `boolean_like` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joint_like`
--

INSERT INTO `joint_like` (`ID_post`, `ID_user`, `boolean_like`) VALUES
(27, 7, 0),
(27, 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `joint_subject`
--

CREATE TABLE `joint_subject` (
  `ID_user` double NOT NULL,
  `ID_subject` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joint_subject`
--

INSERT INTO `joint_subject` (`ID_user`, `ID_subject`) VALUES
(7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `ID_notif` double NOT NULL,
  `Message` varchar(200) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `Date_Notification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`ID_notif`, `Message`, `isDelete`, `Date_Notification`) VALUES
(2, 'Votre post a été supprimé', 0, '2024-05-10 18:26:42'),
(3, 'Votre post a été supprimé', 0, '2024-05-10 18:33:07');

-- --------------------------------------------------------

--
-- Structure de la table `notify`
--

CREATE TABLE `notify` (
  `ID_user` double NOT NULL,
  `ID_notif` double NOT NULL,
  `isRead` tinyint(1) NOT NULL,
  `isDelete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `ID_post` double NOT NULL,
  `ID_subject` double DEFAULT NULL,
  `Text` varchar(300) NOT NULL,
  `Picture` varchar(50) NOT NULL,
  `CreationDate` date NOT NULL,
  `ID_user` double NOT NULL,
  `isSensible` tinyint(1) NOT NULL,
  `isRemove` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`ID_post`, `ID_subject`, `Text`, `Picture`, `CreationDate`, `ID_user`, `isSensible`, `isRemove`) VALUES
(27, 1, 'J\'adore les chats', '', '2024-05-10', 7, 1, 0),
(28, NULL, 'Je suis d\'accord', '', '2024-05-10', 7, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE `subjects` (
  `ID_subject` double NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `subjects`
--

INSERT INTO `subjects` (`ID_subject`, `name`, `description`) VALUES
(1, 'Chat', 'Sujet sur les petits chat tout pipou'),
(2, 'Chien', 'Ici on parle de chien !');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID_user` double NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Birthdate` date NOT NULL,
  `Password` varchar(100) NOT NULL,
  `ProfilePicture` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `ProfilDescription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID_user`, `FirstName`, `Name`, `Username`, `email`, `Birthdate`, `Password`, `ProfilePicture`, `isAdmin`, `ProfilDescription`) VALUES
(6, 'admin', 'admin', 'admin', 'admin@horiweb.com', '2024-05-10', '$2y$10$6oVhbJ6Oy6UiINMGdEDn1uyL/z94DZW/NNbxwBOW6OxpQhqlPrWh2', '', 1, ''),
(7, 'Nicolas', 'Roelandt', 'nico', 'nicolas.roelandt59@orange.fr', '2003-05-20', '$2y$10$end2Yc.YkbeGeQIMO4Fgbe9WaglZ2BcsYnfo0qT/C4TXdJonBagNa', '', NULL, 'j\'ai 20 ans et toutes mes dents'),
(8, 'Elie', 'Vitrai', 'Elie', 'elie@horiweb.com', '2024-05-02', '$2y$10$xeDvZ4dkNhGBYWLnwnoYRevbMqyC4hNcW72vjf6SO5DQ5FUcVHex.', '', NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `warning`
--

CREATE TABLE `warning` (
  `ID_user` double NOT NULL,
  `ID_notif` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ban`
--
ALTER TABLE `ban`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `Id_Notification` (`ID_notif`);

--
-- Index pour la table `followers`
--
ALTER TABLE `followers`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `ID_follower` (`ID_follower`);

--
-- Index pour la table `joint_comment`
--
ALTER TABLE `joint_comment`
  ADD KEY `ID_post` (`ID_post`),
  ADD KEY `ID_comment` (`ID_comment`);

--
-- Index pour la table `joint_like`
--
ALTER TABLE `joint_like`
  ADD KEY `ID_post` (`ID_post`,`ID_user`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Index pour la table `joint_subject`
--
ALTER TABLE `joint_subject`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `ID_subject` (`ID_subject`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID_notif`);

--
-- Index pour la table `notify`
--
ALTER TABLE `notify`
  ADD KEY `Id_Notification` (`ID_notif`),
  ADD KEY `ID_Utilisateur` (`ID_user`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID_post`),
  ADD KEY `subject` (`ID_subject`),
  ADD KEY `subject_id` (`ID_subject`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Index pour la table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID_subject`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_user`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `warning`
--
ALTER TABLE `warning`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `Id_Notification` (`ID_notif`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID_notif` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID_post` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID_subject` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID_user` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_2` FOREIGN KEY (`ID_notif`) REFERENCES `notification` (`ID_notif`),
  ADD CONSTRAINT `ban_ibfk_3` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`);

--
-- Contraintes pour la table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`ID_follower`) REFERENCES `users` (`ID_user`);

--
-- Contraintes pour la table `joint_comment`
--
ALTER TABLE `joint_comment`
  ADD CONSTRAINT `joint_comment_ibfk_1` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_comment_ibfk_2` FOREIGN KEY (`ID_comment`) REFERENCES `posts` (`ID_post`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_like`
--
ALTER TABLE `joint_like`
  ADD CONSTRAINT `joint_like_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`),
  ADD CONSTRAINT `joint_like_ibfk_2` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID_post`);

--
-- Contraintes pour la table `joint_subject`
--
ALTER TABLE `joint_subject`
  ADD CONSTRAINT `joint_subject_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`),
  ADD CONSTRAINT `joint_subject_ibfk_2` FOREIGN KEY (`ID_subject`) REFERENCES `subjects` (`ID_subject`);

--
-- Contraintes pour la table `notify`
--
ALTER TABLE `notify`
  ADD CONSTRAINT `notify_ibfk_1` FOREIGN KEY (`ID_notif`) REFERENCES `notification` (`ID_notif`),
  ADD CONSTRAINT `notify_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`ID_subject`) REFERENCES `subjects` (`ID_subject`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`);

--
-- Contraintes pour la table `warning`
--
ALTER TABLE `warning`
  ADD CONSTRAINT `warning_ibfk_1` FOREIGN KEY (`ID_notif`) REFERENCES `notification` (`ID_notif`),
  ADD CONSTRAINT `warning_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
