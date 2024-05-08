-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 10:49 AM
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
(1, 1, 16, '2024-05-09', 'Coke', 3, 'Beverages', 10000.00, '1', 30000.00),
(2, 1, 17, '2024-05-09', 'Coke', 3, 'Beverages', 10000.00, '1', 30000.00);

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
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentid`, `checkedids`, `paidamount`, `rmtotalamount`, `ordtotalamount`, `overallamount`, `payment_date`) VALUES
(7, 16, 36000.00, 4000.00, 30000.00, 36000.00, '2024-05-08'),
(8, 17, 66000.00, 36000.00, 30000.00, 66000.00, '2024-05-09'),
(9, 18, 4000.00, 4000.00, 0.00, 4000.00, '2024-05-08');

-- --------------------------------------------------------

--
-- Table structure for table `reservationprocess`
--

CREATE TABLE `reservationprocess` (
  `recervationprocessid` int(11) NOT NULL,
  `guestuserid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `roomfloor` varchar(255) NOT NULL,
  `roomnumber` varchar(255) NOT NULL,
  `adults` varchar(255) NOT NULL,
  `children` varchar(255) NOT NULL,
  `checkindate` date NOT NULL,
  `checkintime` time NOT NULL,
  `checkoutdate` date NOT NULL,
  `checkouttime` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `reservationprice` decimal(10,2) NOT NULL,
  `totalreservationprice` decimal(10,2) NOT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `mobilenumber` varchar(255) NOT NULL,
  `emailaddress` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `paymentmethod` varchar(100) NOT NULL,
  `transactionid` varchar(255) NOT NULL,
  `gcashnumber` varchar(255) DEFAULT NULL,
  `referenceno` varchar(255) DEFAULT NULL,
  `promoname` varchar(255) DEFAULT NULL,
  `totalafterpromo` decimal(10,2) DEFAULT NULL,
  `reservationcompleted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservationprocess`
--

