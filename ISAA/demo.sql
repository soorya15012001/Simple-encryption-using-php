-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2020 at 01:35 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `decrypt`
--

CREATE TABLE `decrypt` (
  `name` varchar(1000) NOT NULL,
  `dob` varchar(1000) NOT NULL,
  `status` varchar(1000) NOT NULL,
  `ph_no` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `addr` varchar(1000) NOT NULL,
  `atm` varchar(1000) NOT NULL,
  `adhaar` varchar(1000) NOT NULL,
  `pan` varchar(1000) NOT NULL,
  `dl_no` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `decrypt`
--



-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `name` varchar(1000) NOT NULL,
  `dob` varchar(1000) NOT NULL,
  `status` varchar(1000) NOT NULL,
  `ph_no` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `addr` varchar(1000) NOT NULL,
  `atm` varchar(1000) NOT NULL,
  `adhaar` varchar(1000) NOT NULL,
  `pan` varchar(1000) NOT NULL,
  `dl_no` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persons`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
