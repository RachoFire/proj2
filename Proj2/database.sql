-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 17, 2021 at 01:14 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Coffee_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `149_drinks`
--

CREATE TABLE `149_drinks` (
  `drinkID` int(11) NOT NULL,
  `drinkName` varchar(50) NOT NULL,
  `drinkImage` varchar(255) NOT NULL DEFAULT 'empty',
  `restaurantID` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `149_drinks`
--

INSERT INTO `149_drinks` (`drinkID`, `drinkName`, `drinkImage`, `restaurantID`, `status`) VALUES
(1, 'test drink', 'empty', 1, NULL),
(2, 'test two drink', 'empty', 1, NULL),
(3, 'test three drink', 'empty', 1, NULL),
(5, 'test', 'http://localhost:8888/proj2/images/1328838392453-4536482_download-tea-cartoon-png-clipart-bubble-tea-coffee.jpg', 1, NULL),
(6, 'test', 'http://localhost:8888/proj2/images/1986326841453-4536482_download-tea-cartoon-png-clipart-bubble-tea-coffee.jpg', 1, NULL),
(7, 'coffee', 'ghj', 1, NULL),
(8, 'coffee', 'http://localhost:8888/proj2/images/989109836453-4536482_download-tea-cartoon-png-clipart-bubble-tea-coffee.jpg', 4, NULL),
(9, 'coffee2', 'http://localhost:8888/proj2/images/208897917453-4536482_download-tea-cartoon-png-clipart-bubble-tea-coffee.jpg', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `356_restaurants`
--

CREATE TABLE `356_restaurants` (
  `restaurantID` int(11) NOT NULL,
  `restaurantName` varchar(50) NOT NULL,
  `streetName` varchar(50) NOT NULL,
  `streetNumber` int(11) NOT NULL,
  `suburb` varchar(50) NOT NULL,
  `postcode` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `356_restaurants`
--

INSERT INTO `356_restaurants` (`restaurantID`, `restaurantName`, `streetName`, `streetNumber`, `suburb`, `postcode`, `username`, `status`) VALUES
(1, 'test', 'test', 2, 'test', 5678, '', NULL),
(2, 'test two', 'test', 2, 'test', 5678, '', NULL),
(3, 'cafe 63', 'test', 5678, 'test', 5678, 'Account', 'deleted'),
(4, 'maccas cafe', 'ghjk', 6789, 'fghj', 6789, 'restaurant', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `365_users`
--

CREATE TABLE `365_users` (
  `username` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `accountType` varchar(50) NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `365_users`
--

INSERT INTO `365_users` (`username`, `firstName`, `lastName`, `password`, `status`, `accountType`) VALUES
('', '', '', '', NULL, ''),
('&#34;&#34;yes', 'test', 'test', '$2y$10$H2SCfsnCjsRYtzCNjvECk.uNceAcDaV2I/gFaX5FoyY3d7Q7WZdiy', NULL, ''),
('account', 'Lucie', 'Davis', '$2y$10$ZYSWrYH/BluoA1lg4U1jqe6p1L/IHfHdbdcIb1rbTmu4JtaESTuA2', 'deleted', 'U'),
('acoount', '9', 'b', '$2y$10$7bc5chgvhp/2S.uoH.NMtuJ3KJ.kUX1wV6cQL5Xj8YDiDgeHFYyGW', NULL, 'U'),
('Admin', 'user', 'account', '$2y$10$WYNfk3dSL8ky23SNwFEB0.xtwW49SkhjJz0IvbGM2Xv3NqGQFKOeq', NULL, 'U'),
('am', 'i', 'really', '$2y$10$zgF.cWnJ35dGv8sa1pQhwuIZk8BmD6iyKnJZfCZIszAEtWD6twKcy', NULL, ''),
('discordMan@514', 'Lucie', 'Davis', '$2y$10$EhwCiAWvkUmmxIhGeWwsJuPe0Euswc2ja3nf.kNKL2qHDHtQTf7mO', NULL, ''),
('ghjk', 'hjk', 'ghjk', 'ghjk', NULL, ''),
('ghjkl', 'ghj', 'ghjk', 'ghjk', NULL, ''),
('hello', 'yo', 'whatsUp', '$2y$10$xj28RuCyvJBALO2Kuri9t.Pp2ikk474wlNsi9cJhBDGMBrptDTuEe', NULL, 'U'),
('hey', 'yo', 'monkey', '$2y$10$WyWLbPzMcLA93Lqf3j/l8O4sHH2ON45/Oy64Hy.e6Aaw3OBg6QvVm', NULL, 'U'),
('I', 'wish', 'for', 'death', NULL, ''),
('LDavis', 'Lincoln', 'Davis', 'Password', NULL, ''),
('Real', 'Lincoln', 'Davis', '$2y$10$3uQXhBrMeKcBvwAO8Yc.tOAzzq8KETd1Dw/nl3r7WRrm69lOsxK0u', 'deleted', ''),
('restaurant', 'test', 'one', '$2y$10$BrW1BQ07Wnb3gI2w2tnns.lk0CK4zb8Si0dN8A/XSzjzhIg/O72Xy', NULL, 'R'),
('test', 'test', 'test', '$2y$10$ekm43C4W5LA8jcmf/HsTVOf.H/8ooR83AyDfDB7JW6u2BMAJrVPI.', 'deleted', 'U'),
('this', 'this', 'this', 'this', NULL, ''),
('yo', 'hi', 'hello', 'hey', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `149_drinks`
--
ALTER TABLE `149_drinks`
  ADD PRIMARY KEY (`drinkID`),
  ADD UNIQUE KEY `drinkID` (`drinkID`),
  ADD KEY `fk_restaurant` (`restaurantID`);

--
-- Indexes for table `356_restaurants`
--
ALTER TABLE `356_restaurants`
  ADD PRIMARY KEY (`restaurantID`),
  ADD UNIQUE KEY `restaurantID` (`restaurantID`),
  ADD KEY `FK_username` (`username`);

--
-- Indexes for table `365_users`
--
ALTER TABLE `365_users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `149_drinks`
--
ALTER TABLE `149_drinks`
  MODIFY `drinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `356_restaurants`
--
ALTER TABLE `356_restaurants`
  MODIFY `restaurantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `149_drinks`
--
ALTER TABLE `149_drinks`
  ADD CONSTRAINT `fk_restaurant` FOREIGN KEY (`restaurantID`) REFERENCES `356_restaurants` (`restaurantID`);

--
-- Constraints for table `356_restaurants`
--
ALTER TABLE `356_restaurants`
  ADD CONSTRAINT `FK_username` FOREIGN KEY (`username`) REFERENCES `365_users` (`username`);
