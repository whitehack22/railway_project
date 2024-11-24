-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 01:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nairobi_commuters`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'Raizzy', '$2y$10$bU.1j73723nPV3oboeMKjep6A9B9PLJERgpwrDsHgvyAzI2O3m2ty', '2024-11-23 10:03:35', ''),
(6, 'Mugo', '$2y$10$9EQ/MZ1sz.lYPfu0LWeq3umhAbH1r0VyY5zBZz80v6JAFHKxpOl92', '2024-11-24 12:13:49', 'githaigaraizzy@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `p_id` int(11) NOT NULL,
  `p_fname` varchar(50) DEFAULT NULL,
  `p_lname` varchar(50) DEFAULT NULL,
  `p_age` int(3) DEFAULT NULL,
  `p_contact` varchar(15) DEFAULT NULL,
  `p_gender` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `t_no` int(11) DEFAULT NULL,
  `PNR` varchar(10) DEFAULT NULL,
  `payment_status` enum('Pending','Completed') DEFAULT 'Pending',
  `seat_number` varchar(10) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `registered_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`p_id`, `p_fname`, `p_lname`, `p_age`, `p_contact`, `p_gender`, `email`, `password`, `t_no`, `PNR`, `payment_status`, `seat_number`, `role`, `registered_at`) VALUES
(50, 'Gordon', 'Amos', 21, '0792737829', 'Male', 'gordon@gmail.com', '$2y$10$1fTzu0YJpwbwHbIvvO8Evum7WmunoRYw9kXxxDpJjIBvwVjZBLoea', NULL, NULL, 'Pending', NULL, 'user', '2024-11-24 13:48:30'),
(51, NULL, NULL, NULL, NULL, NULL, 'gordon@gmail.com', '$2y$10$1fTzu0YJpwbwHbIvvO8Evum7WmunoRYw9kXxxDpJjIBvwVjZBLoea', 1001, 'HGACUJR0', 'Pending', 'A2', 'user', '2024-11-24 13:57:19'),
(52, NULL, NULL, NULL, NULL, NULL, 'gordon@gmail.com', '$2y$10$1fTzu0YJpwbwHbIvvO8Evum7WmunoRYw9kXxxDpJjIBvwVjZBLoea', 1001, '60YG3ERI', 'Pending', 'A8', 'user', '2024-11-24 13:58:50'),
(53, NULL, NULL, NULL, NULL, NULL, 'gordon@gmail.com', '$2y$10$1fTzu0YJpwbwHbIvvO8Evum7WmunoRYw9kXxxDpJjIBvwVjZBLoea', 1001, '081U2D4Z', '', 'A2', 'user', '2024-11-24 14:15:44'),
(54, NULL, NULL, NULL, NULL, NULL, 'gordon@gmail.com', NULL, 0, 'MO9KLV2E', '', 'S001', 'user', '2024-11-24 15:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `train_name` varchar(50) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `passenger_email` varchar(100) DEFAULT NULL,
  `train_id` int(11) DEFAULT NULL,
  `t_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `train_name`, `seat_number`, `is_available`, `passenger_email`, `train_id`, `t_no`) VALUES
(2, 'Express A', 'A2', 0, 'gordon@gmail.com', NULL, 1001),
(3, 'Express A', 'A3', 1, NULL, NULL, 1001),
(5, 'Express A', 'A5', 1, NULL, NULL, 1001),
(8, 'Express A', 'A8', 1, NULL, NULL, 1001),
(9, 'Express A', 'A9', 1, NULL, NULL, 1001),
(10, 'Express A', 'A10', 1, NULL, NULL, 1001),
(13, 'Commuter X', 'B3', 1, NULL, NULL, 1002),
(14, 'Commuter X', 'B4', 1, NULL, NULL, 1002),
(15, 'Commuter X', 'B5', 1, NULL, NULL, 1002),
(16, 'Commuter X', 'B6', 1, NULL, NULL, 1002),
(17, 'Commuter X', 'B7', 1, NULL, NULL, 1002),
(18, 'Commuter X', 'B8', 1, NULL, NULL, 1002),
(19, 'Commuter X', 'B9', 1, NULL, NULL, 1002),
(20, 'Commuter X', 'B10', 1, NULL, NULL, 1002),
(22, 'Express A', 'A2', 0, 'gordon@gmail.com', NULL, 1001),
(23, 'Express A', 'A3', 1, NULL, NULL, 1001),
(25, 'Express A', 'A5', 1, NULL, NULL, 1001),
(28, 'Express A', 'A8', 1, NULL, NULL, 1001),
(29, 'Express A', 'A9', 1, NULL, NULL, 1001),
(30, 'Express A', 'A10', 1, NULL, NULL, 1001),
(31, 'Commuter X', 'B1', 1, NULL, NULL, 1002),
(32, 'Commuter X', 'B2', 1, NULL, NULL, 1002),
(33, 'Commuter X', 'B3', 1, NULL, NULL, 1002),
(34, 'Commuter X', 'B4', 1, NULL, NULL, 1002),
(35, 'Commuter X', 'B5', 1, NULL, NULL, 1002),
(36, 'Commuter X', 'B6', 1, NULL, NULL, 1002),
(37, 'Commuter X', 'B7', 1, NULL, NULL, 1002),
(38, 'Commuter X', 'B8', 1, NULL, NULL, 1002),
(39, 'Commuter X', 'B9', 1, NULL, NULL, 1002),
(40, 'Commuter X', 'B10', 1, NULL, NULL, 1002),
(291, 'Express B', 'S001', 0, 'gordon@gmail.com', 0, 0),
(292, 'Express B', 'S002', 1, NULL, 0, 0),
(293, 'Express B', 'S003', 1, NULL, 0, 0),
(294, 'Express B', 'S004', 1, NULL, 0, 0),
(295, 'Express B', 'S005', 1, NULL, 0, 0),
(296, 'Express B', 'S006', 1, NULL, 0, 0),
(297, 'Express B', 'S007', 1, NULL, 0, 0),
(298, 'Express B', 'S008', 1, NULL, 0, 0),
(299, 'Express B', 'S009', 1, NULL, 0, 0),
(300, 'Express B', 'S010', 1, NULL, 0, 0),
(301, 'Express B', 'S011', 1, NULL, 0, 0),
(302, 'Express B', 'S012', 1, NULL, 0, 0),
(303, 'Express B', 'S013', 1, NULL, 0, 0),
(304, 'Express B', 'S014', 1, NULL, 0, 0),
(305, 'Express B', 'S015', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `s_no` int(11) NOT NULL,
  `s_name` varchar(50) DEFAULT NULL,
  `s_no_of_platforms` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`s_no`, `s_name`, `s_no_of_platforms`) VALUES
(2, 'Syokimau', 3),
(3, 'Ruiru', 2),
(4, 'Embakasi Village', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `PNR` varchar(10) NOT NULL,
  `t_status` varchar(20) NOT NULL DEFAULT 'Waiting',
  `t_fare` int(11) DEFAULT NULL,
  `p_id` int(11) NOT NULL,
  `booking_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`PNR`, `t_status`, `t_fare`, `p_id`, `booking_date`) VALUES
