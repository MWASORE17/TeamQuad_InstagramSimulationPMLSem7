-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2017 at 12:49 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `PostID` int(11) NOT NULL,
  `UserName` varchar(200) NOT NULL,
  `ImagePath` text NOT NULL,
  `Content` text,
  `Location` text,
  `CreatedOn` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `UserName`, `ImagePath`, `Content`, `Location`, `CreatedOn`) VALUES
(1, 'santri', 'img-002.jpg', 'this is my first post', 'medan', '2017-11-28 17:56:50'),
(2, 'santri', 'img-003.jpg', 'Pertama kali ke sibayak', 'sibayak', '2017-11-28 18:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Email` varchar(200) NOT NULL,
  `ImagePath` varchar(200) DEFAULT NULL,
  `Token` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserName`, `Password`, `Name`, `Email`, `ImagePath`, `Token`) VALUES
('santri', 'e10adc3949ba59abbe56e057f20f883e', 'santri_zahra', 'santrizahra96@gmail.com', 'profile.jpg', 'A2Mo7eSbROA5mri0vnNe3Bpr0P19M1K30J8e0dIK218');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
