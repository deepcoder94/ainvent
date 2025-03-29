-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2025 at 02:09 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u265375724_ainvent`
--

-- --------------------------------------------------------

--
-- Table structure for table `hi_beats`
--

CREATE TABLE `hi_beats` (
  `id` int(11) NOT NULL,
  `beat_name` varchar(100) NOT NULL,
  `beat_address` varchar(100) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_beats`
--

INSERT INTO `hi_beats` (`id`, `beat_name`, `beat_address`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Paulpara', 'Paulpara', 1, '2025-03-12 06:19:47', '2025-03-12 06:19:47', NULL),
(2, 'Bag Bazar', 'Bou Bazar', 1, '2025-03-14 03:55:27', '2025-03-14 03:55:27', NULL),
(3, 'Kharua Bazar', 'A', 1, '2025-03-14 03:59:31', '2025-03-14 03:59:31', NULL),
(4, 'Bou Bazar', 'A', 1, '2025-03-14 03:59:39', '2025-03-14 03:59:39', NULL),
(5, 'HathKhola', 'Station road', 1, '2025-03-14 03:59:49', '2025-03-14 03:59:49', NULL),
(6, 'Lakhi Ganj Bazar', 'Station road', 1, '2025-03-14 03:59:57', '2025-03-14 03:59:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_cache`
--

CREATE TABLE `hi_cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_cache_locks`
--

CREATE TABLE `hi_cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_customers`
--

CREATE TABLE `hi_customers` (
  `id` int(11) NOT NULL,
  `beat_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` varchar(100) NOT NULL,
  `customer_gst` varchar(100) NOT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_customers`
--

INSERT INTO `hi_customers` (`id`, `beat_id`, `customer_name`, `customer_address`, `customer_gst`, `customer_phone`, `created_at`, `updated_at`, `is_active`, `deleted_at`) VALUES
(1, 1, 'Aritra Deb', 'C.M.Street,Patrapara,Bhadreswar,Hooghly,WestBengal.', '09038477792', '9038477792', '2025-03-12 16:57:50', '2025-03-12 16:57:50', 1, NULL),
(2, 1, 'Ajoy Deb', '47/1 Dr C.C.C Road,Bhadreswar,Hooghly', '09681383258', 'rthrn', '2025-03-14 06:50:05', '2025-03-14 06:50:05', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_customer_payments`
--

CREATE TABLE `hi_customer_payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_total` float NOT NULL,
  `total_due` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_customer_payments`
--

INSERT INTO `hi_customer_payments` (`id`, `customer_id`, `invoice_id`, `invoice_total`, `total_due`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 2, 11, 0, 2000, '2025-03-16 16:50:07', '2025-03-22 11:54:17', NULL),
(6, 1, 12, 0, 1270, '2025-03-16 16:50:30', '2025-03-22 12:39:36', NULL),
(7, 1, 13, 0, 3100, '2025-03-16 16:50:51', '2025-03-17 01:57:51', NULL),
(8, 1, 14, 0, 4560, '2025-03-20 07:11:43', '2025-03-22 12:40:02', NULL),
(9, 1, 15, 0, 1728, '2025-03-22 10:24:56', '2025-03-22 12:56:06', NULL),
(10, 2, 16, 0, 3300, '2025-03-22 10:25:17', '2025-03-22 12:38:30', NULL),
(11, 2, 17, 0, 2000, '2025-03-22 10:35:41', '2025-03-22 12:33:40', NULL),
(12, 1, 18, 0, 4000, '2025-03-22 12:20:56', '2025-03-22 12:25:22', NULL),
(13, 1, 19, 0, 4000, '2025-03-22 12:21:51', '2025-03-22 12:25:02', NULL),
(15, 1, 21, 150, 150, '2025-03-22 15:07:07', '2025-03-22 15:07:07', NULL),
(16, 2, 22, 150, 150, '2025-03-22 15:07:30', '2025-03-22 15:07:30', NULL),
(17, 1, 23, 150, 150, '2025-03-22 15:07:51', '2025-03-22 15:07:51', NULL),
(18, 1, 25, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(19, 1, 26, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(20, 1, 24, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(21, 1, 27, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(22, 1, 28, 2640, 2640, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(23, 1, 29, 2640, 2640, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(24, 1, 30, 2640, 2640, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(25, 1, 31, 80, 80, '2025-03-25 06:41:59', '2025-03-25 06:41:59', NULL),
(26, 1, 32, 2560, 2560, '2025-03-26 15:07:48', '2025-03-26 15:07:48', NULL),
(27, 2, 33, 2560, 2560, '2025-03-27 02:12:30', '2025-03-27 02:12:30', NULL),
(28, 2, 34, 1872, 1872, '2025-03-27 02:18:01', '2025-03-27 02:18:01', NULL),
(29, 1, 35, 6258, 6258, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(30, 2, 36, 5500, 5500, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(31, 1, 37, 3356, 3356, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(32, 2, 38, 17675, 17675, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(33, 1, 39, 2640, 2640, '2025-03-28 02:07:28', '2025-03-28 02:07:28', NULL),
(34, 1, 40, 2560, 2560, '2025-03-28 02:15:40', '2025-03-28 02:15:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_distributors`
--

CREATE TABLE `hi_distributors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `gst_number` varchar(200) NOT NULL,
  `phone_number` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_distributors`
--

INSERT INTO `hi_distributors` (`id`, `name`, `address`, `gst_number`, `phone_number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Deb Enterprise', '47/1 Dr C.C.C Road,Bhadreswar,Hooghly', '19GDKPD1370P1Z1', '9831747136   /   9836765591', '2025-03-11 03:24:55', '2025-03-16 16:33:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_failed_jobs`
--

CREATE TABLE `hi_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_gst_invoices`
--

CREATE TABLE `hi_gst_invoices` (
  `id` int(11) NOT NULL,
  `supplier_details` text DEFAULT NULL,
  `receipent_details` text DEFAULT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `gst_breakup` text DEFAULT NULL,
  `taxable_amount` float NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `other_charges` float NOT NULL DEFAULT 0,
  `round_off_amount` float NOT NULL DEFAULT 0,
  `total_invoice_amount` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_gst_invoices`
--

INSERT INTO `hi_gst_invoices` (`id`, `supplier_details`, `receipent_details`, `invoice_number`, `invoice_date`, `gst_breakup`, `taxable_amount`, `discount`, `other_charges`, `round_off_amount`, `total_invoice_amount`, `created_at`, `deleted_at`, `updated_at`) VALUES
(1, '{\"supplier_name\":\"test\",\"supplier_gstin\":\"test\",\"supplier_address\":\"tedt\",\"supplier_phone\":\"tete\"}', '{\"recepent_name\":\"test\",\"recepent_gstin\":\"teste\",\"recepent_address\":\"este\",\"recepent_phone\":\"testass\"}', 'INV-12', '23-03-2025', '{\"gst_cgst\":\"150.28\",\"gst_sgst\":\"150.28\",\"gst_igst\":\"0.00\",\"gst_cess\":\"0.00\",\"gst_state_cess\":\"0.00\"}', 6011.28, 0, 0, 0.223, 6312.07, '2025-03-23 01:28:57', NULL, '2025-03-23 01:28:57'),
(2, '{\"supplier_name\":\"Aritra Deb\",\"supplier_gstin\":null,\"supplier_address\":\"C.M.Street,Patrapara,Bhadreswar,Hooghly,WestBengal.\",\"supplier_phone\":\"09038477792\"}', '{\"recepent_name\":\"Ajoy Deb\",\"recepent_gstin\":null,\"recepent_address\":\"47\\/1 Dr C.C.C Road,Bhadreswar,Hooghly\",\"recepent_phone\":\"09681383258\"}', 'inv-13', '19-03-2025', '{\"gst_cgst\":\"37.50\",\"gst_sgst\":\"37.50\",\"gst_igst\":\"0.00\",\"gst_cess\":\"0.00\",\"gst_state_cess\":\"0.00\"}', 1500, 0, 0, 25, 1600, '2025-03-23 10:27:04', NULL, '2025-03-23 10:27:04'),
(3, '{\"supplier_name\":\"Aritra Deb\",\"supplier_gstin\":null,\"supplier_address\":\"C.M.Street,Patrapara,Bhadreswar,Hooghly,WestBengal.\",\"supplier_phone\":\"09038477792\"}', '{\"recepent_name\":\"Ajoy Deb\",\"recepent_gstin\":null,\"recepent_address\":\"47\\/1 Dr C.C.C Road,Bhadreswar,Hooghly\",\"recepent_phone\":\"09681383258\"}', 'inv-13', '19-03-2025', '{\"gst_cgst\":\"37.50\",\"gst_sgst\":\"37.50\",\"gst_igst\":\"0.00\",\"gst_cess\":\"0.00\",\"gst_state_cess\":\"0.00\"}', 1500, 0, 0, 25, 1600, '2025-03-23 10:27:08', NULL, '2025-03-23 10:27:08'),
(4, '{\"supplier_name\":\"test\",\"supplier_gstin\":\"test\",\"supplier_address\":\"test\",\"supplier_phone\":\"test\"}', '{\"recepent_name\":\"test\",\"recepent_gstin\":\"yegdbh\",\"recepent_address\":\"hzhshhs\",\"recepent_phone\":\"hhdjsn\"}', 'Inv-6', '25-03-2025', '{\"gst_cgst\":\"211.88\",\"gst_sgst\":\"211.88\",\"gst_igst\":\"0.00\",\"gst_cess\":\"0.00\",\"gst_state_cess\":\"0.00\"}', 8475, 0, 0, 0, 8898.75, '2025-03-25 14:42:47', NULL, '2025-03-25 14:42:47'),
(5, '{\"supplier_name\":\"TEst\",\"supplier_gstin\":\"teste\",\"supplier_address\":\"test\",\"supplier_phone\":\"172868678612\"}', '{\"recepent_name\":\"test\",\"recepent_gstin\":\"test\",\"recepent_address\":\"test\",\"recepent_phone\":\"89162816887\"}', 'TEST-12', '25-03-2025', '{\"gst_cgst\":\"27.25\",\"gst_sgst\":\"27.25\",\"gst_igst\":\"0.00\",\"gst_cess\":\"0.00\",\"gst_state_cess\":\"0.00\"}', 1090, 0, 0, 0, 1144.5, '2025-03-25 17:29:38', NULL, '2025-03-25 17:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `hi_gst_invoice_products`
--

CREATE TABLE `hi_gst_invoice_products` (
  `id` int(11) NOT NULL,
  `gst_invoice_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `hsn_code` varchar(100) NOT NULL,
  `quantity` float NOT NULL,
  `unit_price` float NOT NULL,
  `buying_price` float NOT NULL DEFAULT 0,
  `taxable_amount` float NOT NULL,
  `gst_breakup` text DEFAULT NULL,
  `other_charges` float NOT NULL,
  `total` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_gst_invoice_products`
--

INSERT INTO `hi_gst_invoice_products` (`id`, `gst_invoice_id`, `product_name`, `hsn_code`, `quantity`, `unit_price`, `buying_price`, `taxable_amount`, `gst_breakup`, `other_charges`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'KGMO 500 ml (24x500) Pouch', '1234232', 22, 273.24, 250, 6011.28, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 6311.84, '2025-03-23 01:28:57', '2025-03-23 01:28:57', NULL),
(2, 2, 'KGMO 1 Ltr (16x1) Pouch', '115415', 10, 150, 100, 1500, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 1575, '2025-03-23 10:27:04', '2025-03-23 10:27:04', NULL),
(3, 3, 'KGMO 1 Ltr (16x1) Pouch', '115415', 10, 150, 100, 1500, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 1575, '2025-03-23 10:27:08', '2025-03-23 10:27:08', NULL),
(4, 4, 'KGMO 1 Ltr (16x1) Pouch', '115415', 5, 155, 120, 775, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 813.75, '2025-03-25 14:42:47', '2025-03-25 14:42:47', NULL),
(5, 4, 'KGMO 500 ml (24x500) Pouch', 'bbsn', 100, 77, 69, 7700, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 8085, '2025-03-25 14:42:47', '2025-03-25 14:42:47', NULL),
(6, 5, 'KGMO 1 Ltr (12x1) Bottle', 'hafshgd', 3, 158, 129, 474, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 497.7, '2025-03-25 17:29:38', '2025-03-25 17:29:38', NULL),
(7, 5, 'KGMO 500 ml (24x500) Pouch', 'asdas', 8, 77, 75, 616, '{\"gst_rate\":\"5.00\",\"cess_rate\":\"0.00\",\"state_cess_rate\":\"0.00\",\"non_advol_rate\":\"0.00\"}', 0, 646.8, '2025-03-25 17:29:38', '2025-03-25 17:29:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_inventory`
--

CREATE TABLE `hi_inventory` (
  `id` int(11) NOT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `buying_price` varchar(200) NOT NULL,
  `total_stock` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_inventory`
--

INSERT INTO `hi_inventory` (`id`, `item_code`, `product_id`, `buying_price`, `total_stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IN-1', 1, '154.984', 1217, '2025-03-13 05:30:51', '2025-03-28 02:15:40', NULL),
(2, 'IN-2', 2, '75', 11, '2025-03-13 05:31:00', '2025-03-27 03:44:37', NULL),
(3, 'IN-3', 7, '700', 91, '2025-03-14 05:55:31', '2025-03-27 05:24:42', NULL),
(4, 'IN-4', 6, '8', 1599, '2025-03-14 05:55:49', '2025-03-14 07:02:36', NULL),
(5, 'IN-5', 5, '32', 1799, '2025-03-14 05:56:28', '2025-03-14 07:02:36', NULL),
(6, 'IN-6', 4, '71', 401, '2025-03-14 05:57:44', '2025-03-27 05:24:42', NULL),
(7, 'IN-7', 3, '155', 318, '2025-03-14 05:57:57', '2025-03-27 03:39:23', NULL),
(8, 'IN-8', 8, '134.174', 720, '2025-03-14 06:36:04', '2025-03-22 10:37:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_inventory_history`
--

CREATE TABLE `hi_inventory_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `measurement_id` int(11) NOT NULL,
  `stock_out_in` float NOT NULL,
  `stock_action` varchar(50) DEFAULT NULL,
  `buying_price` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_inventory_history`
--

INSERT INTO `hi_inventory_history` (`id`, `product_id`, `measurement_id`, `stock_out_in`, `stock_action`, `buying_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 10, 'add', 150, '2025-03-13 05:30:51', '2025-03-13 05:30:51', NULL),
(2, 2, 3, 10, 'add', 140, '2025-03-13 05:31:00', '2025-03-13 05:31:00', NULL),
(3, 1, 1, 10, 'deduct', 0, '2025-03-13 05:32:10', '2025-03-13 05:32:10', NULL),
(4, 1, 2, 16, 'deduct', 0, '2025-03-13 05:32:25', '2025-03-13 05:32:25', NULL),
(5, 1, 2, 80, 'deduct', 0, '2025-03-13 11:40:39', '2025-03-13 11:40:39', NULL),
(6, 1, 2, 16, 'deduct', 0, '2025-03-14 04:03:17', '2025-03-14 04:03:17', NULL),
(7, 7, 1, 100, 'add', 700, '2025-03-14 05:55:31', '2025-03-14 05:55:31', NULL),
(8, 6, 5, 10, 'add', 8, '2025-03-14 05:55:49', '2025-03-14 05:55:49', NULL),
(9, 5, 6, 20, 'add', 30, '2025-03-14 05:56:28', '2025-03-14 05:56:28', NULL),
(10, 5, 6, 10, 'add', 32, '2025-03-14 05:56:44', '2025-03-14 05:56:44', NULL),
(11, 4, 4, 20, 'add', 71, '2025-03-14 05:57:44', '2025-03-14 05:57:44', NULL),
(12, 3, 3, 30, 'add', 155, '2025-03-14 05:57:57', '2025-03-14 05:57:57', NULL),
(13, 2, 4, 5, 'add', 75, '2025-03-14 05:59:30', '2025-03-14 05:59:30', NULL),
(14, 8, 3, 50, 'add', 135, '2025-03-14 06:36:04', '2025-03-14 06:36:04', NULL),
(15, 1, 2, 16, 'deduct', 0, '2025-03-14 06:48:20', '2025-03-14 06:48:20', NULL),
(16, 7, 1, 1, 'deduct', 0, '2025-03-14 06:48:20', '2025-03-14 06:48:20', NULL),
(17, 4, 4, 24, 'deduct', 0, '2025-03-14 06:50:34', '2025-03-14 06:50:34', NULL),
(18, 4, 1, 6, 'return', 0, '2025-03-14 06:54:04', '2025-03-14 06:54:04', NULL),
(19, 1, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(20, 2, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(21, 3, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(22, 4, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(23, 5, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(24, 6, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(25, 7, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(26, 8, 1, 1, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(27, 7, 1, 2, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(28, 3, 1, 3, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(29, 4, 1, 4, 'deduct', 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(30, 2, 1, 10, 'deduct', 0, '2025-03-14 07:07:41', '2025-03-14 07:07:41', NULL),
(31, 1, 2, 16, 'deduct', 0, '2025-03-16 06:44:52', '2025-03-16 06:44:52', NULL),
(32, 1, 2, 100, 'add', 154.984, '2025-03-16 16:36:11', '2025-03-16 16:36:11', NULL),
(33, 1, 1, 1, 'deduct', 0, '2025-03-16 16:49:42', '2025-03-16 16:49:42', NULL),
(34, 2, 1, 10, 'deduct', 0, '2025-03-16 16:50:07', '2025-03-16 16:50:07', NULL),
(35, 4, 1, 11, 'deduct', 0, '2025-03-16 16:50:30', '2025-03-16 16:50:30', NULL),
(36, 3, 1, 10, 'deduct', 0, '2025-03-16 16:50:51', '2025-03-16 16:50:51', NULL),
(37, 3, 1, 5, 'return', 0, '2025-03-17 01:39:02', '2025-03-17 01:39:02', NULL),
(38, 3, 1, 2, 'return', 0, '2025-03-17 01:40:57', '2025-03-17 01:40:57', NULL),
(39, 8, 3, 10, 'add', 134.166, '2025-03-20 07:09:34', '2025-03-20 07:09:34', NULL),
(40, 1, 2, 16, 'deduct', 0, '2025-03-20 07:11:43', '2025-03-20 07:11:43', NULL),
(41, 2, 4, 24, 'deduct', 0, '2025-03-22 10:24:56', '2025-03-22 10:24:56', NULL),
(42, 1, 2, 16, 'deduct', 0, '2025-03-22 10:25:17', '2025-03-22 10:25:17', NULL),
(43, 1, 2, 16, 'deduct', 0, '2025-03-22 10:35:41', '2025-03-22 10:35:41', NULL),
(44, 8, 1, 1, 'add', 134.174, '2025-03-22 10:37:45', '2025-03-22 10:37:45', NULL),
(45, 1, 2, 16, 'deduct', 0, '2025-03-22 12:20:56', '2025-03-22 12:20:56', NULL),
(46, 1, 2, 16, 'deduct', 0, '2025-03-22 12:21:51', '2025-03-22 12:21:51', NULL),
(47, 1, 2, 16, 'deduct', 0, '2025-03-22 14:28:08', '2025-03-22 14:28:08', NULL),
(48, 1, 1, 10, 'deduct', 0, '2025-03-22 14:38:33', '2025-03-22 14:38:33', NULL),
(49, 1, 1, 10, 'deduct', 0, '2025-03-22 14:42:49', '2025-03-22 14:42:49', NULL),
(50, 1, 1, 1, 'deduct', 0, '2025-03-22 14:44:08', '2025-03-22 14:44:08', NULL),
(51, 1, 1, 1, 'deduct', 0, '2025-03-22 15:07:07', '2025-03-22 15:07:07', NULL),
(52, 1, 1, 1, 'deduct', 0, '2025-03-22 15:07:30', '2025-03-22 15:07:30', NULL),
(53, 1, 1, 1, 'deduct', 0, '2025-03-22 15:07:51', '2025-03-22 15:07:51', NULL),
(54, 1, 1, 10, 'deduct', 0, '2025-03-23 10:27:04', '2025-03-23 10:27:04', NULL),
(55, 1, 1, 10, 'deduct', 0, '2025-03-23 10:27:08', '2025-03-23 10:27:08', NULL),
(56, 1, 1, 1, 'return', 0, '2025-03-23 11:00:59', '2025-03-23 11:00:59', NULL),
(57, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(58, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(59, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(60, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(61, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(62, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(63, 1, 2, 16, 'deduct', 0, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(64, 2, 1, 1, 'deduct', 0, '2025-03-25 06:41:59', '2025-03-25 06:41:59', NULL),
(65, 1, 1, 5, 'deduct', 0, '2025-03-25 14:42:47', '2025-03-25 14:42:47', NULL),
(66, 2, 1, 100, 'deduct', 0, '2025-03-25 14:42:47', '2025-03-25 14:42:47', NULL),
(67, 3, 1, 3, 'deduct', 0, '2025-03-25 17:29:38', '2025-03-25 17:29:38', NULL),
(68, 2, 1, 8, 'deduct', 0, '2025-03-25 17:29:38', '2025-03-25 17:29:38', NULL),
(69, 1, 2, 16, 'deduct', 0, '2025-03-26 15:07:48', '2025-03-26 15:07:48', NULL),
(70, 1, 2, 16, 'deduct', 0, '2025-03-27 02:12:28', '2025-03-27 02:12:28', NULL),
(71, 3, 1, 12, 'deduct', 0, '2025-03-27 02:18:01', '2025-03-27 02:18:01', NULL),
(72, 2, 4, 48, 'deduct', 0, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(73, 4, 1, 30, 'deduct', 0, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(74, 2, 1, 23, 'deduct', 0, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(75, 3, 1, 20, 'deduct', 0, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(76, 1, 1, 19, 'deduct', 0, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(77, 2, 1, 4, 'deduct', 0, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(78, 1, 2, 80, 'deduct', 0, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(79, 4, 1, 15, 'deduct', 0, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(80, 7, 1, 5, 'deduct', 0, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(81, 1, 2, 16, 'deduct', 0, '2025-03-28 02:07:26', '2025-03-28 02:07:26', NULL),
(82, 1, 2, 16, 'deduct', 0, '2025-03-28 02:15:40', '2025-03-28 02:15:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_invoices`
--

CREATE TABLE `hi_invoices` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `beat_id` int(11) NOT NULL,
  `invoice_total` float NOT NULL DEFAULT 0,
  `invoice_amount` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_invoices`
--

INSERT INTO `hi_invoices` (`id`, `invoice_number`, `customer_id`, `beat_id`, `invoice_total`, `invoice_amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'INV-1', 1, 1, 0, 0, '2025-03-13 05:32:10', '2025-03-13 05:32:10', NULL),
(2, 'INV-2', 1, 1, 0, 0, '2025-03-13 05:32:25', '2025-03-13 05:32:25', NULL),
(3, 'INV-3', 1, 1, 0, 0, '2025-03-13 11:40:39', '2025-03-13 11:40:39', NULL),
(4, 'INV-4', 1, 1, 0, 0, '2025-03-14 04:03:17', '2025-03-14 04:03:17', NULL),
(5, 'INV-5', 1, 1, 0, 0, '2025-03-14 06:48:20', '2025-03-14 06:48:20', NULL),
(6, 'INV-6', 2, 1, 0, 0, '2025-03-14 06:50:34', '2025-03-14 06:50:34', NULL),
(7, 'INV-7', 1, 1, 0, 0, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(8, 'INV-8', 1, 1, 0, 0, '2025-03-14 07:07:41', '2025-03-14 07:07:41', NULL),
(9, 'INV-9', 1, 1, 0, 0, '2025-03-16 06:44:52', '2025-03-16 06:44:52', NULL),
(10, 'INV-10', 1, 1, 0, 0, '2025-03-16 16:49:42', '2025-03-16 16:49:42', NULL),
(11, 'INV-11', 2, 1, 0, 0, '2025-03-16 16:50:07', '2025-03-16 16:50:07', NULL),
(12, 'INV-12', 1, 1, 0, 0, '2025-03-16 16:50:30', '2025-03-16 16:50:30', NULL),
(13, 'INV-13', 1, 1, 0, 0, '2025-03-16 16:50:51', '2025-03-16 16:50:51', NULL),
(14, 'INV-14', 1, 1, 2480, 0, '2025-03-20 07:11:43', '2025-03-20 07:11:43', NULL),
(15, 'INV-15', 1, 1, 1920, 0, '2025-03-22 10:24:56', '2025-03-22 10:24:56', NULL),
(16, 'INV-16', 2, 1, 2400, 0, '2025-03-22 10:25:17', '2025-03-22 10:25:17', NULL),
(17, 'INV-17', 2, 1, 2400, 0, '2025-03-22 10:35:41', '2025-03-22 10:35:41', NULL),
(18, 'INV-18', 1, 1, 2400, 0, '2025-03-22 12:20:56', '2025-03-22 12:20:56', NULL),
(19, 'INV-19', 1, 1, 2400, 0, '2025-03-22 12:21:51', '2025-03-22 12:21:51', NULL),
(20, 'INV-20', 1, 1, 2400, 0, '2025-03-22 14:28:08', '2025-03-22 14:28:08', NULL),
(21, 'INV-21', 1, 1, 150, 0, '2025-03-22 15:07:07', '2025-03-22 15:07:07', NULL),
(22, 'INV-22', 2, 1, 150, 0, '2025-03-22 15:07:30', '2025-03-22 15:07:30', NULL),
(23, 'INV-23', 1, 1, 150, 0, '2025-03-22 15:07:51', '2025-03-22 15:07:51', NULL),
(24, 'INV-24', 1, 1, 2640, 2640, '2025-03-25 06:19:26', '2025-03-25 06:19:32', NULL),
(25, 'INV-25', 1, 1, 2640, 2640, '2025-03-25 06:19:31', '2025-03-25 06:19:32', NULL),
(26, 'INV-26', 1, 1, 2640, 2640, '2025-03-25 06:19:30', '2025-03-25 06:19:32', NULL),
(27, 'INV-27', 1, 1, 2640, 2640, '2025-03-25 06:19:31', '2025-03-25 06:19:32', NULL),
(28, 'INV-28', 1, 1, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:34', NULL),
(29, 'INV-29', 1, 1, 2640, 2640, '2025-03-25 06:19:31', '2025-03-25 06:19:34', NULL),
(30, 'INV-30', 1, 1, 2640, 2640, '2025-03-25 06:19:32', '2025-03-25 06:19:34', NULL),
(31, 'INV-31', 1, 1, 80, 80, '2025-03-25 06:41:59', '2025-03-25 06:41:59', NULL),
(32, 'INV-32', 1, 1, 2560, 2560, '2025-03-26 15:07:46', '2025-03-26 15:07:48', NULL),
(33, 'INV-33', 2, 1, 2560, 2560, '2025-03-27 02:12:24', '2025-03-27 02:12:30', NULL),
(34, 'INV-34', 2, 1, 1872, 1872, '2025-03-27 02:18:01', '2025-03-27 02:18:01', NULL),
(35, 'INV-35', 1, 1, 6258, 6258, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(36, 'INV-36', 2, 1, 5500, 5500, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(37, 'INV-37', 1, 1, 3356, 3356, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(38, 'INV-38', 2, 1, 17675, 17675, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(39, 'INV-39', 1, 1, 2640, 2640, '2025-03-28 02:07:25', '2025-03-28 02:07:28', NULL),
(40, 'INV-40', 1, 1, 2560, 2560, '2025-03-28 02:15:40', '2025-03-28 02:15:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_invoice_products`
--

CREATE TABLE `hi_invoice_products` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `rate` float NOT NULL,
  `buying_price` float NOT NULL DEFAULT 0,
  `measurement_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_invoice_products`
--

INSERT INTO `hi_invoice_products` (`id`, `invoice_id`, `product_id`, `quantity`, `rate`, `buying_price`, `measurement_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 9, 155, 0, 1, '2025-03-13 05:32:10', '2025-03-23 11:00:59', NULL),
(2, 2, 1, 1, 155, 0, 2, '2025-03-13 05:32:25', '2025-03-13 05:32:25', NULL),
(3, 3, 1, 5, 150, 0, 2, '2025-03-13 11:40:39', '2025-03-13 11:40:39', NULL),
(4, 4, 1, 1, 100, 0, 2, '2025-03-14 04:03:17', '2025-03-14 04:03:17', NULL),
(5, 5, 1, 1, 100, 0, 2, '2025-03-14 06:48:20', '2025-03-14 06:48:20', NULL),
(6, 5, 7, 1, 100, 0, 1, '2025-03-14 06:48:20', '2025-03-14 06:48:20', NULL),
(7, 6, 4, 0.75, 10, 0, 4, '2025-03-14 06:50:34', '2025-03-14 06:54:04', NULL),
(8, 7, 1, 1, 10, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(9, 7, 2, 1, 20, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(10, 7, 3, 1, 30, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(11, 7, 4, 1, 40, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(12, 7, 5, 1, 50, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(13, 7, 6, 1, 60, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(14, 7, 7, 1, 70, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(15, 7, 8, 1, 80, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(16, 7, 7, 2, 30, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(17, 7, 3, 3, 40, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(18, 7, 4, 4, 60, 0, 1, '2025-03-14 07:02:36', '2025-03-14 07:02:36', NULL),
(19, 8, 2, 10, 400, 0, 1, '2025-03-14 07:07:41', '2025-03-14 07:07:41', NULL),
(20, 9, 1, 1, 151, 0, 2, '2025-03-16 06:44:52', '2025-03-16 06:44:52', NULL),
(21, 10, 1, 1, 155, 0, 1, '2025-03-16 16:49:42', '2025-03-16 16:49:42', NULL),
(22, 11, 2, 10, 120, 0, 1, '2025-03-16 16:50:07', '2025-03-16 16:50:07', NULL),
(23, 12, 4, 11, 80, 0, 1, '2025-03-16 16:50:30', '2025-03-16 16:50:30', NULL),
(24, 13, 3, 3, 160, 0, 1, '2025-03-16 16:50:51', '2025-03-17 01:40:57', NULL),
(25, 14, 1, 1, 155, 0, 2, '2025-03-20 07:11:43', '2025-03-20 07:11:43', NULL),
(26, 15, 2, 1, 80, 0, 4, '2025-03-22 10:24:56', '2025-03-22 10:24:56', NULL),
(27, 16, 1, 1, 150, 0, 2, '2025-03-22 10:25:17', '2025-03-22 10:25:17', NULL),
(28, 17, 1, 1, 150, 0, 2, '2025-03-22 10:35:41', '2025-03-22 10:35:41', NULL),
(29, 18, 1, 1, 150, 0, 2, '2025-03-22 12:20:56', '2025-03-22 12:20:56', NULL),
(30, 19, 1, 1, 150, 0, 2, '2025-03-22 12:21:51', '2025-03-22 12:21:51', NULL),
(31, 20, 1, 1, 150, 0, 2, '2025-03-22 14:28:08', '2025-03-22 14:28:08', NULL),
(32, 21, 1, 1, 150, 0, 1, '2025-03-22 15:07:07', '2025-03-22 15:07:07', NULL),
(33, 22, 1, 1, 150, 0, 1, '2025-03-22 15:07:30', '2025-03-22 15:07:30', NULL),
(34, 23, 1, 1, 150, 0, 1, '2025-03-22 15:07:51', '2025-03-22 15:07:51', NULL),
(35, 24, 1, 1, 165, 0, 2, '2025-03-25 06:19:28', '2025-03-25 06:19:28', NULL),
(36, 25, 1, 1, 165, 0, 2, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(37, 26, 1, 1, 165, 0, 2, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(38, 27, 1, 1, 165, 0, 2, '2025-03-25 06:19:32', '2025-03-25 06:19:32', NULL),
(39, 29, 1, 1, 165, 0, 2, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(40, 28, 1, 1, 165, 0, 2, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(41, 30, 1, 1, 165, 0, 2, '2025-03-25 06:19:34', '2025-03-25 06:19:34', NULL),
(42, 31, 2, 1, 80, 0, 1, '2025-03-25 06:41:59', '2025-03-25 06:41:59', NULL),
(43, 32, 1, 1, 160, 0, 2, '2025-03-26 15:07:48', '2025-03-26 15:07:48', NULL),
(44, 33, 1, 1, 160, 0, 2, '2025-03-27 02:12:26', '2025-03-27 02:12:26', NULL),
(45, 34, 3, 12, 156, 0, 1, '2025-03-27 02:18:01', '2025-03-27 02:18:01', NULL),
(46, 35, 2, 2, 81, 75, 4, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(47, 35, 4, 30, 79, 71, 1, '2025-03-27 03:33:28', '2025-03-27 03:33:28', NULL),
(48, 36, 2, 23, 100, 75, 1, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(49, 36, 3, 20, 160, 155, 1, '2025-03-27 03:39:23', '2025-03-27 03:39:23', NULL),
(50, 37, 1, 19, 160, 154.984, 1, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(51, 37, 2, 4, 79, 75, 1, '2025-03-27 03:44:37', '2025-03-27 03:44:37', NULL),
(52, 38, 1, 5, 160, 154.984, 2, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(53, 38, 4, 15, 75, 71, 1, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(54, 38, 7, 5, 750, 700, 1, '2025-03-27 05:24:42', '2025-03-27 05:24:42', NULL),
(55, 39, 1, 1, 165, 154.984, 2, '2025-03-28 02:07:26', '2025-03-28 02:07:26', NULL),
(56, 40, 1, 1, 160, 154.984, 2, '2025-03-28 02:15:40', '2025-03-28 02:15:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_jobs`
--

CREATE TABLE `hi_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_job_batches`
--

CREATE TABLE `hi_job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_measurements`
--

CREATE TABLE `hi_measurements` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_measurements`
--

INSERT INTO `hi_measurements` (`id`, `name`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Piece', 1, '2025-03-13 05:28:15', '2025-03-13 05:28:15', NULL),
(2, 'Case 16', 16, '2025-03-13 05:28:27', '2025-03-13 05:28:27', NULL),
(3, 'Case 12', 12, '2025-03-13 05:30:15', '2025-03-13 05:30:15', NULL),
(4, 'Case 24', 24, '2025-03-14 03:52:45', '2025-03-14 03:52:45', NULL),
(5, 'Case 160', 160, '2025-03-14 03:53:55', '2025-03-14 03:53:55', NULL),
(6, 'Case 60', 60, '2025-03-14 04:23:12', '2025-03-14 04:23:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_migrations`
--

CREATE TABLE `hi_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_password_reset_tokens`
--

CREATE TABLE `hi_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_payment_history`
--

CREATE TABLE `hi_payment_history` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `beat_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_payment_history`
--

INSERT INTO `hi_payment_history` (`id`, `customer_id`, `beat_id`, `invoice_id`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 100, '2025-03-16 16:27:16', '2025-03-16 16:27:16', NULL),
(2, 1, 1, 1, 10, '2025-03-16 16:30:46', '2025-03-16 16:30:46', NULL),
(3, 1, 1, 9, 10, '2025-03-16 16:31:05', '2025-03-16 16:31:05', NULL),
(4, 1, 1, 13, 100, '2025-03-17 01:57:51', '2025-03-17 01:57:51', NULL),
(5, 1, 1, 1, 3100, '2025-03-17 02:00:29', '2025-03-17 02:00:29', NULL),
(6, 2, 1, 6, 180, '2025-03-17 02:02:56', '2025-03-17 02:02:56', NULL),
(7, 2, 1, 6, 40, '2025-03-20 07:08:11', '2025-03-20 07:08:11', NULL),
(8, 2, 1, 16, 500, '2025-03-22 10:41:21', '2025-03-22 10:41:21', NULL),
(9, 2, 1, 17, 2000, '2025-03-22 10:41:37', '2025-03-22 10:41:37', NULL),
(10, 1, 1, 10, 55, '2025-03-22 11:33:47', '2025-03-22 11:33:47', NULL),
(11, 2, 1, 11, 200, '2025-03-22 11:33:51', '2025-03-22 11:33:51', NULL),
(12, 2, 1, 6, 100, '2025-03-22 11:53:37', '2025-03-22 11:53:37', NULL),
(13, 2, 1, 11, 200, '2025-03-22 11:54:17', '2025-03-22 11:54:17', NULL),
(14, 1, 1, 18, 400, '2025-03-22 12:21:18', '2025-03-22 12:21:18', NULL),
(15, 1, 1, 19, 400, '2025-03-22 12:22:55', '2025-03-22 12:22:55', NULL),
(16, 1, 1, 19, 400, '2025-03-22 12:25:02', '2025-03-22 12:25:02', NULL),
(17, 1, 1, 18, 400, '2025-03-22 12:25:22', '2025-03-22 12:25:22', NULL),
(18, 2, 1, 17, 800, '2025-03-22 12:33:40', '2025-03-22 12:33:40', NULL),
(19, 2, 1, 16, 1000, '2025-03-22 12:38:30', '2025-03-22 12:38:30', NULL),
(20, 1, 1, 12, 490, '2025-03-22 12:39:36', '2025-03-22 12:39:36', NULL),
(21, 1, 1, 14, 400, '2025-03-22 12:40:02', '2025-03-22 12:40:02', NULL),
(22, 1, 1, 15, 192, '2025-03-22 12:56:06', '2025-03-22 12:56:06', NULL),
(23, 1, 1, 20, 400, '2025-03-22 14:28:28', '2025-03-22 14:28:28', NULL),
(24, 1, 1, 20, 100, '2025-03-22 14:28:51', '2025-03-22 14:28:51', NULL),
(25, 2, 1, 6, 100, '2025-03-22 15:03:43', '2025-03-22 15:03:43', NULL),
(26, 1, 1, 20, 1900, '2025-03-22 15:05:21', '2025-03-22 15:05:21', NULL),
(27, 1, 1, 9, 4667, '2025-03-23 11:06:43', '2025-03-23 11:06:43', NULL),
(28, 1, 1, 10, 255, '2025-03-25 06:14:43', '2025-03-25 06:14:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_products`
--

CREATE TABLE `hi_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_rate` float NOT NULL DEFAULT 0,
  `product_hsn` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_products`
--

INSERT INTO `hi_products` (`id`, `product_name`, `product_rate`, `product_hsn`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KGMO 1 Ltr (16x1) Pouch', 145, '115415', 1, '2025-03-13 05:29:04', '2025-03-22 11:44:49', NULL),
(2, 'KGMO 500 ml (24x500) Pouch', 75, NULL, 1, '2025-03-13 05:29:46', '2025-03-14 04:17:52', NULL),
(3, 'KGMO 1 Ltr (12x1) Bottle', 157, NULL, 1, '2025-03-14 04:18:49', '2025-03-14 04:18:49', NULL),
(4, 'KGMO 500 ml (24x500) Bottle', 75, NULL, 1, '2025-03-14 04:22:05', '2025-03-14 04:22:05', NULL),
(5, 'KGMO 200 ml (60x200) Bottle', 33, NULL, 1, '2025-03-14 04:22:28', '2025-03-14 04:22:28', NULL),
(6, 'KGMO 36 grm (160x36) Lup', 9, NULL, 1, '2025-03-14 04:26:18', '2025-03-14 04:26:18', NULL),
(7, 'KGMO 5 Ltr (4x1) Jar', 750, NULL, 1, '2025-03-14 04:26:59', '2025-03-14 04:26:59', NULL),
(8, 'Soya Oil 1 Ltr (12x1) Pouch', 140, NULL, 1, '2025-03-14 06:35:24', '2025-03-14 06:35:24', NULL),
(9, 'Soya Oil 500 ml (24x500) Pouch', 75, NULL, 1, '2025-03-18 01:37:26', '2025-03-18 01:38:46', NULL),
(10, 'Soya Oil 1 Ltr (12x1) Bottle', 157, NULL, 1, '2025-03-18 01:37:45', '2025-03-18 01:37:45', NULL),
(11, 'Soya Oil 500 ml (24x500) Bottle', 80, NULL, 1, '2025-03-18 01:38:23', '2025-03-18 01:38:23', NULL),
(12, 'Soya Oil 200 ml (60x200) Bottle', 34, NULL, 1, '2025-03-18 01:39:56', '2025-03-18 01:39:56', NULL),
(13, 'Rice Oil 1 Ltr (12x1) Pouch', 128, NULL, 1, '2025-03-18 01:40:54', '2025-03-18 01:40:54', NULL),
(14, 'Sunflower Oil 1 Ltr (12x1) Pouch', 145, NULL, 1, '2025-03-18 01:42:17', '2025-03-18 01:42:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_product_measurements`
--

CREATE TABLE `hi_product_measurements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `measurement_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_product_measurements`
--

INSERT INTO `hi_product_measurements` (`id`, `product_id`, `measurement_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 2, 1, '2025-03-14 04:17:52', '2025-03-14 04:17:52', NULL),
(9, 2, 4, '2025-03-14 04:17:52', '2025-03-14 04:17:52', NULL),
(10, 3, 1, '2025-03-14 04:18:49', '2025-03-14 04:18:49', NULL),
(11, 3, 3, '2025-03-14 04:18:49', '2025-03-14 04:18:49', NULL),
(12, 4, 1, '2025-03-14 04:22:06', '2025-03-14 04:22:06', NULL),
(13, 4, 4, '2025-03-14 04:22:06', '2025-03-14 04:22:06', NULL),
(15, 5, 1, '2025-03-14 04:23:22', '2025-03-14 04:23:22', NULL),
(16, 5, 6, '2025-03-14 04:23:22', '2025-03-14 04:23:22', NULL),
(17, 6, 1, '2025-03-14 04:26:18', '2025-03-14 04:26:18', NULL),
(18, 6, 5, '2025-03-14 04:26:18', '2025-03-14 04:26:18', NULL),
(19, 7, 1, '2025-03-14 04:26:59', '2025-03-14 04:26:59', NULL),
(20, 8, 1, '2025-03-14 06:35:24', '2025-03-14 06:35:24', NULL),
(21, 8, 3, '2025-03-14 06:35:24', '2025-03-14 06:35:24', NULL),
(24, 10, 1, '2025-03-18 01:37:45', '2025-03-18 01:37:45', NULL),
(25, 10, 3, '2025-03-18 01:37:45', '2025-03-18 01:37:45', NULL),
(26, 11, 1, '2025-03-18 01:38:23', '2025-03-18 01:38:23', NULL),
(27, 11, 4, '2025-03-18 01:38:23', '2025-03-18 01:38:23', NULL),
(28, 9, 1, '2025-03-18 01:38:46', '2025-03-18 01:38:46', NULL),
(29, 9, 4, '2025-03-18 01:38:46', '2025-03-18 01:38:46', NULL),
(30, 12, 1, '2025-03-18 01:39:56', '2025-03-18 01:39:56', NULL),
(31, 12, 6, '2025-03-18 01:39:56', '2025-03-18 01:39:56', NULL),
(32, 13, 1, '2025-03-18 01:40:54', '2025-03-18 01:40:54', NULL),
(33, 13, 3, '2025-03-18 01:40:54', '2025-03-18 01:40:54', NULL),
(34, 14, 1, '2025-03-18 01:42:17', '2025-03-18 01:42:17', NULL),
(35, 14, 3, '2025-03-18 01:42:17', '2025-03-18 01:42:17', NULL),
(38, 1, 1, '2025-03-22 11:44:49', '2025-03-22 11:44:49', NULL),
(39, 1, 2, '2025-03-22 11:44:49', '2025-03-22 11:44:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_sessions`
--

CREATE TABLE `hi_sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hi_shipments`
--

CREATE TABLE `hi_shipments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_shipments`
--

INSERT INTO `hi_shipments` (`id`, `invoice_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, '2025-03-14 04:04:24', '2025-03-14 04:04:24', NULL),
(2, 3, '2025-03-14 04:04:24', '2025-03-14 04:04:24', NULL),
(3, 2, '2025-03-14 04:04:24', '2025-03-14 04:04:24', NULL),
(4, 1, '2025-03-14 04:04:24', '2025-03-14 04:04:24', NULL),
(5, 6, '2025-03-14 06:50:46', '2025-03-14 06:50:46', NULL),
(6, 5, '2025-03-14 06:50:46', '2025-03-14 06:50:46', NULL),
(7, 8, '2025-03-14 07:07:46', '2025-03-14 07:07:46', NULL),
(8, 7, '2025-03-14 07:07:46', '2025-03-14 07:07:46', NULL),
(9, 23, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(10, 22, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(11, 21, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(12, 20, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(13, 19, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(14, 18, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(15, 17, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(16, 16, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(17, 15, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(18, 14, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(19, 13, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL),
(20, 12, '2025-03-23 11:07:42', '2025-03-23 11:07:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_users`
--

CREATE TABLE `hi_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hi_beats`
--
ALTER TABLE `hi_beats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_cache`
--
ALTER TABLE `hi_cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `hi_cache_locks`
--
ALTER TABLE `hi_cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `hi_customers`
--
ALTER TABLE `hi_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_customer_payments`
--
ALTER TABLE `hi_customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_distributors`
--
ALTER TABLE `hi_distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_failed_jobs`
--
ALTER TABLE `hi_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hi_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hi_gst_invoices`
--
ALTER TABLE `hi_gst_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_gst_invoice_products`
--
ALTER TABLE `hi_gst_invoice_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_inventory`
--
ALTER TABLE `hi_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_inventory_history`
--
ALTER TABLE `hi_inventory_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_invoices`
--
ALTER TABLE `hi_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_invoice_products`
--
ALTER TABLE `hi_invoice_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_jobs`
--
ALTER TABLE `hi_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hi_jobs_queue_index` (`queue`);

--
-- Indexes for table `hi_job_batches`
--
ALTER TABLE `hi_job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_measurements`
--
ALTER TABLE `hi_measurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_migrations`
--
ALTER TABLE `hi_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_password_reset_tokens`
--
ALTER TABLE `hi_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `hi_payment_history`
--
ALTER TABLE `hi_payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_products`
--
ALTER TABLE `hi_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_product_measurements`
--
ALTER TABLE `hi_product_measurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_sessions`
--
ALTER TABLE `hi_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hi_sessions_user_id_index` (`user_id`),
  ADD KEY `hi_sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `hi_shipments`
--
ALTER TABLE `hi_shipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hi_users`
--
ALTER TABLE `hi_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hi_users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hi_beats`
--
ALTER TABLE `hi_beats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hi_customers`
--
ALTER TABLE `hi_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hi_customer_payments`
--
ALTER TABLE `hi_customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `hi_distributors`
--
ALTER TABLE `hi_distributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hi_failed_jobs`
--
ALTER TABLE `hi_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hi_gst_invoices`
--
ALTER TABLE `hi_gst_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hi_gst_invoice_products`
--
ALTER TABLE `hi_gst_invoice_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hi_inventory`
--
ALTER TABLE `hi_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hi_inventory_history`
--
ALTER TABLE `hi_inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `hi_invoices`
--
ALTER TABLE `hi_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `hi_invoice_products`
--
ALTER TABLE `hi_invoice_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `hi_jobs`
--
ALTER TABLE `hi_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hi_measurements`
--
ALTER TABLE `hi_measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hi_migrations`
--
ALTER TABLE `hi_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hi_payment_history`
--
ALTER TABLE `hi_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `hi_products`
--
ALTER TABLE `hi_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hi_product_measurements`
--
ALTER TABLE `hi_product_measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `hi_shipments`
--
ALTER TABLE `hi_shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hi_users`
--
ALTER TABLE `hi_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
