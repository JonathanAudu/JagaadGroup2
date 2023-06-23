-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 09:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25
​
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
​
​
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
​
--
-- Database: `hotel-booking`
--
​
-- --------------------------------------------------------
​
--
-- Table structure for table `slots`
--
​
CREATE TABLE `slots` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `booked` int(11) NOT NULL DEFAULT 0,
  `booked_user` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` date DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `image` longblob DEFAULT NULL,
  `expired` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
​
--
-- Dumping data for table `slots`
--
​
INSERT INTO `slots` (`id`, `user_id`, `name`, `description`, `booked`, `booked_user`, `created_at`, `updated_at`, `checkin`, `checkout`, `image`, `expired`) VALUES
(14, 1, 'Standard Room ', 'Well furnished with Air condition and Gym membership', 0, NULL, '2023-06-19 13:29:11', NULL, NULL, NULL, 0x75706c6f6164732f706578656c732d737568656c2d7662612d333635393638332e6a7067, 0),
(15, 1, 'Royal Room', 'Well furnished with Air condition and Complimentary breakfast ', 1, 'admin@admin.com', '2023-06-19 13:29:33', '2023-06-19', '2023-06-20', '2023-06-22', 0x75706c6f6164732f706578656c732d656e67696e2d616b797572742d313537393235332e6a7067, 0),
(16, 1, 'Executive Room', 'Hot bathtub, fully functioning air condition and Complimentary breakfast', 1, 'admin@admin.com', '2023-06-19 13:30:01', '2023-06-19', '2023-06-08', '2023-06-14', 0x75706c6f6164732f5061726167726170685f3134363431382e6a7067, 1),
(17, 1, 'Exquisite Room ', 'Hot bathtub, fully functioning air condition and Complimentary breakfast', 1, 'luffy@gmail.com', '2023-06-19 13:30:26', '2023-06-19', '2023-06-20', '2023-06-30', 0x75706c6f6164732f486f74656c2d61636f75737469632e6a7067, 0),
(18, 1, 'Gym Room', 'Our Top of the art Gym house exclusive for members only', 0, NULL, '2023-06-19 14:30:10', NULL, NULL, NULL, 0x75706c6f6164732f7370696e6e696e672d31303234783533392e6a7067, 0);
​
-- --------------------------------------------------------
​
--
-- Table structure for table `users`
--
​
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
​
--
-- Dumping data for table `users`
--
​
INSERT INTO `users` (`id`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'admin@admin.com', '$2y$10$7kyauWbsb79q0uoh5ad6QeyQcYtBF4HTWA0YKcx7Aq38Op/etBZ6S', 1, '2023-06-15 15:01:08'),
(2, 'luffy@gmail.com', '$2y$10$BjZUdbtTaQTwsmB81hHx6exVcf9rpmuebsJ5pp4JgYfBO8TBqWPhW', 0, '2023-06-15 15:59:52'),
(3, 'test@test.com', '$2y$10$wRExsiH77wHDx5WNvsn6/.b9sECXlOo1DUJevs4H6y8C7ElLssAdK', 0, '2023-06-16 12:25:35'),
(4, 'zoro@gmail.com', '$2y$10$xrSYDjP/CvlwjE3JPGFaI.s88m74LiBApk4K5aNr3PLjacZQrHbuC', 0, '2023-06-16 21:04:50');
​
--
-- Indexes for dumped tables
--
​
--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
​
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
​
--
-- AUTO_INCREMENT for dumped tables
--
​
--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
​
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
​
--
-- Constraints for dumped tables
--
​
--
-- Constraints for table `slots`
--
ALTER TABLE `slots`
  ADD CONSTRAINT `slots_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;
​
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;