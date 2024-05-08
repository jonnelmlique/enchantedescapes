-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 10:48 AM
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
-- Database: `hotel_billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `checked`
--

CREATE TABLE `checked` (
  `checkedid` int(11) NOT NULL,
  `guestname` varchar(255) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `roominfoid` int(11) NOT NULL,
  `roomnumber` varchar(255) NOT NULL,
  `roomfloor` int(11) NOT NULL,
  `roomtype` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `checkindate` date NOT NULL,
  `checkintime` time NOT NULL,
  `checkoutdate` date NOT NULL,
  `checkouttime` time NOT NULL,
  `days` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `room_total_price` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `reservationfee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checked`
--

INSERT INTO `checked` (`checkedid`, `guestname`, `contactno`, `roominfoid`, `roomnumber`, `roomfloor`, `roomtype`, `price`, `adult`, `children`, `checkindate`, `checkintime`, `checkoutdate`, `checkouttime`, `days`, `payment_method`, `room_total_price`, `status`, `reservationfee`) VALUES
(8, 'Christian Jay', '09271769411', 1, '0', 2, 'Standard', 4000.00, 1, 2, '2024-05-09', '00:46:00', '0000-00-00', '00:00:00', 0, '', 0.00, '1', 0.00),
(15, 'Jonnel', '09685405691', 1, 'SR201', 2, 'Standard', 4000.00, 2, 1, '2024-05-06', '05:00:00', '2024-05-08', '19:00:00', 0, '', 0.00, '1', 0.00),
(16, 'Jonnel', '09685405691', 1, 'SR201', 2, 'Standard', 4000.00, 2, 1, '2024-05-06', '05:00:00', '2024-05-10', '19:00:00', 4, 'cash', 4000.00, '2', 2000.00),
(17, 'Steve', '02912992992', 49, 'DR704', 7, 'Deluxe', 9000.00, 1, 0, '2024-05-09', '14:43:00', '2024-05-13', '00:00:00', 4, 'debit_card', 36000.00, '2', 2000.00),
(18, 'Christian Jay', '09271769411', 1, 'SR201', 2, 'Standard', 4000.00, 1, 2, '2024-05-09', '18:37:00', '2024-05-10', '00:00:00', 1, 'credit_card', 4000.00, '2', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checked`
--
ALTER TABLE `checked`
  ADD PRIMARY KEY (`checkedid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checked`
--
ALTER TABLE `checked`
  MODIFY `checkedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
