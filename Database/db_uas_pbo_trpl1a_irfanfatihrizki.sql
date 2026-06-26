-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2026 at 02:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_trpl1a_irfanfatihrizki`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mahasiswa`
--

CREATE TABLE `tabel_mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nama_mahasiswa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim_semester` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_ukt_nominal` decimal(12,2) NOT NULL,
  `jenis_pembayaran` enum('Mandiri','Bidikmisi','Prestasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan_ukt` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_wali` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_kk` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peng_kuliah` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dana_saku_subsidi` decimal(12,2) DEFAULT NULL,
  `nama_instansi_beasiswa` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimal_ipk_syarat` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabel_mahasiswa`
--

INSERT INTO `tabel_mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `nim_semester`, `tarif_ukt_nominal`, `jenis_pembayaran`, `golongan_ukt`, `nama_wali`, `nomor_kk`, `peng_kuliah`, `dana_saku_subsidi`, `nama_instansi_beasiswa`, `minimal_ipk_syarat`) VALUES
(1, 'Andi Kurniawan', '2201001/4', '4500000.00', 'Mandiri', 'Gol-4', 'Budi Kurniawan', '3372011234560001', 'Wiraswasta / Rp 6.000.000', NULL, NULL, NULL),
(2, 'Siti Rahayu', '2201002/4', '3500000.00', 'Mandiri', 'Gol-3', 'Hendra Rahayu', '3372019876540002', 'PNS Golongan III / Rp 5.500.000', NULL, NULL, NULL),
(3, 'Bima Sakti', '2201003/6', '5000000.00', 'Mandiri', 'Gol-5', 'Sakti Purnomo', '3374031122330003', 'Direktur CV / Rp 15.000.000', NULL, NULL, NULL),
(4, 'Dewi Anggraini', '2201004/4', '2500000.00', 'Mandiri', 'Gol-2', 'Agus Anggraini', '3374045566770004', 'Petani / Rp 2.500.000', NULL, NULL, NULL),
(5, 'Rizal Maulana', '2201005/2', '4500000.00', 'Mandiri', 'Gol-4', 'Maulana Yusuf', '3374058899000005', 'Kontraktor / Rp 8.000.000', NULL, NULL, NULL),
(6, 'Fitriani Hasanah', '2201006/6', '3000000.00', 'Mandiri', 'Gol-3', 'Hasanah Bakar', '3374062233440006', 'Guru Honorer / Rp 2.000.000', NULL, NULL, NULL),
(7, 'Yoga Pratama', '2201007/4', '5500000.00', 'Mandiri', 'Gol-5', 'Pratama Wijaya', '3374074455660007', 'Pengusaha / Rp 20.000.000', NULL, NULL, NULL),
(8, 'Nadia Permatasari', '2201008/2', '2000000.00', 'Mandiri', 'Gol-2', 'Permata Sari', '3374086677880008', 'Buruh / Rp 2.200.000', NULL, NULL, NULL),
(9, 'Hasrul Efendi', '2202001/4', '0.00', 'Bidikmisi', 'Gol-1', 'Efendi Santoso', '3375011234567001', 'Buruh Tani / Rp 900.000', '700000.00', NULL, NULL),
(10, 'Mardiyah Saputri', '2202002/4', '0.00', 'Bidikmisi', 'Gol-1', 'Saputri Lestari', '3375029876543002', 'Nelayan / Rp 1.000.000', '700000.00', NULL, NULL),
(11, 'Firmansyah', '2202003/6', '0.00', 'Bidikmisi', 'Gol-1', 'Syahroni', '3375031122334003', 'Kuli Bangunan / Rp 800.000', '700000.00', NULL, NULL),
(12, 'Nurul Hidayah', '2202004/4', '0.00', 'Bidikmisi', 'Gol-1', 'Hidayatullah', '3375045566779004', 'Sopir Angkot / Rp 1.200.000', '700000.00', NULL, NULL),
(13, 'Karimuddin Amir', '2202005/2', '0.00', 'Bidikmisi', 'Gol-1', 'Amir Hamzah', '3375058899016005', 'Pedagang Kaki Lima / Rp 1.100.000', '700000.00', NULL, NULL),
(14, 'Sulistyowati', '2202006/6', '0.00', 'Bidikmisi', 'Gol-1', 'Wiyanto', '3375062233447006', 'Tukang Becak / Rp 750.000', '700000.00', NULL, NULL),
(15, 'Rendra Sasmita', '2202007/4', '0.00', 'Bidikmisi', 'Gol-1', 'Sasmita Djoko', '3375074455668007', 'Penjahit / Rp 950.000', '700000.00', NULL, NULL),
(16, 'Albertus Kevin', '2203001/4', '0.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Beasiswa Unggulan Kemdikbud', '3.50'),
(17, 'Mellisa Agustin', '2203002/4', '500000.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Beasiswa KIP-K Kemendikbud', '3.25'),
(18, 'Wahyu Tri Nugroho', '2203003/6', '0.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'PT Pertamina ? Program Beasiswa', '3.75'),
(19, 'Cynthia Lestari', '2203004/4', '1000000.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Yayasan Pendidikan Telkom', '3.40'),
(20, 'Dimas Ardiansyah', '2203005/2', '0.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Beasiswa Bank Indonesia', '3.50'),
(21, 'Kartika Dewi', '2203006/6', '750000.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Beasiswa Djarum Foundation', '3.60'),
(22, 'Farizal Amri', '2203007/4', '0.00', 'Prestasi', NULL, NULL, NULL, NULL, NULL, 'Beasiswa Unggulan Kemdikbud', '3.50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `uq_nim_semester` (`nim_semester`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
