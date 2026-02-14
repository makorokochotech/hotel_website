-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 02:56 AM
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
-- Database: `makorokocho_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `room_type` enum('standard','deluxe','suite') NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `full_name`, `email`, `phone`, `room_type`, `check_in`, `check_out`, `guests`, `booking_date`, `status`, `total_amount`) VALUES
(1, 'jonathan saimon', 'jonathan@gmail.com', '0784028479', 'standard', '2025-06-11', '2025-06-19', 1, '2025-06-14 14:35:40', 'Pending', 0.00),
(2, 'jonathan saimon', 'jonathansaimon31@gmail.com', '0717250159', 'deluxe', '2025-05-25', '2025-06-09', 2, '2025-06-14 14:48:13', 'Pending', 0.00),
(3, 'mnkzlx', 'jonathansaimon31@gmail.com', '07717728', 'standard', '2025-05-27', '2025-05-28', 4, '2025-06-14 15:22:42', 'Pending', 0.00),
(4, 'jonathan saimon', 'jonathansaimon31@gmail.com', '07825729890', 'suite', '2025-06-15', '2025-06-17', 10, '2025-06-14 22:03:36', 'Pending', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'jonathan saimon', 'jonathan@gmail.com', '0784028479', 'nakupenda', '2025-06-14 15:02:43'),
(2, 'jonathan saimon', 'jonathan@gmail.com', '0784028479', 'nakupenda', '2025-06-14 15:05:21'),
(3, 'jonathan saimon', 'jonathansaimon31@gmail.com', '07825729890', 'nakupenda sana ww', '2025-06-14 15:05:59'),
(4, 'jonathan saimon', 'jonathansaimon31@gmail.com', '07825729890', 'nakupenda sana ww', '2025-06-14 15:14:16'),
(5, 'jonathan saimon', 'jonathansaimon31@gmail.com', '07825729890', 'lidya', '2025-06-14 15:14:39'),
(6, 'j again', 'jonathansaimon31@gmail.com', '07825729890', 'nakuja hapo kesho', '2025-06-14 15:18:04'),
(7, 'mm', 'jonathansaimon31@gmail.com', '1234567777', 'bsjznv', '2025-06-14 15:21:40'),
(8, 'Jonathan Saimon', 'jonathansaimon31@gmail.com', '0784028479', 'hapo sasa', '2025-06-14 23:05:28'),
(9, 'Jonathan Saimon', 'jonathansaimon31@gmail.com', '0784028479', 'kubali', '2025-06-14 23:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `room_type` enum('standard','deluxe','suite') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `price`, `description`, `is_available`) VALUES
(1, '101', 'standard', 100.00, 'A comfortable standard room', 1),
(2, '102', 'deluxe', 150.00, 'Spacious deluxe room with sea view', 0),
(3, '103', 'suite', 250.00, 'Luxury suite with king size bed', 1),
(4, '12', '', 13.00, 'dvzc', 0),
(5, '1', 'suite', 12.00, 'ddd', 1),
(6, '1', 'standard', 12.00, 'dd', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
