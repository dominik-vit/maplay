-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Počítač: wm68.wedos.net:3306
-- Vygenerováno: Ned 26. dub 2020, 21:41
-- Verze serveru: 5.6.17
-- Verze PHP: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `d80044_reg`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `points`
--

CREATE TABLE IF NOT EXISTS `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `name` varchar(60) NOT NULL,
  `datum` date NOT NULL,
  `visibility` int(1) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `collectionID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `collectionID` (`collectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Vypisuji data pro tabulku `points`
--

INSERT INTO `points` (`id`, `lat`, `lon`, `name`, `datum`, `visibility`, `userID`, `collectionID`) VALUES
(12, 47.80093296, 13.04247579, 'Salzburg', '2019-12-16', 1, 2, 3),
(13, 48.29820592, 14.26808164, 'Linz', '2017-06-14', 1, 2, 3),
(14, 46.59208269, 13.86777482, 'Villach', '2018-01-09', 1, 2, 3),
(15, 47.06919087, 15.42556511, 'Graz', '2018-11-16', 1, 2, 3),
(64, 63.7733515, -17.75716621, 'IC-c', '2020-04-01', 0, 3, 17),
(65, 63.59527432, -19.49784226, 'IC-b', '2020-03-31', 0, 3, 17),
(66, 64.07603219, -21.81236756, 'IC-a', '2020-03-30', 0, 3, 17),
(67, 48.11100842, 11.57667082, 'Mnichov', '2020-04-07', 1, 1, 18),
(68, 49.42594858, 11.06315335, 'Nurnberg', '2020-04-08', 1, 1, 18),
(71, 48.73924616, 19.14889754, 'BB', '2020-01-08', 1, 5, 20),
(72, 48.14459797, 17.08876294, 'Bratislava', '2020-01-29', 1, 5, 20),
(73, 48.19519775, 16.3517636, 'VÃ­deÅˆ', '2020-02-12', 1, 5, 20),
(74, 48.30398697, 14.28037622, 'Linec', '2020-03-12', 1, 5, 20),
(81, 48.84258529, 16.3236475, 'ads', '2020-04-06', 1, 6, 21),
(82, 49.87191404, 16.53550777, 'f', '2020-04-13', 1, 6, 22),
(84, 46.06202352, 18.20627795, 'Pecs', '2020-04-02', 1, 6, 23),
(85, 47.51026176, 19.05827628, 'Budapest', '2020-04-03', 1, 6, 23),
(86, 49.56714789, 15.08648681, 'pokusdb', '2020-04-06', 0, 3, NULL),
(87, 47.66750456, 13.71706988, 'config2', '0000-00-00', 0, 3, 24);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `points_ibfk_2` FOREIGN KEY (`collectionID`) REFERENCES `collections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `points_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