('MO9KLV2E', 'Ticket Acquired', 100, 54, '2024-11-24 15:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `t_no` int(11) NOT NULL,
  `t_name` varchar(50) DEFAULT NULL,
  `t_source` varchar(50) DEFAULT NULL,
  `t_destination` varchar(50) DEFAULT NULL,
  `t_type` varchar(30) DEFAULT NULL,
  `t_status` varchar(20) DEFAULT 'On time',
  `no_of_seats` int(11) DEFAULT NULL,
  `t_duration` int(11) DEFAULT NULL,
  `route` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`t_no`, `t_name`, `t_source`, `t_destination`, `t_type`, `t_status`, `no_of_seats`, `t_duration`, `route`) VALUES
(0, 'Express B', 'Ruiru', 'Syokimau', 'Express', 'On time', 15, 45, 'Ruiru to Syokimau'),
(1001, 'Express A', 'Embakasi Village', 'Ruiru', 'Express', 'On time', 500, 30, 'Embakasi Village to Ruiru'),
(1002, 'Commuter X', 'Syokimau', 'Embakasi Village', 'Commuter', 'On time', 600, 25, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `PNR` (`PNR`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `train_name` (`train_name`),
  ADD KEY `fk_train_no` (`t_no`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`s_no`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD UNIQUE KEY `PNR` (`PNR`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`t_no`),
  ADD UNIQUE KEY `t_name` (`t_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `s_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_train_no` FOREIGN KEY (`t_no`) REFERENCES `trains` (`t_no`),
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`train_name`) REFERENCES `trains` (`t_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
