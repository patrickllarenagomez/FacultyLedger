-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2018 at 04:51 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_ledger`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_professor`
--

CREATE TABLE `tbl_professor` (
  `professor_id` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `professor_first_name` varchar(30) NOT NULL,
  `professor_last_name` varchar(30) NOT NULL,
  `professor_phone_number` varchar(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_professor`
--

INSERT INTO `tbl_professor` (`professor_id`, `serial_number`, `professor_first_name`, `professor_last_name`, `professor_phone_number`, `is_active`) VALUES
(1, '13231321', 'Patrick', 'Gomez', '09174815147', 1),
(2, '5554433221', 'First name ', 'last name test', '09199999991', 0),
(3, '3123213', 'Patrick', 'Surname', '09174815147', 1),
(4, '09123123123', 'Jayson', 'Noob', '13123213213', 0),
(6, '622076732491', 'Nancy', 'Malgapo', '09174815147', 1),
(7, '123456789', 'PatrickTesting', 'Gomez', '09174815147', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_availability`
--

CREATE TABLE `tbl_room_availability` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(3) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room_availability`
--

INSERT INTO `tbl_room_availability` (`room_id`, `room_number`, `professor_id`, `is_available`) VALUES
(1, '300', 7, 0),
(2, '301', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `schedule_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `subject_code` varchar(30) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `room_number` varchar(3) NOT NULL,
  `schedule_day` tinyint(1) NOT NULL,
  `schedule_time_in` time NOT NULL,
  `schedule_time_out` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`schedule_id`, `professor_id`, `subject_code`, `subject_name`, `room_number`, `schedule_day`, `schedule_time_in`, `schedule_time_out`, `is_active`) VALUES
(1, 3, 'COEN41231', 'Elective 12', '300', 6, '12:00:00', '15:30:00', 1),
(2, 1, 'COEN1231', 'Computer Networks', '301', 6, '13:00:00', '16:00:00', 1),
(3, 1, 'COEN3123', 'Computer Fundamentals', '301', 2, '11:00:00', '14:00:00', 1),
(4, 5, 'TESTING', 'TESTING', '300', 4, '19:00:00', '20:00:00', 0),
(5, 6, 'COEN21231', 'TESTING', '300', 5, '15:30:00', '16:30:00', 0),
(6, 6, 'COEN12312', 'TESTING', '301', 5, '19:00:00', '19:46:00', 1),
(7, 7, 'Trst', '12312', '300', 5, '16:00:00', '17:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time_log`
--

CREATE TABLE `tbl_time_log` (
  `time_log_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `time_log_date` date NOT NULL,
  `time_log_in` time NOT NULL,
  `time_log_out` time NOT NULL,
  `room_number` varchar(3) NOT NULL,
  `is_holiday` tinyint(1) NOT NULL DEFAULT '0',
  `is_valid` tinyint(1) DEFAULT '0',
  `is_late` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_time_log`
--

INSERT INTO `tbl_time_log` (`time_log_id`, `professor_id`, `time_log_date`, `time_log_in`, `time_log_out`, `room_number`, `is_holiday`, `is_valid`, `is_late`, `is_active`) VALUES
(1, 1, '2018-03-06', '09:00:00', '12:00:00', '301', 0, 1, 0, 1),
(6, 1, '2018-03-10', '13:15:01', '13:46:01', '301', 0, 1, 1, 0),
(9, 1, '2018-03-11', '17:45:00', '00:00:00', '301', 0, 1, 1, 0),
(10, 1, '2018-03-14', '09:00:00', '13:00:00', '301', 0, 1, 1, 1),
(11, 3, '2018-03-18', '12:00:00', '15:15:00', '300', 0, 1, 0, 1),
(16, 7, '2018-03-11', '16:30:01', '00:00:00', '300', 0, 0, 1, 1),
(18, 6, '2018-03-23', '19:00:00', '19:46:00', '301', 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_first_name` varchar(30) NOT NULL,
  `user_last_name` varchar(30) NOT NULL,
  `user_level` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `password`, `user_first_name`, `user_last_name`, `user_level`, `is_active`) VALUES
(1, 'patrick', 'e19d5cd5af0378da05f63f891c7467af', 'Patrick', 'Gomez', 3, 1),
(2, 'patrickchecker', 'e19d5cd5af0378da05f63f891c7467af', 'Patrick', 'Gomez', 2, 1),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Julian', 'Lorico', 1, 1),
(4, 'adminchecker', '0176f7fecec403535126e46124b78954', 'Julian', 'Lorico', 2, 1),
(5, 'superadmin', '17c4520f6cfd1ab53d8745e84681eb49', 'Julian', 'Lorico', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_professor`
--
ALTER TABLE `tbl_professor`
  ADD PRIMARY KEY (`professor_id`);

--
-- Indexes for table `tbl_room_availability`
--
ALTER TABLE `tbl_room_availability`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `tbl_time_log`
--
ALTER TABLE `tbl_time_log`
  ADD PRIMARY KEY (`time_log_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_professor`
--
ALTER TABLE `tbl_professor`
  MODIFY `professor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_room_availability`
--
ALTER TABLE `tbl_room_availability`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_time_log`
--
ALTER TABLE `tbl_time_log`
  MODIFY `time_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
