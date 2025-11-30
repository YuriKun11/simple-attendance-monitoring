-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: Nov 18, 2025 at 06:07 PM
-- Server version: 9.5.0
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `touride`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `full_name`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'Brandon', 'brandon@gmail.com', '$2y$10$kBaQnCBlN1QBBgViV96AHuzsz3ZZCU4EIHgmA7rahIEGcTAcMq49y', '2025-11-18 17:12:39', '2025-11-18 17:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `ride_bookings`
--

CREATE TABLE `ride_bookings` (
  `booking_id` int NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `passengers` varchar(10) NOT NULL,
  `transport_mode` varchar(50) NOT NULL,
  `fare_estimate` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','ongoing','finished','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `driver_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ride_bookings`
--

INSERT INTO `ride_bookings` (`booking_id`, `user_id`, `pickup_location`, `destination`, `pickup_date`, `pickup_time`, `passengers`, `transport_mode`, `fare_estimate`, `status`, `created_at`, `driver_id`) VALUES
(11, 2, 'Naguilian', 'Ma-Cho Temple', '2025-11-18', '08:00:00', '1', 'motor', 92.00, 'finished', '2025-11-18 17:52:56', 1),
(12, 2, 'Bauang', 'Saint William the Hermit Cathedral', '2025-11-18', '08:00:00', '4+', 'van', 204.00, 'finished', '2025-11-18 17:57:15', 1),
(13, 2, 'Naguilian', 'Pagoda Hill', '2025-11-18', '08:00:00', '3', 'tricycle', 120.00, 'finished', '2025-11-18 17:59:25', 1),
(14, 2, 'Naguilian', 'Tangadan Falls', '2025-11-18', '08:00:00', '1', 'motor', 506.00, 'pending', '2025-11-18 18:04:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL COMMENT 'Unique User ID',
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User’s full name',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User’s email address',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hashed password)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of account creation',
  `last_login` datetime DEFAULT NULL COMMENT 'Timestamp of last login'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'Yuri Reyes', 'yuri@gmail.com', '$2y$10$27TAn7VATbFkd6wSJsYO8eh.GKkPTK.1YXAU7zftomM66M20UKf7m', '2025-11-06 10:26:02', '2025-11-06 10:32:29'),
(2, 'George Rexy', 'george@gmail.com', '$2y$10$kBgvU48mHPuMQIiJWLt6qubtplb9HLtSqqoI4EBXmBS7zElkE.TFO', '2025-11-06 10:26:24', '2025-11-18 17:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `spot_id` int NOT NULL COMMENT 'corresponds the array in the php yung $allSpots',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_favorites`
--

INSERT INTO `user_favorites` (`id`, `user_id`, `spot_id`, `created_at`) VALUES
(28, 2, 1, '2025-11-15 19:22:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_spot_unique` (`user_id`,`spot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique User ID', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
