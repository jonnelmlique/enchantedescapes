-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 08:31 AM
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
(1, '1981', 'payroll', 'payrolldept@gmail.com', 'Payroll Department', '123321'),
(16, '8319', 'dahliadddada', 'aspe.daniella.02212003@gmail.com', 'IT Department', '841375');

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
(13, 'Daniella Nojas Aspe', '1679', 'aspe.daniella.02212003@gmail.com', '09386140526', '72c Baesa Road Quezon City', '2000-02-02', '2024-05-09 00:00:00', '2024-05-29', 'uploadsKaptPakPak-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `id` int(11) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Release Date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `position` varchar(2555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_id`, `department_name`, `position`) VALUES
(54, '4379', 'Billing Department', 'Manager, Billing Clerk'),
(55, '1987', 'IT Department', 'IT Specialist, IT consultant');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `Id` int(11) NOT NULL,
  `Employee_ID` varchar(255) NOT NULL,
  `img` blob NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
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

INSERT INTO `employee_info` (`Id`, `Employee_ID`, `img`, `first_name`, `last_name`, `middle_name`, `email`, `password`, `Address`, `emp_bday`, `Age`, `Gender`, `Phone`, `StartDate`, `EndDate`, `position`, `Department`, `Status`) VALUES
(32, '1679', 0x3434303039313031325f3636393736333230313934363231385f343434363737333935313835343531343131385f6e2e6a7067, 'Daniellasa', 'Asped', 'Nojas', 'aspe.daniella.02212003@gmail.com', '469828', '72c Baesa Road Quezon City', '2000-02-02', '24', 'Female', '09386140526', '2024-05-08', '', 'IT Specialist', 'IT Department', 'ACTIVE');

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

--
-- Dumping data for table `employee_record`
--

INSERT INTO `employee_record` (`id`, `Employee_ID`, `Date`, `Time_in`, `Time_out`, `Hours`, `Days`, `leave_days`) VALUES
(13, '1679', '2024-05-08', '00:42:25', '08:49:34', '8', '1', '0'),
(14, '1679', '2024-05-09', '04:28:08', '10:29:07', '8', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `eid` int(11) NOT NULL COMMENT 'Employee ID',
  `ename` varchar(255) NOT NULL COMMENT 'Employee''s Username',
  `descr` varchar(255) NOT NULL COMMENT 'Leave Reason',
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `eid`, `ename`, `descr`, `fromdate`, `todate`, `status`) VALUES
(12, 1679, 'Daniella Aspe Noja', 'Vacation,Bereavement,Time off without pay : sa', '2024-05-22', '2024-06-06', 'Pending');

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

--
-- Dumping data for table `overtime_tbl`
--

INSERT INTO `overtime_tbl` (`id`, `Employee_ID`, `Name`, `date`, `No_of_hours`, `No_of_mins`) VALUES
(6, '1679', 'Aspe', '2024-05-08', '0', '36'),
(7, '1679', 'Aspe', '2024-05-09', '2', '16');

-- --------------------------------------------------------

--
-- Table structure for table `payrolltbl`
--

CREATE TABLE `payrolltbl` (
  `payrollid` int(11) NOT NULL,
  `month` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `hours` varchar(255) DEFAULT NULL,
  `dayspresent` varchar(255) DEFAULT NULL,
  `overtimehours` varchar(255) DEFAULT NULL,
  `leavedays` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `overtime` decimal(10,2) DEFAULT NULL,
  `taxrate` decimal(5,2) DEFAULT NULL,
  `totalsalary` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payrolltbl`
--

INSERT INTO `payrolltbl` (`payrollid`, `month`, `employee_name`, `employeeid`, `hours`, `dayspresent`, `overtimehours`, `leavedays`, `salary`, `overtime`, `taxrate`, `totalsalary`) VALUES
(20, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(21, '01', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(22, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(23, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(24, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(25, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(26, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(27, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(28, '08', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 5.00, -5.00),
(29, '09', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 100.00, -100.00),
(30, '07', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(31, '09', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 100.00, -100.00),
(32, '06', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(33, '12', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(34, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(35, '05', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(36, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(37, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(38, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(39, '08', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 5.00, -5.00),
(40, '09', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 100.00, -100.00),
(41, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(42, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(43, '04', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(44, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(45, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(46, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(47, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(48, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(49, '11', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 0.00, 0.00),
(50, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(51, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(52, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(53, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(54, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(55, '08', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 5.00, -5.00),
(56, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(57, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(58, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(59, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(60, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(61, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(62, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(63, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(64, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00),
(65, '02', 'Asped, Daniellasa Nojas', 1679, '0', '0', '0', '0', 0.00, 0.00, 50.00, -50.00),
(66, '05', 'Asped, Daniellasa Nojas', 1679, '16', '2', '4', '60', 1152.00, 400.00, 10.00, 1542.00);

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
(39, '', '8864', '2024-05-07', '13:07:29', '6639b7117f60d.jpg', '', ''),
(40, '', '9646', '2024-05-07', '15:16:14', '6639d53e2b0b7.jpg', '23:19:47', 0x363633613436393362393836652e6a7067),
(41, '', '1679', '2024-05-08', '00:42:25', '663a59f17e127.jpg', '08:49:34', 0x363633616363316564653936372e6a7067),
(42, '', '1679', '2024-05-09', '04:28:08', '663be0586d529.jpg', '10:29:07', 0x363633633334663335626137362e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salaryid` int(11) NOT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `dailyrate` decimal(10,2) DEFAULT NULL,
  `overtimerate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salaryid`, `employeeid`, `dailyrate`, `overtimerate`) VALUES
(1, 1679, 576.00, 100.00);

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
(26, '1679', 'Daniella Aspe Noja', '2024-05-01', '2024-05-31', '00:13:00', '08:13:00', 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `tax_table`
--

CREATE TABLE `tax_table` (
  `taxid` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `percentage` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tax_table`
--

INSERT INTO `tax_table` (`taxid`, `month`, `percentage`) VALUES
(1, '05', 10.00),
(2, '09', 100.00),
(3, '08', 5.00),
(4, '11', 50.00),
(5, '01', 45.00),
(6, '12', 76.00),
(7, '02', 50.00),
(8, '03', 10.00),
(9, '04', 5.00);

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
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
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
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime_tbl`
--
ALTER TABLE `overtime_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolltbl`
--
ALTER TABLE `payrolltbl`
  ADD PRIMARY KEY (`payrollid`);

--
-- Indexes for table `pending_attendance`
--
ALTER TABLE `pending_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salaryid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `tax_table`
--
ALTER TABLE `tax_table`
  ADD PRIMARY KEY (`taxid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `employee_record`
--
ALTER TABLE `employee_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `overtime_tbl`
--
ALTER TABLE `overtime_tbl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payrolltbl`
--
ALTER TABLE `payrolltbl`
  MODIFY `payrollid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `pending_attendance`
--
ALTER TABLE `pending_attendance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salaryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tax_table`
--
ALTER TABLE `tax_table`
  MODIFY `taxid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
