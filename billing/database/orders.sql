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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `StockID` int(11) NOT NULL,
  `CheckedID` int(11) DEFAULT NULL,
  `OrderDate` date NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `OrderQuantity` int(11) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `StockID`, `CheckedID`, `OrderDate`, `ProductName`, `OrderQuantity`, `Category`, `Price`, `Status`, `TotalAmount`) VALUES
(1, 1, 1, '2024-05-16', 'Coke', 3, 'Beverages', 15.00, '1', 45.00),
(2, 2, 1, '2024-05-16', 'Royal', 3, 'Beverages', 15.00, '1', 45.00),
(3, 1, 2, '2024-05-17', 'Coke', 4, 'Beverages', 15.00, '1', 60.00),
(4, 2, 2, '2024-05-17', 'Royal', 1, 'Beverages', 15.00, '1', 15.00),
(5, 4, 2, '2024-05-17', 'Prawn Crackers', 10, 'Snacks', 15.00, '1', 150.00),
(6, 1, 5, '2024-05-18', 'Coke', 3, 'Beverages', 15.00, '1', 45.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `StockID` (`StockID`),
  ADD KEY `CheckedID` (`CheckedID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`StockID`) REFERENCES `stock` (`stock_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CheckedID`) REFERENCES `checked` (`checkedid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
