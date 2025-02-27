-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2025 at 05:45 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hosted_inventory`
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
(2, 'Paulpara', 'Paulpara', 1, '2025-02-21 21:42:15', '2025-02-22 08:08:38', NULL),
(7, 'Bag Bazar', 'Station road', 1, '2025-02-22 08:07:27', '2025-02-22 08:07:27', NULL),
(8, 'Kharua Bazar', 'Chinsura', 1, '2025-02-22 08:08:58', '2025-02-22 08:08:58', NULL),
(9, 'Bou Bazar', 'Bou Bazar', 1, '2025-02-22 08:10:05', '2025-02-22 08:10:05', NULL),
(10, 'HathKhola', 'Hathkhola', 1, '2025-02-22 08:41:59', '2025-02-22 08:41:59', NULL),
(11, 'Lakhi Ganj Bazar', 'Chandannagore', 1, '2025-02-22 08:42:45', '2025-02-22 08:42:45', NULL),
(12, 'Baidyabati 1', 'Bai', 1, '2025-02-22 10:11:37', '2025-02-22 10:11:37', NULL),
(13, 'Baidyabati 2', 'Bai', 1, '2025-02-22 10:12:01', '2025-02-22 10:12:01', NULL),
(14, 'Angus 1', 'A', 1, '2025-02-22 10:12:16', '2025-02-22 10:12:16', NULL),
(15, 'Angus 2', 'A', 1, '2025-02-22 10:12:30', '2025-02-22 10:12:30', NULL),
(16, 'Telinipara', 'T', 1, '2025-02-22 10:13:06', '2025-02-22 10:13:06', NULL),
(17, 'BH Station', 'S', 1, '2025-02-22 10:13:32', '2025-02-22 10:13:32', NULL),
(18, 'BH G.T Road', 'B', 1, '2025-02-22 10:14:03', '2025-02-22 10:14:03', NULL),
(19, 'Tematha', 'Jyoti', 1, '2025-02-22 10:14:23', '2025-02-22 10:14:23', NULL);

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
(3, 2, 'test customer 1', 'Address', 'test', NULL, '2025-02-21 23:44:41', '2025-02-21 23:44:41', 1, NULL),
(4, 7, 'Shubhas', 'Chan', 'gst 123', '9723444333', '2025-02-22 08:48:46', '2025-02-25 06:52:49', 1, NULL);

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
(1, 'Deb Enterprise', '47/1 Dr C.C.C Road,Bhadreswar,Hooghly', '19GDKPD1370P1Z1', '9038477792', '2025-02-21 15:01:01', '2025-02-22 08:45:13', NULL);

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
-- Table structure for table `hi_inventory`
--

CREATE TABLE `hi_inventory` (
  `id` int(11) NOT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_inventory`
--

