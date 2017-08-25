-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 16, 2017 at 12:22 AM
-- Server version: 10.1.18-MariaDB-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `techvil1_stockinventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE IF NOT EXISTS `backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=243 ;

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
(114, 'Korea, Democratic People''s Republic of', 'KP'),
(115, 'Korea, Republic of', 'KR'),
(116, 'Kuwait', 'KW'),
(117, 'Kyrgyzstan', 'KG'),
(118, 'Lao People''s Democratic Republic', 'LA'),
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

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` char(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `symbol`) VALUES
(1, 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `cust_branch`
--

CREATE TABLE IF NOT EXISTS `cust_branch` (
  `branch_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debtor_no` int(11) NOT NULL,
  `br_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`branch_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cust_branch`
--

INSERT INTO `cust_branch` (`branch_code`, `debtor_no`, `br_name`, `br_address`, `br_contact`, `billing_street`, `billing_city`, `billing_state`, `billing_zip_code`, `billing_country_id`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_country_id`) VALUES
(1, 1, ' Mary Roe', '', '', ' MARY ROE', ' MEGASYSTEMS INC', ' TUCSON', 'Washington', 'AZ 85705', 'USA', ' MEGASYSTEMS INC', ' TUCSON', 'Washington', 'AZ 85705'),
(2, 2, ' John Smith', '', '', ' JOHN SMITH', ' 300 BOYLSTON AVE E', '  SEATTLE', 'Washington', 'WA 98102', 'USA', ' 300 BOYLSTON AVE E', '  SEATTLE', 'Washington', 'WA 98102'),
(3, 3, 'Kyla Olsen', '', '', 'Kyla Olsen', 'Ap #651-8679 Sodales Av.', 'Tamuning', 'Tamuning', 'PA 10855', 'TZ', 'Ap #651-8679 Sodales Av.', 'Tamuning', 'Tamuning', 'PA 10855'),
(4, 4, 'Cecilia Chapman', '', '', 'Cecilia Chapman', '711-2880 Nulla St', 'Mankato', 'Mississippi ', '96522', 'US', '711-2880 Nulla St', 'Mankato', 'Mississippi ', '96522'),
(5, 5, 'Iris Watson', '', '', 'Iris Watson', 'Fusce Rd.', 'Frederick', 'Nebraska', '20620', 'US', 'Fusce Rd.', 'Frederick', 'Nebraska', '20620');

-- --------------------------------------------------------

--
-- Table structure for table `debtors_master`
--

CREATE TABLE IF NOT EXISTS `debtors_master` (
  `debtor_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type` int(11) NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `debtors_master`
--

INSERT INTO `debtors_master` (`debtor_no`, `name`, `email`, `password`, `address`, `phone`, `sales_type`, `remember_token`, `inactive`, `created_at`, `updated_at`) VALUES
(1, ' Mary Roe', 'maryroe@gmail.com', '', '', '(257) 563-7401', 0, '', 0, NULL, NULL),
(2, ' John Smith', 'jhon.smith@gmail.com', '', '', '(372) 587-2335', 0, '', 0, NULL, NULL),
(3, 'Kyla Olsen', 'kyla.olsen@gmail.com', '', '', '(654) 393-5734', 0, '', 0, NULL, NULL),
(4, 'Cecilia Chapman', 'cecilia@gmail.com', '', '', '(257) 563-7401', 0, '', 0, NULL, NULL),
(5, 'Iris Watson', 'iris@yahoo.com', '$2y$10$GwzEH2DV/98Fmt1s8bkk7.qWJsYZo9tW36c/cG/o9g/lGkrEp8fCC', '', '(372) 587-2335', 0, '', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email_protocol`, `email_encryption`, `smtp_host`, `smtp_port`, `smtp_email`, `smtp_username`, `smtp_password`, `from_address`, `from_name`) VALUES
(1, 'smtp', 'tls', 'smtp.gmail.com', '587', 'stockpile.techvill@gmail.com', 'stockpile.techvill@gmail.com', 'xgldhlpedszmglvj', 'stockpile.techvill@gmail.com', 'stockpile.techvill@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `email_temp_details`
--

CREATE TABLE IF NOT EXISTS `email_temp_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

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

CREATE TABLE IF NOT EXISTS `invoice_payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `terms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days_before_due` int(11) NOT NULL,
  `defaults` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `invoice_payment_terms`
--

INSERT INTO `invoice_payment_terms` (`id`, `terms`, `days_before_due`, `defaults`) VALUES
(1, 'Cash on deleivery', 0, 1),
(2, 'Net15', 15, 0),
(3, 'Net30', 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_code`
--

CREATE TABLE IF NOT EXISTS `item_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `item_code`
--

INSERT INTO `item_code` (`id`, `stock_id`, `description`, `category_id`, `item_image`, `inactive`, `deleted_status`, `created_at`, `updated_at`) VALUES
(1, 'APPLE', 'Iphone 7+', 1, 'iphone.jpg', 0, 0, NULL, '2017-02-16 15:11:30'),
(2, 'HP', 'HP Pro Book', 1, 'hpprobook.jpg', 0, 0, NULL, '2017-02-16 15:11:12'),
(3, 'LENEVO', 'LED TV', 1, 'ledtv.jpg', 0, 0, NULL, '2017-02-16 15:11:45'),
(4, 'LG', 'LG Refrigeretor', 1, 'lgrefrigeretor.jpg', 0, 0, NULL, '2017-02-16 15:12:01'),
(5, 'SAMSUNG', 'Samsung G7', 1, 'samsung-galaxy7.jpg', 0, 0, NULL, '2017-02-16 15:12:34'),
(6, 'SINGER', 'Singer Refrigerator', 1, 'singer-refrideretor.jpg', 0, 0, NULL, '2017-02-16 15:12:54'),
(7, 'SONY', 'Sony experia 5', 1, 'sony-xperia5.jpg', 0, 0, NULL, '2017-02-16 15:13:11'),
(8, 'WALTON', 'Walton Primo GH', 1, 'walton-primo.jpg', 0, 0, NULL, '2017-02-16 15:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `item_tax_types`
--

CREATE TABLE IF NOT EXISTS `item_tax_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `exempt` tinyint(4) NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item_tax_types`
--

INSERT INTO `item_tax_types` (`id`, `name`, `tax_rate`, `exempt`, `defaults`) VALUES
(1, 'Tax Exempt', 0.00, 1, 0),
(2, 'Sales Tax', 15.00, 0, 1),
(3, 'Purchases Tax', 15.00, 0, 0),
(4, 'Normal', 5.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_unit`
--

CREATE TABLE IF NOT EXISTS `item_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `item_unit`
--

INSERT INTO `item_unit` (`id`, `abbr`, `name`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'each', 'Each', 0, '2017-02-15 15:32:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loc_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `location_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `loc_code`, `location_name`, `delivery_address`, `email`, `phone`, `fax`, `contact`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'PL', 'Primary Location', 'Primary Location', '', '', '', 'Primary Location', 0, '2017-02-15 15:32:17', NULL),
(2, 'JA', 'Jackson Av.', '125 Hayes St, San Francisco, CA 94102, USA', '', '', '', '', 0, '2017-02-15 16:27:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
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

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_type_id` smallint(6) NOT NULL,
  `order_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `payment_type_id`, `order_reference`, `invoice_reference`, `payment_date`, `amount`, `person_id`, `customer_id`, `reference`, `created_at`, `updated_at`) VALUES
(1, 1, 'SO-0003', 'INV-0005', '2017-02-16', 27497.5, 1, 2, '', NULL, NULL),
(2, 1, 'SO-0002', 'INV-0002', '2017-02-16', 5000, 1, 2, '', NULL, NULL),
(3, 1, 'SO-0003', 'INV-0004', '2017-02-16', 1000, 1, 2, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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

CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id`, `category`, `field`, `value`) VALUES
(1, 'preference', 'row_per_page', '100'),
(2, 'preference', 'date_format', '1'),
(3, 'preference', 'date_sepa', '-'),
(4, 'preference', 'soft_name', 'Stockpile'),
(5, 'company', 'site_short_name', 'SP'),
(6, 'preference', 'percentage', '0'),
(7, 'preference', 'quantity', '0'),
(8, 'preference', 'date_format_type', 'dd-mm-yyyy'),
(9, 'company', 'company_name', 'Stockpile'),
(10, 'company', 'company_email', 'demo@demo.com'),
(11, 'company', 'company_phone', '123465798'),
(12, 'company', 'company_street', ' 300 BOYLSTON AVE E'),
(13, 'company', 'company_city', 'Washington'),
(14, 'company', 'company_state', 'Washington'),
(15, 'company', 'company_zipCode', 'WA 98102'),
(16, 'company', 'company_country_id', 'United States'),
(17, 'company', 'dflt_lang', 'en'),
(18, 'company', 'dflt_currency_id', '1'),
(19, 'company', 'sates_type_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_prices`
--

CREATE TABLE IF NOT EXISTS `purchase_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `suppliers_uom` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `conversion_factor` double DEFAULT '1',
  `supplier_description` char(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `purchase_prices`
--

INSERT INTO `purchase_prices` (`id`, `stock_id`, `price`, `suppliers_uom`, `conversion_factor`, `supplier_description`) VALUES
(1, 'APPLE', 100, '', 1, ''),
(2, 'HP', 80, '', 1, ''),
(3, 'LENEVO', 50, '', 1, ''),
(4, 'LG', 50, '', 1, ''),
(5, 'SAMSUNG', 50, '', 1, ''),
(6, 'SINGER', 50, '', 1, ''),
(7, 'SONY', 50, '', 1, ''),
(8, 'WALTON', 50, '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `purch_orders`
--

CREATE TABLE IF NOT EXISTS `purch_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `purch_orders`
--

INSERT INTO `purch_orders` (`order_no`, `supplier_id`, `person_id`, `comments`, `ord_date`, `reference`, `requisition_no`, `into_stock_location`, `delivery_address`, `total`, `tax_included`, `created_at`, `updated_at`) VALUES
(10, 2, 1, '', '2017-01-02', 'PO-0001', NULL, 'PL', '', 207000, 'yes', '2017-02-16 15:15:01', NULL),
(11, 3, 1, '', '2017-02-16', 'PO-0002', NULL, 'PL', '', 287500, 'yes', '2017-02-16 15:17:34', NULL),
(12, 4, 1, '', '2017-02-09', 'PO-0003', NULL, 'JA', '', 172500, 'yes', '2017-02-16 15:18:12', NULL),
(13, 4, 1, '', '2016-01-01', 'PO-0004', NULL, 'JA', '', 230000, 'yes', '2017-02-16 15:20:28', NULL),
(14, 3, 1, '', '2017-02-16', 'PO-0005', NULL, 'JA', '', 115000, 'yes', '2017-02-16 15:21:02', NULL),
(15, 5, 1, '', '2017-02-16', 'PO-0006', NULL, 'JA', '', 57500, 'yes', '2017-02-16 15:27:38', '2017-02-16 15:30:04'),
(16, 1, 1, '', '2017-02-16', 'PO-0007', NULL, 'PL', '', 517500, 'yes', '2017-02-16 16:10:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purch_order_details`
--

CREATE TABLE IF NOT EXISTS `purch_order_details` (
  `po_detail_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`po_detail_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `purch_order_details`
--

INSERT INTO `purch_order_details` (`po_detail_item`, `order_no`, `item_code`, `description`, `qty_invoiced`, `unit_price`, `act_price`, `tax_type_id`, `std_cost_unit`, `quantity_ordered`, `quantity_received`, `created_at`, `updated_at`) VALUES
(17, 10, 'APPLE', 'Iphone 7+', 1000, 100, 0, 2, 0, 1000, 1000, NULL, NULL),
(18, 10, 'HP', 'HP Pro Book', 1000, 80, 0, 2, 0, 1000, 1000, NULL, NULL),
(19, 11, 'SAMSUNG', 'Samsung G7', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(20, 11, 'SONY', 'Sony experia 5', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(21, 11, 'SINGER', 'Singer Refrigerator', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(22, 11, 'LG', 'LG Refrigeretor', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(23, 11, 'LENEVO', 'LED TV', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(24, 12, 'APPLE', 'Iphone 7+', 1000, 100, 0, 2, 0, 1000, 1000, NULL, NULL),
(25, 12, 'WALTON', 'Walton Primo GH', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(26, 13, 'SONY', 'Sony experia 5', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(27, 13, 'SINGER', 'Singer Refrigerator', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(28, 13, 'SAMSUNG', 'Samsung G7', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(29, 13, 'WALTON', 'Walton Primo GH', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(30, 14, 'SINGER', 'Singer Refrigerator', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(31, 14, 'LG', 'LG Refrigeretor', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(32, 15, 'WALTON', 'WALTON', 1000, 50, 0, 2, 0, 1000, 1000, NULL, NULL),
(33, 16, 'WALTON', 'Walton Primo GH', 3000, 50, 0, 2, 0, 3000, 3000, NULL, NULL),
(34, 16, 'APPLE', 'Iphone 7+', 3000, 100, 0, 2, 0, 3000, 3000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE IF NOT EXISTS `sales_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `paid_amount` double NOT NULL DEFAULT '0',
  `choices` enum('no','partial_created','full_created') COLLATE utf8_unicode_ci NOT NULL,
  `payment_term` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`order_no`, `trans_type`, `debtor_no`, `branch_id`, `person_id`, `version`, `reference`, `customer_ref`, `order_reference_id`, `order_reference`, `comments`, `ord_date`, `order_type`, `delivery_address`, `contact_phone`, `contact_email`, `deliver_to`, `from_stk_loc`, `delivery_date`, `payment_id`, `total`, `paid_amount`, `choices`, `payment_term`, `created_at`, `updated_at`) VALUES
(1, 201, 1, 1, 1, 0, 'SO-0001', NULL, 0, NULL, '', '2017-01-15', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 1840, 0, 'no', 0, '2017-02-16 16:02:55', NULL),
(2, 202, 1, 1, 1, 0, 'INV-0001', NULL, 1, 'SO-0001', '', '2017-01-18', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 1840, 0, 'no', 1, '2017-02-16 16:03:34', NULL),
(3, 201, 2, 2, 1, 0, 'SO-0002', NULL, 0, NULL, '', '2017-01-20', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 9000, 0, 'no', 0, '2017-02-16 16:05:40', NULL),
(4, 202, 2, 2, 1, 0, 'INV-0002', NULL, 3, 'SO-0002', '', '2017-01-23', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 9000, 5000, 'no', 1, '2017-02-16 16:06:55', NULL),
(5, 201, 2, 2, 1, 1, 'SO-0003', NULL, 0, NULL, '', '2017-01-22', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 245000, 0, 'no', 0, '2017-02-16 16:08:38', '2017-02-16 16:12:25'),
(6, 202, 2, 2, 1, 0, 'INV-0003', NULL, 5, 'SO-0003', '', '2017-01-28', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 33150, 0, 'no', 1, '2017-02-16 16:13:18', NULL),
(7, 202, 2, 2, 1, 0, 'INV-0004', NULL, 5, 'SO-0003', '', '2017-02-04', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 39935, 1000, 'no', 1, '2017-02-16 16:15:19', NULL),
(8, 202, 2, 2, 1, 0, 'INV-0005', NULL, 5, 'SO-0003', '', '2017-02-10', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 27497.5, 27497.5, 'no', 1, '2017-02-16 16:16:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE IF NOT EXISTS `sales_order_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `sales_order_details`
--

INSERT INTO `sales_order_details` (`id`, `order_no`, `trans_type`, `stock_id`, `tax_type_id`, `description`, `unit_price`, `qty_sent`, `quantity`, `shipment_qty`, `discount_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 201, 'APPLE', 2, 'Iphone 7+', 160, 0, 10, 0, 0, NULL, NULL),
(2, 2, 202, 'APPLE', 2, 'Iphone 7+', 160, 10, 10, 0, 0, NULL, NULL),
(3, 3, 201, 'SAMSUNG', 1, 'Samsung G7', 90, 0, 100, 0, 0, NULL, NULL),
(4, 4, 202, 'SAMSUNG', 1, 'Samsung G7', 90, 100, 100, 0, 0, NULL, NULL),
(5, 5, 201, 'APPLE', 2, 'Iphone 7+', 160, 1000, 1000, 20, 0, NULL, NULL),
(6, 5, 201, 'WALTON', 4, 'Walton Primo GH', 85, 1000, 1000, 20, 0, NULL, NULL),
(7, 6, 202, 'APPLE', 2, 'Iphone 7+', 160, 20, 20, 0, 0, NULL, NULL),
(8, 6, 202, 'WALTON', 4, 'Walton Primo GH', 85, 20, 20, 0, 0, NULL, NULL),
(9, 7, 202, 'APPLE', 2, 'Iphone 7+', 160, 50, 50, 0, 0, NULL, NULL),
(10, 7, 202, 'WALTON', 4, 'Walton Primo GH', 85, 50, 50, 0, 0, NULL, NULL),
(11, 8, 202, 'APPLE', 2, 'Iphone 7+', 160, 5, 5, 0, 0, NULL, NULL),
(12, 8, 202, 'WALTON', 4, 'Walton Primo GH', 85, 5, 5, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_types`
--

CREATE TABLE IF NOT EXISTS `sales_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sales_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_included` int(11) NOT NULL,
  `factor` double NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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

CREATE TABLE IF NOT EXISTS `sale_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` int(11) NOT NULL,
  `curr_abrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sale_prices`
--

INSERT INTO `sale_prices` (`id`, `stock_id`, `sales_type_id`, `curr_abrev`, `price`) VALUES
(1, 'APPLE', 1, 'USD', 160),
(2, 'HP', 1, 'USD', 120),
(3, 'LENEVO', 1, 'USD', 70),
(4, 'LG', 1, 'USD', 80),
(5, 'SAMSUNG', 1, 'USD', 90),
(6, 'SINGER', 1, 'USD', 80),
(7, 'SONY', 1, 'USD', 90),
(8, 'WALTON', 1, 'USD', 85),
(9, 'APPLE', 2, 'USD', 150),
(10, 'HP', 2, 'USD', 100),
(11, 'LENEVO', 2, 'USD', 65),
(12, 'LG', 2, 'USD', 75),
(13, 'SAMSUNG', 2, 'USD', 80),
(14, 'SINGER', 2, 'USD', 65),
(15, 'SONY', 2, 'USD', 85),
(16, 'WALTON', 2, 'USD', 70);

-- --------------------------------------------------------

--
-- Table structure for table `security_role`
--

CREATE TABLE IF NOT EXISTS `security_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8_unicode_ci,
  `areas` text COLLATE utf8_unicode_ci,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `security_role`
--

INSERT INTO `security_role` (`id`, `role`, `description`, `sections`, `areas`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'System Administrator', 'a:21:{s:8:"category";s:3:"100";s:4:"unit";s:3:"600";s:3:"loc";s:3:"200";s:4:"item";s:3:"300";s:4:"user";s:3:"400";s:4:"role";s:3:"500";s:8:"customer";s:3:"700";s:5:"sales";s:3:"800";s:8:"purchese";s:3:"900";s:8:"supplier";s:4:"1000";s:8:"transfer";s:4:"1100";s:5:"order";s:4:"1200";s:8:"shipment";s:4:"1300";s:7:"payment";s:4:"1400";s:6:"backup";s:4:"1500";s:5:"email";s:4:"1600";s:3:"tax";s:4:"1900";s:9:"salestype";s:4:"2000";s:10:"currencies";s:4:"2100";s:11:"paymentterm";s:4:"2200";s:13:"paymentmethod";s:4:"2300";}', 'a:62:{s:7:"cat_add";s:3:"101";s:8:"cat_edit";s:3:"102";s:10:"cat_delete";s:3:"103";s:8:"unit_add";s:3:"601";s:9:"unit_edit";s:3:"602";s:11:"unit_delete";s:3:"603";s:7:"loc_add";s:3:"201";s:8:"loc_edit";s:3:"202";s:10:"loc_delete";s:3:"203";s:8:"item_add";s:3:"301";s:9:"item_edit";s:3:"302";s:11:"item_delete";s:3:"303";s:9:"item_copy";s:3:"304";s:8:"user_add";s:3:"401";s:9:"user_edit";s:3:"402";s:11:"user_delete";s:3:"403";s:9:"user_role";s:3:"501";s:12:"customer_add";s:3:"701";s:13:"customer_edit";s:3:"702";s:15:"customer_delete";s:3:"703";s:9:"sales_add";s:3:"801";s:10:"sales_edit";s:3:"802";s:12:"sales_delete";s:3:"803";s:12:"purchese_add";s:3:"901";s:13:"purchese_edit";s:3:"902";s:15:"purchese_delete";s:3:"903";s:12:"supplier_add";s:4:"1001";s:13:"supplier_edit";s:4:"1002";s:15:"supplier_delete";s:4:"1003";s:12:"transfer_add";s:4:"1101";s:13:"transfer_edit";s:4:"1102";s:15:"transfer_delete";s:4:"1103";s:9:"order_add";s:4:"1201";s:10:"order_edit";s:4:"1202";s:12:"order_delete";s:4:"1203";s:12:"shipment_add";s:4:"1301";s:13:"shipment_edit";s:4:"1302";s:15:"shipment_delete";s:4:"1303";s:11:"payment_add";s:4:"1401";s:12:"payment_edit";s:4:"1402";s:14:"payment_delete";s:4:"1403";s:10:"backup_add";s:4:"1501";s:15:"backup_download";s:4:"1502";s:9:"email_add";s:4:"1601";s:9:"emailtemp";s:4:"1700";s:10:"preference";s:4:"1800";s:7:"tax_add";s:4:"1901";s:8:"tax_edit";s:4:"1902";s:10:"tax_delete";s:4:"1903";s:13:"salestype_add";s:4:"2001";s:14:"salestype_edit";s:4:"2002";s:16:"salestype_delete";s:4:"2003";s:14:"currencies_add";s:4:"2101";s:15:"currencies_edit";s:4:"2102";s:17:"currencies_delete";s:4:"2103";s:15:"paymentterm_add";s:4:"2201";s:16:"paymentterm_edit";s:4:"2202";s:18:"paymentterm_delete";s:4:"2203";s:17:"paymentmethod_add";s:4:"2301";s:18:"paymentmethod_edit";s:4:"2302";s:20:"paymentmethod_delete";s:4:"2303";s:14:"companysetting";s:4:"2400";}', 0, '2017-02-15 15:32:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE IF NOT EXISTS `shipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `packed_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`id`, `order_no`, `trans_type`, `comments`, `status`, `packed_date`, `delivery_date`, `created_at`, `updated_at`) VALUES
(1, 5, 301, '', 0, '2017-02-16', '0000-00-00', NULL, NULL),
(2, 5, 301, '', 1, '2017-02-16', '2017-02-16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_details`
--

CREATE TABLE IF NOT EXISTS `shipment_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `discount_percent` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `shipment_details`
--

INSERT INTO `shipment_details` (`id`, `shipment_id`, `order_no`, `stock_id`, `tax_type_id`, `unit_price`, `quantity`, `discount_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'APPLE', 2, 160, 10, 0, NULL, NULL),
(2, 1, 5, 'WALTON', 4, 85, 10, 0, NULL, NULL),
(3, 2, 5, 'APPLE', 2, 160, 10, 0, NULL, NULL),
(4, 2, 5, 'WALTON', 4, 85, 10, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_category`
--

CREATE TABLE IF NOT EXISTS `stock_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dflt_units` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stock_category`
--

INSERT INTO `stock_category` (`category_id`, `description`, `dflt_units`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Default', 1, 0, '2017-02-15 15:32:17', '2017-02-15 15:34:23'),
(2, 'Hardware', 1, 0, '2017-02-15 16:23:58', NULL),
(3, 'Health & Beauty', 1, 0, '2017-02-15 16:24:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_master`
--

CREATE TABLE IF NOT EXISTS `stock_master` (
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_master`
--

INSERT INTO `stock_master` (`stock_id`, `category_id`, `tax_type_id`, `description`, `long_description`, `units`, `inactive`, `deleted_status`, `created_at`, `updated_at`) VALUES
('APPLE', 1, 2, 'Iphone 7+', '', 'Each', 0, 0, NULL, '2017-02-16 15:11:30'),
('HP', 1, 2, 'HP Pro Book', '', 'Each', 0, 0, NULL, '2017-02-16 15:11:12'),
('LENEVO', 1, 2, 'LED TV', '', 'Each', 0, 0, NULL, '2017-02-16 15:11:45'),
('LG', 1, 2, 'LG Refrigeretor', '', 'Each', 0, 0, NULL, '2017-02-16 15:12:01'),
('SAMSUNG', 1, 2, 'Samsung G7', '', 'Each', 0, 0, NULL, '2017-02-16 15:12:34'),
('SINGER', 1, 2, 'Singer Refrigerator', '', 'Each', 0, 0, NULL, '2017-02-16 15:12:54'),
('SONY', 1, 2, 'Sony experia 5', '', 'Each', 0, 0, NULL, '2017-02-16 15:13:12'),
('WALTON', 1, 2, 'Walton Primo GH', '', 'Each', 0, 0, NULL, '2017-02-16 15:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `stock_moves`
--

CREATE TABLE IF NOT EXISTS `stock_moves` (
  `trans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85 ;

--
-- Dumping data for table `stock_moves`
--

INSERT INTO `stock_moves` (`trans_id`, `stock_id`, `order_no`, `trans_type`, `loc_code`, `tran_date`, `person_id`, `order_reference`, `reference`, `transaction_reference_id`, `transfer_id`, `note`, `qty`, `price`) VALUES
(41, 'APPLE', 0, 102, 'PL', '2017-01-02', 1, '', 'store_in_10', 10, NULL, '', 1000, 100),
(42, 'HP', 0, 102, 'PL', '2017-01-02', 1, '', 'store_in_10', 10, NULL, '', 1000, 80),
(43, 'SAMSUNG', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_11', 11, NULL, '', 1000, 50),
(44, 'SONY', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_11', 11, NULL, '', 1000, 50),
(45, 'SINGER', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_11', 11, NULL, '', 1000, 50),
(46, 'LG', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_11', 11, NULL, '', 1000, 50),
(47, 'LENEVO', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_11', 11, NULL, '', 1000, 50),
(48, 'APPLE', 0, 102, 'JA', '2017-02-09', 1, '', 'store_in_12', 12, NULL, '', 1000, 100),
(49, 'WALTON', 0, 102, 'JA', '2017-02-09', 1, '', 'store_in_12', 12, NULL, '', 1000, 50),
(50, 'SONY', 0, 102, 'JA', '2016-01-01', 1, '', 'store_in_13', 13, NULL, '', 1000, 50),
(51, 'SINGER', 0, 102, 'JA', '2016-01-01', 1, '', 'store_in_13', 13, NULL, '', 1000, 50),
(52, 'SAMSUNG', 0, 102, 'JA', '2016-01-01', 1, '', 'store_in_13', 13, NULL, '', 1000, 50),
(53, 'WALTON', 0, 102, 'JA', '2016-01-01', 1, '', 'store_in_13', 13, NULL, '', 1000, 50),
(54, 'SINGER', 0, 102, 'JA', '2017-02-16', 1, '', 'store_in_14', 14, NULL, '', 1000, 50),
(55, 'LG', 0, 102, 'JA', '2017-02-16', 1, '', 'store_in_14', 14, NULL, '', 1000, 50),
(58, 'WALTON', 0, 102, 'JA', '2017-02-16', 1, '', 'store_in_15', 15, NULL, '', 1000, 50000),
(63, 'APPLE', 0, 401, 'JA', '2017-02-15', 1, '', 'moved_from_PL', 2, 2, '', 100, 0),
(64, 'APPLE', 0, 402, 'PL', '2017-02-15', 1, '', 'moved_in_JA', 2, NULL, '', -100, 0),
(65, 'SAMSUNG', 0, 401, 'PL', '2017-02-16', 1, '', 'moved_from_JA', 3, 3, '', 100, 0),
(66, 'SAMSUNG', 0, 402, 'JA', '2017-02-16', 1, '', 'moved_in_PL', 3, NULL, '', -100, 0),
(71, 'APPLE', 1, 202, 'PL', '2017-01-18', 1, 'SO-0001', 'store_out_2', 2, NULL, '', -10, 160),
(72, 'SAMSUNG', 3, 202, 'PL', '2017-01-23', 1, 'SO-0002', 'store_out_4', 4, NULL, '', -100, 90),
(73, 'WALTON', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_16', 16, NULL, '', 3000, 50),
(74, 'APPLE', 0, 102, 'PL', '2017-02-16', 1, '', 'store_in_16', 16, NULL, '', 3000, 100),
(75, 'APPLE', 5, 202, 'PL', '2017-01-28', 1, 'SO-0003', 'store_out_6', 6, NULL, '', -20, 160),
(76, 'WALTON', 5, 202, 'PL', '2017-01-28', 1, 'SO-0003', 'store_out_6', 6, NULL, '', -20, 85),
(77, 'APPLE', 5, 202, 'PL', '2017-02-04', 1, 'SO-0003', 'store_out_7', 7, NULL, '', -50, 160),
(78, 'WALTON', 5, 202, 'PL', '2017-02-04', 1, 'SO-0003', 'store_out_7', 7, NULL, '', -50, 85),
(79, 'APPLE', 5, 202, 'PL', '2017-02-10', 1, 'SO-0003', 'store_out_8', 8, NULL, '', -5, 160),
(80, 'WALTON', 5, 202, 'PL', '2017-02-10', 1, 'SO-0003', 'store_out_8', 8, NULL, '', -5, 85),
(81, 'SAMSUNG', 0, 401, 'JA', '2017-02-16', 1, '', 'moved_from_PL', 1, 1, '', 10, 0),
(82, 'SAMSUNG', 0, 402, 'PL', '2017-02-16', 1, '', 'moved_in_JA', 1, NULL, '', -10, 0),
(83, 'WALTON', 0, 401, 'PL', '2017-02-16', 1, '', 'moved_from_JA', 2, 2, '', 10, 0),
(84, 'WALTON', 0, 402, 'JA', '2017-02-16', 1, '', 'moved_in_PL', 2, NULL, '', -10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE IF NOT EXISTS `stock_transfer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `source` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `person_id`, `source`, `destination`, `note`, `qty`, `transfer_date`) VALUES
(1, 1, 'PL', 'JA', '', 10, '2017-02-16'),
(2, 1, 'JA', 'PL', '', 10, '2017-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supp_name`, `email`, `address`, `contact`, `city`, `state`, `zipcode`, `country`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Ina Moran', 'ina.morn@yahoo.com', 'Santa Rosa', '(684) 579-1879', 'Nunc Road', 'Lebanon', 'KY 69409', 'Lebanon', 0, NULL, NULL),
(2, 'Hedy Greene', 'hedy@yahoo.com', 'Ap #696-3279 Viverra. Avenue', '(608) 265-2215', 'Latrobe', 'Lebanon', 'DE 38100', 'Lebanon', 0, NULL, NULL),
(3, 'Melvin Porter', 'melvin@gmail.com', 'Curabitur Rd.', '(959) 119-8364', 'Bandera', 'South Dakota', '45149', 'USA', 0, NULL, NULL),
(4, 'Celeste Slater', 'celeste@yahoo.com', 'Ullamcorper. Street', '(786) 713-8616', 'Roseville', 'New york', 'NH 11523', 'United States', 0, NULL, NULL),
(5, 'Theodore Lowe', 'lowe@yahoo.com', 'Ap #867-859 Sit Rd.', '(793) 151-6230', 'Azusa', 'New York', '39531', 'United States', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `password`, `real_name`, `role_id`, `phone`, `email`, `picture`, `inactive`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '', '$2y$10$NFl9z/cbBkX8q41bIkZbm.32OT/Ogp2fYKIZXifzgm2M6n1oG5/0C', 'ADMIN', 1, '', 'admin@techvill.net', '', 0, 'IrFMIppmlerbc80Lga6618NNYD890VdeI8xcfxyll9ZpXT7AXK9Xygcl1Ftf', '2017-02-15 15:32:33', '2017-02-16 14:50:40');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
