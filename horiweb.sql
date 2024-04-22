-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 22 avr. 2024 à 17:23
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
  `Id_Notification` double NOT NULL,
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

-- --------------------------------------------------------

--
-- Structure de la table `joint_comment`
--

CREATE TABLE `joint_comment` (
  `ID_post` double NOT NULL,
  `ID_comment` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `joint_like`
--

CREATE TABLE `joint_like` (
  `ID_post` double DEFAULT NULL,
  `ID_user` double DEFAULT NULL,
  `boolean_like` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `ID_Notification` double NOT NULL,
  `Message` varchar(200) NOT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `Date_Noficitation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notify`
--

CREATE TABLE `notify` (
  `ID_Utilisateur` double NOT NULL,
  `Id_Notification` double NOT NULL,
  `isRead` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `ID` double NOT NULL,
  `ID_subject` double NOT NULL,
  `Text` varchar(300) NOT NULL,
  `Picture` varchar(50) NOT NULL,
  `CreationDate` date NOT NULL,
  `ID_user` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`ID`, `ID_subject`, `Text`, `Picture`, `CreationDate`, `ID_user`) VALUES
(1, 1, 'J\'aime les chats', '', '2024-03-28', 1),
(2, 1, 'J\'aime les chats', '', '2024-03-28', 1);

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE `subjects` (
  `ID` double NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `subjects`
--

INSERT INTO `subjects` (`ID`, `name`, `description`) VALUES
(1, 'Chat', 'Sujet sur les petits chat tout pipou'),
(2, 'Chien', 'Ici on parle de chien !');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` double NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Birthdate` date NOT NULL,
  `Password` varchar(100) NOT NULL,
  `ProfilePicture` varchar(25) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `ProfilDescription` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `FirstName`, `Name`, `Username`, `Birthdate`, `Password`, `ProfilePicture`, `isAdmin`, `ProfilDescription`) VALUES
(1, 'Nicolas', 'R', 'nico', '2024-03-11', 'password', '', 1, 'Yo');

-- --------------------------------------------------------

--
-- Structure de la table `warning`
--

CREATE TABLE `warning` (
  `ID_user` double NOT NULL,
  `Id_Notification` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ban`
--
ALTER TABLE `ban`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `Id_Notification` (`Id_Notification`);

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
  ADD PRIMARY KEY (`ID_Notification`);

--
-- Index pour la table `notify`
--
ALTER TABLE `notify`
  ADD KEY `Id_Notification` (`Id_Notification`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `subject` (`ID_subject`),
  ADD KEY `subject_id` (`ID_subject`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Index pour la table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `warning`
--
ALTER TABLE `warning`
  ADD KEY `ID_user` (`ID_user`),
  ADD KEY `Id_Notification` (`Id_Notification`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID_Notification` double NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `ID` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `ban_ibfk_2` FOREIGN KEY (`Id_Notification`) REFERENCES `notification` (`ID_Notification`);

--
-- Contraintes pour la table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`ID_follower`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_comment`
--
ALTER TABLE `joint_comment`
  ADD CONSTRAINT `joint_comment_ibfk_1` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_comment_ibfk_2` FOREIGN KEY (`ID_comment`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_like`
--
ALTER TABLE `joint_like`
  ADD CONSTRAINT `joint_like_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_like_ibfk_2` FOREIGN KEY (`ID_post`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_subject`
--
ALTER TABLE `joint_subject`
  ADD CONSTRAINT `joint_subject_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_subject_ibfk_2` FOREIGN KEY (`ID_subject`) REFERENCES `subjects` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notify`
--
ALTER TABLE `notify`
  ADD CONSTRAINT `notify_ibfk_1` FOREIGN KEY (`Id_Notification`) REFERENCES `notification` (`ID_Notification`),
  ADD CONSTRAINT `notify_ibfk_2` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `users` (`ID`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`ID_subject`) REFERENCES `subjects` (`ID`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `warning`
--
ALTER TABLE `warning`
  ADD CONSTRAINT `warning_ibfk_1` FOREIGN KEY (`Id_Notification`) REFERENCES `notification` (`ID_Notification`),
  ADD CONSTRAINT `warning_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
