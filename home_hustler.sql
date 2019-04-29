-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2019 at 06:47 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_hustler`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `username`, `password`, `register_datetime`) VALUES
(2, 'test@gmail.com', 'Test', '$2y$10$kddh.KoD6a6kdMmjTZi2KuPjFr.MrdtMMjydVPPwDo81XDDKEanqu', '2019-04-23 23:34:17'),
(3, 'fred@gmail.com', 'fred', '$2y$10$1kiONPk0YAiXA3PtlLD7uesO6UQY2VdpZAa5ZjF/GmqIcfS3hyD.K', '2019-04-24 12:04:16'),
(4, 'bubba@bubba.com', 'Bubba', '$2y$10$HVAiq1NqbcvNVYj5AGC/s.m5PGE58htq/47yxATywzsN4Ni4By0d6', '2019-04-24 12:24:43'),
(6, 'new@gmail', 'new', '$2y$10$pSnQYi9eJ/VSrONkwX5Q/.TD6u1MJsmGZkQ9AHCrPd5HZqTL02md.', '2019-04-26 12:55:16'),
(9, 'gogo@gogo.go', 'gogo', '$2y$10$44j7oZ7MkFfweTV4kGj9aOd8kxgV/NiiOQc3PuulCRpE2sBc8CkKK', '2019-04-26 13:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_favorites`
--

CREATE TABLE `user_favorites` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `favorite` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_parameters`
--

CREATE TABLE `user_parameters` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `work_address` varchar(64) DEFAULT NULL,
  `city` varchar(48) DEFAULT NULL,
  `state` char(2) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `budget` mediumint(8) UNSIGNED DEFAULT NULL,
  `vehicle_mpg` tinyint(3) UNSIGNED DEFAULT NULL,
  `hourly_wage` smallint(5) UNSIGNED DEFAULT NULL,
  `maximum_commute_distance` tinyint(3) UNSIGNED DEFAULT NULL,
  `minimum_square_feet` smallint(5) UNSIGNED DEFAULT NULL,
  `minimum_lot_size` smallint(5) UNSIGNED DEFAULT NULL,
  `minimum_bedrooms` tinyint(3) UNSIGNED DEFAULT NULL,
  `minimum_bathrooms` tinyint(3) UNSIGNED DEFAULT NULL,
  `maximum_home_age` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD KEY `user_favorites_fk` (`user_id`);

--
-- Indexes for table `user_parameters`
--
ALTER TABLE `user_parameters`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_parameters`
--
ALTER TABLE `user_parameters`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `user_favorites_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_parameters`
--
ALTER TABLE `user_parameters`
  ADD CONSTRAINT `user_parameters_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
