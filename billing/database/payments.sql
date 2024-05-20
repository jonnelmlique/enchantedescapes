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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentid` int(11) NOT NULL,
  `checkedids` int(11) NOT NULL,
  `paidamount` decimal(10,2) NOT NULL,
  `rmtotalamount` decimal(10,2) NOT NULL,
  `ordtotalamount` decimal(10,2) NOT NULL,
  `overallamount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentid`, `checkedids`, `paidamount`, `rmtotalamount`, `ordtotalamount`, `overallamount`, `payment_date`, `balance`) VALUES
(1, 1, 7000.00, 8000.00, 90.00, 6090.00, '2024-05-16', 910.00),
(2, 2, 9225.00, 9000.00, 225.00, 9225.00, '2024-05-16', 0.00),
(3, 4, 5000.00, 4000.00, 0.00, 4000.00, '2024-05-16', 1000.00),
(4, 5, 15100.00, 15000.00, 45.00, 15045.00, '2024-05-16', 55.00),
(5, 3, 9000.00, 9000.00, 0.00, 9000.00, '2024-05-16', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentid`),
  ADD KEY `checkedids` (`checkedids`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`checkedids`) REFERENCES `checked` (`checkedid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
