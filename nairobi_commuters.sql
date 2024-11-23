-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 07:49 AM
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
-- Database: `nairobi_commuters`
--

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
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`p_id`, `p_fname`, `p_lname`, `p_age`, `p_contact`, `p_gender`, `email`, `password`, `t_no`, `PNR`, `payment_status`, `seat_number`, `role`) VALUES
(1, 'John', 'Doe', 34, '0701234567', 'Male', 'john.doe@example.com', 'password123', 12951, NULL, 'Pending', NULL, 'user'),
(2, 'Jane', 'Kamau', 28, '0729876543', 'Female', 'jane.kamau@example.com', 'pass456', NULL, NULL, 'Pending', NULL, 'user'),
(3, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(4, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(5, 'J', 'A', 21, '0700000000', 'Male', 'j@gmail.com', '123456789', 1001, 'TZCJRI6H', 'Completed', NULL, 'user'),
(6, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(7, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(8, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(9, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(10, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(11, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(12, 'J', 'A', 22, '0712345678', 'Male', 'jj@gmail.com', '123456789', 1002, '31VPPC0V', 'Completed', NULL, 'user'),
(13, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(14, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(15, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(16, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(17, '', '', 0, '', '', '', '', NULL, NULL, 'Pending', NULL, 'user'),
(24, NULL, NULL, NULL, NULL, NULL, 'jj@gmail.com', NULL, 1002, 'YU8PYJUG', '', 'B10', 'user');

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
(1, 'Express A', 'A1', 1, NULL, NULL, 1001),
(2, 'Express A', 'A2', 0, 'jj@gmail.com', NULL, 1001),
(3, 'Express A', 'A3', 0, 'jj@gmail.com', NULL, 1001),
(4, 'Express A', 'A4', 1, NULL, NULL, 1001),
(5, 'Express A', 'A5', 0, 'jj@gmail.com', NULL, 1001),
(6, 'Express A', 'A6', 1, NULL, NULL, 1001),
(7, 'Express A', 'A7', 1, NULL, NULL, 1001),
(8, 'Express A', 'A8', 1, NULL, NULL, 1001),
(9, 'Express A', 'A9', 0, 'jamesjohn@gmail.com', NULL, 1001),
(10, 'Express A', 'A10', 1, NULL, NULL, 1001),
(11, 'Commuter X', 'B1', 1, NULL, NULL, 1002),
(12, 'Commuter X', 'B2', 1, NULL, NULL, 1002),
(13, 'Commuter X', 'B3', 1, NULL, NULL, 1002),
(14, 'Commuter X', 'B4', 1, NULL, NULL, 1002),
(15, 'Commuter X', 'B5', 1, NULL, NULL, 1002),
(16, 'Commuter X', 'B6', 1, NULL, NULL, 1002),
(17, 'Commuter X', 'B7', 1, NULL, NULL, 1002),
(18, 'Commuter X', 'B8', 1, NULL, NULL, 1002),
(19, 'Commuter X', 'B9', 1, NULL, NULL, 1002),
(20, 'Commuter X', 'B10', 0, 'jj@gmail.com', NULL, 1002),
(21, 'Express A', 'A1', 1, NULL, NULL, 1001),
(22, 'Express A', 'A2', 0, 'jj@gmail.com', NULL, 1001),
(23, 'Express A', 'A3', 0, 'jj@gmail.com', NULL, 1001),
(24, 'Express A', 'A4', 1, NULL, NULL, 1001),
(25, 'Express A', 'A5', 0, 'jj@gmail.com', NULL, 1001),
(26, 'Express A', 'A6', 1, NULL, NULL, 1001),
(27, 'Express A', 'A7', 1, NULL, NULL, 1001),
(28, 'Express A', 'A8', 1, NULL, NULL, 1001),
(29, 'Express A', 'A9', 0, 'jamesjohn@gmail.com', NULL, 1001),
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
(40, 'Commuter X', 'B10', 0, 'jj@gmail.com', NULL, 1002);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `s_id` int(11) NOT NULL,
  `s_fname` varchar(50) DEFAULT NULL,
  `s_lname` varchar(50) DEFAULT NULL,
  `s_department` varchar(50) NOT NULL,
  `s_salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, 'Embakasi Village', 4),
(2, 'Syokimau', 3),
(3, 'Ruiru', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `PNR` decimal(10,0) NOT NULL,
  `t_status` varchar(20) NOT NULL DEFAULT 'Waiting',
  `t_fare` int(11) DEFAULT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`PNR`, `t_status`, `t_fare`, `p_id`) VALUES
(1234567890, 'Confirmed', 300, 1),
(1234567891, 'Confirmed', NULL, 0),
(1234567892, 'Waiting', NULL, 0),
(1234567893, 'Cancelled', NULL, 0),
(9876543210, 'Waiting', 250, 2);

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
(0, '[value-2]', '[value-3]', '[value-4]', '[value-5]', '[value-6]', 0, 0, '[value-9]'),
(1001, 'Express A', 'Embakasi Village', 'Ruiru', 'Express', 'On time', 500, 30, 'Embakasi Village to Ruiru'),
(1002, 'Commuter X', 'Syokimau', 'Embakasi Village', 'Commuter', 'On time', 600, 25, '');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`s_id`);

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
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `s_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
