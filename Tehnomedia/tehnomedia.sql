-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2023 at 06:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tehnomedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `brend`
--

CREATE TABLE `brend` (
  `brend_id` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brend`
--

INSERT INTO `brend` (`brend_id`, `naziv`) VALUES
(1, 'Asus'),
(2, 'Apple'),
(3, 'Dell'),
(4, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `izvestaj`
--

CREATE TABLE `izvestaj` (
  `izvestaj_id` int(11) NOT NULL,
  `datum_izvestaja` date NOT NULL,
  `izvestaj` text NOT NULL,
  `uneo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `izvestaj`
--

INSERT INTO `izvestaj` (`izvestaj_id`, `datum_izvestaja`, `izvestaj`, `uneo`) VALUES
(1, '2023-01-01', 'Ovo je prvi izvestaj u ovoj godini.', 'Pera'),
(2, '2023-01-02', 'Ovo je drugi izvestaj ove godine.', 'Pera');

-- --------------------------------------------------------

--
-- Table structure for table `proizvod`
--

CREATE TABLE `proizvod` (
  `proizvod_id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `cena` decimal(11,0) NOT NULL,
  `datumUnosa` date NOT NULL,
  `zaposleni_id` int(11) NOT NULL,
  `brend_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proizvod`
--

INSERT INTO `proizvod` (`proizvod_id`, `naziv`, `cena`, `datumUnosa`, `zaposleni_id`, `brend_id`) VALUES
(1, 'iphone 11', '70000', '2020-07-05', 1, 2),
(2, 'Zenbook 14 laptop', '50000', '2022-01-11', 1, 1),
(3, 'Samsung Galaxy S20 Mini telefon', '54000', '2020-05-12', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `zaposleni`
--

CREATE TABLE `zaposleni` (
  `zaposleni_id` int(11) NOT NULL,
  `ime` varchar(20) NOT NULL,
  `prezime` varchar(20) NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `sifra` varchar(20) NOT NULL,
  `korisnicko_ime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zaposleni`
--

INSERT INTO `zaposleni` (`zaposleni_id`, `ime`, `prezime`, `datum_rodjenja`, `sifra`, `korisnicko_ime`) VALUES
(1, 'Milena', 'Erbez', '2001-12-02', 'admin123', 'admin'),
(2, 'Pera', 'Peric', '2000-12-12', 'pera123', 'pera');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brend`
--
ALTER TABLE `brend`
  ADD PRIMARY KEY (`brend_id`);

--
-- Indexes for table `izvestaj`
--
ALTER TABLE `izvestaj`
  ADD PRIMARY KEY (`izvestaj_id`);

--
-- Indexes for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD PRIMARY KEY (`proizvod_id`),
  ADD KEY `radnik` (`zaposleni_id`),
  ADD KEY `brend` (`brend_id`);

--
-- Indexes for table `zaposleni`
--
ALTER TABLE `zaposleni`
  ADD PRIMARY KEY (`zaposleni_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD CONSTRAINT `brend` FOREIGN KEY (`brend_id`) REFERENCES `brend` (`brend_id`),
  ADD CONSTRAINT `radnik` FOREIGN KEY (`zaposleni_id`) REFERENCES `zaposleni` (`zaposleni_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
