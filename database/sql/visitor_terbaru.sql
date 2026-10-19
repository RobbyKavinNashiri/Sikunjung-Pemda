-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 19, 2026 at 03:07 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int UNSIGNED NOT NULL,
  `nama_jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Kepala Dinas');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_penduduk`
--

CREATE TABLE `jabatan_penduduk` (
  `id_jabatan_penduduk` int UNSIGNED NOT NULL,
  `id_jabatan` int UNSIGNED NOT NULL,
  `id_penduduk` int UNSIGNED NOT NULL,
  `status` enum('Y','T') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan_penduduk`
--

INSERT INTO `jabatan_penduduk` (`id_jabatan_penduduk`, `id_jabatan`, `id_penduduk`, `status`) VALUES
(1, 1, 1, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id_kunjungan` int UNSIGNED NOT NULL,
  `id_settings_kunjungan` int UNSIGNED NOT NULL,
  `id_pemohon` int UNSIGNED NOT NULL,
  `konfrimasi_admin` enum('Y','T') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_waktu_admin` datetime DEFAULT NULL,
  `konfrimasi_penduduk` enum('Y','T') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_waktu_penduduk` datetime DEFAULT NULL,
  `catatan_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_penduduk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuannya` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemohon`
--

CREATE TABLE `pemohon` (
  `id_pemohon` int UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemohon`
--

INSERT INTO `pemohon` (`id_pemohon`, `nama`, `telepon`, `email`, `password`) VALUES
(1, 'Kavin', '089628341661', 'kavinunuja@gmail.com', '$2y$12$2/QIq6crWjbSley9hoRMDuTmTj9LgQzLK8mozf6VqFW8cGI3kkBe2');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id_penduduk` int UNSIGNED NOT NULL,
  `nama_penduduk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kk` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Admin','Penduduk') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` (`id_penduduk`, `nama_penduduk`, `nik`, `kk`, `jenis_kelamin`, `alamat`, `username`, `password`, `status`) VALUES
(1, 'Admin Utama', '3513000000000001', '3513000000000002', 'L', 'Kraksaan', 'admin', '$2y$12$71J9NJTycBeYkg/8nDYPAu6SezKP2JEN69ZwYIsDhVJlu5WfIexfe', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `settings_kegiatan`
--

CREATE TABLE `settings_kegiatan` (
  `id_settings_kegiatan` int UNSIGNED NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `id_jabatan_penduduk` int UNSIGNED NOT NULL,
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings_kunjungan`
--

CREATE TABLE `settings_kunjungan` (
  `id_settings_kunjungan` int UNSIGNED NOT NULL,
  `id_jabatan_penduduk` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_aktif` time NOT NULL,
  `jam_non_aktif` time NOT NULL,
  `status` enum('Y','T') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jabatan_penduduk`
--
ALTER TABLE `jabatan_penduduk`
  ADD PRIMARY KEY (`id_jabatan_penduduk`),
  ADD KEY `fk_jp_jabatan` (`id_jabatan`),
  ADD KEY `fk_jp_penduduk` (`id_penduduk`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `fk_kj_setting` (`id_settings_kunjungan`),
  ADD KEY `fk_kj_pemohon` (`id_pemohon`);

--
-- Indexes for table `pemohon`
--
ALTER TABLE `pemohon`
  ADD PRIMARY KEY (`id_pemohon`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id_penduduk`);

--
-- Indexes for table `settings_kegiatan`
--
ALTER TABLE `settings_kegiatan`
  ADD PRIMARY KEY (`id_settings_kegiatan`) USING BTREE,
  ADD KEY `fk_sg_jp` (`id_jabatan_penduduk`);

--
-- Indexes for table `settings_kunjungan`
--
ALTER TABLE `settings_kunjungan`
  ADD PRIMARY KEY (`id_settings_kunjungan`),
  ADD KEY `fk_sk_jp` (`id_jabatan_penduduk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan_penduduk`
--
ALTER TABLE `jabatan_penduduk`
  MODIFY `id_jabatan_penduduk` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id_kunjungan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemohon`
--
ALTER TABLE `pemohon`
  MODIFY `id_pemohon` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id_penduduk` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings_kegiatan`
--
ALTER TABLE `settings_kegiatan`
  MODIFY `id_settings_kegiatan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings_kunjungan`
--
ALTER TABLE `settings_kunjungan`
  MODIFY `id_settings_kunjungan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jabatan_penduduk`
--
ALTER TABLE `jabatan_penduduk`
  ADD CONSTRAINT `fk_jp_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  ADD CONSTRAINT `fk_jp_penduduk` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`);

--
-- Constraints for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `fk_kj_pemohon` FOREIGN KEY (`id_pemohon`) REFERENCES `pemohon` (`id_pemohon`),
  ADD CONSTRAINT `fk_kj_setting` FOREIGN KEY (`id_settings_kunjungan`) REFERENCES `settings_kunjungan` (`id_settings_kunjungan`);

--
-- Constraints for table `settings_kegiatan`
--
ALTER TABLE `settings_kegiatan`
  ADD CONSTRAINT `fk_sg_jp` FOREIGN KEY (`id_jabatan_penduduk`) REFERENCES `jabatan_penduduk` (`id_jabatan_penduduk`);

--
-- Constraints for table `settings_kunjungan`
--
ALTER TABLE `settings_kunjungan`
  ADD CONSTRAINT `fk_sk_jp` FOREIGN KEY (`id_jabatan_penduduk`) REFERENCES `jabatan_penduduk` (`id_jabatan_penduduk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
