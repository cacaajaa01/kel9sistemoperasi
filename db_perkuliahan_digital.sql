-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_perkuliahan_digital
CREATE DATABASE IF NOT EXISTS `db_perkuliahan_digital` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_perkuliahan_digital`;

-- Dumping structure for table db_perkuliahan_digital.akun
CREATE TABLE IF NOT EXISTS `akun` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `level` enum('Dosen','Mahasiswa') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perkuliahan_digital.akun: ~0 rows (approximately)
INSERT INTO `akun` (`username`, `password`, `nama`, `level`) VALUES
	('admin', 'admin', 'Administrator', 'Dosen'),
	('f1g124047', '12345', 'Nurul Asiza', 'Mahasiswa');

-- Dumping structure for table db_perkuliahan_digital.dosen
CREATE TABLE IF NOT EXISTS `dosen` (
  `nidn` varchar(10) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`nidn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perkuliahan_digital.dosen: ~4 rows (approximately)
INSERT INTO `dosen` (`nidn`, `nama_dosen`, `email`) VALUES
	('11001', 'Dr. Andi Tendriawaru, S.Si., M.Si', 'anditenriawaru@gmail.com'),
	('11002', 'Gunawan, S.Kom., M.Kom', 'gunawan@gmail.com'),
	('11003', 'Gusti Arviana Rahman, S.Si., M.Si', 'gustiarvianarahman@gmail.com'),
	('11004', 'La Surimi, S.Si., M.CS', 'lasurimi@gmail.com');

-- Dumping structure for table db_perkuliahan_digital.jadwal
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `kode_mk` varchar(10) DEFAULT NULL,
  `nidn` varchar(10) DEFAULT NULL,
  `hari` varchar(20) NOT NULL,
  `jam` time NOT NULL,
  `ruangan` varchar(20) NOT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `kode_mk` (`kode_mk`),
  KEY `nidn` (`nidn`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`nidn`) REFERENCES `dosen` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perkuliahan_digital.jadwal: ~5 rows (approximately)
INSERT INTO `jadwal` (`id_jadwal`, `kode_mk`, `nidn`, `hari`, `jam`, `ruangan`) VALUES
	(4, 'IL001', '11001', 'Senin', '08:00:00', 'Lab Komputer 1'),
	(5, 'IL002', '11002', 'Selasa', '08:00:00', 'Lab Komputer 2'),
	(6, 'IL003', '11003', 'Rabu', '09:30:00', 'Lab Komputer 1'),
	(7, 'IL004', '11001', 'Kamis', '08:00:00', 'Lab Komputer 2'),
	(8, 'IL005', '11001', 'Jumat', '08:00:00', 'Lab Komputer 1'),
	(9, 'IL006', '11004', 'Jumat', '10:00:00', 'Lab Komputer 2');

-- Dumping structure for table db_perkuliahan_digital.krs
CREATE TABLE IF NOT EXISTS `krs` (
  `id_krs` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `id_jadwal` int NOT NULL,
  PRIMARY KEY (`id_krs`),
  KEY `username` (`username`),
  KEY `id_jadwal` (`id_jadwal`),
  CONSTRAINT `krs_ibfk_1` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE,
  CONSTRAINT `krs_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perkuliahan_digital.krs: ~3 rows (approximately)
INSERT INTO `krs` (`id_krs`, `username`, `id_jadwal`) VALUES
	(8, 'f1g124047', 4),
	(9, 'f1g124047', 5),
	(10, 'f1g124047', 6);

-- Dumping structure for table db_perkuliahan_digital.matakuliah
CREATE TABLE IF NOT EXISTS `matakuliah` (
  `kode_mk` varchar(10) NOT NULL,
  `nama_mk` varchar(100) NOT NULL,
  `sks` int NOT NULL,
  `semester` int NOT NULL,
  PRIMARY KEY (`kode_mk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_perkuliahan_digital.matakuliah: ~6 rows (approximately)
INSERT INTO `matakuliah` (`kode_mk`, `nama_mk`, `sks`, `semester`) VALUES
	('IL001', 'Kompleksitas Algoritma', 3, 3),
	('IL002', 'Organisasi dan Arsitektur Komputer', 3, 3),
	('IL003', 'Basis Data', 3, 3),
	('IL004', 'Alajabar Linear', 3, 3),
	('IL005', 'Matematika Diskrit', 3, 3),
	('IL006', 'Rekayasa Perangkat Lunak', 3, 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
