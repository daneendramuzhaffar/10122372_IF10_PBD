-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 01:55 PM
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
-- Database: `kepegawaian_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `gaji` int(11) NOT NULL DEFAULT 0,
  `tanggal_lahir` date DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `email`, `id_jabatan`, `gaji`, `tanggal_lahir`, `password`) VALUES
(2, 'Ani Lestari', 'ani.lestari@gmail.com', 2, 6000000, '1988-08-23', '1234'),
(14, 'johan', 'johan@gmail.com', 1, 50000000, '1990-07-10', '1234'),
(15, 'Lamine Yamal', 'lamine@gmail.com', 3, 3500000, '2002-07-11', '1234'),
(16, 'willy', 'willy@gmail.com', 3, 3500000, '2001-07-04', '1234');

--
-- Triggers `pegawai`
--
DELIMITER $$
CREATE TRIGGER `after_pegawai_delete` AFTER DELETE ON `pegawai` FOR EACH ROW INSERT INTO log_pegawai (id_pegawai, aksi, user_admin)
VALUES (OLD.id_pegawai, 'DELETE', SESSION_USER())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_pegawai_insert` AFTER INSERT ON `pegawai` FOR EACH ROW INSERT INTO log_pegawai (id_pegawai, aksi, user_admin)
VALUES (NEW.id_pegawai, 'INSERT', SESSION_USER())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_pegawai_update` AFTER UPDATE ON `pegawai` FOR EACH ROW INSERT INTO log_pegawai (id_pegawai, aksi, user_admin)
VALUES (NEW.id_pegawai, 'UPDATE', SESSION_USER())
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
