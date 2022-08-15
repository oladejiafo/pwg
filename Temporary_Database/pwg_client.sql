-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 15, 2022 at 01:40 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwg_client`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

DROP TABLE IF EXISTS `applicants`;
CREATE TABLE IF NOT EXISTS `applicants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `place_birth` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_birth` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citizenship` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_dete_issue` date DEFAULT NULL,
  `passport_date_expiry` date DEFAULT NULL,
  `issued_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addess_1` text COLLATE utf8mb4_unicode_ci,
  `address_2` text COLLATE utf8mb4_unicode_ci,
  `current_residance_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_residance_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residence_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_validity` date DEFAULT NULL,
  `visa_copy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_street_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer_phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_schengen_visa_issued` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'is schengen visa issued in past 5 years',
  `is_fingerprint_collected` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'is fingerprint collected for schengen visa application',
  `applicant_status` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicants_user_id_foreign` (`user_id`),
  KEY `applicants_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `user_id`, `first_name`, `middle_name`, `surname`, `country`, `job_type`, `resume`, `agent_phone_number`, `agent_name`, `referral_first_name`, `referral_last_name`, `coupon_code`, `dob`, `place_birth`, `country_birth`, `citizenship`, `sex`, `civil_status`, `passport_number`, `passport_dete_issue`, `passport_date_expiry`, `issued_by`, `passport`, `phone_number`, `home_country`, `state`, `city`, `postal_code`, `addess_1`, `address_2`, `current_residance_country`, `current_residance_mobile`, `residence_id`, `id_validity`, `visa_copy`, `work_state`, `work_city`, `work_postal_code`, `work_street_number`, `company_name`, `employer_phone_number`, `employer_email`, `is_schengen_visa_issued`, `is_fingerprint_collected`, `applicant_status`, `deleted_at`, `created_at`, `updated_at`, `product_id`) VALUES
(43, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-12 05:49:02', '2022-08-12 05:49:02', 1),
(42, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Belgium', NULL, NULL, NULL, NULL, NULL, 'Barbados', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-12 03:18:12', '2022-08-12 03:18:12', 1),
(41, 2, 'Oladeji Afo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-11 06:56:25', '2022-08-11 06:56:25', 1),
(40, 2, 'Oladeji Afo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-11 05:39:58', '2022-08-11 05:39:58', 1),
(39, 2, 'Oladeji Afo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-11 05:19:14', '2022-08-11 05:19:14', 1),
(16, 2, 'Oladeji', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tester', 'tester', '54455445', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-05 09:59:29', '2022-08-05 09:59:29', 1),
(37, 2, 'Oladeji Afo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-11 04:18:49', '2022-08-11 04:18:49', 1),
(38, 2, 'Oladeji Afo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-11 04:43:40', '2022-08-11 04:43:40', 1),
(44, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Benin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-15 05:08:29', '2022-08-15 05:08:29', 1),
(45, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-15 07:17:45', '2022-08-15 07:17:45', 1),
(46, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-15 09:12:26', '2022-08-15 09:12:26', 1),
(47, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, NULL, 'United Arab Emirates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-15 09:16:07', '2022-08-15 09:16:07', 1),
(48, 2, 'Oladejii', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Bhutan', NULL, NULL, NULL, NULL, NULL, 'Bhutan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2022-08-15 09:28:48', '2022-08-15 09:28:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2014_10_12_000000_create_users_table', 1),
(22, '2014_10_12_100000_create_password_resets_table', 1),
(23, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(24, '2019_08_19_000000_create_failed_jobs_table', 1),
(25, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(26, '2022_08_01_025424_create_sessions_table', 1),
(27, '2022_08_01_062220_create_applicants_table', 1),
(28, '2022_08_01_071758_create_products_table', 1),
(29, '2022_08_01_075348_create_orders_table', 1),
(30, '2022_08_01_080932_create_payments_table', 1),
(31, '2022_08_02_130424_update_products_table_one', 1),
(32, '2022_08_02_130503_create_product_details_table', 1),
(33, '2022_08_02_130520_create_product_items_table', 1),
(34, '2022_08_03_100234_create_product_payments_table', 1),
(35, '2022_08_04_061852_update_users_table_1', 2),
(36, '2022_08_05_053120_update_payments_table_1', 3),
(37, '2022_08_05_054838_update_payments_table_2', 3),
(38, '2022_08_05_060647_update_applicants_table_1', 4),
(39, '2022_08_05_062444_drop_orders_table', 4),
(40, '2022_08_08_115402_update_users_table_2', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `card_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_holder_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `cvv` int(11) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_payment_id` bigint(20) UNSIGNED NOT NULL,
  `card_type` tinyint(4) NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_number_foreign` (`application_id`),
  KEY `payments_product_payment_id_foreign` (`product_payment_id`),
  KEY `payments_applicant_id_foreign` (`applicant_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `application_id`, `card_number`, `card_holder_name`, `month`, `year`, `cvv`, `total`, `currency_code`, `payment_status`, `transaction_id`, `deleted_at`, `created_at`, `updated_at`, `product_payment_id`, `card_type`, `applicant_id`) VALUES
(1, 16, '', '', 0, 0000, 0, '0.00', NULL, 'Paid', NULL, NULL, NULL, NULL, 1, 0, 16);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `discount` int(11) NOT NULL,
  `currency` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AED',
  `benefits` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `slogan`, `description`, `unit_price`, `discount`, `currency`, `benefits`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Poland', 'Your Dream Home', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad. Poland, officially the Republic of Poland, is a country in Central Europe. It is divided into 16 administrative provinces called voivodeships, covering an area of 312,696 km². Poland has a population of over 38 million and is the fifth-most populous member state of the European Union', '4789.00', 35, 'AED', 'In Poland, working hours are 40 hours a week and 8 hours a day. - Overtime cannot be more than 48 hours a week or 150 hours a year. - When an employee has been working for less than 10 years, they are entitled to 26 days of annual leave. - The bare minimum wage The current minimum wage in Poland is 2,600 PLN. - Imposition of taxes 17 percent, up to $85,528 in annual profits  32 percent, annual salary of more than 85,528 dollars', 'v1_17064.png', NULL, NULL, NULL),
(2, 'Canada', 'Your dream destination', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad', '9975.00', 10, 'AED', '', 'v1_17105.png', NULL, NULL, NULL),
(3, 'Germany', 'Your Dream Home', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad', '15758.00', 2, 'AED', '', 'v1_17079.png', NULL, NULL, NULL),
(4, 'CZECH', 'Your Dream Home', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad', '7875.00', 5, 'AED', '', 'v1_17030.png', NULL, NULL, NULL),
(5, 'UK', 'Your Dream Home', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad', '10499.00', 0, 'AED', '', 'v1_16990.png', NULL, NULL, NULL),
(6, 'Malta', '', 'One of the the most destination prefered by many when in search of migrating and looking for work abroad', '10499.00', 0, 'AED', '', 'v1_16990.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

DROP TABLE IF EXISTS `product_details`;
CREATE TABLE IF NOT EXISTS `product_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_details_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `job_title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'House Keeping', 'Housekeepers are responsible for cleaning and reporting any safety hazards to the homeowner or manager in charge. They must complete tasks like vacuuming, sweeping, emptying trash cans, dusting shelves, cleaning windows, and mopping floors.', NULL, NULL),
(2, 1, 'Teacher', 'A Teacher is a professional who teaches students based on national curriculum guidelines within their specialist subject areas. ', NULL, NULL),
(3, 2, 'Doctor', 'ggfhgjkgkkj\r\nghgjkgkghjkghjjkggkjhgk\r\nfjhgjgkjhjkjhkhjkhkhkhkhkhkhk\r\n', NULL, NULL),
(4, 1, 'Plumber', 'Primary Purpose: Under general supervision, maintain the flow and drainage of water, air, and other gases by assembling, installing, and repairing pipes, fittings, and plumbing fixtures districtwide.', NULL, NULL),
(5, 1, 'Butcher', 'Butchers cut and trim meat from larger, wholesale portions into steaks, chops, roasts, and other cuts. They then prepare meat for sale by performing various duties, such as weighing meat, wrapping it, and putting it out for display.', NULL, NULL),
(6, 1, 'Data Analyst', 'Data analysts gather and scrutinise data using specialist tools to generate information that helps others make decisions. They will respond to questions about data and look for trends, patterns and anomalies within it.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

DROP TABLE IF EXISTS `product_items`;
CREATE TABLE IF NOT EXISTS `product_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `item` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_payments`
--

DROP TABLE IF EXISTS `product_payments`;
CREATE TABLE IF NOT EXISTS `product_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_payments_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_payments`
--

INSERT INTO `product_payments` (`id`, `product_id`, `payment`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'First Payment', '1500.00', 0, NULL, NULL),
(2, 1, 'Second Payment', '2000.00', 0, NULL, NULL),
(3, 1, 'Final Payment', '1289.00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('oWUZVqVMUT2UM63xJz323zkZMY3FelTcJr0RJdsq', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGFxUHhHbjVNM1NJcjZTUUpNd05mNWRVNnlkY040SUtwbGhPdFR6SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wYXltZW50P3BpZD0xIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1660570140);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone_number`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `signature`, `otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Oladejii', 'dejigegs@gmail.com', NULL, '0503890996', '$2y$10$5HFDHm/1/Dl2rtejFWjVneVEff0eA9YsiW2Ye2lCn8.47YpoPb2IG', '', NULL, '1660570137.png', NULL, NULL, '2022-08-04 07:53:06', '2022-08-15 09:28:57'),
(3, 'Victor', 'ade@gmail.com', NULL, '90989999', '$2y$10$SIC6cTPKg/v2QcnO6ljIceBNcxqWnemLtlRgzGw1SWMSxPeK2K5la', NULL, NULL, NULL, NULL, NULL, '2022-08-11 04:37:33', '2022-08-11 04:37:33');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
