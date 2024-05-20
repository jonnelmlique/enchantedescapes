-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 01:23 PM
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
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `id` int(255) NOT NULL,
  `adminID` varchar(255) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`id`, `adminID`, `adminName`, `email`, `Department`, `password`) VALUES
(5, '1956', 'Admin', 'aspe.daniella.02212003@gmail.com', 'DEPARTMENT NI PAPA', '414770'),
(6, '8250', 'dahlia', 'aspe.daniella.02212003@gmail.com', 'DEPARTMENT NI PAPA', '687633'),
(7, '4906', 'mama', 'mama@gmail.com', 'RESERVATION DEPARTMENT', '863375');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_tbl`
--

CREATE TABLE `attendance_tbl` (
  `id` int(255) NOT NULL,
  `attendance_id` varchar(255) NOT NULL,
  `employee_ID` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `Time_in` varchar(255) NOT NULL,
  `Timein_img` blob NOT NULL,
  `Time_out` varchar(255) NOT NULL,
  `Timeout_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `sno` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id_no` varchar(15) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `exp_date` varchar(20) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`sno`, `name`, `id_no`, `email`, `phone`, `address`, `dob`, `date`, `exp_date`, `image`) VALUES
(1, 'asd', '123', 'admin@gmail.com]', '3258897897', 'asd', '2024-04-04', '2024-04-15 17:02:13', '2024-04-08', 'assets/uploads/1669759951_6-pibig-info-p-shinobu-kocho-art-oboi-7.jpg'),
(4, 'fdsfg23424234', '12', 'ramos.joannejoy.10032001@gmail.com]', '32432435435', 'pusoko', '2024-04-16', '2024-04-15 18:43:10', '2024-04-22', 'uploadsCapture.PNG'),
(5, 'Daniella Aspe', '21234', 'aspe.daniella.02212003@gmail.com]', '09386140526', '72c Baesa Road Quezon City', '2024-04-19', '2024-04-19 01:36:58', '2027-06-08', 'uploads1x1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `crud`
--

CREATE TABLE `crud` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crud`
--

INSERT INTO `crud` (`id`, `name`, `email`, `department`, `position`) VALUES
(8, 'Daniella Aspe', 'daniellaaspe90@gmail.com', 'IT department', 'head');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_id`, `department_name`) VALUES
(1, '', 'RESERVATION DEPARTMENTko'),
(2, '', 'RESERVATION DEPARTMENTko'),
(3, 'DEPT_662797981676d', 'Billing Department'),
(4, 'DEPT-62797981677', 'Billing Department');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `Id` int(11) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `img` blob NOT NULL,
  `Name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `emp_bday` varchar(255) NOT NULL,
  `Age` varchar(255) NOT NULL,
  `Gender` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `StartDate` varchar(255) NOT NULL,
  `EndDate` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`Id`, `Employee_ID`, `img`, `Name`, `email`, `password`, `Address`, `emp_bday`, `Age`, `Gender`, `Phone`, `StartDate`, `EndDate`, `position`, `Department`, `Status`) VALUES
(12, '8831', 0x44696420796f75206163746976656c79207061727469636970617465645f776174636820696e20616e79206f662074686520696e7472616d7572616c206576656e7473206c61737420796561725f2e6a706567, 'titako', 'tita@gmail.com', '495281', '73 ahahdhad', '1996-02-02', '28', '', '09563825167', '2024-04-27', '', 'Secretary', 'DEPARTMENT NI PAPA', 'ACTIVE'),
(15, '5225', 0x7172636f64655f6c6f63616c686f73742e706e67, 'Dolores Aspeddaaaahj', 'dolores@gmail.com', '708642', '72c Baesa Road Quezon City', '1998-03-05', '26', 'Female', '09386140526', '2024-04-23', '', 'Secretary', 'DEPARTMENT NI PAPA', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `employee_record`
--

CREATE TABLE `employee_record` (
  `id` int(11) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `Time_in` varchar(255) NOT NULL,
  `Time_out` varchar(255) NOT NULL,
  `Hours` varchar(255) NOT NULL,
  `Days` varchar(255) NOT NULL,
  `leave_days` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtime_tbl`
--

CREATE TABLE `overtime_tbl` (
  `id` int(255) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `No_of_hours` varchar(255) NOT NULL,
  `No_of_mins` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_attendance`
--

CREATE TABLE `pending_attendance` (
  `id` int(255) NOT NULL,
  `attendance_id` varchar(255) NOT NULL,
  `employee_ID` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `Time_in` varchar(255) NOT NULL,
  `Timein_img` varchar(255) NOT NULL,
  `Time_out` varchar(255) NOT NULL,
  `Timeout_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_attendance`
--

INSERT INTO `pending_attendance` (`id`, `attendance_id`, `employee_ID`, `Date`, `Time_in`, `Timein_img`, `Time_out`, `Timeout_img`) VALUES
(26, '', '8747', '2024-04-22', '14:34:54', '6626050e6a385.jpg', '', ''),
(27, '', '8831', '2024-04-23', '11:37:28', '66272cf870ef2.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `Time_in` time NOT NULL,
  `Time_out` time NOT NULL,
  `schedule_days` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `Employee_ID`, `Name`, `start_date`, `end_date`, `Time_in`, `Time_out`, `schedule_days`) VALUES
(9, '8747', 'Dahlia Aspe', '2024-04-23', '2024-05-11', '00:40:00', '08:40:00', 'Monday,Thursday'),
(12, '8831', 'titako', '2024-04-23', '2024-05-04', '00:54:00', '08:54:00', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'),
(13, '8831', 'titako', '2024-04-23', '2024-05-11', '11:00:00', '19:00:00', 'Tuesday,Thursday,Saturday');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL,
  `shiftstart` datetime NOT NULL,
  `shiftend` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `name`, `email`, `position`, `shiftstart`, `shiftend`) VALUES
(12, 'Pagaduan,Mark Jay B', 'pagaduan.markjay.03201999@gmail.com', 'asd', '2024-04-25 21:55:00', '2024-04-29 16:55:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `crud`
--
ALTER TABLE `crud`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `employee_record`
--
ALTER TABLE `employee_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime_tbl`
--
ALTER TABLE `overtime_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_attendance`
--
ALTER TABLE `pending_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `crud`
--
ALTER TABLE `crud`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employee_record`
--
ALTER TABLE `employee_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overtime_tbl`
--
ALTER TABLE `overtime_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_attendance`
--
ALTER TABLE `pending_attendance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
