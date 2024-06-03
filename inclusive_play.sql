-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 09:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inclusive_play`
--

-- --------------------------------------------------------

--
-- Table structure for table `gamelist`
--

CREATE TABLE `gamelist` (
  `GameID` char(5) NOT NULL CHECK (`GameID` regexp '^GA[0-9][0-9][0-9]'),
  `GameName` varchar(50) NOT NULL,
  `SteamLink` varchar(100) DEFAULT NULL,
  `EpicgamesLink` varchar(100) DEFAULT NULL,
  `Othergamelink` varchar(100) DEFAULT NULL,
  `HasColorblindMode` tinyint(1) NOT NULL,
  `IsDeafFriendly` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamepage`
--

CREATE TABLE `gamepage` (
  `GameID` char(5) NOT NULL CHECK (`GameID` regexp '^GA[0-9][0-9][0-9]'),
  `GameName` varchar(50) NOT NULL,
  `SteamLink` varchar(100) DEFAULT NULL,
  `EpicGamesLink` varchar(100) DEFAULT NULL,
  `OtherGamesLink` varchar(100) DEFAULT NULL,
  `GameImageLink` varchar(100) DEFAULT NULL,
  `HasColorblindMode` tinyint(1) NOT NULL,
  `IsDeafFriendly` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamepage`
--

INSERT INTO `gamepage` (`GameID`, `GameName`, `SteamLink`, `EpicGamesLink`, `OtherGamesLink`, `GameImageLink`, `HasColorblindMode`, `IsDeafFriendly`) VALUES
('GA001', 'Five Nights at Freddy\'s', 'https://store.steampowered.com/app/319510/Five_Nights_at_Freddys/', NULL, NULL, NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gamelist`
--
ALTER TABLE `gamelist`
  ADD PRIMARY KEY (`GameID`);

--
-- Indexes for table `gamepage`
--
ALTER TABLE `gamepage`
  ADD PRIMARY KEY (`GameID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
