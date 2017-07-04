-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 04 Juillet 2017 à 11:21
-- Version du serveur :  5.5.55-0+deb8u1
-- Version de PHP :  7.0.20-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `stickframework`
--

-- --------------------------------------------------------

--
-- Structure de la table `stck_categories`
--

CREATE TABLE IF NOT EXISTS `stck_categories` (
`categorieId` int(11) NOT NULL,
  `categorieName` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stck_categories`
--

INSERT INTO `stck_categories` (`categorieId`, `categorieName`) VALUES
(1, 'Le PHP'),
(2, 'Le javaScript'),
(3, 'Le Html');

-- --------------------------------------------------------

--
-- Structure de la table `stck_groups`
--

CREATE TABLE IF NOT EXISTS `stck_groups` (
`groupId` int(11) NOT NULL,
  `groupName` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stck_groups`
--

INSERT INTO `stck_groups` (`groupId`, `groupName`) VALUES
(1, 'Admin'),
(2, 'Staff'),
(3, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `stck_posts`
--

CREATE TABLE IF NOT EXISTS `stck_posts` (
`postId` int(11) NOT NULL,
  `postName` varchar(50) NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `postContent` longtext,
  `userId` int(11) DEFAULT NULL,
  `categorieId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stck_posts`
--

INSERT INTO `stck_posts` (`postId`, `postName`, `postDate`, `postContent`, `userId`, `categorieId`) VALUES
(1, 'Make PHP great again !', '2017-07-03 20:52:32', 'Premier article sur le PHP !', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `stck_users`
--

CREATE TABLE IF NOT EXISTS `stck_users` (
`userId` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `userNickname` varchar(30) DEFAULT NULL,
  `userMail` varchar(50) DEFAULT NULL,
  `userIsActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stck_users`
--

INSERT INTO `stck_users` (`userId`, `userName`, `userNickname`, `userMail`, `userIsActive`) VALUES
(1, 'Francis', 'Joe the Pimp', 'francis.contact.mail@gmail.com', 1),
(2, 'Quentin', 'Tchikito', 'Quentin@StickFrameWork.com', 1),
(3, 'Balthazar', 'le Turfu', 'balthazar@StickFrameWork.com', 1),
(4, 'Albert', 'The Artist', 'Albert@isafakeperson.com', 1);

-- --------------------------------------------------------

--
-- Structure de la table `stck_users_groups`
--

CREATE TABLE IF NOT EXISTS `stck_users_groups` (
  `groupId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `stck_users_groups`
--

INSERT INTO `stck_users_groups` (`groupId`, `userId`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `stck_categories`
--
ALTER TABLE `stck_categories`
 ADD PRIMARY KEY (`categorieId`);

--
-- Index pour la table `stck_groups`
--
ALTER TABLE `stck_groups`
 ADD PRIMARY KEY (`groupId`);

--
-- Index pour la table `stck_posts`
--
ALTER TABLE `stck_posts`
 ADD PRIMARY KEY (`postId`), ADD KEY `FK_stck_posts_userId` (`userId`), ADD KEY `FK_stck_posts_categorieId` (`categorieId`);

--
-- Index pour la table `stck_users`
--
ALTER TABLE `stck_users`
 ADD PRIMARY KEY (`userId`);

--
-- Index pour la table `stck_users_groups`
--
ALTER TABLE `stck_users_groups`
 ADD PRIMARY KEY (`groupId`,`userId`), ADD KEY `FK_stck_users_groups_userId` (`userId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `stck_categories`
--
ALTER TABLE `stck_categories`
MODIFY `categorieId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `stck_groups`
--
ALTER TABLE `stck_groups`
MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `stck_posts`
--
ALTER TABLE `stck_posts`
MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `stck_users`
--
ALTER TABLE `stck_users`
MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `stck_posts`
--
ALTER TABLE `stck_posts`
ADD CONSTRAINT `FK_stck_posts_categorieId` FOREIGN KEY (`categorieId`) REFERENCES `stck_categories` (`categorieId`),
ADD CONSTRAINT `FK_stck_posts_userId` FOREIGN KEY (`userId`) REFERENCES `stck_users` (`userId`);

--
-- Contraintes pour la table `stck_users_groups`
--
ALTER TABLE `stck_users_groups`
ADD CONSTRAINT `FK_stck_users_groups_groupId` FOREIGN KEY (`groupId`) REFERENCES `stck_groups` (`groupId`),
ADD CONSTRAINT `FK_stck_users_groups_userId` FOREIGN KEY (`userId`) REFERENCES `stck_users` (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
