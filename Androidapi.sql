-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2015 at 06:25 PM
-- Server version: 5.1.73
-- PHP Version: 5.4.40

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Androidapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `catname` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catname`) VALUES
(1, 'Wash and Fold'),
(2, 'Dry Cleanings'),
(5, 'launder and press');

-- --------------------------------------------------------

--
-- Table structure for table `creditdetails`
--

CREATE TABLE IF NOT EXISTS `creditdetails` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  `number` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `creditdetails`
--

INSERT INTO `creditdetails` (`id`, `unique_id`, `number`) VALUES
(1, '1', '324234df32432');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `price` double(10,2) NOT NULL,
  `cat_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `cat_id`) VALUES
(1, 'Dress Pants', 5.99, 5),
(2, 'Jeans', 4.99, 2),
(3, 'Dresses', 8.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `second_step`
--

CREATE TABLE IF NOT EXISTS `second_step` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) DEFAULT NULL,
  `address` text,
  `apt_number` text,
  `zipcode` text,
  `location` text,
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `second_step`
--

INSERT INTO `second_step` (`id`, `unique_id`, `address`, `apt_number`, `zipcode`, `location`, `note`) VALUES
(6, '559a1c91cbae37.01031188', 'addressfhf', 'apt_numberfhf', 'zipcode3232fhf', 'locationfhf', 'notefhf'),
(7, '', 'ghdf', '', '45', 'rtr', 'jgj'),
(8, '', 'dg', '', '45', 'fg', 'dvgfdg'),
(9, '', 'fgh', '', '546', 'jd', 'b w '),
(10, '', 'moh', '', '160059', 'chd', 'hey'),
(11, '', 'moh', '', '160059', 'chd', 'hey t'),
(12, '', 'chd', '', '160059', 'moh', 'hey'),
(13, '', 'chd', '', '160059', 'moh', 'hiii'),
(14, '', 'chd', '', '16059', 'moh', 'text2'),
(15, '', 'moh', '', '160052', 'chds', 'texts444'),
(16, '', 'chdi', '', '16050', 'mohi', 'ihis text'),
(17, '', 'chd', '', '160054', 'mohali', 'heyss'),
(18, '', 'chsndi', '', '160054', 'mohasli', 'thissss'),
(19, '', 'mohsli', '', '160054', 'chasndi', 'this is note'),
(20, '', 'chandigarh', '', '160059', 'mohali', 'its notes'),
(21, '', 'f mohali', '', '16050', 's chd', 'inside note'),
(22, '', 'mohali', '', '160059', 'chandigarh', 'this is final'),
(23, '', 'abc', '', '123', 'def', 'ghi'),
(24, '', 'my add 1', '', '546874', 'loca.22', 'dfhsif'),
(25, '', ' Test add ', '', '1236456', 'testingh', 'Testyyyy'),
(26, '', 'one add', 'two add', '35684874', '', 'tisj'),
(27, '', 'line one add', 'line two add', '210505', 'Office', 'thisssssss'),
(28, '', 'mohali', 'chd', '16059', 'Other', 'higyugf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `encrypted_password` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `lname` varchar(40) NOT NULL,
  `cellphone` text NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `unique_id` (`unique_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `unique_id`, `fname`, `email`, `encrypted_password`, `salt`, `created_at`, `updated_at`, `lname`, `cellphone`) VALUES
(4, '559a1c91cbae37.01031188', 'sandeep1', 'sandeep.shinedezign@gmail.com1', '+UlR+Rz8uaHx1p7bGVYwruCr2SkxNjZkYjBiNGUx', '166db0b4e1', '2015-07-06 11:43:37', NULL, 'sindhu', '987765443221'),
(5, '559b7003c973e9.78114079', 'sandeep', 'sandeep.shinedezign@mail.com1', 'skrJV18/eJ23haw8tzWGIsbIo9A5NjI2ZmI0ZDJl', '9626fb4d2e', '2015-07-07 11:51:55', NULL, 'sindhu', 'sasas'),
(6, '559b702521bc92.66734038', 'sandeep', 'sandeep.shinedezign@mail.com', 'sjbW1LB9PlqPWBTgk1Z+t67bUT04Mjc4NGFiOThm', '82784ab98f', '2015-07-07 11:52:29', NULL, 'sindhu', 'sasas'),
(7, '559b919e440656.74259708', 'test', 'test.shinedezign@gmail.com', 'RajUYdf0XKLHJkIKlVFgROa9dZ8wM2YwZGQzZTk5', '03f0dd3e99', '2015-07-07 14:15:18', NULL, 'user', '8888888888'),
(8, '559b95cbbccfe9.22372321', 'test1', 'test.shinedezign@gmail.com1', 'at3swZpRYl5R8i+tJi+NWjGUkIA5ZDZjNzQ4ZTU4', '9d6c748e58', '2015-07-07 14:33:07', NULL, 'user1', '88888888881'),
(9, '559d0bf7ca3be8.94239534', '', 'jdfh@gmail.com', 'ywXiqdJaBRZkRt8JE55LAOx2ubg5ZDQyMjAwZjA0', '9d42200f04', '2015-07-08 17:09:35', NULL, '', ''),
(10, '559d11f1d6bfd5.60705027', '', '', 'w7Z3B0HkTpAkqiVDeTLdvI+iUwg4ZDg0MDhmYWYw', '8d8408faf0', '2015-07-08 17:35:05', NULL, '', ''),
(11, '559d12177a2de6.34383939', '', 'ugfdu@gmail.com', 'E3UjfE8mCAzZRox+Z730HDES30I3MzQyYTU0MDE5', '7342a54019', '2015-07-08 17:35:43', NULL, '', ''),
(12, '559d127ac62435.72971705', '', 'gdf', 'wiYJyIWCl/g0b8T+of1kw8S3RM43YmY0NDVlYjIx', '7bf445eb21', '2015-07-08 17:37:22', NULL, '', ''),
(13, '559d130bde4c66.84060111', '', 'ghhf@gmail.com', 'OrCj+K2lnfppZALpO4lfqWH6caVmMDU5ZTEyNzZl', 'f059e1276e', '2015-07-08 17:39:47', NULL, '', ''),
(14, '559d1e1bacce69.13519898', '', 'dhf@gmail.com', 'FG8/12VcT9elStiPcKpx5siC2RM3YWRhOTA5MWE5', '7ada9091a9', '2015-07-08 18:26:59', NULL, '', ''),
(15, '559d219458e9f8.77455763', '', 'dinr@gmail.com', 'pzqILi08DahxGdNlmuiTtf7EasAyZWNhN2YyMjE2', '2eca7f2216', '2015-07-08 18:41:48', NULL, '', ''),
(16, '559d219d755422.18178975', '', 'gfd', 's3iSiES6C6LJWFaOl03xEG1S8a84MmU3NWI5ZjU3', '82e75b9f57', '2015-07-08 18:41:57', NULL, '', ''),
(17, '559df537b447b8.86177035', '', 'hhn', 'PM4Y6pkkaW+Nb7OL+RDb3xQwyfk1YjEwYWE4N2Y3', '5b10aa87f7', '2015-07-09 09:44:47', NULL, '', ''),
(18, '559df53f673399.52952039', '', 'kop', '5jRYJthdLuiJSo+u+zTlj4PbAl5lNzkzMjcwN2Yw', 'e7932707f0', '2015-07-09 09:44:55', NULL, '', ''),
(19, '559df547cf0d28.28436536', '', 'juio', '+4eqYgjVsfVe/AwChh5CmjAzFTAxMmRhNjc1YjVk', '12da675b5d', '2015-07-09 09:45:03', NULL, '', ''),
(20, '559df6a2e66179.70695271', '', 'gf', 'vVbBOxiubsPysWAXkbYoC5z4dTg1YmMxMGI5ZjBk', '5bc10b9f0d', '2015-07-09 09:50:50', NULL, '', ''),
(21, '559df6b3b80f64.68227074', '', 'hjug', 'hxxJTOvJ/g7dYhRqk5DFndxZ/HJhZWI2MWFlODli', 'aeb61ae89b', '2015-07-09 09:51:07', NULL, '', ''),
(22, '559df6fa628a61.66656268', '', 'dhg@gmail.com', 'Hv0MIDAVjSoqaP9aLAcgaF+hhAs4MmQzOTk5MmJk', '82d39992bd', '2015-07-09 09:52:18', NULL, '', ''),
(23, '559dfa15efedc7.35793490', '', 'gh', 'sEykbIQ2VdqTI41+ClKq3PrK5d5jNjA0MjA2MDU1', 'c604206055', '2015-07-09 10:05:33', NULL, '', ''),
(24, '559dfb0573ef73.17422163', '', 'vc', 'Qc2PXoSuenXLo0qjMyaIcAE95wNiNzNmYzQwZTc1', 'b73fc40e75', '2015-07-09 10:09:33', NULL, '', ''),
(25, '559e6b4da35b49.88416610', '', 'sampreet.shinedezign@gmail.com', 'HsX37xMo0/xTEy4x3zhrrZhKXcg3YzkyYWRmMGE4', '7c92adf0a8', '2015-07-09 18:08:37', NULL, '', ''),
(26, '559e6ca10ceed9.65891647', '', 'sampreet@gmail.com', 'KIf55QZNUv2XXehqpyVWoq1cszVkMmZkNzc0ZDcx', 'd2fd774d71', '2015-07-09 18:14:17', NULL, '', '');
