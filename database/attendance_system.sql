-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: Dec 02, 2024 at 08:06 AM
-- Server version: 9.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('present','absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `status`) VALUES
(1, 1, '2024-11-28', 'present'),
(2, 2, '2024-11-28', 'present'),
(3, 3, '2024-11-28', 'present'),
(4, 4, '2024-11-28', 'present'),
(5, 5, '2024-11-28', 'present'),
(6, 6, '2024-11-28', 'present'),
(7, 7, '2024-11-28', 'present'),
(8, 8, '2024-11-28', 'present'),
(9, 1, '2024-11-29', 'present'),
(10, 2, '2024-11-29', 'present'),
(11, 3, '2024-11-29', 'present'),
(12, 4, '2024-11-29', 'present'),
(13, 5, '2024-11-29', 'present'),
(14, 6, '2024-11-29', 'present'),
(15, 7, '2024-11-29', 'present'),
(16, 8, '2024-11-29', 'present'),
(17, 10, '2024-12-01', 'present'),
(18, 11, '2024-12-01', 'present'),
(25, 10, '2024-12-02', 'present'),
(26, 11, '2024-12-02', 'present'),
(27, 15, '2024-12-02', 'absent'),
(33, 37, '2024-12-02', 'present'),
(34, 38, '2024-12-02', 'present'),
(35, 40, '2024-12-02', 'present'),
(36, 41, '2024-12-02', 'present'),
(37, 42, '2024-12-02', 'present'),
(38, 43, '2024-12-02', 'present'),
(39, 44, '2024-12-02', 'present'),
(40, 45, '2024-12-02', 'present'),
(41, 46, '2024-12-02', 'present'),
(42, 47, '2024-12-02', 'present'),
(43, 48, '2024-12-02', 'present'),
(44, 49, '2024-12-02', 'present'),
(45, 50, '2024-12-02', 'present'),
(46, 51, '2024-12-02', 'present'),
(47, 52, '2024-12-02', 'present'),
(48, 53, '2024-12-02', 'present'),
(49, 54, '2024-12-02', 'present'),
(50, 16, '2024-11-26', 'present'),
(51, 17, '2024-11-26', 'absent'),
(52, 18, '2024-11-26', 'present'),
(53, 19, '2024-11-27', 'present'),
(54, 20, '2024-11-27', 'present'),
(55, 21, '2024-11-27', 'absent'),
(56, 22, '2024-11-28', 'present'),
(57, 16, '2024-11-28', 'present'),
(58, 17, '2024-11-28', 'present'),
(59, 18, '2024-11-29', 'absent'),
(60, 19, '2024-11-29', 'present'),
(61, 20, '2024-11-29', 'present'),
(62, 21, '2024-11-30', 'present'),
(63, 22, '2024-11-30', 'absent'),
(64, 16, '2024-12-01', 'present'),
(65, 17, '2024-12-01', 'present'),
(66, 18, '2024-12-01', 'present'),
(67, 19, '2024-12-02', 'present'),
(68, 20, '2024-12-02', 'present'),
(69, 21, '2024-12-02', 'present'),
(70, 22, '2024-12-02', 'absent'),
(71, 16, '2024-12-02', 'present'),
(72, 17, '2024-12-02', 'absent'),
(73, 18, '2024-12-02', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `instructor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_name`, `instructor_id`) VALUES
(1, 'Software Engineering', 3),
(3, 'Algorithms and Complexity', 3),
(4, 'Mysql', 3),
(5, 'Computer Science', 218),
(6, 'Information Technology', 218),
(7, 'Cyber Security', 218),
(8, 'Software Engineering', 3),
(9, 'Data Structures', 3),
(10, 'Database Management', 3),
(11, 'Web Development', 3);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`) VALUES
(218, NULL, 'Rodel', 'Parbo Castillo', 'jyreyes1122@gmail.com', 98877665432);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` bigint NOT NULL,
  `student_id` bigint NOT NULL,
  `class_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`, `student_id`, `class_id`) VALUES
(10, NULL, 'Jan Yuri', 'Reyes', 'jyreyes1122@gmail.com', 9566326635, 21007843510, 1),
(11, NULL, 'Brandon Sean', 'Gallardo', 'brandon@gmail.com', 9566326636, 20033, 4),
(15, NULL, 'Lordicx', 'Gabas', 'lordick@gmail.com', 90990, 231231, 3),
(16, NULL, 'John', 'Doe', 'john.doe@example.com', 9566326600, 21007843511, 5),
(17, NULL, 'Jane', 'Smith', 'jane.smith@example.com', 9566326601, 21007843512, 6),
(18, NULL, 'Tom', 'Jones', 'tom.jones@example.com', 9566326602, 21007843513, 7),
(19, NULL, 'Mary', 'Johnson', 'mary.johnson@example.com', 9566326603, 21007843514, 8),
(20, NULL, 'Jake', 'Williams', 'jake.williams@example.com', 9566326604, 21007843515, 9),
(21, NULL, 'Emily', 'Brown', 'emily.brown@example.com', 9566326605, 21007843516, 10),
(22, NULL, 'Oliver', 'Gleen', 'oliver.davis@example.com', 9566326606, 21007843517, 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`) VALUES
(19, 'jyreyes@gmail.com', '$2y$10$2ZsZisBqfFvxUmAI7ICUNeVINspRL.GS6z/I4E/.r9p.LZKNb3gga', 'YuriKun11'),
(20, 'jyreyes1111@gmail.com', '$2y$10$As64hd3d8lnFsM/CLYiOK.Gq64QzSoSxRo5DkrB6mSGtvwBsKWYje', 'YuriKun11'),
(21, 'test@gmail.com', '$2y$10$T/026Exoz8g/ZBJXhi1tkOzC8DGDqCo0Tzn3Nie7hDqNt4Fs.45eS', 'Yurikun11'),
(22, '213@123', '$2y$10$CI2oIet.p6OYf/lqcGgaieHqawjCgEsBvYU5PReLhJiL9vGk5h7L.', '21321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