INSERT INTO `reservationprocess` (`recervationprocessid`, `guestuserid`, `roomid`, `roomfloor`, `roomnumber`, `adults`, `children`, `checkindate`, `checkintime`, `checkoutdate`, `checkouttime`, `price`, `reservationprice`, `totalreservationprice`, `prefix`, `firstname`, `lastname`, `suffix`, `mobilenumber`, `emailaddress`, `country`, `address`, `city`, `zipcode`, `status`, `paymentmethod`, `transactionid`, `gcashnumber`, `referenceno`, `promoname`, `totalafterpromo`, `reservationcompleted`) VALUES
(1, 1, 1, '2', 'SR201', '2', '1', '2024-05-06', '05:00:00', '2024-05-08', '19:00:00', 4000.00, 2000.00, 2000.00, '', 'Jonnel', 'Lique', '', '09685405691', 'jonnelmlique38@gmail.com', 'Philippines', '#3 Kalayaan', 'Quezon City', '1123', 'Accepted', 'PayPal', '8UL475326C807961S', '', '', NULL, 2000.00, '2024-05-05 05:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomid` int(11) NOT NULL,
  `roomtype` varchar(255) NOT NULL,
  `roominclusion` text NOT NULL,
  `bedsavailable` varchar(255) NOT NULL,
  `maxoccupancy` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `reservationprice` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomid`, `roomtype`, `roominclusion`, `bedsavailable`, `maxoccupancy`, `price`, `reservationprice`, `status`, `image`) VALUES
(1, 'Standard', 'Desk, TV, Wifi', '1 Queen Bed', 3, 4000.00, 2000.00, 'Available', 'standard-room.jpg'),
(2, 'Deluxe', 'Additional Seating Area, Upgraded Bathroom, Wifi', '2 Queen Bed', 3, 9000.00, 4500.00, 'Available', 'deluxe.jpg'),
(3, 'Suites', 'Dining Area, Separate Bedrooms, Wifi', '1 King Bed, 3 Single Beds', 5, 15000.00, 7500.00, 'Available', 'suite.jpg'),
(4, 'Executive', 'Workspace, Wifi, Business Center Access', '2 Queen Bed', 2, 11000.00, 5500.00, 'Available', 'executive.jpg'),
(5, 'Family', 'Wifi, Breakfast, Access to Pool, Newspaper', '1 King Bed, 1 Queen Bed, 1 Bunk Bed, 2 Single Beds', 6, 12000.00, 6000.00, 'Available', 'family-room.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roominfo`
--

CREATE TABLE `roominfo` (
  `roominfoid` int(11) NOT NULL,
  `roomtype` varchar(255) NOT NULL,
  `roomnumber` varchar(255) NOT NULL,
  `roomfloor` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roominfo`
--

INSERT INTO `roominfo` (`roominfoid`, `roomtype`, `roomnumber`, `roomfloor`, `status`) VALUES
(1, 'Standard', 'SR201', 2, 'Available'),
(2, 'Standard', 'SR202', 2, 'Available'),
(3, 'Standard', 'SR203', 2, 'Available'),
(4, 'Standard', 'SR204', 2, 'Available'),
(5, 'Standard', 'SR205', 2, 'Available'),
(6, 'Standard', 'SR206', 2, 'Available'),
(7, 'Standard', 'SR207', 2, 'Available'),
(8, 'Standard', 'SR208', 2, 'Available'),
(9, 'Standard', 'SR209', 2, 'Available'),
(10, 'Standard', 'SR210', 2, 'Available'),
(11, 'Standard', 'SR301', 3, 'Available'),
(12, 'Standard', 'SR302', 3, 'Available'),
(13, 'Standard', 'SR303', 3, 'Available'),
(14, 'Standard', 'SR304', 3, 'Available'),
(15, 'Standard', 'SR305', 3, 'Available'),
(16, 'Standard', 'SR306', 3, 'Available'),
(17, 'Standard', 'SR307', 3, 'Available'),
(18, 'Standard', 'SR308', 3, 'Available'),
(19, 'Standard', 'SR309', 3, 'Available'),
(20, 'Standard', 'SR310', 3, 'Available'),
(21, 'Standard', 'SR401', 4, 'Available'),
(22, 'Standard', 'SR402', 4, 'Available'),
(23, 'Standard', 'SR403', 4, 'Available'),
(24, 'Standard', 'SR404', 4, 'Available'),
(25, 'Standard', 'SR405', 4, 'Available'),
(26, 'Standard', 'SR406', 4, 'Available'),
(27, 'Standard', 'SR407', 4, 'Available'),
(28, 'Standard', 'SR408', 4, 'Available'),
(29, 'Standard', 'SR409', 4, 'Available'),
(30, 'Standard', 'SR410', 4, 'Available'),
(31, 'Standard', 'SR501', 5, 'Available'),
(32, 'Standard', 'SR502', 5, 'Available'),
(33, 'Standard', 'SR503', 5, 'Available'),
(34, 'Standard', 'SR504', 5, 'Available'),
(35, 'Standard', 'SR505', 5, 'Available'),
(36, 'Standard', 'SR506', 5, 'Available'),
(37, 'Standard', 'SR507', 5, 'Available'),
(38, 'Standard', 'SR508', 5, 'Available'),
(39, 'Standard', 'SR509', 5, 'Available'),
(40, 'Standard', 'SR510', 5, 'Available'),
(41, 'Deluxe', 'DR601', 6, 'Available'),
(42, 'Deluxe', 'DR602', 6, 'Available'),
(43, 'Deluxe', 'DR603', 6, 'Available'),
(44, 'Deluxe', 'DR604', 6, 'Available'),
(45, 'Deluxe', 'DR605', 6, 'Available'),
(46, 'Deluxe', 'DR701', 7, 'Available'),
(47, 'Deluxe', 'DR702', 7, 'Available'),
(48, 'Deluxe', 'DR703', 7, 'Available'),
(49, 'Deluxe', 'DR704', 7, 'Available'),
(50, 'Deluxe', 'DR705', 7, 'Available'),
(51, 'Deluxe', 'DR801', 8, 'Available'),
(52, 'Deluxe', 'DR802', 8, 'Available'),
(53, 'Deluxe', 'DR803', 8, 'Available'),
(54, 'Deluxe', 'DR804', 8, 'Available'),
(55, 'Deluxe', 'DR805', 8, 'Available'),
(56, 'Suites', 'S901', 9, 'Available'),
(57, 'Suites', 'S902', 9, 'Available'),
(58, 'Suites', 'S903', 9, 'Available'),
(59, 'Suites', 'S904', 9, 'Available'),
(60, 'Suites', 'S1001', 10, 'Available'),
(61, 'Suites', 'S1002', 10, 'Available'),
(62, 'Suites', 'S1003', 10, 'Available'),
(63, 'Suites', 'S1004', 10, 'Available'),
(64, 'Executive', 'ER1101', 11, 'Available'),
(65, 'Executive', 'ER1102', 11, 'Available'),
(66, 'Executive', 'ER1103', 11, 'Available'),
(67, 'Executive', 'ER1201', 12, 'Available'),
(68, 'Executive', 'ER1202', 12, 'Available'),
(69, 'Family', 'FR1301', 13, 'Available'),
(70, 'Family', 'FR1302', 13, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `product_id` int(100) DEFAULT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
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
(1, 1, '1', 'Coke', 'Coke Corporation', 'Beverages', 'Canned Drinks', '0000-00-00', 10, 500, 10000, '2024-05-01', '15:36:00', 100000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checked`
--
ALTER TABLE `checked`
  ADD PRIMARY KEY (`checkedid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `StockID` (`StockID`),
  ADD KEY `CheckedID` (`CheckedID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentid`),
  ADD KEY `checkedids` (`checkedids`);

--
-- Indexes for table `reservationprocess`
--
ALTER TABLE `reservationprocess`
  ADD PRIMARY KEY (`recervationprocessid`),
  ADD UNIQUE KEY `roomnumber` (`roomnumber`),
  ADD KEY `roomid` (`roomid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomid`);

--
-- Indexes for table `roominfo`
--
ALTER TABLE `roominfo`
  ADD PRIMARY KEY (`roominfoid`),
  ADD UNIQUE KEY `roomnumber` (`roomnumber`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checked`
--
ALTER TABLE `checked`
  MODIFY `checkedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reservationprocess`
--
ALTER TABLE `reservationprocess`
  MODIFY `recervationprocessid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roominfo`
--
ALTER TABLE `roominfo`
  MODIFY `roominfoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`StockID`) REFERENCES `stock` (`stock_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CheckedID`) REFERENCES `checked` (`checkedid`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`checkedids`) REFERENCES `checked` (`checkedid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
