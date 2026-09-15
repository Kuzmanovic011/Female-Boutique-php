-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 11:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekat_pva`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikli`
--

CREATE TABLE `artikli` (
  `idArtikla` int(3) UNSIGNED NOT NULL,
  `nazivArtikla` varchar(25) NOT NULL,
  `tipArtikla` enum('MAJICA','FARMERKE','DZEMPER','KAPUT','HALJINA','KOMPLET') NOT NULL,
  `kolicinaArtikla` int(3) UNSIGNED NOT NULL DEFAULT 1,
  `cenaArtikla` int(3) UNSIGNED NOT NULL,
  `slikaArtikla` varchar(40) NOT NULL,
  `opisArtikla` text NOT NULL DEFAULT 'nema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`idArtikla`, `nazivArtikla`, `tipArtikla`, `kolicinaArtikla`, `cenaArtikla`, `slikaArtikla`, `opisArtikla`) VALUES
(1, 'Majica1', 'MAJICA', 0, 2500, 'majica1.jpg', 'Pamucna majica kratkih rukava, moderna i udobna.'),
(2, 'Majica2', 'MAJICA', 2, 2200, 'majica2.jpg', 'Nova kolekcija različitih majici'),
(3, 'Majica3', 'MAJICA', 0, 2200, 'majica3.jpg', 'Svakidasnja roze majica'),
(4, 'Majica4', 'MAJICA', 0, 3000, 'majica4.jpg', 'Nova kolekcija različitih crnih Guess majici'),
(5, 'Dzemper1', 'DZEMPER', 10, 3200, 'dzemper1.jpg', 'Nije unet opis'),
(6, 'Džemper2', 'DZEMPER', 3, 2750, 'dzemper2.jpg', 'Ovo je opis džempera'),
(7, 'Džemper3', 'DZEMPER', 2, 4000, 'dzemper3.jpg', 'Nije unet opis'),
(8, 'Kaput1', 'KAPUT', 4, 7000, 'kaputi9.jpg', 'Nije unet opis');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `idKorisnika` int(3) UNSIGNED NOT NULL,
  `ime` varchar(20) NOT NULL,
  `prezime` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `lozinka` varchar(256) NOT NULL,
  `tipKorisnika` enum('Administrator','Korisnik') NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `brojTelefona` varchar(20) NOT NULL,
  `slikaKorisnika` varchar(40) NOT NULL,
  `brojPristupa` int(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`idKorisnika`, `ime`, `prezime`, `email`, `lozinka`, `tipKorisnika`, `adresa`, `brojTelefona`, `slikaKorisnika`, `brojPristupa`) VALUES
(3, 'test', 'test', 'test5@gmail.com', 'TestLozinka1#', 'Korisnik', 'testAdresa', '00000000', '', 5),
(6, 'aaa', 'aaaaa', 'peraperic@gmail.com', 'Jasampera12!', 'Korisnik', 'Nedodjija6', '111111111', '', 1),
(7, 'aaaa', 'aaaaaa', 'testicA@gmail.com', 'peraPeric123!', 'Korisnik', 'Ssssss 41', '123456789', '', 1),
(8, 'testHash', 'testHash', 'testHas@gmail.com', '7d374b3ca8193d376581217234c1d55421c2c924e5c868b33be9dbd7aaf2b7130eea245ec03018e86aa4e4fec08868ed9a788260f8db9632973abe2b51f60480', 'Korisnik', 'testHash 21', '987654321', '', 1),
(9, 'pera', 'peric', 'probaDatoteka@gmail.com', '48bde6a7461f2873c84a73d11f3617befae5d9287acd7bcc54548e44c8bf28851898f436f3fa09bb27de085c6b5466c5e79c25f624b4435019fb9764c2668acb', 'Korisnik', 'Proba122', '112233445', '', 1),
(10, 'pera', 'peric', 'proxaDatoteka@gmail.com', '4514e8e8293509aef72f57dabeea29cc7364ee485e7289627cb087b813bb1011a3977817b28c7f53d1a73937cb001e6d2266bfbf220d1a6a377c8d6efc8f2b8e', 'Korisnik', 'Proba122', '112233425', '', 1),
(11, 'pera', 'peric', 'proxvDatoteka@gmail.com', '4514e8e8293509aef72f57dabeea29cc7364ee485e7289627cb087b813bb1011a3977817b28c7f53d1a73937cb001e6d2266bfbf220d1a6a377c8d6efc8f2b8e', 'Korisnik', 'Proba122', '172233425', '', 1),
(12, 'test', 'test', 'test1@gmail.com', 'd787a3c0317fd70de01da92b71d1808bf3d4ae75ff6693dae9289b5fe9997d24bf2f1d4810526b9f12ea38ffe7fd526b53811bf8b9df567c2ac9fa177a09b0d8', 'Korisnik', 'nbtnN12', '811224444', '', 17),
(13, 'testAdmin', 'testAdmin', 'test1Admin@gmail.com', 'c111f054af790fc5de336dd82c12b660c4b0a0185f10cdf864a588cf1f36580da24da35efeb57b25a9427ea5eab8b57ff126177b720847296db8b9f1e3ecef7a', 'Administrator', 'Nedodjija bb2', '987445623', '', 4),
(14, 'testKorisnik', 'testKorisnik', 'test233@gmail.com', '65f2c41cbf5023a0b96dcb40cfaf9e81548008cca7834c3b966f52f859f274e4ceb7275d18597f3de215a63e926e1b0bb74759435eeb7762f6b92e41a8040da9', 'Korisnik', 'pera12A', '012345678', 'Neimenovani dijagram.drawio.png', 1),
(15, 'testGlavni', 'testGlavni', 'test11@gmail.com', '$2y$10$X3Ls8DnkvuVssRgLXWKJyOJn6zQGMqWS6E/Y5o9la8jP5ctl7Q0Ae', 'Korisnik', 'Adresa221', '012345698', 'Neimenovani dijagram.drawio.png', 15),
(16, 'probaReg', 'probaReg', 'probaReg1@gmail.com', '$2y$10$DEKG2Kq9EvpJ88UIzaSj.O6.bsiFELaffACZ8IC1Z9iLPa522V1Wy', 'Korisnik', 'probaA12', '044551174', 'Neimenovani dijagram.drawio.png', 1),
(17, 'opetPa', 'opetPa', 'opetPa22@gmail.com', '$2y$10$ozExyia4ttZmqCgGEdyGz.BP9TCPIKqciVnVuzHJJ/h4Xg3W7/0zm', 'Korisnik', 'jasamA2', '044517444', 'Neimenovani dijagram.drawio.png', 1),
(18, 'admin', 'admin', 'admin1@gmail.com', '$2y$10$PlvpKkLmxPIJfpIWHCfDGu6fkskRTTI/6LG4xzjiCaWOpW20KkSBK', 'Administrator', 'Adresa11', '012456398', 'Neimenovani dijagram.drawio.png', 7),
(19, 'Korisnik', 'Korisnik', 'korisnik1@gmail.com', '$2y$10$G0zeM562qgB3Vq8.jxvGx.G3bFbxd4gnchXEcsn7NK2AfkmXo411y', 'Korisnik', 'Adresa1', '0123456112', 'aktuelnoo2.jpg', 3),
(20, 'Admin', 'Admin', 'admin2@gmail.com', '$2y$10$jBjDfJ8aRE/8RGRlG3svMuHWUcxVXMvF9UiPJnWUqMCBc9R7779CC', 'Administrator', 'Adresa23', '0114235784', 'aktuelno44-removebg-preview.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbine`
--

CREATE TABLE `porudzbine` (
  `idPorudzbine` int(3) UNSIGNED NOT NULL,
  `idKorisnika` int(3) UNSIGNED NOT NULL,
  `idArtikla` int(3) UNSIGNED NOT NULL,
  `velicinaArtikla` enum('XS','S','M','L','XL','XXL') NOT NULL,
  `datumIsporuke` date NOT NULL,
  `napomena` text NOT NULL DEFAULT 'nema napomene'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `porudzbine`
--

INSERT INTO `porudzbine` (`idPorudzbine`, `idKorisnika`, `idArtikla`, `velicinaArtikla`, `datumIsporuke`, `napomena`) VALUES
(1, 12, 1, 'S', '2026-03-06', 'nema'),
(2, 12, 2, 'M', '2026-03-06', 'nema'),
(3, 12, 3, 'M', '2026-03-06', 'nema'),
(4, 12, 2, 'XL', '2026-03-06', 'nema'),
(5, 12, 3, 'XL', '2026-03-06', 'nema'),
(6, 12, 4, 'L', '2026-03-06', 'nema'),
(7, 12, 2, 'M', '2026-03-06', 'nema'),
(8, 12, 2, 'L', '2026-03-06', 'nema'),
(9, 12, 3, 'M', '2026-03-06', 'nema'),
(10, 12, 3, 'XS', '2026-03-06', 'nema'),
(11, 15, 1, 'M', '2026-03-07', 'nema'),
(12, 15, 1, 'XL', '2026-03-07', 'ovo je test napomena'),
(13, 15, 3, 'M', '2026-03-07', ''),
(14, 15, 3, 'XL', '2026-03-07', ''),
(15, 15, 3, 'XL', '2026-03-07', ''),
(16, 15, 3, 'XL', '2026-03-07', ''),
(17, 15, 4, 'L', '2026-03-09', ''),
(18, 15, 1, 'S', '2026-03-09', ''),
(19, 15, 1, 'L', '2026-03-09', ''),
(20, 15, 2, 'L', '2026-03-09', ''),
(21, 15, 1, 'XS', '2026-03-09', 'probaStanje'),
(22, 15, 1, 'XL', '2026-03-09', ''),
(23, 15, 1, 'XL', '2026-03-09', ''),
(24, 15, 1, 'XS', '2026-03-09', ''),
(25, 19, 8, 'M', '2026-03-14', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikli`
--
ALTER TABLE `artikli`
  ADD PRIMARY KEY (`idArtikla`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`idKorisnika`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `porudzbine`
--
ALTER TABLE `porudzbine`
  ADD PRIMARY KEY (`idPorudzbine`),
  ADD KEY `idKorisnika` (`idKorisnika`),
  ADD KEY `idArtikla` (`idArtikla`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikli`
--
ALTER TABLE `artikli`
  MODIFY `idArtikla` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `idKorisnika` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `porudzbine`
--
ALTER TABLE `porudzbine`
  MODIFY `idPorudzbine` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
