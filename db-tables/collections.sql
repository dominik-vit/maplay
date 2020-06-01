-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Počítač: wm68.wedos.net:3306
-- Vygenerováno: Ned 26. dub 2020, 21:40
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
-- Struktura tabulky `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collNAME` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `public` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Vypisuji data pro tabulku `collections`
--

INSERT INTO `collections` (`id`, `collNAME`, `userID`, `public`) VALUES
(3, 'Sever Rakouska', 2, 1),
(17, 'Iceland', 3, 0),
(18, 'Bavaria', 1, 1),
(20, 'JuÅ¾nÃ½ pÃ¡s', 1, 0),
(21, 'pokus1', 1, 0),
(22, 'sd', 6, 1),
(23, 'Uhry', 6, 1),
(24, '', 3, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
