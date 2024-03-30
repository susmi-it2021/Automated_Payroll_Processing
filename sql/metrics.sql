-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 12:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yellowbags`
--

-- --------------------------------------------------------

--
-- Table structure for table `metrics`
--

CREATE TABLE `metrics` (
  `id` int(11) NOT NULL,
  `total_working_hours` time NOT NULL,
  `average_producer_earning` decimal(10,2) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `sunday_wage_per_hour` decimal(10,2) NOT NULL,
  `lunch_break_time` time NOT NULL,
  `lunch_break_in` time NOT NULL,
  `lunch_break_out` time NOT NULL,
  `morning_slot_1_time` time NOT NULL,
  `morning_slot_1_overtime_wage` decimal(10,2) NOT NULL,
  `morning_slot_2_time` time NOT NULL,
  `morning_slot_2_overtime_wage` decimal(10,2) NOT NULL,
  `morning_slot_3_time` time NOT NULL,
  `morning_slot_3_overtime_wage` decimal(10,2) NOT NULL,
  `morning_slot_4_overtime_wage` decimal(10,2) NOT NULL,
  `evening_slot_1_overtime_wage` decimal(10,2) NOT NULL,
  `evening_slot_2_time` time NOT NULL,
  `evening_slot_2_overtime_wage` decimal(10,2) NOT NULL,
  `evening_slot_3_time` time NOT NULL,
  `evening_slot_3_overtime_wage` decimal(10,2) NOT NULL,
  `evening_slot_4_time` time NOT NULL,
  `evening_slot_4_overtime_wage` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `metrics`
--

INSERT INTO `metrics` (`id`, `total_working_hours`, `average_producer_earning`, `time_in`, `time_out`, `sunday_wage_per_hour`, `lunch_break_time`, `lunch_break_in`, `lunch_break_out`, `morning_slot_1_time`, `morning_slot_1_overtime_wage`, `morning_slot_2_time`, `morning_slot_2_overtime_wage`, `morning_slot_3_time`, `morning_slot_3_overtime_wage`, `morning_slot_4_overtime_wage`, `evening_slot_1_overtime_wage`, `evening_slot_2_time`, `evening_slot_2_overtime_wage`, `evening_slot_3_time`, `evening_slot_3_overtime_wage`, `evening_slot_4_time`, `evening_slot_4_overtime_wage`) VALUES
(1, '08:00:00', '300.00', '10:00:00', '19:00:00', '15.00', '00:30:00', '13:30:00', '14:20:00', '07:00:00', '80.00', '08:00:00', '60.00', '09:00:00', '40.00', '20.00', '20.00', '20:00:00', '20.00', '21:00:00', '60.00', '22:00:00', '100.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `metrics`
--
ALTER TABLE `metrics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `metrics`
--
ALTER TABLE `metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
