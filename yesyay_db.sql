-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2017 at 02:51 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1-log
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yesyay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country`, `code`) VALUES
(1, 'United States', 'US'),
(2, 'Canada', 'CA'),
(3, 'Afghanistan', 'AF'),
(4, 'Albania', 'AL'),
(5, 'Algeria', 'DZ'),
(6, 'American Samoa', 'AS'),
(7, 'Andorra', 'AD'),
(8, 'Angola', 'AO'),
(9, 'Anguilla', 'AI'),
(10, 'Antarctica', 'AQ'),
(11, 'Antigua and/or Barbuda', 'AG'),
(12, 'Argentina', 'AR'),
(13, 'Armenia', 'AM'),
(14, 'Aruba', 'AW'),
(15, 'Australia', 'AU'),
(16, 'Austria', 'AT'),
(17, 'Azerbaijan', 'AZ'),
(18, 'Bahamas', 'BS'),
(19, 'Bahrain', 'BH'),
(20, 'Bangladesh', 'BD'),
(21, 'Barbados', 'BB'),
(22, 'Belarus', 'BY'),
(23, 'Belgium', 'BE'),
(24, 'Belize', 'BZ'),
(25, 'Benin', 'BJ'),
(26, 'Bermuda', 'BM'),
(27, 'Bhutan', 'BT'),
(28, 'Bolivia', 'BO'),
(29, 'Bosnia and Herzegovina', 'BA'),
(30, 'Botswana', 'BW'),
(31, 'Bouvet Island', 'BV'),
(32, 'Brazil', 'BR'),
(33, 'British lndian Ocean Territory', 'IO'),
(34, 'Brunei Darussalam', 'BN'),
(35, 'Bulgaria', 'BG'),
(36, 'Burkina Faso', 'BF'),
(37, 'Burundi', 'BI'),
(38, 'Cambodia', 'KH'),
(39, 'Cameroon', 'CM'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Cook Islands', 'CK'),
(52, 'Costa Rica', 'CR'),
(53, 'Croatia (Hrvatska)', 'HR'),
(54, 'Cuba', 'CU'),
(55, 'Cyprus', 'CY'),
(56, 'Czech Republic', 'CZ'),
(57, 'Democratic Republic of Congo', 'CD'),
(58, 'Denmark', 'DK'),
(59, 'Djibouti', 'DJ'),
(60, 'Dominica', 'DM'),
(61, 'Dominican Republic', 'DO'),
(62, 'East Timor', 'TP'),
(63, 'Ecudaor', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (Malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'France, Metropolitan', 'FX'),
(76, 'French Guiana', 'GF'),
(77, 'French Polynesia', 'PF'),
(78, 'French Southern Territories', 'TF'),
(79, 'Gabon', 'GA'),
(80, 'Gambia', 'GM'),
(81, 'Georgia', 'GE'),
(82, 'Germany', 'DE'),
(83, 'Ghana', 'GH'),
(84, 'Gibraltar', 'GI'),
(85, 'Greece', 'GR'),
(86, 'Greenland', 'GL'),
(87, 'Grenada', 'GD'),
(88, 'Guadeloupe', 'GP'),
(89, 'Guam', 'GU'),
(90, 'Guatemala', 'GT'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard and Mc Donald Islands', 'HM'),
(96, 'Honduras', 'HN'),
(97, 'Hong Kong', 'HK'),
(98, 'Hungary', 'HU'),
(99, 'Iceland', 'IS'),
(100, 'India', 'IN'),
(101, 'Indonesia', 'ID'),
(102, 'Iran (Islamic Republic of)', 'IR'),
(103, 'Iraq', 'IQ'),
(104, 'Ireland', 'IE'),
(105, 'Israel', 'IL'),
(106, 'Italy', 'IT'),
(107, 'Ivory Coast', 'CI'),
(108, 'Jamaica', 'JM'),
(109, 'Japan', 'JP'),
(110, 'Jordan', 'JO'),
(111, 'Kazakhstan', 'KZ'),
(112, 'Kenya', 'KE'),
(113, 'Kiribati', 'KI'),
(114, 'Korea, Democratic People\'s Republic of', 'KP'),
(115, 'Korea, Republic of', 'KR'),
(116, 'Kuwait', 'KW'),
(117, 'Kyrgyzstan', 'KG'),
(118, 'Lao People\'s Democratic Republic', 'LA'),
(119, 'Latvia', 'LV'),
(120, 'Lebanon', 'LB'),
(121, 'Lesotho', 'LS'),
(122, 'Liberia', 'LR'),
(123, 'Libyan Arab Jamahiriya', 'LY'),
(124, 'Liechtenstein', 'LI'),
(125, 'Lithuania', 'LT'),
(126, 'Luxembourg', 'LU'),
(127, 'Macau', 'MO'),
(128, 'Macedonia', 'MK'),
(129, 'Madagascar', 'MG'),
(130, 'Malawi', 'MW'),
(131, 'Malaysia', 'MY'),
(132, 'Maldives', 'MV'),
(133, 'Mali', 'ML'),
(134, 'Malta', 'MT'),
(135, 'Marshall Islands', 'MH'),
(136, 'Martinique', 'MQ'),
(137, 'Mauritania', 'MR'),
(138, 'Mauritius', 'MU'),
(139, 'Mayotte', 'TY'),
(140, 'Mexico', 'MX'),
(141, 'Micronesia, Federated States of', 'FM'),
(142, 'Moldova, Republic of', 'MD'),
(143, 'Monaco', 'MC'),
(144, 'Mongolia', 'MN'),
(145, 'Montserrat', 'MS'),
(146, 'Morocco', 'MA'),
(147, 'Mozambique', 'MZ'),
(148, 'Myanmar', 'MM'),
(149, 'Namibia', 'NA'),
(150, 'Nauru', 'NR'),
(151, 'Nepal', 'NP'),
(152, 'Netherlands', 'NL'),
(153, 'Netherlands Antilles', 'AN'),
(154, 'New Caledonia', 'NC'),
(155, 'New Zealand', 'NZ'),
(156, 'Nicaragua', 'NI'),
(157, 'Niger', 'NE'),
(158, 'Nigeria', 'NG'),
(159, 'Niue', 'NU'),
(160, 'Norfork Island', 'NF'),
(161, 'Northern Mariana Islands', 'MP'),
(162, 'Norway', 'NO'),
(163, 'Oman', 'OM'),
(164, 'Pakistan', 'PK'),
(165, 'Palau', 'PW'),
(166, 'Panama', 'PA'),
(167, 'Papua New Guinea', 'PG'),
(168, 'Paraguay', 'PY'),
(169, 'Peru', 'PE'),
(170, 'Philippines', 'PH'),
(171, 'Pitcairn', 'PN'),
(172, 'Poland', 'PL'),
(173, 'Portugal', 'PT'),
(174, 'Puerto Rico', 'PR'),
(175, 'Qatar', 'QA'),
(176, 'Republic of South Sudan', 'SS'),
(177, 'Reunion', 'RE'),
(178, 'Romania', 'RO'),
(179, 'Russian Federation', 'RU'),
(180, 'Rwanda', 'RW'),
(181, 'Saint Kitts and Nevis', 'KN'),
(182, 'Saint Lucia', 'LC'),
(183, 'Saint Vincent and the Grenadines', 'VC'),
(184, 'Samoa', 'WS'),
(185, 'San Marino', 'SM'),
(186, 'Sao Tome and Principe', 'ST'),
(187, 'Saudi Arabia', 'SA'),
(188, 'Senegal', 'SN'),
(189, 'Serbia', 'RS'),
(190, 'Seychelles', 'SC'),
(191, 'Sierra Leone', 'SL'),
(192, 'Singapore', 'SG'),
(193, 'Slovakia', 'SK'),
(194, 'Slovenia', 'SI'),
(195, 'Solomon Islands', 'SB'),
(196, 'Somalia', 'SO'),
(197, 'South Africa', 'ZA'),
(198, 'South Georgia South Sandwich Islands', 'GS'),
(199, 'Spain', 'ES'),
(200, 'Sri Lanka', 'LK'),
(201, 'St. Helena', 'SH'),
(202, 'St. Pierre and Miquelon', 'PM'),
(203, 'Sudan', 'SD'),
(204, 'Suriname', 'SR'),
(205, 'Svalbarn and Jan Mayen Islands', 'SJ'),
(206, 'Swaziland', 'SZ'),
(207, 'Sweden', 'SE'),
(208, 'Switzerland', 'CH'),
(209, 'Syrian Arab Republic', 'SY'),
(210, 'Taiwan', 'TW'),
(211, 'Tajikistan', 'TJ'),
(212, 'Tanzania, United Republic of', 'TZ'),
(213, 'Thailand', 'TH'),
(214, 'Togo', 'TG'),
(215, 'Tokelau', 'TK'),
(216, 'Tonga', 'TO'),
(217, 'Trinidad and Tobago', 'TT'),
(218, 'Tunisia', 'TN'),
(219, 'Turkey', 'TR'),
(220, 'Turkmenistan', 'TM'),
(221, 'Turks and Caicos Islands', 'TC'),
(222, 'Tuvalu', 'TV'),
(223, 'Uganda', 'UG'),
(224, 'Ukraine', 'UA'),
(225, 'United Arab Emirates', 'AE'),
(226, 'United Kingdom', 'GB'),
(227, 'United States minor outlying islands', 'UM'),
(228, 'Uruguay', 'UY'),
(229, 'Uzbekistan', 'UZ'),
(230, 'Vanuatu', 'VU'),
(231, 'Vatican City State', 'VA'),
(232, 'Venezuela', 'VE'),
(233, 'Vietnam', 'VN'),
(234, 'Virgin Islands (British)', 'VG'),
(235, 'Virgin Islands (U.S.)', 'VI'),
(236, 'Wallis and Futuna Islands', 'WF'),
(237, 'Western Sahara', 'EH'),
(238, 'Yemen', 'YE'),
(239, 'Yugoslavia', 'YU'),
(240, 'Zaire', 'ZR'),
(241, 'Zambia', 'ZM'),
(242, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` char(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `symbol`) VALUES
(1, 'Baht', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `cust_branch`
--

CREATE TABLE `cust_branch` (
  `branch_code` int(10) UNSIGNED NOT NULL,
  `debtor_no` int(11) NOT NULL,
  `br_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `channel_id` text COLLATE utf8_unicode_ci NOT NULL,
  `channel` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cust_branch`
--

INSERT INTO `cust_branch` (`branch_code`, `debtor_no`, `br_name`, `br_address`, `br_contact`, `billing_street`, `billing_city`, `billing_state`, `billing_zip_code`, `billing_country_id`, `shipping_name`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_country_id`, `channel_id`, `channel`) VALUES
(1, 1, 'Shoaib Ahmed', '', '', '51/1-b North Mughda,North Jhilpar,Dhaka', 'Dhaka', 'Motijheel', '1219', 'BD', '', '51/1-b North Mughda,North Jhilpar,Dhaka', 'Dhaka', 'Motijheel', '1219', 'BD', 'sdfsf', 'twitter'),
(2, 2, 'Test', '', '', 'test', 'test', 'test2', '123123', 'US', '', 'test', 'test', 'test2', '123123', 'US', 'test2323', 'facebook'),
(3, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'testset', 'lazada'),
(4, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'channelid', 'lazada'),
(5, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'yeschannel', 'facebook'),
(6, 14, 'test', '', 'test', '1234', '12345', '231234', '234234', 'TH', '', '1234', '12345', '231234', '234234', 'TH', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `debtors_master`
--

CREATE TABLE `debtors_master` (
  `debtor_no` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type` int(11) NOT NULL,
  `channel_id` text COLLATE utf8_unicode_ci NOT NULL,
  `channel_name` text COLLATE utf8_unicode_ci,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `debtors_master`
--

INSERT INTO `debtors_master` (`debtor_no`, `name`, `email`, `password`, `address`, `phone`, `sales_type`, `channel_id`, `channel_name`, `remember_token`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Shoaib Ahmed', 'ash12oab@ymail.com', '$2y$10$5joKDUACIckC608yIDPVx.W9n3RYNfyxmmq2.0E9Xz8upaU5fG6Ci', '', '0988251927', 0, 'test', '0', '', 0, '2017-07-16 07:41:08', '2017-07-17 10:15:35'),
(2, 'Test', 'test@test.com', '', '', 'test', 0, '', '0', '', 0, '2017-07-27 12:43:03', NULL),
(3, 'paul@paul.com', '', '', '', 'test', 0, '', '0', '', 0, '2017-07-27 13:29:50', NULL),
(4, 'paul@paul.com', '', '', '', 'test', 0, 'testset', '0', '', 0, '2017-07-27 13:35:26', NULL),
(5, 'paul@chaladmarketing.com', '', '', '', '', 0, 'channelid', '0', '', 0, '2017-07-27 13:39:12', NULL),
(8, 'test001', '', '', '', '123123', 0, 'test', 'facebook', '', 0, '2017-07-29 19:21:49', NULL),
(9, 'test00233', 'sales@yesyes', '', '', '123123', 0, 'channel_id', 'sdsdsds', '', 0, '2017-07-29 19:22:31', '2017-07-29 19:33:06'),
(10, 'test003', '', '', '', '123123', 0, 'channel_id', 'facebook', '', 0, '2017-07-29 19:33:33', NULL),
(11, 'test003', '', '', '', '123123', 0, 'channel_id', 'facebook', '', 0, '2017-07-29 19:37:11', '2017-07-29 19:38:49'),
(12, 'nok', '', '', '', 'noksnumber', 0, 'Facebook', 'line', '', 0, '2017-07-29 19:59:45', '2017-08-06 22:17:56'),
(13, 'nok', 'sales@test.com', '', '', 'noksnumber', 0, 'Facebook', 'line', '', 0, '2017-07-29 20:00:28', '2017-08-06 22:14:07'),
(14, 'paul2', 'paul@chaladmarketing.com', '$2y$10$JOJyzXvSiP1opIVVhLWUleWvpOBZXwiYR5/HvJTyIb63AdZVxEiTq', '', 'phonepaul', 0, 'channelidpaul', 'facebook', 'PfUOhLvBmgWNKXe9DBq93Mx9XP8xwuWpTzn6GPlOVyjBCXcXPWgvbXmp5uu8', 0, '2017-07-29 20:00:56', '2017-07-30 19:06:12'),
(15, 'test', 'test@test.com', '', '', '13123', 0, 'facebook', 'test', '', 0, '2017-08-07 10:22:37', NULL),
(16, 'test', 'test@test.com', '', '', '099', 0, 'facebook', 'test', '', 0, '2017-08-07 10:55:53', NULL),
(17, 'Test', 'test@test.com', '', '', '123123', 0, 'twitter', 'test', '', 0, '2017-08-07 11:20:00', NULL),
(18, 'name1', 'test@test.com', '', '', 'phone1', 0, 'facebook', 'channel1', '', 0, '2017-08-07 12:44:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `email_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email_protocol`, `email_encryption`, `smtp_host`, `smtp_port`, `smtp_email`, `smtp_username`, `smtp_password`, `from_address`, `from_name`) VALUES
(1, 'smtp', 'tls', 'smtp.gmail.com', '587', 'stockpile.techvill@gmail.com', 'stockpile.techvill@gmail.com', 'xgldhlpedszmglvj', 'stockpile.techvill@gmail.com', 'stockpile.techvill@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `email_temp_details`
--

CREATE TABLE `email_temp_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `temp_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_temp_details`
--

INSERT INTO `email_temp_details` (`id`, `temp_id`, `subject`, `body`, `lang`, `lang_id`) VALUES
(1, 2, 'Your Order # {order_reference_no} from {company_name} has been shipped', 'Hi {customer_name},<br><br>Thank you for your order. Here’s a brief overview of your shipment:<br>Sales Order # {order_reference_no} was packed on {packed_date} and shipped on {delivery_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>', 'en', 1),
(2, 2, 'Subject', 'Body', 'ar', 2),
(3, 2, 'Subject', 'Body', 'ch', 3),
(4, 2, 'Subject', 'Body', 'fr', 4),
(5, 2, 'Subject', 'Body', 'po', 5),
(6, 2, 'Subject', 'Body', 'rs', 6),
(7, 2, 'Subject', 'Body', 'sp', 7),
(8, 2, 'Subject', 'Body', 'tu', 8),
(9, 1, 'Payment information for Order#{order_reference_no} and Invoice#{invoice_reference_no}.', '<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}</p><p>{billing_state}</p><p>{billing_zip_code}</p><p>{billing_country}<br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b></i></p><p><i>Order No : {order_reference_no}</i><br><i></i></p><p><i>Invoice No : {invoice_reference_no}</i><br></p><p><br></p><p>Regards,</p><p>{company_name}<br></p><br><br><br><br><br><br>', 'en', 1),
(10, 1, 'Subject', 'Body', 'ar', 2),
(11, 1, 'Subject', 'Body', 'ch', 3),
(12, 1, 'Subject', 'Body', 'fr', 4),
(13, 1, 'Subject', 'Body', 'po', 5),
(14, 1, 'Subject', 'Body', 'rs', 6),
(15, 1, 'Subject', 'Body', 'sp', 7),
(16, 1, 'Subject', 'Body', 'tu', 8),
(17, 3, 'Payment information for Order#{order_reference_no} and Invoice#{invoice_reference_no}.', '<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}</p><p>{billing_state}</p><p>{billing_zip_code}<br></p><p>{billing_country}<br>&nbsp; &nbsp; &nbsp; &nbsp; <br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b><br>Order No : {order_reference_no}<br>&nbsp;</i><i>Invoice No : {invoice_reference_no}<br>&nbsp;</i>Regards,</p><p>{company_name} <br></p><br>', 'en', 1),
(18, 3, 'Subject', 'Body', 'ar', 2),
(19, 3, 'Subject', 'Body', 'ch', 3),
(20, 3, 'Subject', 'Body', 'fr', 4),
(21, 3, 'Subject', 'Body', 'po', 5),
(22, 3, 'Subject', 'Body', 'rs', 6),
(23, 3, 'Subject', 'Body', 'sp', 7),
(24, 3, 'Subject', 'Body', 'tu', 8),
(25, 4, 'Your Invoice # {invoice_reference_no} for sales Order #{order_reference_no} from {company_name} has been created.', '<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your invoice: Invoice #{invoice_reference_no} is for Sales Order #{order_reference_no}. The invoice total is {currency}{total_amount}, please pay before {due_date}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Order summary<br></b></p><p><b></b>{invoice_summery}<br></p><p>Regards,</p><p>{company_name}<br></p><br><br>', 'en', 1),
(26, 4, 'Subject', 'Body', 'ar', 2),
(27, 4, 'Subject', 'Body', 'ch', 3),
(28, 4, 'Subject', 'Body', 'fr', 4),
(29, 4, 'Subject', 'Body', 'po', 5),
(30, 4, 'Subject', 'Body', 'rs', 6),
(31, 4, 'Subject', 'Body', 'sp', 7),
(32, 4, 'Subject', 'Body', 'tu', 8),
(33, 5, 'Your Order# {order_reference_no} from {company_name} has been created.', '<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your Order #{order_reference_no} that was created on {order_date}. The order total is {currency}{total_amount}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}</p><p>&nbsp;{billing_state}</p><p>&nbsp;{billing_zip_code}</p><p>&nbsp;{billing_country}<br></p><p><br></p><p><b>Order summary<br></b></p><p><b></b>{order_summery}<br></p><p>Regards,</p><p>{company_name}</p><br><br>', 'en', 1),
(34, 5, 'Subject', 'Body', 'ar', 2),
(35, 5, 'Subject', 'Body', 'ch', 3),
(36, 5, 'Subject', 'Body', 'fr', 4),
(37, 5, 'Subject', 'Body', 'po', 5),
(38, 5, 'Subject', 'Body', 'rs', 6),
(39, 5, 'Subject', 'Body', 'sp', 7),
(40, 5, 'Subject', 'Body', 'tu', 8),
(41, 6, 'Your Order # {order_reference_no} from {company_name} has been packed', 'Hi {customer_name},<br><br>Thank you for your order. Here’s a brief overview of your shipment:<br>Sales Order # {order_reference_no} was packed on {packed_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}<br>{shipping_state}<br>{shipping_zip_code}<br>{shipping_country}<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>', 'en', 1),
(42, 6, 'Subject', 'Body', 'ar', 2),
(43, 6, 'Subject', 'Body', 'ch', 3),
(44, 6, 'Subject', 'Body', 'fr', 4),
(45, 6, 'Subject', 'Body', 'po', 5),
(46, 6, 'Subject', 'Body', 'rs', 6),
(47, 6, 'Subject', 'Body', 'sp', 7),
(48, 6, 'Subject', 'Body', 'tu', 8);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment_terms`
--

CREATE TABLE `invoice_payment_terms` (
  `id` int(10) UNSIGNED NOT NULL,
  `terms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days_before_due` int(11) NOT NULL,
  `defaults` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_payment_terms`
--

INSERT INTO `invoice_payment_terms` (`id`, `terms`, `days_before_due`, `defaults`) VALUES
(1, 'Immediate Payment', 0, 1),
(2, 'Net15', 15, 0),
(3, 'Net30', 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_code`
--

CREATE TABLE `item_code` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` smallint(6) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` int(11) NOT NULL,
  `special_price` int(11) NOT NULL,
  `qty_per_pack` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_code`
--

INSERT INTO `item_code` (`id`, `stock_id`, `description`, `category_id`, `item_image`, `inactive`, `deleted_status`, `created_at`, `updated_at`, `weight`, `special_price`, `qty_per_pack`) VALUES
(3, 'TEST ID', 'PRODUCT NAME', 2, 'My Medi Practice HR.jpg', 0, 0, '2017-07-14 23:46:26', '2017-07-30 19:27:59', 12, 98, 12),
(4, 'TEST ID123', '123', 2, 'background_body.png', 0, 0, '2017-07-15 14:09:08', '2017-07-18 20:50:57', 123, 123, 12);

-- --------------------------------------------------------

--
-- Table structure for table `item_tax_types`
--

CREATE TABLE `item_tax_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `exempt` tinyint(4) NOT NULL,
  `defaults` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_tax_types`
--

INSERT INTO `item_tax_types` (`id`, `name`, `tax_rate`, `exempt`, `defaults`) VALUES
(1, 'Tax Exempt', 0.00, 1, 1),
(2, 'VAT', 7.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_unit`
--

CREATE TABLE `item_unit` (
  `id` int(10) UNSIGNED NOT NULL,
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item_unit`
--

INSERT INTO `item_unit` (`id`, `abbr`, `name`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'each', 'Each', 0, '2017-07-14 23:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(10) UNSIGNED NOT NULL,
  `loc_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `location_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `loc_code`, `location_name`, `delivery_address`, `email`, `phone`, `fax`, `contact`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'PL', 'Primary Location', 'Primary Location', '', '', '', 'Primary Location', 0, '2017-07-14 23:11:49', NULL),
(3, 'test', 'test', 'test', '', '', '', '', 0, '2017-07-23 21:28:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2016_08_30_100832_create_users_table', 1),
('2016_08_30_104058_create_security_role_table', 1),
('2016_08_30_104506_create_stock_category_table', 1),
('2016_08_30_105339_create_location_table', 1),
('2016_08_30_110408_create_item_code_table', 1),
('2016_08_30_114231_create_item_unit_table', 1),
('2016_09_02_070031_create_stock_master_table', 1),
('2016_09_20_123717_create_stock_move_table', 1),
('2016_10_05_113244_create_debtor_master_table', 1),
('2016_10_05_113333_create_sales_orders_table', 1),
('2016_10_05_113356_create_sales_order_details_table', 1),
('2016_10_18_060431_create_supplier_table', 1),
('2016_10_18_063931_create_purch_order_table', 1),
('2016_10_18_064211_create_purch_order_detail_table', 1),
('2016_11_15_121343_create_preference_table', 1),
('2016_12_01_130110_create_shipment_table', 1),
('2016_12_01_130443_create_shipment_details_table', 1),
('2016_12_03_051429_create_sale_price_table', 1),
('2016_12_03_052017_create_sales_types_table', 1),
('2016_12_03_061206_create_purchase_price_table', 1),
('2016_12_03_062131_create_payment_term_table', 1),
('2016_12_03_062247_create_payment_history_table', 1),
('2016_12_03_062932_create_item_tax_type_table', 1),
('2016_12_03_063827_create_invoice_payment_term_table', 1),
('2016_12_03_064157_create_email_temp_details_table', 1),
('2016_12_03_064747_create_email_config_table', 1),
('2016_12_03_065532_create_cust_branch_table', 1),
('2016_12_03_065915_create_currency_table', 1),
('2016_12_03_070030_create_country_table', 1),
('2016_12_03_070030_create_stock_transfer_table', 1),
('2016_12_03_071018_create_backup_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_type_id` smallint(6) NOT NULL,
  `order_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `payment_type_id`, `order_reference`, `invoice_reference`, `payment_date`, `amount`, `person_id`, `customer_id`, `reference`, `created_at`, `updated_at`) VALUES
(4, 1, 'SO-0002', 'INV-0005', '2017-07-30', 11.5, 1, 1, 'by all pay', NULL, NULL),
(5, 1, 'SO-0002', 'INV-0005', '2017-08-06', 0, 1, 1, 'by all pay', NULL, NULL),
(6, 1, 'SO-0002', 'INV-0006', '2017-08-06', 50, 1, 1, 'by all pay', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE `payment_terms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_terms`
--

INSERT INTO `payment_terms` (`id`, `name`, `defaults`) VALUES
(1, 'Bank', 1),
(2, 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id`, `category`, `field`, `value`) VALUES
(1, 'preference', 'row_per_page', '25'),
(2, 'preference', 'date_format', '1'),
(3, 'preference', 'date_sepa', '-'),
(4, 'preference', 'soft_name', 'Stockpile'),
(5, 'company', 'site_short_name', 'CM'),
(6, 'preference', 'percentage', '0'),
(7, 'preference', 'quantity', '0'),
(8, 'preference', 'date_format_type', 'dd-mm-yyyy'),
(9, 'company', 'company_name', 'Chalad Marketing'),
(10, 'company', 'company_email', 'admin@techvill.net'),
(11, 'company', 'company_phone', '123465798'),
(12, 'company', 'company_street', 'Chiang Mai'),
(13, 'company', 'company_city', 'Chiang Mai'),
(14, 'company', 'company_state', 'Chiang Mai'),
(15, 'company', 'company_zipCode', '50220'),
(16, 'company', 'company_country_id', 'Thailand'),
(17, 'company', 'dflt_lang', 'en'),
(18, 'company', 'dflt_currency_id', '1'),
(19, 'company', 'sates_type_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_prices`
--

CREATE TABLE `purchase_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `suppliers_uom` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `conversion_factor` double DEFAULT '1',
  `supplier_description` char(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchase_prices`
--

INSERT INTO `purchase_prices` (`id`, `stock_id`, `price`, `suppliers_uom`, `conversion_factor`, `supplier_description`) VALUES
(1, 'TEST ID123', 30, '', 1, ''),
(2, 'TEST ID', 150, '', 1, ''),
(3, 'TEST ID123', 30, '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `purch_orders`
--

CREATE TABLE `purch_orders` (
  `order_no` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `comments` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ord_date` date NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `requisition_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `into_stock_location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `tax_included` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purch_orders`
--

INSERT INTO `purch_orders` (`order_no`, `supplier_id`, `person_id`, `comments`, `ord_date`, `reference`, `requisition_no`, `into_stock_location`, `delivery_address`, `total`, `tax_included`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SDf', '2017-07-16', 'PO-0001', NULL, 'PL', '', 2760, 'yes', '2017-07-15 14:04:21', NULL),
(2, 1, 1, '', '2017-07-23', 'PO-0002', NULL, 'PL', '', 11500, 'yes', '2017-07-23 14:28:35', NULL),
(3, 1, 1, '', '2017-07-30', 'PO-0003', NULL, 'test', '', 50, 'yes', '2017-07-30 20:19:05', '2017-07-30 20:19:18'),
(4, 1, 1, '', '2017-08-06', 'PO-0004', NULL, 'PL', '', 50000, 'yes', '2017-08-06 10:46:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purch_order_details`
--

CREATE TABLE `purch_order_details` (
  `po_detail_item` int(10) UNSIGNED NOT NULL,
  `order_no` int(11) NOT NULL,
  `item_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `qty_invoiced` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `act_price` double NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL,
  `std_cost_unit` double NOT NULL DEFAULT '0',
  `quantity_ordered` double NOT NULL DEFAULT '0',
  `quantity_received` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purch_order_details`
--

INSERT INTO `purch_order_details` (`po_detail_item`, `order_no`, `item_code`, `description`, `qty_invoiced`, `unit_price`, `act_price`, `tax_type_id`, `std_cost_unit`, `quantity_ordered`, `quantity_received`, `created_at`, `updated_at`) VALUES
(1, 1, 'TEST ID', 'Product Name', 12, 200, 0, 3, 0, 12, 12, NULL, NULL),
(2, 2, 'TEST ID', 'Product Name', 1000, 10, 0, 3, 0, 1000, 1000, NULL, NULL),
(3, 3, 'TEST ID', 'TEST ID', 1, 50, 0, 1, 0, 1, 1, NULL, NULL),
(4, 4, 'TEST ID', 'PRODUCT NAME', 100, 500, 0, 1, 0, 100, 100, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quote_cust_info`
--

CREATE TABLE `quote_cust_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `channel_id` varchar(50) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `bill_street` varchar(255) NOT NULL,
  `bill_city` varchar(255) NOT NULL,
  `bill_state` varchar(255) NOT NULL,
  `bill_zipCode` varchar(255) NOT NULL,
  `bill_country_id` varchar(255) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `ship_street` varchar(255) NOT NULL,
  `ship_zipCode` varchar(255) NOT NULL,
  `ship_city` varchar(255) NOT NULL,
  `ship_state` varchar(255) NOT NULL,
  `ship_country_id` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total_weight` float NOT NULL,
  `shipping_method` varchar(11) NOT NULL,
  `total` float NOT NULL,
  `is_vat` int(11) NOT NULL,
  `payment_made` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quote_cust_info`
--

INSERT INTO `quote_cust_info` (`id`, `name`, `phone`, `channel_id`, `channel`, `bill_street`, `bill_city`, `bill_state`, `bill_zipCode`, `bill_country_id`, `shipping_name`, `ship_street`, `ship_zipCode`, `ship_city`, `ship_state`, `ship_country_id`, `create_time`, `total_weight`, `shipping_method`, `total`, `is_vat`, `payment_made`, `status`) VALUES
(19, 'Shoaib Ahmed', '0988251927', 'sdfsf', 'twitter', '51/1-b North Mughda,North Jhilpar,Dhaka', 'Dhaka', 'Motijheel', '1219', 'ZW', 'Shoaib Ahmed', '51/1-b North Mughda,North Jhilpar,Dhaka', '1219', 'Dhaka', 'Motijheel', 'ZW', '2017-07-23 13:41:10', 429, 'EMS', 859, 1, 100, 0),
(20, 'Shoaib Ahmed', '0988251927', 'sdfsf', 'twitter', '51/1-b North Mughda,North Jhilpar,Dhaka', 'Dhaka', 'Motijheel', '1219', 'ZW', '', '51/1-b North Mughda,North Jhilpar,Dhaka', '1219', 'Dhaka', 'Motijheel', 'ZW', '2017-07-19 01:44:57', 12, 'EMS', 204.86, 1, 0, 0),
(21, 'Nok', '0818293293', '?????????', 'facebook', '', '', '', '', 'ZW', '', '', '', '', '', 'ZW', '2017-07-22 08:46:51', 24, 'EMS', 296, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quote_details`
--

CREATE TABLE `quote_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_weight` varchar(6) NOT NULL,
  `unit_price` float NOT NULL,
  `discount` float NOT NULL,
  `item_price` float NOT NULL,
  `comments` varchar(5000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quote_details`
--

INSERT INTO `quote_details` (`id`, `quote_id`, `stock_id`, `stock`, `product_name`, `item_quantity`, `item_id`, `item_weight`, `unit_price`, `discount`, `item_price`, `comments`, `created_at`) VALUES
(16, 19, 0, 12, 'Product Name', 5, 3, '12 gm', 98, 0, 490, '', '2017-07-23 13:41:10'),
(17, 19, 0, 12, 'Product Name', 5, 3, '12 gm', 98, 0, 490, '', '2017-07-23 13:41:10'),
(18, 20, 0, 12, 'Product Name', 1, 3, '12 gm', 98, 0, 98, '', '2017-07-19 01:44:57'),
(19, 21, 0, 10, 'Product Name', 2, 3, '12 gm', 98, 0, 196, '', '2017-07-22 08:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `quote_payment`
--

CREATE TABLE `quote_payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `payment_image` varchar(500) NOT NULL,
  `create_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quote_payment`
--

INSERT INTO `quote_payment` (`id`, `quote_id`, `payment_method`, `amount`, `payment_image`, `create_time`) VALUES
(1, 19, 'cash', 500, '1000.jpg', '2017-07-20'),
(2, 20, 'cash', 500, '1000.jpg', '2017-07-20'),
(3, 19, 'cash', 100, '1483195675.jpg', '0000-00-00'),
(4, 21, 'transfer', 1000, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `order_no` int(10) UNSIGNED NOT NULL,
  `trans_type` int(11) NOT NULL,
  `debtor_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `version` tinyint(4) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customer_ref` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_reference_id` int(11) NOT NULL,
  `order_reference` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ord_date` date NOT NULL,
  `order_type` int(11) NOT NULL,
  `delivery_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliver_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_stk_loc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_id` tinyint(4) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `item_tax` double(8,2) NOT NULL,
  `total_weight` float NOT NULL,
  `shipping_method` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_cost` float NOT NULL,
  `discount_amnount` float NOT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `choices` enum('no','partial_created','full_created') COLLATE utf8_unicode_ci NOT NULL,
  `payment_term` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`order_no`, `trans_type`, `debtor_no`, `branch_id`, `person_id`, `version`, `reference`, `customer_ref`, `order_reference_id`, `order_reference`, `comments`, `ord_date`, `order_type`, `delivery_address`, `contact_phone`, `contact_email`, `deliver_to`, `from_stk_loc`, `delivery_date`, `payment_id`, `total`, `item_tax`, `total_weight`, `shipping_method`, `shipping_cost`, `discount_amnount`, `paid_amount`, `choices`, `payment_term`, `created_at`, `updated_at`) VALUES
(1, 201, 1, 1, 1, 1, 'SO-0001', NULL, 0, NULL, '', '2017-07-18', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 11.5, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-07-17 21:16:04', '2017-07-23 14:24:55'),
(2, 202, 1, 1, 1, 0, 'INV-0001', NULL, 1, 'SO-0001', '', '2017-07-18', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 0, 0.00, 0, '', 0, 0, 0, 'no', 1, '2017-07-19 21:00:20', NULL),
(3, 201, 1, 1, 1, 1, 'SO-0002', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, '1', NULL, 1, 160, 0.00, 0, 'EMS', 100, 0, 0, 'no', 0, '2017-07-19 21:09:59', '2017-08-07 11:16:18'),
(7, 202, 1, 1, 1, 0, 'INV-0005', NULL, 3, 'SO-0002', '', '2017-07-23', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 11.5, 0.00, 0, '', 0, 0, 11.5, 'no', 1, '2017-07-23 20:03:12', NULL),
(8, 201, 14, 6, 1, 0, 'SO-0003', NULL, 0, NULL, '', '2017-07-30', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 98, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-07-30 18:23:08', NULL),
(9, 201, 14, 6, 1, 0, 'SO-0005', NULL, 0, NULL, '', '2017-07-30', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 204.86, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-07-30 18:24:02', NULL),
(10, 202, 1, 1, 1, 0, 'INV-0006', NULL, 3, 'SO-0002', '', '2017-07-20', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 50, 0.00, 0, '', 0, 0, 50, 'no', 1, '2017-08-06 10:35:10', NULL),
(11, 201, 2, 2, 1, 0, 'SO-0006', NULL, 0, NULL, '', '2017-08-06', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 9900, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-08-06 10:47:30', NULL),
(12, 201, 16, 16, 1, 0, 'SO-0007', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 199.86, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-08-06 10:56:17', NULL),
(13, 201, 2, 2, 1, 0, 'SO-0008', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1075, 0.00, 0, '', 0, 0, 0, 'no', 0, '2017-08-06 10:57:08', NULL),
(14, 201, 2, 2, 1, 0, 'SO-0009', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, '1', NULL, 1, 1103, 7.00, 243, 'EMS', 100, 4, 0, 'no', 0, '2017-08-07 09:01:05', '2017-08-07 11:15:40'),
(17, 201, 12, 12, 1, 0, 'SO-0010', NULL, 0, NULL, '', '2017-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1000, 0.00, 120, 'EMS', 100, 80, 0, 'no', 0, '2017-08-07 21:30:54', NULL),
(18, 201, 16, 16, 1, 0, 'SO-0011', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 90, 0.00, 12, 'Registered', 0, 5, 0, 'no', 0, '2017-08-07 21:34:52', NULL),
(19, 201, 2, 2, 1, 0, 'SO-0012', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, '1', NULL, 1, 1597, 0.00, 1167, 'EMS', 0, 5, 0, 'no', 0, '2017-08-07 21:53:41', '2017-08-07 21:53:55'),
(20, 201, 1, 1, 1, 0, 'SO-0013', NULL, 0, NULL, '', '1970-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 336.47, 7.00, 135, 'EMS', 100, 2, 0, 'no', 0, '2017-08-08 06:24:51', NULL),
(21, 201, 1, 1, 1, 0, 'SO-0014', NULL, 0, NULL, '1', '1970-01-01', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 336.47, 7.00, 135, 'EMS', 100, 10, 0, 'no', 0, '2017-08-08 06:42:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE `sales_order_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty_sent` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `shipment_qty` double NOT NULL DEFAULT '0',
  `discount_percent` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_order_details`
--

INSERT INTO `sales_order_details` (`id`, `order_no`, `trans_type`, `stock_id`, `tax_type_id`, `description`, `unit_price`, `qty_sent`, `quantity`, `shipment_qty`, `discount_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 201, 'TEST ID', 1, 'Product Name', 10, 1, 1, 1, 0, NULL, NULL),
(2, 2, 202, 'TEST ID', 3, 'Product Name', 0, 1, 1, 0, 0, NULL, NULL),
(4, 3, 201, 'TEST ID', 3, 'Product Name', 10, 6, 6, 6, 0, NULL, NULL),
(8, 7, 202, 'TEST ID', 3, 'Product Name', 10, 1, 1, 0, 0, NULL, NULL),
(9, 10, 202, 'TEST ID', 3, 'Product Name', 10, 5, 5, 0, 0, NULL, NULL),
(11, 13, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(12, 14, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(15, 17, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(18, 17, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 10, 0, 0, NULL, NULL),
(19, 18, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(20, 19, 201, 'TEST ID123', 0, '123', 123, 9, 9, 0, 0, NULL, NULL),
(21, 19, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 5, 5, 0, 0, NULL, NULL),
(22, 20, 201, 'TEST ID123', 0, '123', 123, 0, 1, 0, 0, NULL, NULL),
(23, 20, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(24, 21, 201, 'TEST ID', 0, 'PRODUCT NAME', 98, 0, 1, 0, 0, NULL, NULL),
(25, 21, 201, 'TEST ID123', 0, '123', 123, 0, 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_types`
--

CREATE TABLE `sales_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `sales_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_included` int(11) NOT NULL,
  `factor` double NOT NULL,
  `defaults` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_types`
--

INSERT INTO `sales_types` (`id`, `sales_type`, `tax_included`, `factor`, `defaults`) VALUES
(1, 'Retail', 1, 0, 1),
(2, 'Wholesale', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_prices`
--

CREATE TABLE `sale_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` int(11) NOT NULL,
  `curr_abrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sale_prices`
--

INSERT INTO `sale_prices` (`id`, `stock_id`, `sales_type_id`, `curr_abrev`, `price`) VALUES
(1, 'TEST ID123', 1, 'USD', 160),
(2, 'TEST ID123', 2, 'USD', 0),
(3, 'TEST ID', 1, 'USD', 180),
(4, 'TEST ID', 2, 'USD', 0),
(5, 'TEST ID123', 1, 'USD', 0),
(6, 'TEST ID123', 2, 'USD', 2);

-- --------------------------------------------------------

--
-- Table structure for table `security_role`
--

CREATE TABLE `security_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8_unicode_ci,
  `areas` text COLLATE utf8_unicode_ci,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `security_role`
--

INSERT INTO `security_role` (`id`, `role`, `description`, `sections`, `areas`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'System Administrator', 'a:21:{s:8:"category";s:3:"100";s:4:"unit";s:3:"600";s:3:"loc";s:3:"200";s:4:"item";s:3:"300";s:4:"user";s:3:"400";s:4:"role";s:3:"500";s:8:"customer";s:3:"700";s:5:"sales";s:3:"800";s:8:"purchese";s:3:"900";s:8:"supplier";s:4:"1000";s:8:"transfer";s:4:"1100";s:5:"order";s:4:"1200";s:8:"shipment";s:4:"1300";s:7:"payment";s:4:"1400";s:6:"backup";s:4:"1500";s:5:"email";s:4:"1600";s:3:"tax";s:4:"1900";s:9:"salestype";s:4:"2000";s:10:"currencies";s:4:"2100";s:11:"paymentterm";s:4:"2200";s:13:"paymentmethod";s:4:"2300";}', 'a:62:{s:7:"cat_add";s:3:"101";s:8:"cat_edit";s:3:"102";s:10:"cat_delete";s:3:"103";s:8:"unit_add";s:3:"601";s:9:"unit_edit";s:3:"602";s:11:"unit_delete";s:3:"603";s:7:"loc_add";s:3:"201";s:8:"loc_edit";s:3:"202";s:10:"loc_delete";s:3:"203";s:8:"item_add";s:3:"301";s:9:"item_edit";s:3:"302";s:11:"item_delete";s:3:"303";s:9:"item_copy";s:3:"304";s:8:"user_add";s:3:"401";s:9:"user_edit";s:3:"402";s:11:"user_delete";s:3:"403";s:9:"user_role";s:3:"501";s:12:"customer_add";s:3:"701";s:13:"customer_edit";s:3:"702";s:15:"customer_delete";s:3:"703";s:9:"sales_add";s:3:"801";s:10:"sales_edit";s:3:"802";s:12:"sales_delete";s:3:"803";s:12:"purchese_add";s:3:"901";s:13:"purchese_edit";s:3:"902";s:15:"purchese_delete";s:3:"903";s:12:"supplier_add";s:4:"1001";s:13:"supplier_edit";s:4:"1002";s:15:"supplier_delete";s:4:"1003";s:12:"transfer_add";s:4:"1101";s:13:"transfer_edit";s:4:"1102";s:15:"transfer_delete";s:4:"1103";s:9:"order_add";s:4:"1201";s:10:"order_edit";s:4:"1202";s:12:"order_delete";s:4:"1203";s:12:"shipment_add";s:4:"1301";s:13:"shipment_edit";s:4:"1302";s:15:"shipment_delete";s:4:"1303";s:11:"payment_add";s:4:"1401";s:12:"payment_edit";s:4:"1402";s:14:"payment_delete";s:4:"1403";s:10:"backup_add";s:4:"1501";s:15:"backup_download";s:4:"1502";s:9:"email_add";s:4:"1601";s:9:"emailtemp";s:4:"1700";s:10:"preference";s:4:"1800";s:7:"tax_add";s:4:"1901";s:8:"tax_edit";s:4:"1902";s:10:"tax_delete";s:4:"1903";s:13:"salestype_add";s:4:"2001";s:14:"salestype_edit";s:4:"2002";s:16:"salestype_delete";s:4:"2003";s:14:"currencies_add";s:4:"2101";s:15:"currencies_edit";s:4:"2102";s:17:"currencies_delete";s:4:"2103";s:15:"paymentterm_add";s:4:"2201";s:16:"paymentterm_edit";s:4:"2202";s:18:"paymentterm_delete";s:4:"2203";s:17:"paymentmethod_add";s:4:"2301";s:18:"paymentmethod_edit";s:4:"2302";s:20:"paymentmethod_delete";s:4:"2303";s:14:"companysetting";s:4:"2400";}', 0, '2017-07-14 23:11:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `packed_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`id`, `order_no`, `trans_type`, `comments`, `status`, `packed_date`, `delivery_date`, `created_at`, `updated_at`) VALUES
(3, 3, 301, '', 1, '2017-08-06', '2017-08-06', NULL, NULL),
(4, 1, 301, '', 1, '2017-08-06', '2017-08-06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_details`
--

CREATE TABLE `shipment_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `discount_percent` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shipment_details`
--

INSERT INTO `shipment_details` (`id`, `shipment_id`, `order_no`, `stock_id`, `tax_type_id`, `unit_price`, `quantity`, `discount_percent`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 'TEST ID', 3, 10, 6, 0, NULL, NULL),
(4, 4, 1, 'TEST ID', 1, 10, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_cost`
--

CREATE TABLE `shipping_cost` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `weight_to` float NOT NULL,
  `weight_from` float NOT NULL,
  `method` varchar(10) NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_cost`
--

INSERT INTO `shipping_cost` (`id`, `weight_to`, `weight_from`, `method`, `cost`) VALUES
(1, 0, 500, 'EMS', 100),
(2, 0, 10000, 'Registered', 0),
(3, 501, 1000, 'EMS', 105);

-- --------------------------------------------------------

--
-- Table structure for table `stock_category`
--

CREATE TABLE `stock_category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dflt_units` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_category`
--

INSERT INTO `stock_category` (`category_id`, `description`, `dflt_units`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Default', 1, 0, '2017-07-14 23:11:51', NULL),
(2, 'Hardware', 1, 0, '2017-07-14 23:11:51', NULL),
(3, 'Health & Beauty', 1, 0, '2017-07-14 23:11:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_master`
--

CREATE TABLE `stock_master` (
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci,
  `units` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_master`
--

INSERT INTO `stock_master` (`stock_id`, `category_id`, `tax_type_id`, `description`, `long_description`, `units`, `inactive`, `deleted_status`, `created_at`, `updated_at`) VALUES
('TEST ID', 2, 1, 'PRODUCT NAME', NULL, 'Each', 0, 0, '2017-07-14 23:46:27', '2017-07-30 19:27:59'),
('TEST ID123', 2, 2, '123', NULL, 'Each', 0, 0, '2017-07-15 14:09:09', '2017-07-18 20:50:57');

-- --------------------------------------------------------

--
-- Table structure for table `stock_moves`
--

CREATE TABLE `stock_moves` (
  `trans_id` int(10) UNSIGNED NOT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `trans_type` smallint(6) NOT NULL DEFAULT '0',
  `loc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tran_date` date NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `order_reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_reference_id` int(11) NOT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `note` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_moves`
--

INSERT INTO `stock_moves` (`trans_id`, `stock_id`, `order_no`, `trans_type`, `loc_code`, `tran_date`, `person_id`, `order_reference`, `reference`, `transaction_reference_id`, `transfer_id`, `note`, `qty`, `price`) VALUES
(1, 'TEST ID', 0, 102, 'PL', '2017-07-16', 1, '', 'store_in_1', 1, NULL, '', 12, 200),
(2, 'TEST ID', 1, 202, 'PL', '2017-07-20', 1, 'SO-0001', 'store_out_2', 2, NULL, '', -1, 0),
(4, 'TEST ID', 0, 401, 'JA', '2017-07-23', 1, '', 'moved_from_PL', 1, 1, '', -1, 0),
(5, 'TEST ID', 0, 402, 'PL', '2017-07-23', 1, '', 'moved_in_JA', 1, NULL, '', 0, 0),
(7, 'TEST ID', 0, 102, 'PL', '2017-07-23', 1, '', 'store_in_2', 2, NULL, '', 1000, 10),
(9, 'TEST ID', 3, 202, 'PL', '2017-07-23', 1, 'SO-0002', 'store_out_7', 7, NULL, '', -1, 10),
(10, 'TEST ID', 0, 102, 'test', '2017-07-30', 1, '', 'store_in_3', 3, NULL, '', 1, 50),
(11, 'TEST ID', 3, 202, 'PL', '2017-08-06', 1, 'SO-0002', 'store_out_10', 10, NULL, '', -5, 10),
(12, 'TEST ID', 0, 102, 'PL', '2017-08-06', 1, '', 'store_in_4', 4, NULL, '', 100, 500);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(11) NOT NULL,
  `source` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `transfer_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `person_id`, `source`, `destination`, `note`, `qty`, `transfer_date`) VALUES
(1, 1, 'PL', 'JA', '', -1, '2017-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `supp_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supp_name`, `email`, `address`, `contact`, `city`, `state`, `zipcode`, `country`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'toka Ink', 'ashoab@ymail.com', '2 DIT Avenue, Motijheel Commercial Area', '01717041668', 'Dhaka', 'Motijheel', '1000', 'BD', 0, '2017-07-15 14:03:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `password`, `real_name`, `role_id`, `phone`, `email`, `picture`, `inactive`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '', '$2y$10$Qgu1jVsYIIlVDtWocu9vMOC1jCGd52y04wVP9UxGqMifjKgsWhIIa', 'admin', 1, '', 'ashoab@ymail.com', '', 0, 'qaCGv7QTccZ0PR1s2RqXKTr0dArWA9hgNLTj4CAxbOUx3UPDIaUGIsVsqS9k', '2017-07-14 23:12:07', '2017-08-08 06:16:14'),
(2, 'rahat', '$2y$10$B9oszFQGm1GAFkoBwFuCM.tvOS7eAn8.72pVUArKfmb4abnjYAgR2', 'rahat', 1, '01735044473', 'rahat.it@gmail.com', '', 0, '', '2017-07-31 15:04:32', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cust_branch`
--
ALTER TABLE `cust_branch`
  ADD PRIMARY KEY (`branch_code`);

--
-- Indexes for table `debtors_master`
--
ALTER TABLE `debtors_master`
  ADD PRIMARY KEY (`debtor_no`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_temp_details`
--
ALTER TABLE `email_temp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payment_terms`
--
ALTER TABLE `invoice_payment_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_code`
--
ALTER TABLE `item_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_tax_types`
--
ALTER TABLE `item_tax_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_unit`
--
ALTER TABLE `item_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_terms`
--
ALTER TABLE `payment_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_prices`
--
ALTER TABLE `purchase_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purch_orders`
--
ALTER TABLE `purch_orders`
  ADD PRIMARY KEY (`order_no`);

--
-- Indexes for table `purch_order_details`
--
ALTER TABLE `purch_order_details`
  ADD PRIMARY KEY (`po_detail_item`);

--
-- Indexes for table `quote_cust_info`
--
ALTER TABLE `quote_cust_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `quote_details`
--
ALTER TABLE `quote_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `quote_payment`
--
ALTER TABLE `quote_payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`order_no`);

--
-- Indexes for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_types`
--
ALTER TABLE `sales_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_prices`
--
ALTER TABLE `sale_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `security_role`
--
ALTER TABLE `security_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_details`
--
ALTER TABLE `shipment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_cost`
--
ALTER TABLE `shipping_cost`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `stock_category`
--
ALTER TABLE `stock_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `stock_master`
--
ALTER TABLE `stock_master`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `stock_moves`
--
ALTER TABLE `stock_moves`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cust_branch`
--
ALTER TABLE `cust_branch`
  MODIFY `branch_code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `debtors_master`
--
ALTER TABLE `debtors_master`
  MODIFY `debtor_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `email_temp_details`
--
ALTER TABLE `email_temp_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `invoice_payment_terms`
--
ALTER TABLE `invoice_payment_terms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item_code`
--
ALTER TABLE `item_code`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item_tax_types`
--
ALTER TABLE `item_tax_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `item_unit`
--
ALTER TABLE `item_unit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment_terms`
--
ALTER TABLE `payment_terms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `preference`
--
ALTER TABLE `preference`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `purchase_prices`
--
ALTER TABLE `purchase_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `purch_orders`
--
ALTER TABLE `purch_orders`
  MODIFY `order_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `purch_order_details`
--
ALTER TABLE `purch_order_details`
  MODIFY `po_detail_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `quote_cust_info`
--
ALTER TABLE `quote_cust_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `quote_details`
--
ALTER TABLE `quote_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `quote_payment`
--
ALTER TABLE `quote_payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `order_no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `sales_types`
--
ALTER TABLE `sales_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sale_prices`
--
ALTER TABLE `sale_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `security_role`
--
ALTER TABLE `security_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `shipment_details`
--
ALTER TABLE `shipment_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `shipping_cost`
--
ALTER TABLE `shipping_cost`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stock_category`
--
ALTER TABLE `stock_category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stock_moves`
--
ALTER TABLE `stock_moves`
  MODIFY `trans_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
