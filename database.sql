-- ============================================================
-- SQL Schema & Seed Data: Dashboard Daftar Hadir Murid (SMK)
-- Target Database: db_presensi_murid
-- Environment: Laragon (MySQL / MariaDB)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `db_presensi_murid` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_presensi_murid`;

-- Drop existing tables to ensure clean re-import
DROP TABLE IF EXISTS `presensi`;
DROP TABLE IF EXISTS `murid`;
DROP TABLE IF EXISTS `guru_mapel`;
DROP TABLE IF EXISTS `guru`;
DROP TABLE IF EXISTS `mapel`;
DROP TABLE IF EXISTS `kelas`;

-- --------------------------------------------------------
-- Tabel 1: kelas
-- --------------------------------------------------------
CREATE TABLE `kelas` (
  `id_kelas` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy kelas
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'XII RPL 1'),
(2, 'XII RPL 2'),
(3, 'XI TKJ 1');

-- --------------------------------------------------------
-- Tabel 2: mapel
-- --------------------------------------------------------
CREATE TABLE `mapel` (
  `id_mapel` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy mapel
INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Pemrograman Web & Perangkat Bergerak'),
(2, 'Basis Data'),
(3, 'Administrasi Infrastruktur Jaringan');

-- --------------------------------------------------------
-- Tabel 3: guru
-- --------------------------------------------------------
CREATE TABLE `guru` (
  `id_guru` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_guru` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy guru (SMK Guru pengajar Mapel spesifik)
INSERT INTO `guru` (`id_guru`, `nama_guru`) VALUES
(1, 'Ahmad Fauzi, S.Pd.'),
(2, 'Siti Rahmawati, M.Pd.'),
(3, 'Budi Santoso, S.Kom.');

-- --------------------------------------------------------
-- Tabel 3b: guru_mapel (relasi many-to-many guru <-> mapel)
-- --------------------------------------------------------
CREATE TABLE `guru_mapel` (
  `id_guru` INT(11) NOT NULL,
  `id_mapel` INT(11) NOT NULL,
  PRIMARY KEY (`id_guru`, `id_mapel`),
  KEY `fk_gm_mapel` (`id_mapel`),
  CONSTRAINT `fk_gm_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gm_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy relasi guru <-> mapel (satu guru bisa mengampu banyak mapel)
INSERT INTO `guru_mapel` (`id_guru`, `id_mapel`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 3);

-- --------------------------------------------------------
-- Tabel 4: murid (dengan No. Absen & FK -> kelas)
-- --------------------------------------------------------
CREATE TABLE `murid` (
  `id_murid` INT(11) NOT NULL AUTO_INCREMENT,
  `no_absen` INT(11) NOT NULL DEFAULT 1,
  `nama_murid` VARCHAR(150) NOT NULL,
  `id_kelas` INT(11) NOT NULL,
  PRIMARY KEY (`id_murid`),
  KEY `fk_murid_kelas` (`id_kelas`),
  CONSTRAINT `fk_murid_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Dummy murid (Format: No. Absen, Nama Murid, Kelas)
INSERT INTO `murid` (`id_murid`, `no_absen`, `nama_murid`, `id_kelas`) VALUES
(1, 1, 'Aditya Pratama', 1),
(2, 2, 'Anisa Putri', 1),
(3, 3, 'Bagas Saputra', 1),
(4, 18, 'Made Agus Astika Putra', 2),
(5, 1, 'Dewi Anggraini', 2),
(6, 2, 'Eko Wijaya', 2);

-- --------------------------------------------------------
-- Tabel 5: presensi
-- --------------------------------------------------------
CREATE TABLE `presensi` (
  `id_presensi` INT(11) NOT NULL AUTO_INCREMENT,
  `id_murid` INT(11) NOT NULL,
  `id_guru` INT(11) NOT NULL,
  `id_mapel` INT(11) NOT NULL,
  `tanggal` DATE NOT NULL,
  `status` ENUM('H','I','S','A') DEFAULT NULL,
  PRIMARY KEY (`id_presensi`),
  UNIQUE KEY `unique_presensi` (`id_murid`,`id_guru`,`id_mapel`,`tanggal`),
  KEY `fk_presensi_guru` (`id_guru`),
  KEY `fk_presensi_mapel` (`id_mapel`),
  CONSTRAINT `fk_presensi_murid` FOREIGN KEY (`id_murid`) REFERENCES `murid` (`id_murid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_presensi_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_presensi_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Presensi Data untuk Pengujian
INSERT INTO `presensi` (`id_murid`, `id_guru`, `id_mapel`, `tanggal`, `status`) VALUES
(4, 1, 1, '2026-08-01', 'H'),
(5, 1, 1, '2026-08-01', 'H'),
(6, 1, 1, '2026-08-01', 'I'),
(4, 1, 1, '2026-08-02', 'H'),
(4, 1, 2, '2026-08-01', 'S'),
(5, 1, 2, '2026-08-01', 'H'),
(4, 2, 2, '2026-08-01', 'A'),
(5, 2, 2, '2026-08-01', 'H');
