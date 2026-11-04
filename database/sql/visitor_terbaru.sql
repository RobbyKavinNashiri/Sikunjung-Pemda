-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: visitor
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jabatan` (
  `id_jabatan` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan`
--

LOCK TABLES `jabatan` WRITE;
/*!40000 ALTER TABLE `jabatan` DISABLE KEYS */;
INSERT INTO `jabatan` VALUES (1,'Kepala Dinas'),(4,'Sekretaris Daerah'),(5,'Kepala Bagian Umum'),(6,'Kepala Bidang Pelayanan');
/*!40000 ALTER TABLE `jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatan_penduduk`
--

DROP TABLE IF EXISTS `jabatan_penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jabatan_penduduk` (
  `id_jabatan_penduduk` int unsigned NOT NULL AUTO_INCREMENT,
  `id_jabatan` int unsigned NOT NULL,
  `id_penduduk` int unsigned NOT NULL,
  `status` enum('Y','T') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_jabatan_penduduk`),
  KEY `fk_jp_jabatan` (`id_jabatan`),
  KEY `fk_jp_penduduk` (`id_penduduk`),
  CONSTRAINT `fk_jp_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`),
  CONSTRAINT `fk_jp_penduduk` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatan_penduduk`
--

LOCK TABLES `jabatan_penduduk` WRITE;
/*!40000 ALTER TABLE `jabatan_penduduk` DISABLE KEYS */;
INSERT INTO `jabatan_penduduk` VALUES (1,1,1,'Y'),(2,4,3,'Y'),(3,5,8,'Y'),(4,6,9,'Y');
/*!40000 ALTER TABLE `jabatan_penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kunjungan`
--

DROP TABLE IF EXISTS `kunjungan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kunjungan` (
  `id_kunjungan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_settings_kunjungan` int unsigned NOT NULL,
  `id_pemohon` int unsigned NOT NULL,
  `konfrimasi_admin` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_waktu_admin` datetime DEFAULT NULL,
  `konfrimasi_penduduk` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_waktu_penduduk` datetime DEFAULT NULL,
  `catatan_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_penduduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuannya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_waktu` datetime NOT NULL,
  PRIMARY KEY (`id_kunjungan`),
  KEY `fk_kj_setting` (`id_settings_kunjungan`),
  KEY `fk_kj_pemohon` (`id_pemohon`),
  CONSTRAINT `fk_kj_pemohon` FOREIGN KEY (`id_pemohon`) REFERENCES `pemohon` (`id_pemohon`),
  CONSTRAINT `fk_kj_setting` FOREIGN KEY (`id_settings_kunjungan`) REFERENCES `settings_kunjungan` (`id_settings_kunjungan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kunjungan`
--

LOCK TABLES `kunjungan` WRITE;
/*!40000 ALTER TABLE `kunjungan` DISABLE KEYS */;
INSERT INTO `kunjungan` VALUES (1,4,1,'Y','2026-10-30 10:11:02',NULL,NULL,'boleh',NULL,'keperluan pengajuan sesuatu','2026-11-01 09:00:00'),(2,5,1,'Y','2026-11-01 08:09:44','T','2026-10-30 18:55:26','oke','sorry bro ada kesibukan lain','reservasi','2026-11-02 09:00:00'),(4,7,2,'Y','2026-10-31 15:59:06','Y','2026-10-31 15:59:06','Silakan datang tepat waktu.','Disetujui.','Penyerahan dokumen (contoh)','2026-11-02 09:30:00'),(5,10,2,'Y','2026-10-31 15:59:06','T','2026-10-31 15:59:06',NULL,'Jadwal bentrok dengan rapat.','Audiensi (contoh)','2026-11-03 14:00:00'),(6,1,1,'Y','2026-11-01 08:11:54',NULL,NULL,NULL,NULL,'Konsultasi program kerja','2026-11-04 09:00:00'),(7,11,2,NULL,NULL,NULL,NULL,NULL,NULL,'Konsultasi program kerja (contoh)','2026-11-05 09:00:00'),(8,13,2,'Y','2026-11-03 05:28:58','Y','2026-11-03 05:28:58','Silakan datang tepat waktu.','Disetujui.','Penyerahan dokumen (contoh)','2026-11-05 09:30:00'),(9,16,2,'Y','2026-11-03 05:28:58','T','2026-11-03 05:28:58',NULL,'Jadwal bentrok dengan rapat.','Audiensi (contoh)','2026-11-06 14:00:00'),(10,12,2,'Y','2026-11-03 05:56:46','Y','2026-11-03 06:03:45',NULL,NULL,'presentasi','2026-11-06 14:00:00');
/*!40000 ALTER TABLE `kunjungan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemohon`
--

DROP TABLE IF EXISTS `pemohon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pemohon` (
  `id_pemohon` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pemohon`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemohon`
--

LOCK TABLES `pemohon` WRITE;
/*!40000 ALTER TABLE `pemohon` DISABLE KEYS */;
INSERT INTO `pemohon` VALUES (1,'Kavin Demo','081200000009','kavin.demo@contoh.test','$2y$12$2/QIq6crWjbSley9hoRMDuTmTj9LgQzLK8mozf6VqFW8cGI3kkBe2'),(2,'Pemohon Demo','081200000001','pemohon.demo@contoh.test','$2y$12$GLZDfvFXj6WCqFv95V2tV.8JexcTcgdj14fAGA3XVZM1aYi9Sc.CG');
/*!40000 ALTER TABLE `pemohon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penduduk`
--

DROP TABLE IF EXISTS `penduduk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penduduk` (
  `id_penduduk` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_penduduk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kk` char(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Admin','Penduduk') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_penduduk`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penduduk`
--

LOCK TABLES `penduduk` WRITE;
/*!40000 ALTER TABLE `penduduk` DISABLE KEYS */;
INSERT INTO `penduduk` VALUES (1,'Admin Utama','3513000000000001','3513000000000002','L','Kraksaan','admin','$2y$12$71J9NJTycBeYkg/8nDYPAu6SezKP2JEN69ZwYIsDhVJlu5WfIexfe','Admin'),(3,'Budi Santoso','3531000000000004','3531000000000004','L','paiton','Budi','$2y$12$FdeSIx7gT4uyp6ybD8LbC.7sr2Gh3hsC1u1ufQV0t9MaEItiLJwy6','Penduduk'),(5,'Admin','3531000000000005','3531000000000005','L','locare','ardi','$2y$12$xETC6ntKTOjaa80JJSoP5exGD85XM2M7eXDOfWmKpOGACmz5Arphm','Penduduk'),(7,'bagus','3513000000000012','3513000000000012','P','jepang','bagus','$2y$12$p8i128O74Olvm/C10a/m3OvCEoVtWAtgDSH7AZhlFfkJUnJrZrjDG','Penduduk'),(8,'Siti Rahmawati','3513000000000021','3513000000000022','P','Jl. Contoh No. 1 (data palsu)','siti','$2y$12$NyT1u/iGeVsEAxsf5Vd37uk0Q/TxiUZZ8X4cJx0Xs2wb57SNUre.K','Penduduk'),(9,'Andi Wijaya','3513000000000031','3513000000000032','L','Jl. Contoh No. 1 (data palsu)','andi','$2y$12$6I0XREeCE.E.kZiSOv.QyOMwjbBEk4XwIMaaungzk5DUUsPGI2jVu','Penduduk');
/*!40000 ALTER TABLE `penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_kegiatan`
--

DROP TABLE IF EXISTS `settings_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings_kegiatan` (
  `id_settings_kegiatan` int unsigned NOT NULL AUTO_INCREMENT,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `id_jabatan_penduduk` int unsigned NOT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_settings_kegiatan`),
  KEY `fk_sg_jp` (`id_jabatan_penduduk`),
  CONSTRAINT `fk_sg_jp` FOREIGN KEY (`id_jabatan_penduduk`) REFERENCES `jabatan_penduduk` (`id_jabatan_penduduk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_kegiatan`
--

LOCK TABLES `settings_kegiatan` WRITE;
/*!40000 ALTER TABLE `settings_kegiatan` DISABLE KEYS */;
INSERT INTO `settings_kegiatan` VALUES (1,'2026-11-06','2026-11-07',2,'Rapat koordinasi (contoh)'),(2,'2026-11-06','2026-11-07',3,'Rapat koordinasi (contoh)'),(3,'2026-11-06','2026-11-07',4,'Rapat koordinasi (contoh)');
/*!40000 ALTER TABLE `settings_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings_kunjungan`
--

DROP TABLE IF EXISTS `settings_kunjungan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings_kunjungan` (
  `id_settings_kunjungan` int unsigned NOT NULL AUTO_INCREMENT,
  `id_jabatan_penduduk` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_aktif` time NOT NULL,
  `jam_non_aktif` time NOT NULL,
  `status` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_settings_kunjungan`),
  KEY `fk_sk_jp` (`id_jabatan_penduduk`),
  CONSTRAINT `fk_sk_jp` FOREIGN KEY (`id_jabatan_penduduk`) REFERENCES `jabatan_penduduk` (`id_jabatan_penduduk`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings_kunjungan`
--

LOCK TABLES `settings_kunjungan` WRITE;
/*!40000 ALTER TABLE `settings_kunjungan` DISABLE KEYS */;
INSERT INTO `settings_kunjungan` VALUES (1,1,'2026-11-04','08:00:00','12:00:00','Y'),(4,1,'2026-11-01','08:00:00','12:00:00','Y'),(5,2,'2026-11-02','08:00:00','12:00:00','Y'),(6,2,'2026-11-03','13:00:00','16:00:00','Y'),(7,3,'2026-11-02','08:00:00','12:00:00','Y'),(8,3,'2026-11-03','13:00:00','16:00:00','Y'),(9,4,'2026-11-02','08:00:00','12:00:00','Y'),(10,4,'2026-11-03','13:00:00','16:00:00','Y'),(11,2,'2026-11-05','08:00:00','12:00:00','Y'),(12,2,'2026-11-06','13:00:00','16:00:00','Y'),(13,3,'2026-11-05','08:00:00','12:00:00','Y'),(14,3,'2026-11-06','13:00:00','16:00:00','Y'),(15,4,'2026-11-05','08:00:00','12:00:00','Y'),(16,4,'2026-11-06','13:00:00','16:00:00','Y');
/*!40000 ALTER TABLE `settings_kunjungan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-04 18:26:33
