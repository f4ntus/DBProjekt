-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Apr 2020 um 16:36
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `befragungstool`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_abschliessen`
--

CREATE TABLE `tbl_abschliessen` (
  `Matrikelnummer` char(7) NOT NULL,
  `FbNr` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_beantwortet`
--

CREATE TABLE `tbl_beantwortet` (
  `FNr` tinyint(4) NOT NULL,
  `FbNr` mediumint(9) NOT NULL,
  `Matrikelnummer` char(7) NOT NULL,
  `Bewertung` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_befrager`
--

CREATE TABLE `tbl_befrager` (
  `Benutzername` varchar(32) NOT NULL,
  `Kennwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_befrager`
--

INSERT INTO `tbl_befrager` (`Benutzername`, `Kennwort`) VALUES
('Luxe', 'stinkt');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_frage`
--

CREATE TABLE `tbl_frage` (
  `FbNr` mediumint(9) NOT NULL,
  `FNr` tinyint(4) NOT NULL,
  `Fragetext` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_fragebogen`
--

CREATE TABLE `tbl_fragebogen` (
  `FbNr` mediumint(9) NOT NULL,
  `Titel` text NOT NULL,
  `Benutzername` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_fragebogen`
--

INSERT INTO `tbl_fragebogen` (`FbNr`, `Titel`, `Benutzername`) VALUES
(1, 'Test Titel keine Ahnung', 'luxe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_freigeschaltet`
--

CREATE TABLE `tbl_freigeschaltet` (
  `FbNr` mediumint(9) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_kommentiert`
--

CREATE TABLE `tbl_kommentiert` (
  `FbNr` mediumint(9) NOT NULL,
  `Matrikelnummer` char(7) NOT NULL,
  `Kommentar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_kurs`
--

CREATE TABLE `tbl_kurs` (
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_student`
--

CREATE TABLE `tbl_student` (
  `Matrikelnummer` char(7) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_abschliessen`
--
ALTER TABLE `tbl_abschliessen`
  ADD PRIMARY KEY (`Matrikelnummer`,`FbNr`),
  ADD KEY `FbNr` (`FbNr`);

--
-- Indizes für die Tabelle `tbl_beantwortet`
--
ALTER TABLE `tbl_beantwortet`
  ADD PRIMARY KEY (`FNr`,`FbNr`,`Matrikelnummer`),
  ADD KEY `FbNr` (`FbNr`),
  ADD KEY `Matrikelnummer` (`Matrikelnummer`);

--
-- Indizes für die Tabelle `tbl_befrager`
--
ALTER TABLE `tbl_befrager`
  ADD PRIMARY KEY (`Benutzername`);

--
-- Indizes für die Tabelle `tbl_frage`
--
ALTER TABLE `tbl_frage`
  ADD PRIMARY KEY (`FNr`,`FbNr`),
  ADD KEY `FbNr` (`FbNr`);

--
-- Indizes für die Tabelle `tbl_fragebogen`
--
ALTER TABLE `tbl_fragebogen`
  ADD PRIMARY KEY (`FbNr`),
  ADD KEY `Benutzername` (`Benutzername`);

--
-- Indizes für die Tabelle `tbl_freigeschaltet`
--
ALTER TABLE `tbl_freigeschaltet`
  ADD PRIMARY KEY (`FbNr`,`Name`),
  ADD KEY `Name` (`Name`);

--
-- Indizes für die Tabelle `tbl_kommentiert`
--
ALTER TABLE `tbl_kommentiert`
  ADD PRIMARY KEY (`FbNr`,`Matrikelnummer`),
  ADD KEY `Matrikelnummer` (`Matrikelnummer`);

--
-- Indizes für die Tabelle `tbl_kurs`
--
ALTER TABLE `tbl_kurs`
  ADD PRIMARY KEY (`Name`);

--
-- Indizes für die Tabelle `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`Matrikelnummer`),
  ADD KEY `Name` (`Name`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_frage`
--
ALTER TABLE `tbl_frage`
  MODIFY `FNr` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_fragebogen`
--
ALTER TABLE `tbl_fragebogen`
  MODIFY `FbNr` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_abschliessen`
--
ALTER TABLE `tbl_abschliessen`
  ADD CONSTRAINT `tbl_abschliessen_ibfk_1` FOREIGN KEY (`FbNr`) REFERENCES `tbl_fragebogen` (`FbNr`),
  ADD CONSTRAINT `tbl_abschliessen_ibfk_2` FOREIGN KEY (`Matrikelnummer`) REFERENCES `tbl_student` (`Matrikelnummer`);

--
-- Constraints der Tabelle `tbl_beantwortet`
--
ALTER TABLE `tbl_beantwortet`
  ADD CONSTRAINT `tbl_beantwortet_ibfk_1` FOREIGN KEY (`FbNr`) REFERENCES `tbl_fragebogen` (`FbNr`),
  ADD CONSTRAINT `tbl_beantwortet_ibfk_2` FOREIGN KEY (`FNr`) REFERENCES `tbl_frage` (`FNr`),
  ADD CONSTRAINT `tbl_beantwortet_ibfk_3` FOREIGN KEY (`Matrikelnummer`) REFERENCES `tbl_student` (`Matrikelnummer`);

--
-- Constraints der Tabelle `tbl_frage`
--
ALTER TABLE `tbl_frage`
  ADD CONSTRAINT `tbl_frage_ibfk_1` FOREIGN KEY (`FbNr`) REFERENCES `tbl_fragebogen` (`FbNr`);

--
-- Constraints der Tabelle `tbl_fragebogen`
--
ALTER TABLE `tbl_fragebogen`
  ADD CONSTRAINT `tbl_fragebogen_ibfk_1` FOREIGN KEY (`Benutzername`) REFERENCES `tbl_befrager` (`Benutzername`);

--
-- Constraints der Tabelle `tbl_freigeschaltet`
--
ALTER TABLE `tbl_freigeschaltet`
  ADD CONSTRAINT `tbl_freigeschaltet_ibfk_1` FOREIGN KEY (`FbNr`) REFERENCES `tbl_fragebogen` (`FbNr`),
  ADD CONSTRAINT `tbl_freigeschaltet_ibfk_2` FOREIGN KEY (`Name`) REFERENCES `tbl_kurs` (`Name`);

--
-- Constraints der Tabelle `tbl_kommentiert`
--
ALTER TABLE `tbl_kommentiert`
  ADD CONSTRAINT `tbl_kommentiert_ibfk_1` FOREIGN KEY (`FbNr`) REFERENCES `tbl_fragebogen` (`FbNr`),
  ADD CONSTRAINT `tbl_kommentiert_ibfk_2` FOREIGN KEY (`Matrikelnummer`) REFERENCES `tbl_student` (`Matrikelnummer`);

--
-- Constraints der Tabelle `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `tbl_student_ibfk_1` FOREIGN KEY (`Name`) REFERENCES `tbl_kurs` (`Name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
