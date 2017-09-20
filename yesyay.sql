-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2017 at 02:28 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yesyay`
--

-- --------------------------------------------------------

--
-- Table structure for table `debtors_master`
--

DROP TABLE IF EXISTS `debtors_master`;
CREATE TABLE IF NOT EXISTS `debtors_master` (
  `debtor_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type` int(11) NOT NULL,
  `channel_id` text COLLATE utf8_unicode_ci NOT NULL,
  `channel_name` text COLLATE utf8_unicode_ci,
  `shipping_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `different_billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `debtors_master`
--

INSERT INTO `debtors_master` (`debtor_no`, `name`, `email`, `password`, `address`, `phone`, `sales_type`, `channel_id`, `channel_name`, `shipping_name`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_country_id`, `contact_phone`, `different_billing_address`, `billing_name`, `billing_street`, `billing_city`, `billing_state`, `billing_zip_code`, `billing_country_id`, `remember_token`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Shoaib Ahmed', 'ash12oab@ymail.com', '$2y$10$5joKDUACIckC608yIDPVx.W9n3RYNfyxmmq2.0E9Xz8upaU5fG6Ci', '', '0988251927', 0, 'test', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-16 07:41:08', '2017-07-17 10:15:35'),
(2, 'Test', 'test@test.com', '', '', 'test', 0, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-27 12:43:03', NULL),
(3, 'paul@paul.com', '', '', '', 'test', 0, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-27 13:29:50', NULL),
(4, 'paul@paul.com', '', '', '', 'test', 0, 'testset', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-27 13:35:26', NULL),
(5, 'paul@chaladmarketing.com', '', '', '', '', 0, 'channelid', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-27 13:39:12', NULL),
(8, 'test001', '', '', '', '123123', 0, 'test', 'facebook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 19:21:49', NULL),
(9, 'test00233', 'sales@yesyes', '', '', '123123', 0, 'channel_id', 'sdsdsds', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 19:22:31', '2017-07-29 19:33:06'),
(10, 'test003', '', '', '', '123123', 0, 'channel_id', 'facebook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 19:33:33', NULL),
(11, 'test003', '', '', '', '123123', 0, 'channel_id', 'facebook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 19:37:11', '2017-07-29 19:38:49'),
(12, 'nok', '', '', '', 'noksnumber', 0, 'Facebook', 'line', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 19:59:45', '2017-08-06 22:17:56'),
(13, 'nok', 'sales@test.com', '', '', 'noksnumber', 0, 'Facebook', 'line', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-07-29 20:00:28', '2017-08-06 22:14:07'),
(14, 'paul2', 'paul@chaladmarketing.com', '$2y$10$JOJyzXvSiP1opIVVhLWUleWvpOBZXwiYR5/HvJTyIb63AdZVxEiTq', '', 'phonepaul', 0, 'channelidpaul', 'facebook', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PfUOhLvBmgWNKXe9DBq93Mx9XP8xwuWpTzn6GPlOVyjBCXcXPWgvbXmp5uu8', 0, '2017-07-29 20:00:56', '2017-07-30 19:06:12'),
(15, 'test', 'test@test.com', '', '', '13123', 0, 'facebook', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 10:22:37', NULL),
(16, 'test', 'test@test.com', '', '', '099', 0, 'facebook', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 10:55:53', NULL),
(17, 'Test', 'test@test.com', '', '', '123123', 0, 'twitter', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 11:20:00', NULL),
(18, 'name1', 'test@test.com', '', '', 'phone1', 0, 'facebook', 'channel1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 12:44:33', NULL),
(19, 'Nam Nguyen', 'tesst@gmaoil.coooom', '', '', '0968650059', 0, 'facebook', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 21:18:07', NULL),
(20, 'Nam Nguyen', 'tesst@gmaiel.com', '', '', '120231', 0, 'facebook', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 21:43:22', NULL),
(21, 'Nam Nguyen', 'tesst@gmail.com', '', '', '1231321', 0, '', '123123', 'Nam Nguyen', 'sâ', 'asa', 'ssasa', 'sấ', 'AL', 'ssasa', '1', '22', 'sâ', 'asa', 'ssasa', 'sấ', 'AD', '', 0, '2017-08-07 22:08:24', '2017-09-18 03:26:04'),
(22, 'Testing', 'tesst@gmail.com', '', '', '0989898911', 0, '', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2017-08-07 22:28:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_code`
--

DROP TABLE IF EXISTS `item_code`;
CREATE TABLE IF NOT EXISTS `item_code` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_type_id` int(11) NOT NULL DEFAULT '1',
  `description` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` smallint(6) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `list_items` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'for grouped products',
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `cost_price` double DEFAULT NULL,
  `special_price` int(11) NOT NULL,
  `qty_per_pack` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_code`
--

INSERT INTO `item_code` (`id`, `stock_id`, `item_type_id`, `description`, `category_id`, `item_image`, `list_items`, `inactive`, `deleted_status`, `created_at`, `updated_at`, `weight`, `price`, `cost_price`, `special_price`, `qty_per_pack`) VALUES
(3, 'TEST ID', 1, 'PRODUCT NAME', 2, 'My Medi Practice HR.jpg', NULL, 0, 0, '2017-07-14 23:46:26', '2017-07-30 19:27:59', 12, NULL, NULL, 98, 12),
(4, 'TEST ID123', 1, '123', 2, 'background_body.png', NULL, 0, 1, '2017-07-15 14:09:08', '2017-07-18 20:50:57', 123, NULL, NULL, 123, 12),
(5, 'TEST 123', 1, 'ABC 123', 1, '', NULL, 0, 1, '2017-09-18 13:00:36', NULL, 12, 12000, 12, 12, 12),
(6, '123', 1, 'ABC 1234', 1, '', NULL, 0, 0, '2017-09-19 07:30:37', NULL, 123, 123, 12, 123, 12),
(7, '123', 2, '111', 3, '12524336_1233157233380461_1119153466726702164_n.png', ',TEST ID,TEST 123', 0, 0, '2017-09-19 10:10:04', NULL, 0, 120000, NULL, 123, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

DROP TABLE IF EXISTS `item_type`;
CREATE TABLE IF NOT EXISTS `item_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`id`, `type_name`, `created_at`, `updated_at`) VALUES
(1, 'Simple Product', '2017-09-19 00:00:00', '2017-09-19 00:00:00'),
(2, 'Grouped Product', '2017-09-19 00:00:00', '2017-09-19 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
