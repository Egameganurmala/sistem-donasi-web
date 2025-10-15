-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2025 at 07:57 PM
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
-- Database: `donasiyuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `donasi`
--

CREATE TABLE `donasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `program_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `metode` varchar(20) NOT NULL,
  `no_va` varchar(30) DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'completed',
  `tgl_donasi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donasi`
--

INSERT INTO `donasi` (`id`, `user_id`, `nama_lengkap`, `email`, `program_id`, `jumlah`, `metode`, `no_va`, `status`, `tgl_donasi`) VALUES
(1, NULL, 'Reksi Nuranda', 'reksinuranda@gmail.com', 3, 200000, '', NULL, 'completed', '2025-10-11 21:19:28'),
(2, NULL, 'khalila', 'khalila@gmail.com', 1, 1000000, '', NULL, 'completed', '2025-10-11 21:31:05'),
(3, 3, '', '', 2, 9000000, '', NULL, 'completed', '2025-10-11 21:31:47'),
(4, NULL, 'Dhiya Puspita', 'dhiyapuspita@gmail.com', 2, 300000, '', NULL, 'completed', '2025-10-11 21:45:46'),
(5, NULL, 'oci', 'oci@gmail.com', 2, 500000, '', NULL, 'completed', '2025-10-11 21:56:13'),
(6, NULL, 'nabila', 'nabila@gmail.com', 2, 700000, '', NULL, 'completed', '2025-10-11 21:58:12'),
(7, NULL, 'aisah', 'aisah@gmail.com', 2, 2000000, '', NULL, 'completed', '2025-10-11 21:58:54'),
(8, NULL, 'faizan', 'faizan@gmail.com', 2, 400000, '', NULL, 'completed', '2025-10-11 22:00:01'),
(9, 3, '', '', 2, 500000, '', NULL, 'completed', '2025-10-11 22:06:49'),
(10, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 100000, '', NULL, 'completed', '2025-10-11 22:19:39'),
(11, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 100000, '', NULL, 'completed', '2025-10-11 22:19:41'),
(12, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 100000, '', NULL, 'completed', '2025-10-11 22:19:43'),
(13, 3, 'mega nurmala', 'meganurmala@gmail.com', 1, 1000000, '', NULL, 'completed', '2025-10-11 22:20:27'),
(15, NULL, 'oci', 'oci@gmail.com', 2, 200000, '', NULL, 'completed', '2025-10-11 22:25:02'),
(16, NULL, 'oci', 'oci@gmail.com', 3, 200000, '', NULL, 'completed', '2025-10-11 22:25:36'),
(17, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:50:38'),
(18, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:50:44'),
(19, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:50:51'),
(20, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:53:53'),
(21, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:53:58'),
(22, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:57:10'),
(23, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 800000, 'OVO', NULL, 'completed', '2025-10-11 22:57:22'),
(24, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 9000000, 'Gopay', NULL, 'completed', '2025-10-11 23:00:12'),
(25, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 500000, 'Dana', NULL, 'completed', '2025-10-11 23:02:16'),
(26, 3, 'mega nurmala', 'meganurmala@gmail.com', 1, 60000, 'OVO', NULL, 'completed', '2025-10-11 23:03:07'),
(39, NULL, 'oci', 'oci@gmail.com', 1, 80000, 'OVO', NULL, 'pending', '2025-10-11 19:28:31'),
(40, NULL, 'oci', 'oci@gmail.com', 1, 80000, 'OVO', NULL, 'pending', '2025-10-11 19:28:42'),
(41, NULL, 'oci', 'oci@gmail.com', 1, 80000, 'OVO', NULL, 'pending', '2025-10-11 19:29:40'),
(42, NULL, 'oci', 'oci@gmail.com', 2, 9000000, 'OVO', NULL, 'completed', '2025-10-11 19:31:25'),
(43, NULL, 'oci', 'oci@gmail.com', 2, 7000000, 'OVO', NULL, 'completed', '2025-10-11 19:34:42'),
(44, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 600000, 'OVO', NULL, 'completed', '2025-10-12 00:36:47'),
(45, NULL, 'oci', 'oci@gmail.com', 3, 5000000, 'OVO', NULL, 'completed', '2025-10-11 19:37:52'),
(47, NULL, 'oci', 'oci@gmail.com', 2, 1000000, 'OVO', NULL, 'completed', '2025-10-13 15:18:36'),
(48, NULL, 'oci', 'oci@gmail.com', 2, 2000000, 'Gopay', NULL, 'completed', '2025-10-13 15:21:32'),
(49, NULL, 'oci', 'oci@gmail.com', 2, 300000, 'OVO', NULL, 'completed', '2025-10-13 15:44:54'),
(50, NULL, 'oci', 'oci@gmail.com', 1, 600000, 'OVO', '88015590759246', 'completed', '2025-10-13 16:03:53'),
(51, NULL, 'oci', 'oci@gmail.com', 1, 600000, 'ovo', 'OVO-5913199975', 'pending', '2025-10-13 16:05:05'),
(52, NULL, 'oci', 'oci@gmail.com', 1, 900000, 'ovo', 'OVO-9880281565', 'completed', '2025-10-13 16:05:19'),
(53, NULL, 'oci', 'oci@gmail.com', 1, 800000, 'ovo', 'OVO-6522775490', 'completed', '2025-10-13 16:06:20'),
(54, NULL, 'oci', 'oci@gmail.com', 1, 800000, 'ovo', 'OVO-6388326017', 'pending', '2025-10-13 16:07:32'),
(55, NULL, 'oci', 'oci@gmail.com', 1, 800000, 'ovo', 'OVO-3526899473', 'pending', '2025-10-13 16:10:08'),
(56, NULL, 'oci', 'oci@gmail.com', 1, 80000, 'ovo', 'OVO-4234612360', 'completed', '2025-10-13 16:10:27'),
(57, NULL, 'oci', 'oci@gmail.com', 1, 80000, 'ovo', 'OVO-6442173619', 'completed', '2025-10-13 16:13:55'),
(58, NULL, 'oci', 'oci@gmail.com', 1, 900000, 'gopay', 'GOPAY-1833823597', 'pending', '2025-10-13 16:25:27'),
(59, NULL, 'oci', 'oci@gmail.com', 1, 900000, 'gopay', '0036433509866', 'pending', '2025-10-13 16:29:12'),
(60, NULL, 'oci', 'oci@gmail.com', 1, 90000, 'ovo', '0018546157008', 'completed', '2025-10-13 16:29:43'),
(61, NULL, 'oci', 'oci@gmail.com', 1, 90000, 'ovo', '0018591714753', 'completed', '2025-10-13 16:29:43'),
(62, NULL, 'oci', 'oci@gmail.com', 2, 900000, 'dana', '0022829301989', 'completed', '2025-10-13 16:45:20'),
(63, NULL, 'oci', 'oci@gmail.com', 3, 900000, 'ovo', '0014941740283', 'completed', '2025-10-13 17:06:49'),
(64, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 900000, 'dana', NULL, 'completed', '2025-10-13 22:44:59'),
(65, 3, 'mega nurmala', 'meganurmala@gmail.com', 1, 100000, 'gopay', '0038878441624', 'completed', '2025-10-13 17:56:11'),
(66, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 300000, 'dana', '0021766863484', 'completed', '2025-10-13 18:39:14'),
(67, 3, 'mega nurmala', 'meganurmala@gmail.com', 3, 100000, 'ovo', '0013757705159', 'completed', '2025-10-13 18:40:18'),
(68, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 80000, 'dana', '0026909113921', 'completed', '2025-10-13 18:44:51'),
(69, 3, 'mega nurmala', 'meganurmala@gmail.com', 2, 20000, 'ovo', '0011979068879', 'completed', '2025-10-13 23:51:01'),
(70, 3, 'mega nurmala', 'meganurmala@gmail.com', 1, 70000, 'dana', '0025918814819', 'completed', '2025-10-13 23:55:12'),
(71, NULL, 'oci', 'oci@gmail.com', 1, 300000, 'gopay', '0033758328418', 'completed', '2025-10-13 23:56:32'),
(72, 3, '', '', 1, 7000000, 'dana', '0022757496845', 'pending', '2025-10-14 00:31:09'),
(73, NULL, 'oci', 'oci@gmail.com', 2, 200000, 'dana', '0021322995671', 'pending', '2025-10-14 00:52:04'),
(74, NULL, 'oci', 'oci@gmail.com', 2, 800000, 'gopay', '0036893247560', 'pending', '2025-10-14 00:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `donasi_program`
--

CREATE TABLE `donasi_program` (
  `id` int(11) NOT NULL,
  `nama_program` varchar(100) NOT NULL,
  `target` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donasi_program`
--

INSERT INTO `donasi_program` (`id`, `nama_program`, `target`, `deskripsi`) VALUES
(1, 'Bantu Pendidikan Anak Yatim', 50000000, 'Membantu anak-anak yatim untuk pendidikan mereka.'),
(2, 'Donasi Bencana Alam', 100000000, 'Bantuan untuk korban bencana alam.'),
(3, 'Santunan Lansia', 30000000, 'Memberikan santunan bagi lansia yang membutuhkan.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','donatur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'Admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(3, 'meganurmala', '$2y$10$MDvnYym7/qlatrhq6eQuoOdJeMg91MTaMzEwz7kp4A.owkv0ia.Ta', 'donatur'),
(4, 'aida', '$2y$10$kvhlz6yrXxejobeblxgXDuFMVv47NnTDGXrEhjopJnvlHd6w73JFu', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `donasi_ibfk_1` (`user_id`);

--
-- Indexes for table `donasi_program`
--
ALTER TABLE `donasi_program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `donasi_program`
--
ALTER TABLE `donasi_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donasi`
--
ALTER TABLE `donasi`
  ADD CONSTRAINT `donasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `donasi_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `donasi_program` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
