-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2015 at 04:56 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catname`) VALUES
(1, 'Wash and Fold'),
(7, 'Household'),
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
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ques` text NOT NULL,
  `ans` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `ques`, `ans`) VALUES
(15, 'hnbxvcbnvcb', 'bvnbmbnmb'),
(14, 'hfghgcfhvf', 'nbcvnbcvbfnv'),
(13, 'hgdsfhdhyfgshfiii', 'hghnfgg'),
(12, 'hshsfdh', 'hsdfhshfhs');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `cat_id`) VALUES
(1, 'Dress Pants', 5.99, 5),
(2, 'Jeans', 4.99, 2),
(3, 'Dresses', 8.00, 1),
(6, 'Wash and Fold', 1.39, 1),
(7, 'Blouses', 4.99, 2),
(9, 'Pants', 4.99, 2),
(10, 'Dry Cleaned Dress Shirt', 4.99, 2),
(11, 'Dress Pants', 4.99, 2),
(12, 'Dresses', 8.75, 2),
(13, 'Ties', 3.99, 2),
(14, 'Jackets', 8.99, 2),
(15, 'Sweaters', 5.99, 2),
(16, 'Aprons', 4.99, 2),
(17, 'Jump Suits', 7.99, 2),
(18, 'Scarves', 4.99, 2),
(19, 'Skirts', 4.99, 2),
(20, 'Cardigans', 6.99, 2),
(21, 'Silk - Surcharge', 1.50, 2),
(22, 'Cashmere - Surcharge', 1.50, 2),
(23, 'Shorts', 4.99, 2),
(24, 'Vests', 4.99, 2),
(25, 'Windbreakers', 12.99, 2),
(26, 'Trench Coats', 12.99, 2),
(27, 'Bathrobe', 9.99, 2),
(28, 'Pea Coats', 12.99, 2),
(29, '3/4 Coats', 12.99, 2),
(30, 'Rain Coats', 12.99, 2),
(31, 'Leggings', 4.99, 2),
(32, 'Sweatshirt', 4.99, 2),
(33, 'Sweatpants', 4.99, 2),
(34, 'Overalls', 8.99, 2),
(35, 'Handkerchiefs', 3.99, 2),
(36, 'Pajamas', 4.99, 2),
(37, 'Nightgown', 6.99, 2),
(38, 'Laundered Shirt', 1.99, 5),
(39, 'Comforters - Double', 20.99, 7),
(40, 'Comforters - Twin', 18.99, 7),
(41, 'Comforters - Queen', 23.99, 7),
(42, 'Comforters - King', 27.99, 2),
(43, 'Comforters - King', 27.99, 7),
(44, 'Bedspreads - Double', 18.99, 7),
(45, 'Bedspreads - King', 24.99, 7),
(46, 'Bedspreads - Twin', 17.99, 7),
(47, 'Bedspreads - Queen', 21.99, 7),
(48, 'Bath Mats', 4.99, 7),
(49, 'Blankets - Large', 13.99, 7),
(50, 'Blankets - Small', 11.99, 7),
(51, 'Blankets - Medium', 12.99, 7),
(52, 'Duvet Covers', 19.99, 7),
(53, 'Sheets', 11.99, 7),
(54, 'Mattress Pads', 16.99, 7),
(55, 'Mattress Covers', 12.99, 7),
(56, 'Pillow Cases', 5.99, 7),
(57, 'Sleeping Bag', 14.99, 7),
(58, 'Place Mats/Napkins', 4.99, 7),
(59, 'Tablecloths - Large', 15.99, 7),
(60, 'Tablecloths - Medium', 12.99, 7),
(61, 'Tablecloths - Small', 9.99, 7),
(62, 'Cushion Covers - Large', 49.99, 7),
(63, 'Cushion Covers - Medium', 29.99, 7),
(64, 'Cushion Covers - Small', 15.99, 7),
(65, 'Pillow', 8.00, 7),
(67, 'Curtain', 15.00, 7),
(74, 'Swim Suits', 11.99, 2),
(73, 'Cummerbunds', 3.99, 2),
(72, 'Tuxedos', 15.99, 2),
(75, 'Hats', 5.99, 2),
(76, 'Kids Dresses', 4.99, 2),
(77, 'Suits - 2PC', 11.99, 2),
(78, 'Suits - 3 PC', 13.99, 2),
(79, 'Outerwear - Small', 9.99, 2),
(80, 'Outerwear - Large', 15.99, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `unique_id` text NOT NULL,
  `status` text NOT NULL,
  `pay_id` text NOT NULL,
  `time` text NOT NULL,
  `desc` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` text NOT NULL,
  `drop_off_date` text NOT NULL,
  `drop_off_time` text NOT NULL,
  `pick_up_date` text NOT NULL,
  `pick_up_time` text NOT NULL,
  `repeat` text NOT NULL,
  `address_id` int(20) NOT NULL,
  `cleaning_notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `order`
--


-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE IF NOT EXISTS `ordered_items` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `product_name` text NOT NULL,
  `product_category` text NOT NULL,
  `product_price` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ordered_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `unique_id` text NOT NULL,
  `choice` text NOT NULL,
  `treat` text NOT NULL,
  `delivery` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `preferences`
--


-- --------------------------------------------------------

--
-- Table structure for table `referal_table`
--

CREATE TABLE IF NOT EXISTS `referal_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `use_referal` text NOT NULL,
  `use_status` text NOT NULL,
  `send_referal` text NOT NULL,
  `send_status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `referal_table`
--

INSERT INTO `referal_table` (`id`, `use_referal`, `use_status`, `send_referal`, `send_status`) VALUES
(23, '55b1d0d9d53126.79441350', 'Approved', '55b1d031d78b54.60607007', 'Pending'),
(22, '55b1d031d78b54.60607007', 'Approved', '55b1cf7d012317.68705665', 'Pending'),
(21, '55b1ceb3c49415.35852362', 'Approved', '55b1cf7d012317.68705665', 'Pending');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `second_step`
--

INSERT INTO `second_step` (`id`, `unique_id`, `address`, `apt_number`, `zipcode`, `location`, `note`) VALUES
(88, '55b1cf7d012317.68705665', 'Test', 'test1', '1121', 'Home', 'DD');

-- --------------------------------------------------------

--
-- Table structure for table `share_code`
--

CREATE TABLE IF NOT EXISTS `share_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` text NOT NULL,
  `code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `share_code`
--

INSERT INTO `share_code` (`id`, `unique_id`, `code`) VALUES
(8, '55b1d031d78b54.60607007', '55b1d0bad2b2b'),
(7, '55b1cf7d012317.68705665', '55b1cf8425207');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `unique_id`, `fname`, `email`, `encrypted_password`, `salt`, `created_at`, `updated_at`, `lname`, `cellphone`) VALUES
(34, '55b1ceb3c49415.35852362', 'Sampreet', 'sampreet.shinedezign@gmail.com', 'QyQQauSux/gjg5sOzRZyJwimRFQ2N2U2NjcyNzU0', '67e6672754', '2015-07-24 11:05:47', NULL, 'Singh', '8427100930'),
(35, '55b1cf7d012317.68705665', 'sam', 'samtek.shinedezign@gmail.com', 'ry3Xww8Mf7VFrWG8uy+g+GxHFjg0MGNiZmFjMWM1', '40cbfac1c5', '2015-07-24 11:09:09', NULL, 'tek', '88888888'),
(36, '55b1d031d78b54.60607007', 'Sandeep', 'sandeep.shinedezign@gmail.com', 'ZHZd5kH8t2csDUf1vNydFU+X/ygzODk1ODZlY2I0', '389586ecb4', '2015-07-24 11:12:09', NULL, 'Sindhu', '99999999'),
(37, '55b1d0d9d53126.79441350', 'Jaswant', 'jaswant.shinedezign@gmail.com', 'srCSdoqbsNt0lTFfsuUGWadHzkEzZjZiNmMxYzQz', '3f6b6c1c43', '2015-07-24 11:14:57', NULL, 'Singh', '888888');
