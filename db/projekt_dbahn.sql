-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Mai 2023 um 21:42
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projekt_dbahn`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `favourite_stations`
--

CREATE TABLE `favourite_stations` (
  `idFavourite_stations` int(255) NOT NULL,
  `id_user` int(255) NOT NULL,
  `idStation` int(20) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `stationName` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `favourite_stations`
--

INSERT INTO `favourite_stations` (`idFavourite_stations`, `id_user`, `idStation`, `typ`, `stationName`) VALUES
(16, 1, 3881, 'isBahnhof', 'Magdeburg Hbf'),
(17, 1, 6184, 'isBahnhof', 'Thale Hbf');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `idUser` int(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `password` varchar(65) NOT NULL,
  `salt` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`idUser`, `name`, `password`, `salt`) VALUES
(1, 'Kai', '82c233392bb6e005b2d8761be9bee3be9452fd543dfcf403b51661370776d6d6', '08ac13850471');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `favourite_stations`
--
ALTER TABLE `favourite_stations`
  ADD PRIMARY KEY (`idFavourite_stations`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `favourite_stations`
--
ALTER TABLE `favourite_stations`
  MODIFY `idFavourite_stations` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
