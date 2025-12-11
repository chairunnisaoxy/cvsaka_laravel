-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 08:37 AM
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
-- Database: `newcvsakapratama`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_penggajian`
--

CREATE TABLE `laporan_penggajian` (
  `id_laporan` varchar(50) NOT NULL,
  `id_karyawan` varchar(20) DEFAULT NULL,
  `periode_start` date DEFAULT NULL,
  `periode_end` date DEFAULT NULL,
  `total_gaji` decimal(12,2) DEFAULT NULL,
  `total_bonus` decimal(12,2) DEFAULT NULL,
  `total_potongan` decimal(12,2) DEFAULT NULL,
  `total_bersih` decimal(12,2) DEFAULT NULL,
  `jumlah_hari` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_penggajian`
--

INSERT INTO `laporan_penggajian` (`id_laporan`, `id_karyawan`, `periode_start`, `periode_end`, `total_gaji`, `total_bonus`, `total_potongan`, `total_bersih`, `jumlah_hari`, `created_at`) VALUES
('LAP-20251128-093049-K03', 'K03', '2025-11-28', '2025-12-11', 1400000.00, 20000.00, 50000.00, 1370000.00, 14, '2025-11-28 15:30:49'),
('LAP-20251206-081910-K10', 'K10', '2025-11-29', '2025-12-13', 1400000.00, 0.00, 0.00, 1400000.00, 14, '2025-12-06 14:19:10'),
('LAP-20251206-084541-K10', 'K10', '2025-11-28', '2025-12-26', 1400000.00, 0.00, 0.00, 1400000.00, 14, '2025-12-06 14:45:41'),
('LAP-20251206-084724-K06', 'K06', '2025-11-28', '2025-11-28', 100000.00, 0.00, 0.00, 100000.00, 1, '2025-12-06 14:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_10_212412_create_m_karyawan_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_absensi`
--

CREATE TABLE `m_absensi` (
  `id_absensi` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_absensi`
--

INSERT INTO `m_absensi` (`id_absensi`, `tanggal`, `jam_masuk`, `jam_keluar`) VALUES
('AB02', '2025-11-28', '07:00:00', '19:00:00'),
('AB03', '2025-11-29', '07:00:00', '19:00:00'),
('AB04', '2025-11-30', '07:00:00', '19:00:00'),
('AB05', '2025-12-01', '07:00:00', '19:00:00'),
('AB06', '2025-12-02', '07:00:00', '19:00:00'),
('AB07', '2025-12-03', '07:00:00', '19:00:00'),
('AB08', '2025-12-05', '07:00:00', '19:00:00'),
('AB09', '2025-12-04', '07:00:00', '19:00:00'),
('AB10', '2025-12-06', '07:00:00', '20:00:00'),
('AB11', '2025-12-07', '07:00:00', '19:00:00'),
('AB12', '2025-12-08', '07:00:00', '19:00:00'),
('AB13', '2025-12-09', '07:00:00', '19:00:00'),
('AB14', '2025-12-10', '07:00:00', '19:00:00'),
('AB15', '2025-12-11', '07:00:00', '19:00:00'),
('AB16', '2025-12-12', '07:00:00', '20:00:00'),
('AB17', '2025-12-13', '07:00:00', '19:00:00'),
('AB18', '2025-12-14', '07:00:00', '20:00:00'),
('AB19', '2025-12-15', '07:00:00', '20:00:00'),
('AB20', '2025-12-16', '07:00:00', '19:00:00'),
('AB21', '2025-12-17', '07:00:00', '20:00:00'),
('AB22', '2025-12-18', '07:00:00', '20:00:00'),
('AB23', '2025-12-19', '07:00:00', '20:00:00'),
('AB24', '2025-12-20', '07:00:00', '20:00:00'),
('AB25', '2025-12-21', '07:00:00', '20:08:00'),
('AB26', '2025-12-22', '07:00:00', '20:00:00'),
('AB27', '2025-12-23', '07:00:00', '20:00:00'),
('AB28', '2025-12-24', '07:00:00', '20:00:00'),
('AB29', '2025-12-25', '07:00:00', '20:00:00'),
('AB30', '2025-12-26', '07:00:00', '20:00:00'),
('AB31', '2025-12-27', '07:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_karyawan`
--

CREATE TABLE `m_karyawan` (
  `id_karyawan` varchar(50) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `jabatan` enum('pemilik','supervisor','operator') NOT NULL,
  `gaji_harian` decimal(12,2) DEFAULT 100000.00,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_karyawan` enum('aktif','nonaktif') NOT NULL,
  `jml_target` int(11) DEFAULT 500,
  `total_hadir` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_karyawan`
--

INSERT INTO `m_karyawan` (`id_karyawan`, `nama_karyawan`, `jabatan`, `gaji_harian`, `email`, `password`, `no_telp`, `alamat`, `status_karyawan`, `jml_target`, `total_hadir`) VALUES
('K01', 'Pemilik', 'pemilik', 100000.00, 'pemilik@gmail.com', '$2y$10$atGmm2oM2fFu/Ttei7wZdemtsubadNXUMFRzOmDwYtsMph0hAsz7C', '0111111111111', 'Jl. Supervisor', 'aktif', 500, 0),
('K02', 'Supervisor', 'supervisor', 100000.00, 'noir@gmail.com', '$2y$10$atGmm2oM2fFu/Ttei7wZdemtsubadNXUMFRzOmDwYtsMph0hAsz7C', '022222222222222', '', 'aktif', 500, 0),
('K03', 'Ona', 'operator', 100000.00, 'ona@gmail.com', NULL, '03333333333333', 'Jl. Ona', 'aktif', 500, 14),
('k04', 'Rosa', 'operator', 100000.00, 'rosa@gmail.com', NULL, '08444444444444', 'Jl. rosa', 'aktif', 500, 1),
('k05', 'Niskos', 'operator', 100000.00, 'niskos@gmail.com', NULL, '0555555555555555555', 'Jl. Niskos', 'aktif', 500, 1),
('K06', 'Siti', 'operator', 100000.00, 'siti@gmail.com', NULL, '086666666666666', 'Jl. Siti', 'aktif', 500, 1),
('K07', 'Nur', 'operator', 100000.00, 'nur@gmail.com', NULL, '08777777777777777', 'Jl. Nur', 'aktif', 500, 1),
('k08', 'Salsa', 'operator', 100000.00, '', NULL, '08888888888888888', 'Jl. Salsa', 'aktif', 500, 1),
('K09', 'Linda', 'operator', 100000.00, '', NULL, '0999999999999999', 'Jl. Linda', 'aktif', 500, 1),
('K10', 'Hani', 'operator', 100000.00, '', NULL, '01000000000000', 'Jl. Hani', 'aktif', 500, 28),
('K11', 'Bambang Widi', 'operator', 100000.00, NULL, NULL, NULL, NULL, 'aktif', 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_produk`
--

CREATE TABLE `m_produk` (
  `id_produk` varchar(50) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `status_produk` enum('aktif','nonaktif') NOT NULL,
  `satuan` varchar(20) DEFAULT 'pcs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_produk`
--

INSERT INTO `m_produk` (`id_produk`, `nama_produk`, `status_produk`, `satuan`) VALUES
('PR01', 'Footstep K2F2', 'aktif', 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_absensi_karyawan`
--

CREATE TABLE `t_absensi_karyawan` (
  `id_karyawan` varchar(50) NOT NULL,
  `id_absensi` varchar(50) NOT NULL,
  `total_gaji` decimal(12,2) DEFAULT 100000.00,
  `bonus_lembur` decimal(12,2) DEFAULT 0.00,
  `potongan` decimal(12,2) DEFAULT 0.00,
  `total_aktual` int(11) DEFAULT 0,
  `status_absensi` enum('hadir','tidak hadir','cuti') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_absensi_karyawan`
--

INSERT INTO `t_absensi_karyawan` (`id_karyawan`, `id_absensi`, `total_gaji`, `bonus_lembur`, `potongan`, `total_aktual`, `status_absensi`) VALUES
('k04', 'AB02', 100000.00, 0.00, 0.00, 0, 'hadir'),
('k05', 'AB02', 100000.00, 0.00, 0.00, 0, 'hadir'),
('K07', 'AB02', 100000.00, 0.00, 0.00, 0, 'hadir'),
('k08', 'AB02', 100000.00, 0.00, 0.00, 0, 'hadir'),
('K09', 'AB02', 100000.00, 0.00, 0.00, 0, 'hadir');

-- --------------------------------------------------------

--
-- Table structure for table `t_produk_karyawan`
--

CREATE TABLE `t_produk_karyawan` (
  `id_produk` varchar(50) NOT NULL,
  `id_karyawan` varchar(50) NOT NULL,
  `jml_aktual` int(11) NOT NULL,
  `jml_keranjang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_produk_karyawan`
--

INSERT INTO `t_produk_karyawan` (`id_produk`, `id_karyawan`, `jml_aktual`, `jml_keranjang`) VALUES
('PR01', 'K01', 400, 1),
('PR01', 'K03', 500, 1),
('PR01', 'k04', 300, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_penggajian`
--
ALTER TABLE `laporan_penggajian`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_absensi`
--
ALTER TABLE `m_absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `m_produk`
--
ALTER TABLE `m_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `t_absensi_karyawan`
--
ALTER TABLE `t_absensi_karyawan`
  ADD PRIMARY KEY (`id_karyawan`,`id_absensi`),
  ADD KEY `id_absensi` (`id_absensi`);

--
-- Indexes for table `t_produk_karyawan`
--
ALTER TABLE `t_produk_karyawan`
  ADD PRIMARY KEY (`id_produk`,`id_karyawan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan_penggajian`
--
ALTER TABLE `laporan_penggajian`
  ADD CONSTRAINT `laporan_penggajian_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `m_karyawan` (`id_karyawan`);

--
-- Constraints for table `t_absensi_karyawan`
--
ALTER TABLE `t_absensi_karyawan`
  ADD CONSTRAINT `t_absensi_karyawan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `m_karyawan` (`id_karyawan`),
  ADD CONSTRAINT `t_absensi_karyawan_ibfk_2` FOREIGN KEY (`id_absensi`) REFERENCES `m_absensi` (`id_absensi`);

--
-- Constraints for table `t_produk_karyawan`
--
ALTER TABLE `t_produk_karyawan`
  ADD CONSTRAINT `t_produk_karyawan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `m_produk` (`id_produk`),
  ADD CONSTRAINT `t_produk_karyawan_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `m_karyawan` (`id_karyawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
