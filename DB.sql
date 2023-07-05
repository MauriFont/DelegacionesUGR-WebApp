-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host:
-- Generation Time: Jul 05, 2023 at 07:42 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DGE`
--

-- --------------------------------------------------------

--
-- Table structure for table `Areas`
--

CREATE TABLE `Areas` (
  `id` int(2) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cargos`
--

CREATE TABLE `Cargos` (
  `id` int(3) UNSIGNED NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `miembro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Cargos_por_area`
--

CREATE TABLE `Cargos_por_area` (
  `id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Centros`
--

CREATE TABLE `Centros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `acronimo` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `Centros`
--

INSERT INTO `Centros` (`id`, `nombre`, `acronimo`) VALUES
(1, 'Delegación General de Estudiantes', 'DGE');

-- --------------------------------------------------------

--
-- Table structure for table `Miembros`
--

CREATE TABLE `Miembros` (
  `id` int(11) NOT NULL,
  `dni` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(254) COLLATE utf8_spanish_ci NOT NULL,
  `telegram` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `centro` int(2) NOT NULL,
  `entrada` date NOT NULL,
  `salida` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Plenos`
--

CREATE TABLE `Plenos` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_segunda` time NOT NULL,
  `asunto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL COMMENT '0 = inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Areas`
--
ALTER TABLE `Areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Cargos`
--
ALTER TABLE `Cargos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miembro_id` (`miembro_id`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- Indexes for table `Cargos_por_area`
--
ALTER TABLE `Cargos_por_area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `Centros`
--
ALTER TABLE `Centros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Miembros`
--
ALTER TABLE `Miembros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miembros_fk_centro` (`centro`);

--
-- Indexes for table `Plenos`
--
ALTER TABLE `Plenos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Areas`
--
ALTER TABLE `Areas`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Cargos`
--
ALTER TABLE `Cargos`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Cargos_por_area`
--
ALTER TABLE `Cargos_por_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Miembros`
--
ALTER TABLE `Miembros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Plenos`
--
ALTER TABLE `Plenos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cargos`
--
ALTER TABLE `Cargos`
  ADD CONSTRAINT `Cargos_ibfk_1` FOREIGN KEY (`miembro_id`) REFERENCES `Miembros` (`id`),
  ADD CONSTRAINT `Cargos_ibfk_2` FOREIGN KEY (`cargo_id`) REFERENCES `Cargos_por_area` (`id`);

--
-- Constraints for table `Cargos_por_area`
--
ALTER TABLE `Cargos_por_area`
  ADD CONSTRAINT `Cargos_por_area_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `Areas` (`id`);

--
-- Constraints for table `Miembros`
--
ALTER TABLE `Miembros`
  ADD CONSTRAINT `miembros_fk_centro` FOREIGN KEY (`centro`) REFERENCES `Centros` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
