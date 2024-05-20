-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 02:29 PM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(100) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `quantity_per_item` int(4) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `product_id`, `supplier_id`, `product_name`, `supplier`, `category`, `type`, `expiry_date`, `quantity`, `quantity_per_item`, `price`, `date`, `time`, `total`) VALUES
(1, 1, 1, 'Coke', 'Coke Corporation', 'Beverages', 'Canned Drinks', '2024-05-31', 10, 50, 15, '2024-05-01', '22:59:00', 750),
(2, 2, 2, 'Royal', 'Royal Corporation', 'Beverages', 'Canned Drinks', '2024-05-31', 10, 10, 15, '2024-05-01', '15:16:00', 150),
(4, 4, 4, 'Prawn Crackers', 'Oishi', 'Snacks', 'Junk Food', '2024-05-31', 10, 500, 15, '2024-05-31', '23:48:00', 7500),
(5, 5, 5, 'Piattos', 'Jack N Jill', 'Snacks', 'Junk Food', '2024-05-31', 10, 500, 15, '2024-05-01', '11:49:00', 7500),
(6, 6, 6, 'Dairy Milk', 'Cadbury', 'Candy', 'Chocolate', '2024-05-21', 10, 1000, 1, '2024-05-01', '11:50:00', 1000),
(7, 7, 7, 'Emperador Lights', 'Emperador Corporation', 'Alcohol', 'Bottled Alcohol', '2024-05-31', 10, 500, 15, '2024-05-01', '00:21:00', 7500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
