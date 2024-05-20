-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 03:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
(1, 'Jonnel Lique', '09685405691', 1, 'SR201', 2, 'Standard', 4000.00, 2, 1, '2024-05-06', '05:00:00', '2024-05-08', '19:00:00', 2, 'cash', 8000.00, '2', 2000.00),
(2, 'Laurence Macapagal', '09282424241', 54, 'DR804', 8, 'Deluxe', 9000.00, 1, 1, '2024-05-17', '08:56:00', '2024-05-17', '13:00:00', 1, 'debit_card', 9000.00, '2', 0.00),
(3, 'Jeremy Hayag', '09222123213', 51, 'DR801', 8, 'Deluxe', 9000.00, 1, 2, '2024-05-17', '21:56:00', '2024-05-17', '17:00:00', 1, 'debit_card', 9000.00, '2', 0.00),
(4, 'Dominic Istanislao', '09239444112', 10, 'SR210', 2, 'Standard', 4000.00, 2, 1, '2024-05-18', '09:57:00', '2024-05-18', '14:00:00', 1, 'cash', 4000.00, '2', 0.00),
(5, 'Jonna Macarimbang', '09231114223', 62, 'S1003', 10, 'Suites', 15000.00, 2, 2, '2024-05-20', '11:57:00', '2024-05-20', '00:00:00', 1, 'cash', 15000.00, '2', 0.00);

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
  MODIFY `checkedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
