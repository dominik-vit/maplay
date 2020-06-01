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
-- Struktura tabulky `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `email`, `activation_code`) VALUES
(1, 'mikllhor', '$2y$10$4C5T5iKve9.rrMt33FaAi.k5K3HWvNNY4jDnRwuUrwrmLdbxCf.AK', 'mikllhor@gmail.com', 'activated'),
(2, 'test1', '$2y$10$kR2BVBICKF2jrR5y0i90D.ykA2oyHbOla467xH9TJRDl3KTdvL8i.', 'test1@gmail.com', 'activated'),
(3, 'test2', '$2y$10$U6WdP367VHsISOAHtxD/mO3hV2Ku9gwURf7oNvTyqcNhwzWO2HAwG', 'test2@test.com', 'activated'),
(4, 'JanTest', '$2y$10$Bdthxy7c74Qk6Fq..XPIiOPfMNyeQCcvUL3q2g1N0nO/14bX7O8Rm', 'pinosjan@gmail.com', 'activated'),
(5, 'user', '$2y$10$vdkvBnfBq7k4/RJleEgSSeTrahMeSUxJDBc9nbcP/9N8dxLfp4Ttu', 'user@gmail.com', 'activated'),
(6, 'user2', '$2y$10$4unmNv/tyrKUP07M8MpB2ebZoTuCtkXNV//TBFKPYiSilHuNQsr7K', 'user2@gmial.com', 'activated');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
