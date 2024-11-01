-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 01, 2024 at 02:00 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practical`
--

-- --------------------------------------------------------

--
-- Table structure for table `signal_lights`
--

DROP TABLE IF EXISTS `signal_lights`;
CREATE TABLE IF NOT EXISTS `signal_lights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `light_name` varchar(10) NOT NULL,
  `light_sequence` int(11) NOT NULL,
  `green_interval` int(11) NOT NULL,
  `yellow_interval` int(11) NOT NULL,
  `added_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signal_lights`
--

INSERT INTO `signal_lights` (`id`, `light_name`, `light_sequence`, `green_interval`, `yellow_interval`, `added_date`, `updated_date`) VALUES
(1, 'A', 3, 2, 2, '2024-11-01 00:00:00', '2024-11-01 13:57:46'),
(2, 'B', 2, 2, 2, '2024-11-01 00:00:00', '2024-11-01 13:57:46'),
(3, 'C', 4, 2, 2, '2024-11-01 00:00:00', '2024-11-01 13:57:46'),
(4, 'D', 1, 2, 2, '2024-11-01 00:00:00', '2024-11-01 13:57:46');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
