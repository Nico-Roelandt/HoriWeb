-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 25 mars 2024 à 16:42
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
-- Structure de la table `follower`
--

CREATE TABLE `follower` (
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
-- Structure de la table `joint_post`
--

CREATE TABLE `joint_post` (
  `ID_post` double DEFAULT NULL,
  `ID_user` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `ID` double NOT NULL,
  `Text` varchar(300) NOT NULL,
  `Picture` varchar(50) NOT NULL,
  `CreationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`ID`, `Text`, `Picture`, `CreationDate`) VALUES
(1, 'J\'aime les pates', '', '2024-03-22');

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

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `follower`
--
ALTER TABLE `follower`
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
-- Index pour la table `joint_post`
--
ALTER TABLE `joint_post`
  ADD KEY `ID_post` (`ID_post`,`ID_user`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `ID` double NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `follower_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follower_ibfk_2` FOREIGN KEY (`ID_follower`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_comment`
--
ALTER TABLE `joint_comment`
  ADD CONSTRAINT `joint_comment_ibfk_1` FOREIGN KEY (`ID_post`) REFERENCES `post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_comment_ibfk_2` FOREIGN KEY (`ID_comment`) REFERENCES `post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_like`
--
ALTER TABLE `joint_like`
  ADD CONSTRAINT `joint_like_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_like_ibfk_2` FOREIGN KEY (`ID_post`) REFERENCES `post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `joint_post`
--
ALTER TABLE `joint_post`
  ADD CONSTRAINT `joint_post_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joint_post_ibfk_2` FOREIGN KEY (`ID_post`) REFERENCES `post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
