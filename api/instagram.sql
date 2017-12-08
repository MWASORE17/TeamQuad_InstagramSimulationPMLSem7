-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2017 at 03:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `user_id`, `content`, `created_on`) VALUES
(1, 5, 1, 'askfjdjgbcfgblcvbcvklbj dfjgldfjlgk', '2017-12-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `follow_user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`id`, `user_id`, `follow_user_id`, `created_on`) VALUES
(1, 1, 2, '2017-12-05 00:00:00'),
(3, 1, 3, '2017-12-05 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ImagePath` text NOT NULL,
  `Content` text,
  `Location` text,
  `CreatedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `UserId`, `ImagePath`, `Content`, `Location`, `CreatedOn`) VALUES
(1, 3, 'img-002.jpg', 'this is my first post', 'medan', '2017-11-28 17:56:50'),
(2, 3, 'img-003.jpg', 'Pertama kali ke sibayak', 'sibayak', '2017-11-28 18:34:23'),
(5, 1, 'asdfasdf1512540389.jpg', 'fjdlahflls', 'aaaaaa', '2017-12-06 13:06:29'),
(6, 1, 'asdfasdf1512543354.jpg', 'dtuvvxfh', 'aaaaa', '2017-12-06 13:55:54'),
(7, 1, 'asdfasdf1512543404.jpg', 'galleryyyy', 'dtewaaaaa', '2017-12-06 13:56:44'),
(8, 2, 'qwerqwer1512543404.jpg', 'galleryyyyqwer', 'dtewaaaaaqwer', '2017-12-06 13:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `UserName`, `Password`, `Name`, `Email`, `ImagePath`, `Token`) VALUES
(1, 'asdfasdf', '6a204bd89f3c8348afd5c77c717a097a', NULL, 'asdf@asdf.com', 'cover_tahilalats.jpg', 'fCChK4vPTjfpQXYK8T4pBtDMsnC4yBI-6THjTqfQvfo'),
(2, 'qwerqwer', 'd74682ee47c3fffd5dcd749f840fcdd4', NULL, 'qwerqwer@qwerqwer.com', 'cover_tahilalats.jpg', 'Af7XmvDdy_FTmenU3lT1DvdrgjuwWTU3njZWdh2hTIY'),
(3, 'santri', 'e10adc3949ba59abbe56e057f20f883e', 'santri_zahra', 'santrizahra96@gmail.com', '', 'A2Mo7eSbROA5mri0vnNe3Bpr0P19M1K30J8e0dIK218');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
