-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 10:30 PM
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
-- Database: `rezepte`
--

-- --------------------------------------------------------

--
-- Table structure for table `bewertung`
--

CREATE TABLE `bewertung` (
  `bewertung_id` int(11) NOT NULL,
  `rezept_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `anzahlsterne` int(11) NOT NULL,
  `kommentar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rezept`
--

CREATE TABLE `rezept` (
  `rezept_id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `zubereitung` text NOT NULL,
  `zubereitungsdauer` int(11) NOT NULL,
  `portionen` int(11) NOT NULL,
  `ernaehrung` enum('Vegan','Vegetarisch','Fleisch','Fisch') NOT NULL,
  `schwierigkeitsgrad` enum('Leicht','Mittel','Schwer') NOT NULL,
  `mahlzeitkategorie` enum('Frühstück','Mittagessen','Abendessen','Dessert','Snack') NOT NULL,
  `kueche` enum('Amerikanisch','Italienisch','Indisch','Asiatisch','Orientalisch','Deutsch') NOT NULL,
  `bild` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zutaten`
--

CREATE TABLE `zutaten` (
  `zutaten_id` int(11) NOT NULL,
  `rezept_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `menge` decimal(10,2) NOT NULL,
  `einheit` enum('g','ml','Stück','TL','EL','L','kg') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bewertung`
--
ALTER TABLE `bewertung`
  ADD PRIMARY KEY (`bewertung_id`);

--
-- Indexes for table `rezept`
--
ALTER TABLE `rezept`
  ADD PRIMARY KEY (`rezept_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `zutaten`
--
ALTER TABLE `zutaten`
  ADD PRIMARY KEY (`zutaten_id`),
  ADD KEY `rezept_id` (`rezept_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bewertung`
--
ALTER TABLE `bewertung`
  MODIFY `bewertung_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezept`
--
ALTER TABLE `rezept`
  MODIFY `rezept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zutaten`
--
ALTER TABLE `zutaten`
  MODIFY `zutaten_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rezept`
--
ALTER TABLE `rezept`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `zutaten`
--
ALTER TABLE `zutaten`
  ADD CONSTRAINT `zutaten_ibfk_1` FOREIGN KEY (`rezept_id`) REFERENCES `rezept` (`rezept_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
