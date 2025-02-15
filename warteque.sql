-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2025 at 08:16 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warteque`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int NOT NULL,
  `nama_makanan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `harga` int NOT NULL,
  `gambar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `nama_makanan`, `deskripsi`, `harga`, `gambar`) VALUES
(7, 'Rawon Daging', 'Sup daging khas Jawa Timur dengan kuah hitam pekat dari kluwek, dipadukan dengan rempah-rempah seperti bawang merah, bawang putih, ketumbar, dan lengkuas. Biasanya disajikan dengan nasi, tauge pendek, telur asin, dan kerupuk. Rasanya gurih dengan aroma khas yang menggugah selera.', 25000, 'Nasi_dibentuk_bulat.jpg'),
(8, 'Sate Madura', 'Sate khas Madura yang biasanya terbuat dari daging ayam atau kambing, disajikan dengan bumbu kacang kental dan lontong. Rasanya manis, gurih, dan sedikit pedas.', 20000, 'sate_madura.jpg'),
(9, 'Nasi Padang', 'Sajian khas Minangkabau yang terdiri dari nasi putih dengan berbagai lauk seperti rendang, ayam pop, sambal ijo, dan sayur daun singkong. Punya cita rasa kaya rempah dan gurih.', 25000, 'nasi_padang.jpeg'),
(10, 'Semur Jengkol', 'Masakan khas Betawi berbahan dasar jengkol yang dimasak dengan kecap manis, bawang merah, bawang putih, dan rempah lainnya. Memiliki rasa manis dan gurih dengan tekstur jengkol yang lembut.', 15000, 'semur_jengkol.jpg'),
(11, 'Opor Ayam', 'Hidangan khas Indonesia berupa ayam yang dimasak dengan santan dan rempah-rempah seperti kunyit, serai, dan daun salam. Rasanya gurih dan biasanya disajikan dengan ketupat atau nasi.', 20000, 'opor_ayam.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `pesanan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`pesanan_id`, `user_id`, `menu_id`, `jumlah`, `total_harga`) VALUES
(1, 1, 8, 1, 20000),
(2, 1, 8, 2, 40000),
(3, 1, 8, 1, 20000),
(4, 1, 8, 5, 100000),
(5, 1, 8, 1, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pelanggan','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin123', 'admin'),
(3, 'wyxli', 'wyxli', 'wyxli123', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`pesanan_id`),
  ADD KEY `fk_menu_id` (`menu_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `pesanan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
