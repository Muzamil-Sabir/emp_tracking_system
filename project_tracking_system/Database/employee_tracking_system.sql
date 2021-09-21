-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2021 at 05:05 AM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_tracking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `cordinates_street_address` varchar(500) DEFAULT NULL,
  `cordinates_country` varchar(500) DEFAULT NULL,
  `cordinates_updated_at` datetime DEFAULT NULL,
  `isactive` int(11) NOT NULL DEFAULT '0',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `contact`, `address`, `password`, `lat`, `lng`, `cordinates_street_address`, `cordinates_country`, `cordinates_updated_at`, `isactive`, `added_at`) VALUES
(21, 'Jasleen', 'jasleen@gmail.com', NULL, NULL, 'jasleen14', NULL, NULL, NULL, NULL, NULL, 0, '2021-05-09 14:57:18'),
(27, 'Raveena', 'raveenabains@gmail.com', '0780490555', '50,gale street,london', 'Jalandhar12', 51.8156, 0.8084, 's address', 'uk', NULL, 0, '2021-05-11 00:32:19'),
(26, 'Muzamil', 'muzamil@gmail.com', NULL, NULL, '123', 34.0153956, 73.0886137, 'Unnamed Road, Baldher, Haripur, Khyber Pakhtunkhwa, Pakistan', 'Pakistan', '2021-05-16 17:55:45', 1, '2021-05-10 03:47:56'),
(28, 'Rupinder Singh', 'rupinder@gmail.com', NULL, NULL, 'rupinder ', NULL, NULL, NULL, NULL, NULL, 0, '2021-05-10 22:56:39'),
(30, 'How to Learn', 'thinktech039@gmail.com', NULL, NULL, '123', NULL, NULL, NULL, NULL, NULL, 0, '2021-05-19 19:13:09'),
(31, 'newemp', 'any@gmail.com', '234345', '345', 'MTIzNDU2', NULL, NULL, NULL, NULL, NULL, 1, '2021-05-21 18:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_tittle` varchar(100) NOT NULL,
  `task_description` varchar(300) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `submitted_at` datetime DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_tittle`, `task_description`, `assigned_to`, `assigned_at`, `status`, `submitted_at`, `lat`, `lng`, `remarks`) VALUES
(6, 'Marketing', 'deliver some medicines to the cv4 5kh', 26, '2021-05-16 17:01:19', 'completed', '2021-05-16 18:01:19', 34.0127297, 73.0970471, 'completed'),
(5, 'Marketing', 'DELIVER FAIRNESS CREAM TO CV6 3LH.', 0, '2021-05-11 19:18:26', 'pending', NULL, NULL, NULL, NULL),
(4, 'New Task', 'des', 26, '2021-05-12 10:42:20', 'completed', '2021-05-04 15:42:14', NULL, NULL, 'Deliverred on Time'),
(7, 'Marketing', 'deliver some medicines to cv5 6lk', 0, '2021-05-10 23:30:35', 'pending', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `name`, `email`, `password`, `datetime`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', '123', '2021-05-21 11:13:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