INSERT INTO `hi_inventory` (`id`, `item_code`, `product_id`, `total_stock`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IN-1', 3, 2400, '2025-02-25 07:03:57', '2025-02-27 14:12:58', NULL),
(2, 'IN-2', 2, 1200, '2025-02-27 03:14:39', '2025-02-27 05:15:47', NULL),
(3, 'IN-3', 4, 1200, '2025-02-27 03:14:39', '2025-02-27 03:14:39', NULL),
(4, 'IN-4', 7, 4768, '2025-02-27 05:16:48', '2025-02-27 05:18:07', NULL),
(5, 'IN-5', 8, 1200, '2025-02-27 05:17:24', '2025-02-27 05:17:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_inventory_history`
--

CREATE TABLE `hi_inventory_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `measurement_id` int(11) NOT NULL,
  `stock_out_in` int(11) NOT NULL,
  `stock_action` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_inventory_history`
--

INSERT INTO `hi_inventory_history` (`id`, `product_id`, `measurement_id`, `stock_out_in`, `stock_action`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, 1, 'add', '2025-02-25 07:03:57', '2025-02-25 07:03:57', NULL),
(2, 2, 4, 100, 'add', '2025-02-27 03:14:39', '2025-02-27 03:14:39', NULL),
(3, 3, 6, 100, 'add', '2025-02-27 03:14:39', '2025-02-27 03:14:39', NULL),
(4, 4, 1, 100, 'add', '2025-02-27 03:14:39', '2025-02-27 03:14:39', NULL),
(5, 2, 1, 120, 'deduct', '2025-02-27 03:19:36', '2025-02-27 03:19:36', NULL),
(6, 2, 1, 120, 'deduct', '2025-02-27 03:19:36', '2025-02-27 03:19:36', NULL),
(7, 2, 4, 160, 'deduct', '2025-02-27 05:15:47', '2025-02-27 05:15:47', NULL),
(8, 7, 7, 30, 'add', '2025-02-27 05:16:48', '2025-02-27 05:16:48', NULL),
(9, 8, 1, 100, 'add', '2025-02-27 05:17:24', '2025-02-27 05:17:24', NULL),
(10, 7, 4, 32, 'deduct', '2025-02-27 05:18:07', '2025-02-27 05:18:07', NULL),
(11, 3, 2, 12, 'deduct', '2025-02-27 14:12:58', '2025-02-27 14:12:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_invoices`
--

CREATE TABLE `hi_invoices` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `beat_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_invoices`
--

INSERT INTO `hi_invoices` (`id`, `customer_id`, `beat_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, '2025-02-25 02:35:41', '2025-02-25 02:35:41', NULL),
(2, 3, 2, '2025-02-25 02:36:27', '2025-02-25 02:36:27', NULL),
(3, 4, 7, '2025-02-25 02:39:16', '2025-02-25 02:39:16', NULL),
(4, 4, 7, '2025-02-25 06:51:54', '2025-02-25 06:51:54', NULL),
(5, 3, 2, '2025-02-27 00:48:36', '2025-02-27 00:48:36', NULL),
(6, 4, 7, '2025-02-27 00:58:27', '2025-02-27 00:58:27', NULL),
(7, 3, 2, '2025-02-27 05:19:42', '2025-02-27 05:19:42', NULL),
(8, 3, 2, '2025-02-27 14:12:34', '2025-02-27 14:12:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_invoice_products`
--

CREATE TABLE `hi_invoice_products` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rate` float NOT NULL,
  `measurement_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_invoice_products`
--

INSERT INTO `hi_invoice_products` (`id`, `invoice_id`, `product_id`, `quantity`, `rate`, `measurement_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 10, 0, 1, '2025-02-25 02:35:41', '2025-02-25 02:35:41', NULL),
(2, 2, 2, 10, 0, 1, '2025-02-25 02:36:27', '2025-02-25 02:36:27', NULL),
(3, 3, 2, 10, 0, 4, '2025-02-25 02:39:16', '2025-02-25 02:39:16', NULL),
(4, 4, 7, 2, 0, 4, '2025-02-25 06:51:54', '2025-02-25 06:51:54', NULL),
(5, 4, 10, 9, 0, 6, '2025-02-25 06:51:54', '2025-02-25 06:51:54', NULL),
(6, 4, 3, 1, 0, 2, '2025-02-25 06:51:54', '2025-02-25 06:51:54', NULL),
(7, 5, 2, 1, 100, 4, '2025-02-27 00:48:36', '2025-02-27 00:48:36', NULL),
(8, 6, 2, 10, 100, 4, '2025-02-27 00:58:27', '2025-02-27 00:58:27', NULL),
(9, 6, 5, 10, 10, 6, '2025-02-27 00:58:27', '2025-02-27 00:58:27', NULL),
(10, 7, 2, 15, 100, 4, '2025-02-27 05:19:42', '2025-02-27 05:19:42', NULL),
(11, 7, 8, 10, 148, 1, '2025-02-27 05:19:42', '2025-02-27 05:19:42', NULL),
(12, 8, 3, 12, 10, 2, '2025-02-27 14:12:34', '2025-02-27 14:12:34', NULL);

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
(1, 'Case 12', 12, '2025-02-22 06:41:02', '2025-02-24 18:15:51', NULL),
(2, 'Piece', 1, '2025-02-22 06:41:12', NULL, NULL),
(4, 'Case 16', 16, '2025-02-22 08:45:51', '2025-02-24 18:16:02', NULL),
(5, 'Case 60', 60, '2025-02-22 08:46:01', '2025-02-24 18:16:10', NULL),
(6, 'Case 24', 24, '2025-02-22 08:46:09', '2025-02-24 18:16:17', NULL),
(7, 'Case 160', 160, '2025-02-27 05:16:22', '2025-02-27 05:16:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hi_migrations`
--

CREATE TABLE `hi_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hi_migrations`
--

INSERT INTO `hi_migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `hi_products`
--

CREATE TABLE `hi_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_rate` float NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hi_products`
--

INSERT INTO `hi_products` (`id`, `product_name`, `product_rate`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'KGMO 1 Ltr (16x1) Pouch', 148, 1, '2025-02-22 00:44:04', '2025-02-22 14:50:03', NULL),
(3, 'KGMO 500 ml (24x500) Pouch', 75, 1, '2025-02-22 00:45:52', '2025-02-22 14:50:43', NULL),
(4, 'KGMO 1 Ltr (12x1) Bottle', 153, 1, '2025-02-22 07:32:12', '2025-02-22 14:51:33', NULL),
(5, 'KGMO 500 ml (24x500) Bottle', 80, 1, '2025-02-22 14:52:06', '2025-02-22 14:52:06', NULL),
(6, 'KGMO 200 ml (60x200) Bottle', 33, 1, '2025-02-22 14:53:10', '2025-02-22 14:53:10', NULL),
(7, 'KGMO 36 grm (160x36) Lup', 8.5, 1, '2025-02-22 14:54:24', '2025-02-22 14:54:24', NULL),
(8, 'Soya Oil 1 Ltr (12x1) Pouch', 140, 1, '2025-02-22 14:55:57', '2025-02-22 14:55:57', NULL),
(9, 'Soya Oil 500 ml (24x500) Pouch', 145, 1, '2025-02-22 14:58:39', '2025-02-22 15:02:19', NULL),
(10, 'Soya Oil 1 Ltr (12x1) Bottle', 145, 1, '2025-02-22 14:59:41', '2025-02-22 15:02:54', NULL),
(11, 'Soya Oil 500 ml (24x500) Bottle', 75, 1, '2025-02-22 15:00:25', '2025-02-22 15:00:25', NULL),
(12, 'Soya Oil 200 ml (60x200) Bottle', 32, 1, '2025-02-22 15:01:14', '2025-02-22 15:01:14', NULL);

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

--
-- Dumping data for table `hi_sessions`
--

INSERT INTO `hi_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cAZ7RBtHv9qLlOUgCvSZBSUxV4zlhNTCpkwrrTAF', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVlsMGVSS2ZSU1U5cDRHcmVDeWxFMENFZlBQaXVMQUhEQThwUEVEdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3QvaG9zdGVkX2ludmVudG9yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1740208313);

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
(1, 1, '2025-02-27 03:19:36', '2025-02-27 03:19:36', NULL),
(2, 2, '2025-02-27 03:19:36', '2025-02-27 03:19:36', NULL),
(3, 3, '2025-02-27 05:15:47', '2025-02-27 05:15:47', NULL),
(4, 8, '2025-02-27 14:12:58', '2025-02-27 14:12:58', NULL);

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
-- Indexes for table `hi_products`
--
ALTER TABLE `hi_products`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `hi_customers`
--
ALTER TABLE `hi_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `hi_inventory`
--
ALTER TABLE `hi_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hi_inventory_history`
--
ALTER TABLE `hi_inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hi_invoices`
--
ALTER TABLE `hi_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hi_invoice_products`
--
ALTER TABLE `hi_invoice_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hi_jobs`
--
ALTER TABLE `hi_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hi_measurements`
--
ALTER TABLE `hi_measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hi_migrations`
--
ALTER TABLE `hi_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hi_products`
--
ALTER TABLE `hi_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hi_shipments`
--
ALTER TABLE `hi_shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hi_users`
--
ALTER TABLE `hi_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
