-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2025 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `role`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '$2y$12$Z2rd4laRZsIpxUWoQE.52OgWhHX1kdAXC2jgFFeZwR2fHljJiYKwC', '9876543210', 'admin', 1, '2025-10-04 09:28:23', NULL, '2025-09-18 07:31:27', '2025-10-04 09:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `advance_payments`
--

CREATE TABLE `advance_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `percentage` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advance_payments`
--

INSERT INTO `advance_payments` (`id`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 9, '2025-09-20 05:43:39', '2025-09-20 05:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `bank_id`, `branch_id`, `designation`, `name`, `email`, `mobile_number`, `whatsapp_number`, `password`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'hwhjhwqj', 'iwquwqiw', 'ja@mail.com', '', NULL, '$2y$12$ocf3w02UQ3YkvYGcNksWJOas7g4iyjyESSPuROSDM8qK145W6wAEG', 'agents/MGJosEh1pWWsCRyMy8IKEdyLkNZzi7Nibi65Gs00.png', 1, '2025-09-29 12:44:01', '2025-09-29 12:44:01'),
(2, 1, 2, 'jbsjsd', 'wjqwijowqjwq', 'j@mail.com', '1212121212', '1212121212', '$2y$12$os4JRoyfvno61GeU1TtyuO2FSPUoH8KpB4MhIPzRVXmJ5yuSbpSgC', NULL, 1, '2025-10-01 12:22:18', '2025-10-01 12:22:18'),
(3, 1, 3, 'lkwew', 'wijoiowe', 'sdjkj@mail.com', '9889090837', '7873287328', '$2y$12$.GTrFEhQ47KN9gCTbTUoZOX/Vr4byiAEbD1bnXugtfLfyDzEvMEKG', 'agents/aTc2PRkjSOSr08ArNEEz7VkONxQbn5nuUbuYPcbM.png', 1, '2025-10-03 08:37:21', '2025-10-04 09:29:23'),
(4, 1, 2, 'skjksjs', 'jatin mishra', 'ahah@gmail.com', '5656565656', '5656565656', '$2y$12$mC1jgpQGrXRTOWE9XuacDen8ZJuZbwspsh4oc8VZ0E8fUuL20LCty', 'agents/tMU4PYuNNYNKqDWfFGJXbXC6XrFZ90pjd0epUuqM.jpg', 1, '2025-10-04 09:29:53', '2025-10-04 09:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `agent_tokens`
--

CREATE TABLE `agent_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_tokens`
--

INSERT INTO `agent_tokens` (`id`, `agent_id`, `token`, `created_at`, `updated_at`) VALUES
(1, 3, 'CAuFnzgjTUp8L95Y77ccpQ5YOCvWyY6LnTgLlRCgUPeGPqHKhDKE0jxS8zCS', '2025-10-04 09:27:03', '2025-10-04 09:27:03'),
(2, 3, 'u4MmdCJTsSEH0p9oUnMhEz8wpXRTHEUxtoBbDO8wQ8bgQmYbWfXo6317g7pP', '2025-10-04 09:27:43', '2025-10-04 09:27:43'),
(3, 3, 'hYlTN9sZgekOg5Aqkre4JhONgBOKuul982Zp76D2us3HCW1opLHvsvOAIZoA', '2025-10-04 09:29:34', '2025-10-04 09:29:34'),
(4, 4, 'I3yq58ZV4EBJYtcApfC777qR4nZKtQIpkbkJ7WKNK6tzxPklj49zCO4xBzgK', '2025-10-04 09:30:14', '2025-10-04 09:30:14'),
(5, 4, '67pmPx0gYWVzhHunYv1QfVOAq9uTJh1kp6lpiAt8ay6qXyDSrt5IJodEm3fB', '2025-10-04 09:32:22', '2025-10-04 09:32:22'),
(6, 4, 'vIq7ZelRR8LNMeDIOX3DDYOGDx9YGukFv6AODZSb9jjrNMeTTiEbit3ir3AQ', '2025-10-04 09:36:43', '2025-10-04 09:36:43'),
(7, 4, 'uC040klzToFWi6MturRSjPx2CT956tPOXGj0G3MdJCj9xjxgHvH49yzGV3b6', '2025-10-04 09:37:00', '2025-10-04 09:37:00'),
(8, 4, '4mKiMgVxZZvhnC67SRwhyZT88oHBMn75PJjaKmia1r6nB4npWtAuRhkEtQaR', '2025-10-04 09:37:10', '2025-10-04 09:37:10'),
(9, 4, 'Z76d4ZZ1CF3q4St7lVLpRnEXVYajrFTpXfflcspaEJuRy1uBu5llkRqyOuzF', '2025-10-04 09:37:19', '2025-10-04 09:37:19'),
(10, 4, 'NuzsgEpGj9QHpm8K7HrAK4Vuq21tKSUJfDKQeUu22WBor0fJxUw1ZqVozHoJ', '2025-10-04 09:38:02', '2025-10-04 09:38:02'),
(11, 3, 'LPwSUUT0saCSmE8DsBarXoVM54SU08MWwdNVJ6YTaJasJAFCfJMLQjK8elty', '2025-10-04 09:39:51', '2025-10-04 09:39:51'),
(12, 3, 'GPG7ZfKn1dnhIG9TgHX29zX6S1cB0MnrKEEeU7LQYN2LPQivrkglSe9M4T0a', '2025-10-04 09:40:36', '2025-10-04 09:40:36'),
(13, 4, 'vWaTymjqHjX8dCBZN8FuRpt2Gaf8ChWmuUABDFfXHgb0VnA3lDfTmxBl0XGY', '2025-10-04 09:41:20', '2025-10-04 09:41:20'),
(14, 3, 'bnKMuWiFdik0CCvSR89aYa502zKfVrEEZOclMCatqfuhT4mbVMRJpnfaKdMX', '2025-10-04 09:41:29', '2025-10-04 09:41:29'),
(15, 3, 'zQv6CkLjyCke7FCVetKJ24JPzezYeKMjhw8oeV4JBJkr9Zu0Pi0IZjAx0mip', '2025-10-04 09:47:51', '2025-10-04 09:47:51'),
(16, 3, 'dL8ggUjOZ2GWwIcYlAMbhyPWNImX4nA7RPZ9VceXudF0i5nfUF78Pwy2VnXB', '2025-10-04 09:48:38', '2025-10-04 09:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `bank_code` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank`, `address`, `bank_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sbi', 'jajbajb', '2t22yeyeyu', 1, '2025-09-29 10:59:17', '2025-09-29 11:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `branch_address` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `bank_id`, `branch_address`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 1, 'kknwjkwq', 1, '2025-09-29 11:51:39', '2025-09-29 11:51:39'),
(3, 1, 'Ramesh Nagar', 1, '2025-10-04 09:29:09', '2025-10-04 09:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 1,
  `box_ids_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`box_ids_json`)),
  `category_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `featured`, `box_ids_json`, `category_image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Laddu', 0, '\"null\"', 'categories/cat_68cce80632d4e.png', 1, 0, '2025-09-18 23:46:39', '2025-09-18 23:50:06'),
(2, 'Traditional Barfi', 1, '\"null\"', 'categories/cat_68cce8227944d.png', 1, 0, '2025-09-18 23:50:34', '2025-09-18 23:50:34'),
(3, 'Syrupy Delights', 1, '\"null\"', 'categories/cat_68ce4f4d95e17.png', 1, 0, '2025-09-18 23:51:00', '2025-09-20 01:23:01'),
(4, 'Traditional Halwa', 1, '\"null\"', 'categories/cat_68cce852d3ec3.png', 1, 0, '2025-09-18 23:51:22', '2025-09-18 23:51:22'),
(5, 'Namkeen\'s Mixtures', 1, '\"null\"', 'categories/cat_68cce86cdbd93.png', 1, 0, '2025-09-18 23:51:48', '2025-09-18 23:51:48'),
(6, 'Sweets Gift Boxes', 1, '\"null\"', 'categories/cat_68cce88b5a572.png', 1, 0, '2025-09-18 23:52:19', '2025-09-18 23:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiries`
--

CREATE TABLE `contact_enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied','closed') NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `phone_verified` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `password`, `address`, `city`, `state`, `pincode`, `is_active`, `email_verified`, `phone_verified`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'jatin mishra', 'jatin@mail.com', '6299477707', '$2y$12$yHatgp.W2Ro/W9iXRqO.ZOUyDgVN6JdRMgTUCvm5rvy3abxQdk6Vu', NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, '2025-09-27 12:27:11', '2025-09-27 12:27:11'),
(5, 'Ravi Kumar', 'ravi@example.com', '9876543210', '$2y$12$5scJr1G1Ed6F141y3YfDXumTMWJ13LFt/4ncrC94UTtiaDtB/UY2S', NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, '2025-10-03 08:43:52', '2025-10-03 08:43:52');

-- --------------------------------------------------------

--
-- Table structure for table `gold_items`
--

CREATE TABLE `gold_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `gross_weight` decimal(8,2) NOT NULL,
  `stone_weight` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `purity` int(11) NOT NULL,
  `rate_per_gram` decimal(10,2) NOT NULL,
  `market_value` decimal(12,2) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gold_items`
--

INSERT INTO `gold_items` (`id`, `customer_id`, `description`, `quantity`, `gross_weight`, `stone_weight`, `net_weight`, `purity`, `rate_per_gram`, `market_value`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 4, 'jbb', 1, 6.00, 8.00, -2.00, 8, 7.00, -14.00, 'gfy', '2025-10-03 08:57:15', '2025-10-03 08:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_08_02_191602_create_admins_table', 1),
(3, '2025_08_02_191617_create_categories_table', 1),
(4, '2025_08_02_191627_create_subcategories_table', 1),
(5, '2025_08_02_191703_create_products_table', 1),
(6, '2025_08_02_191715_create_customers_table', 1),
(7, '2025_08_02_191718_create_orders_table', 1),
(8, '2025_08_02_191744_create_banners_table', 1),
(9, '2025_08_02_191755_create_boxes_table', 1),
(10, '2025_08_02_191805_create_testimonials_table', 1),
(11, '2025_08_02_191816_create_subscription_orders_table', 1),
(12, '2025_08_02_191826_create_faqs_table', 1),
(13, '2025_08_02_191846_create_newsletter_subscribers_table', 1),
(14, '2025_08_02_191900_create_delivery_locations_table', 1),
(15, '2025_08_02_191901_create_contact_enquiries_table', 1),
(16, '2025_08_02_192914_create_order_items_table', 1),
(17, '2025_08_03_064233_create_category_box_table', 1),
(18, '2025_08_06_052105_create_policies_table', 1),
(19, '2025_08_06_093903_create_personal_access_tokens_table', 1),
(20, '2025_08_06_095308_create_oauth_auth_codes_table', 1),
(21, '2025_08_06_095309_create_oauth_access_tokens_table', 1),
(22, '2025_08_06_095311_create_oauth_clients_table', 1),
(23, '2025_08_06_095312_create_oauth_device_codes_table', 1),
(24, '2025_08_06_145424_create_subscription_logs_table', 1),
(25, '2025_08_06_170000_update_policies_table_add_fields', 1),
(26, '2025_08_07_000000_create_carts_table', 2),
(27, '2025_08_07_000001_create_wishlists_table', 3),
(28, '2025_08_07_000002_create_reviews_table', 4),
(29, '2025_08_08_051545_create_password_resets_table', 5),
(30, '2025_08_11_171304_create_website_settings_table', 6),
(31, '2025_08_22_085839_create_website_banners_table', 7),
(32, '2025_08_23_063848_create_payments_table', 8),
(33, '2025_08_23_094443_create_notifications_table', 9),
(34, '2025_08_26_192604_create_subscription_admin_products_table', 10),
(35, '2025_08_22_065301_create_blocked_slots_table', 11),
(36, '2025_09_20_110927_create_cache_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `owner_type` varchar(255) DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect_uris` text NOT NULL,
  `grant_types` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_device_codes`
--

CREATE TABLE `oauth_device_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `user_code` char(8) NOT NULL,
  `scopes` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `otp`, `created_at`) VALUES
('admin@mail.com', 'bYpGeuqe2XosqIspspUiI9lozLSA06IeV1sQ55nf0rm5VpNyzs3sKpzQzqpm', '913386', '2025-10-01 12:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'auth_token', '6657261b79bd1f8dfa741b90227359394295cc8f1e9e69e9cdf4480b32711bff', '[\"*\"]', NULL, NULL, '2025-09-19 00:03:59', '2025-09-19 00:03:59'),
(2, 'App\\Models\\User', 3, 'auth_token', 'e1d12e950aac2211666b7e7ad3c473edb0219a523ec1cea48ed06f03ff372eeb', '[\"*\"]', '2025-09-20 07:22:39', NULL, '2025-09-19 00:05:32', '2025-09-20 07:22:39'),
(4, 'App\\Models\\User', 1, 'auth_token', 'cdf7cf136b293ef32183e0308c94d1668d19bcb24c4f4936ef31a6d88aa9a193', '[\"*\"]', '2025-09-20 02:29:51', NULL, '2025-09-20 01:38:27', '2025-09-20 02:29:51'),
(5, 'App\\Models\\User', 3, 'auth_token', '09f390c0c63d6de9a61416a68647afb60e216cb1e3e2412bbe26b321c1934b86', '[\"*\"]', '2025-09-20 06:57:05', NULL, '2025-09-20 01:54:30', '2025-09-20 06:57:05'),
(6, 'App\\Models\\User', 1, 'auth_token', '8c75e860907e3ddadb7df303c4c8b8c2fb0264b06632b0c069bb53a7b2cdd14b', '[\"*\"]', '2025-09-20 07:25:34', NULL, '2025-09-20 03:11:02', '2025-09-20 07:25:34'),
(7, 'App\\Models\\User', 3, 'auth_token', '20d9dffe5a41e2830a4b5c22ef78e1146b0578111e560f94755c7361ce23e091', '[\"*\"]', '2025-09-20 07:31:10', NULL, '2025-09-20 07:30:54', '2025-09-20 07:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `last_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `type`, `title`, `content`, `is_active`, `meta_title`, `meta_description`, `last_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'policy', 'Privacy Policy', 'Our Privacy Policy is designed to protect your personal data. We only use the information to improve our services and provide you with a better experience. Your information is never shared with third parties without your consent.', 1, 'Privacy Policy', 'This Privacy Policy explains how we collect, use, and protect your personal information.', 1, '2025-09-20 06:57:16', '2025-09-20 06:57:16'),
(3, 'terms', 'good', '<ul data-start=\"874\" data-end=\"1082\"><li data-start=\"874\" data-end=\"972\"><p data-start=\"876\" data-end=\"972\">We strive to display accurate product information, including prices, images, and descriptions.</p>\n</li>\n<li data-start=\"973\" data-end=\"1027\">\n<p data-start=\"975\" data-end=\"1027\">Prices are subject to change without prior notice.</p>\n</li>\n<li data-start=\"1028\" data-end=\"1082\">\n<p data-start=\"1030\" data-end=\"1082\">Product availability may vary and is not guaranteed.</p>\n</li>\n</ul><p data-start=\"1084\" data-end=\"1110\"><strong data-start=\"1084\" data-end=\"1108\">5. Orders &amp; Payments</strong></p><ul data-start=\"1111\" data-end=\"1329\">\n<li data-start=\"1111\" data-end=\"1178\">\n<p data-start=\"1113\" data-end=\"1178\">By placing an order, you agree to provide accurate information.</p>\n</li>\n<li data-start=\"1179\" data-end=\"1228\">\n<p data-start=\"1181\" data-end=\"1228\">Payment must be made in full before shipment.</p>\n</li>\n<li data-start=\"1229\" data-end=\"1329\">\n<p data-start=\"1231\" data-end=\"1329\">We accept payments through [list payment gateways – e.g., credit/debit cards, UPI, net banking].</p>\n</li>\n</ul><p data-start=\"1331\" data-end=\"1359\"><strong data-start=\"1331\" data-end=\"1357\">6. Shipping &amp; Delivery</strong></p><ul data-start=\"1360\" data-end=\"1572\">\n<li data-start=\"1360\" data-end=\"1419\">\n<p data-start=\"1362\" data-end=\"1419\">Estimated delivery timelines are mentioned at checkout.</p>\n</li>\n<li data-start=\"1420\" data-end=\"1500\">\n<p data-start=\"1422\" data-end=\"1500\">Delays may occur due to unforeseen circumstances (logistics, weather, etc.).</p>\n</li>\n<li data-start=\"1501\" data-end=\"1572\">\n<p data-start=\"1503\" data-end=\"1572\">Shipping charges (if applicable) will be displayed during checkout.</p>\n</li>\n</ul><p data-start=\"1574\" data-end=\"1615\"><strong data-start=\"1574\" data-end=\"1613\">7. Cancellations, Returns &amp; Refunds</strong></p><ul data-start=\"1616\" data-end=\"1866\">\n<li data-start=\"1616\" data-end=\"1660\">\n<p data-start=\"1618\" data-end=\"1660\">Orders can be cancelled before shipment.</p>\n</li>\n<li data-start=\"1661\" data-end=\"1774\">\n<p data-start=\"1663\" data-end=\"1774\">Returns are accepted within <strong data-start=\"1691\" data-end=\"1701\">7 days</strong> of delivery, provided the product is unused and in original packaging.</p>\n</li>\n<li data-start=\"1775\" data-end=\"1866\">\n<p data-start=\"1777\" data-end=\"1866\">Refunds will be processed to the original payment method within <strong data-start=\"1841\" data-end=\"1863\">7–10 business days</strong>.</p>\n</li>\n</ul><p data-start=\"1868\" data-end=\"2032\"><strong data-start=\"1868\" data-end=\"1896\">8. Intellectual Property</strong><br data-start=\"1896\" data-end=\"1899\">\nAll website content, including logos, images, and text, is the property of [Your Website Name] and cannot be used without permission.</p><p data-start=\"2034\" data-end=\"2188\"><strong data-start=\"2034\" data-end=\"2064\">9. Limitation of Liability</strong><br data-start=\"2064\" data-end=\"2067\">\nWe are not responsible for damages caused by misuse of our products, delayed deliveries, or third-party service failures.</p><p>\n\n\n\n\n\n\n\n\n</p><p data-start=\"2190\" data-end=\"2368\"><strong data-start=\"2190\" data-end=\"2211\">10. Governing Law</strong></p>', 1, 'g', 'sshshs', NULL, '2025-09-20 01:31:55', '2025-09-20 01:31:55'),
(4, 'privacy', 'good', '<p data-start=\"184\" data-end=\"412\">We value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit or make a purchase from our website.</p><p data-start=\"414\" data-end=\"445\"><strong data-start=\"414\" data-end=\"443\">2. Information We Collect</strong></p><ul data-start=\"446\" data-end=\"657\">\r\n<li data-start=\"446\" data-end=\"513\">\r\n<p data-start=\"448\" data-end=\"513\">Personal details (name, email, phone number, shipping address).</p>\r\n</li>\r\n<li data-start=\"514\" data-end=\"584\">\r\n<p data-start=\"516\" data-end=\"584\">Payment information (processed securely via third-party gateways).</p>\r\n</li>\r\n<li data-start=\"585\" data-end=\"657\">\r\n<p data-start=\"587\" data-end=\"657\">Technical data such as IP address, browser type, and device details.</p>\r\n</li>\r\n</ul><p data-start=\"659\" data-end=\"695\"><strong data-start=\"659\" data-end=\"693\">3. How We Use Your Information</strong></p><ul data-start=\"696\" data-end=\"896\">\r\n<li data-start=\"696\" data-end=\"735\">\r\n<p data-start=\"698\" data-end=\"735\">To process and deliver your orders.</p>\r\n</li>\r\n<li data-start=\"736\" data-end=\"791\">\r\n<p data-start=\"738\" data-end=\"791\">To provide customer support and respond to queries.</p>\r\n</li>\r\n<li data-start=\"792\" data-end=\"843\">\r\n<p data-start=\"794\" data-end=\"843\">To improve our website, products, and services.</p>\r\n</li>\r\n<li data-start=\"844\" data-end=\"896\">\r\n<p data-start=\"846\" data-end=\"896\">To send promotional offers (only if you opt-in).</p>\r\n</li>\r\n</ul><p data-start=\"898\" data-end=\"1054\"><strong data-start=\"898\" data-end=\"918\">4. Data Security</strong><br data-start=\"918\" data-end=\"921\">\r\nWe implement security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p><p data-start=\"1056\" data-end=\"1169\"><strong data-start=\"1056\" data-end=\"1085\">5. Sharing of Information</strong><br data-start=\"1085\" data-end=\"1088\">\r\nWe do not sell or rent your personal data. Information may only be shared with:</p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><ul data-start=\"1170\" data-end=\"1289\">\r\n<li data-start=\"1170\" data-end=\"1245\">\r\n<p data-start=\"1172\" data-end=\"1245\">Service providers (delivery, payment gateways) to complete your orders.</p>\r\n</li>\r\n<li data-start=\"1246\" data-end=\"1289\">\r\n<p data-start=\"1248\" data-end=\"1289\">Legal authorities when required by law.</p></li></ul>', 1, 'g', 'right', NULL, '2025-09-20 01:33:09', '2025-09-20 01:33:09'),
(5, 'refund', 'good', '<p data-start=\"174\" data-end=\"356\"><strong data-start=\"174\" data-end=\"193\">1. Introduction</strong><br data-start=\"193\" data-end=\"196\">\r\nOur Refund Policy ensures a smooth and transparent process in case you are not satisfied with your purchase. Please read it carefully before making any order.</p><p data-start=\"358\" data-end=\"389\"><strong data-start=\"358\" data-end=\"387\">2. Eligibility for Refund</strong></p><ul data-start=\"390\" data-end=\"654\">\r\n<li data-start=\"390\" data-end=\"453\">\r\n<p data-start=\"392\" data-end=\"453\">Refund requests must be made within <strong data-start=\"428\" data-end=\"438\">7 days</strong> of delivery.</p>\r\n</li>\r\n<li data-start=\"454\" data-end=\"549\">\r\n<p data-start=\"456\" data-end=\"549\">The item must be unused, in its original packaging, and in the same condition as delivered.</p>\r\n</li>\r\n<li data-start=\"550\" data-end=\"654\">\r\n<p data-start=\"552\" data-end=\"654\">Certain items (perishable goods, personalized products, or gift cards) are not eligible for refunds.</p>\r\n</li>\r\n</ul><p data-start=\"656\" data-end=\"679\"><strong data-start=\"656\" data-end=\"677\">3. Refund Process</strong></p><ul data-start=\"680\" data-end=\"907\">\r\n<li data-start=\"680\" data-end=\"798\">\r\n<p data-start=\"682\" data-end=\"798\">Once your return is received and inspected, we will notify you regarding the approval or rejection of your refund.</p>\r\n</li>\r\n<li data-start=\"799\" data-end=\"907\">\r\n<p data-start=\"801\" data-end=\"907\">If approved, the refund will be initiated within <strong data-start=\"850\" data-end=\"872\">7–10 business days</strong> to your original payment method.</p>\r\n</li>\r\n</ul><p data-start=\"909\" data-end=\"941\"><strong data-start=\"909\" data-end=\"939\">4. Late or Missing Refunds</strong></p><ul data-start=\"942\" data-end=\"1230\">\r\n<li data-start=\"942\" data-end=\"1033\">\r\n<p data-start=\"944\" data-end=\"1033\">If you haven’t received your refund within the timeline, first check your bank account.</p>\r\n</li>\r\n<li data-start=\"1034\" data-end=\"1121\">\r\n<p data-start=\"1036\" data-end=\"1121\">Then contact your bank or payment provider, as processing may take additional time.</p>\r\n</li>\r\n<li data-start=\"1122\" data-end=\"1230\">\r\n<p data-start=\"1124\" data-end=\"1230\">If you’ve done all this and still have not received your refund, contact us at support@[yourdomain].com.</p>\r\n</li>\r\n</ul><p data-start=\"1232\" data-end=\"1374\"><strong data-start=\"1232\" data-end=\"1248\">5. Exchanges</strong><br data-start=\"1248\" data-end=\"1251\">\r\nWe only replace items if they are defective or damaged. For exchange requests, contact us at 📧 support@[yourdomain].com.</p><p data-start=\"1376\" data-end=\"1399\"><strong data-start=\"1376\" data-end=\"1397\">6. Shipping Costs</strong></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><ul data-start=\"1400\" data-end=\"1557\">\r\n<li data-start=\"1400\" data-end=\"1497\">\r\n<p data-start=\"1402\" data-end=\"1497\">Return shipping costs may be deducted from your refund unless the return is due to our error.</p>\r\n</li>\r\n<li data-start=\"1498\" data-end=\"1557\">\r\n<p data-start=\"1500\" data-end=\"1557\">Original shipping charges are generally non-refundable</p></li></ul>', 1, 'd', 'good', NULL, '2025-09-20 01:33:58', '2025-09-20 01:33:58'),
(6, 'return', 'good', '<article class=\"text-token-text-primary w-full focus:outline-none scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" tabindex=\"-1\" dir=\"auto\" data-turn-id=\"request-WEB:0a313821-b1fc-448a-b531-04b7749ebf97-6\" data-testid=\"conversation-turn-14\" data-scroll-anchor=\"false\" data-turn=\"assistant\"><div class=\"text-base my-auto mx-auto [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div data-message-author-role=\"assistant\" data-message-id=\"2ef84c27-c623-4b73-9faa-8c82665e5a66\" dir=\"auto\" class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" data-message-model-slug=\"gpt-5\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words light markdown-new-styling\"><h2 data-start=\"121\" data-end=\"172\">📑 Refund Policy (Sample for E-Commerce Website)</h2>\r\n<p data-start=\"174\" data-end=\"356\"><strong data-start=\"174\" data-end=\"193\">1. Introduction</strong><br data-start=\"193\" data-end=\"196\">\r\nOur Refund Policy ensures a smooth and transparent process in case you are not satisfied with your purchase. Please read it carefully before making any order.</p>\r\n<p data-start=\"358\" data-end=\"389\"><strong data-start=\"358\" data-end=\"387\">2. Eligibility for Refund</strong></p>\r\n<ul data-start=\"390\" data-end=\"654\">\r\n<li data-start=\"390\" data-end=\"453\">\r\n<p data-start=\"392\" data-end=\"453\">Refund requests must be made within <strong data-start=\"428\" data-end=\"438\">7 days</strong> of delivery.</p>\r\n</li>\r\n<li data-start=\"454\" data-end=\"549\">\r\n<p data-start=\"456\" data-end=\"549\">The item must be unused, in its original packaging, and in the same condition as delivered.</p>\r\n</li>\r\n<li data-start=\"550\" data-end=\"654\">\r\n<p data-start=\"552\" data-end=\"654\">Certain items (perishable goods, personalized products, or gift cards) are not eligible for refunds.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"656\" data-end=\"679\"><strong data-start=\"656\" data-end=\"677\">3. Refund Process</strong></p>\r\n<ul data-start=\"680\" data-end=\"907\">\r\n<li data-start=\"680\" data-end=\"798\">\r\n<p data-start=\"682\" data-end=\"798\">Once your return is received and inspected, we will notify you regarding the approval or rejection of your refund.</p>\r\n</li>\r\n<li data-start=\"799\" data-end=\"907\">\r\n<p data-start=\"801\" data-end=\"907\">If approved, the refund will be initiated within <strong data-start=\"850\" data-end=\"872\">7–10 business days</strong> to your original payment method.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"909\" data-end=\"941\"><strong data-start=\"909\" data-end=\"939\">4. Late or Missing Refunds</strong></p>\r\n<ul data-start=\"942\" data-end=\"1230\">\r\n<li data-start=\"942\" data-end=\"1033\">\r\n<p data-start=\"944\" data-end=\"1033\">If you haven’t received your refund within the timeline, first check your bank account.</p>\r\n</li>\r\n<li data-start=\"1034\" data-end=\"1121\">\r\n<p data-start=\"1036\" data-end=\"1121\">Then contact your bank or payment provider, as processing may take additional time.</p>\r\n</li>\r\n<li data-start=\"1122\" data-end=\"1230\">\r\n<p data-start=\"1124\" data-end=\"1230\">If you’ve done all this and still have not received your refund, contact us at support@[yourdomain].com.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1232\" data-end=\"1374\"><strong data-start=\"1232\" data-end=\"1248\">5. Exchanges</strong><br data-start=\"1248\" data-end=\"1251\">\r\nWe only replace items if they are defective or damaged. For exchange requests, contact us at 📧 support@[yourdomain].com.</p>\r\n<p data-start=\"1376\" data-end=\"1399\"><strong data-start=\"1376\" data-end=\"1397\">6. Shipping Costs</strong></p>\r\n<ul data-start=\"1400\" data-end=\"1557\">\r\n<li data-start=\"1400\" data-end=\"1497\">\r\n<p data-start=\"1402\" data-end=\"1497\">Return shipping costs may be deducted from your refund unless the return is due to our error.</p>\r\n</li>\r\n<li data-start=\"1498\" data-end=\"1557\">\r\n<p data-start=\"1500\" data-end=\"1557\">Original shipping charges are generally non-refundable.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1559\" data-end=\"1682\"><strong data-start=\"1559\" data-end=\"1576\">7. Contact Us</strong><br data-start=\"1576\" data-end=\"1579\">\r\nFor questions about refunds, contact:<br data-start=\"1616\" data-end=\"1619\">\r\n📧 Email: support@[yourdomain].com<br data-start=\"1653\" data-end=\"1656\">\r\n📞 Phone: +91-XXXXXXXXXX</p>\r\n<hr data-start=\"1684\" data-end=\"1687\">\r\n<h3 data-start=\"1689\" data-end=\"1713\">✅ SQL Insert Example</h3>\r\n<pre class=\"overflow-visible!\" data-start=\"1714\" data-end=\"2646\"><div class=\"contain-inline-size rounded-2xl relative bg-token-sidebar-surface-primary\"><div class=\"sticky top-9\"><div class=\"absolute end-0 bottom-0 flex h-9 items-center pe-2\"><div class=\"bg-token-bg-elevated-secondary text-token-text-secondary flex items-center gap-4 rounded-sm px-2 font-sans text-xs\"></div></div></div><div class=\"overflow-y-auto p-4\" dir=\"ltr\"><code class=\"whitespace-pre! language-sql\"><span class=\"hljs-keyword\">INSERT</span> <span class=\"hljs-keyword\">INTO</span> policies \r\n(`type`, `title`, `content`, `is_active`, `meta_title`, `meta_description`, `last_updated_by`, `created_at`, `updated_at`) \r\n<span class=\"hljs-keyword\">VALUES</span>\r\n(<span class=\"hljs-string\">\'policy\'</span>, <span class=\"hljs-string\">\'Refund Policy\'</span>, \r\n<span class=\"hljs-string\">\'Our Refund Policy allows customers to request a refund within 7 days of delivery. Conditions: (1) Item must be unused, original packaging, same condition. (2) Some items like perishable, personalized, and gift cards are non-refundable. (3) Refunds will be processed within 7–10 business days to the original payment method. (4) In case of delays, customers should check with bank/payment provider. (5) Exchanges allowed only for defective or damaged items. (6) Return shipping costs may apply, original shipping charges are non-refundable. (7) Contact: support@[yourdomain].com for refund queries.\'</span>, \r\n<span class=\"hljs-number\">1</span>, \r\n<span class=\"hljs-string\">\'Refund Policy\'</span>, \r\n<span class=\"hljs-string\">\'E-commerce Refund Policy covering eligibility, process, exchanges, and shipping cost details.\'</span>, \r\n<span class=\"hljs-number\">1</span>, NOW(), NOW());\r\n</code></div></div></pre>\r\n<hr data-start=\"2648\" data-end=\"2651\">\r\n<p data-start=\"2653\" data-end=\"2876\" data-is-last-node=\"\" data-is-only-node=\"\">👉 अब आपके पास <strong data-start=\"2668\" data-end=\"2723\">Terms &amp; Conditions, Privacy Policy और Refund Policy</strong> तीनों ready हैं।<br data-start=\"2740\" data-end=\"2743\">\r\nक्या आप चाहोगे कि मैं <strong data-start=\"2765\" data-end=\"2782\">Return Policy</strong> भी इसी तरह बना दूँ ताकि पूरा सेट (Terms, Privacy, Refund, Return) एक बार में complete हो जाए?</p></div></div></div></div><div class=\"flex min-h-[46px] justify-start\"></div></div></div></article><article class=\"text-token-text-primary w-full focus:outline-none scroll-mt-(--header-height)\" tabindex=\"-1\" dir=\"auto\" data-turn-id=\"3e87d515-1403-48fa-b53f-9b111904ef69\" data-testid=\"conversation-turn-15\" data-scroll-anchor=\"false\" data-turn=\"user\"><h5 class=\"sr-only\">You said:</h5><div class=\"text-base my-auto mx-auto pt-12 [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div data-message-author-role=\"user\" data-message-id=\"3e87d515-1403-48fa-b53f-9b111904ef69\" dir=\"auto\" class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\"><div class=\"flex w-full flex-col gap-1 empty:hidden items-end rtl:items-start\"><div class=\"user-message-bubble-color relative rounded-[18px] px-4 py-1.5 data-[multiline]:py-3 max-w-[var(--user-chat-width,70%)]\"><div class=\"whitespace-pre-wrap\">etutn policy</div></div></div></div></div><div class=\"flex justify-end\"></div></div></div></article><article class=\"text-token-text-primary w-full focus:outline-none scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" tabindex=\"-1\" dir=\"auto\" data-turn-id=\"request-WEB:0a313821-b1fc-448a-b531-04b7749ebf97-7\" data-testid=\"conversation-turn-16\" data-scroll-anchor=\"true\" data-turn=\"assistant\"><h6 class=\"sr-only\">ChatGPT said:</h6><div class=\"text-base my-auto mx-auto pb-10 [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div data-message-author-role=\"assistant\" data-message-id=\"629e3762-cc5f-4692-9bd0-e0ca75b38e3e\" dir=\"auto\" class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" data-message-model-slug=\"gpt-5\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words light markdown-new-styling\"><p data-start=\"0\" data-end=\"100\">ठीक है भाई 👍<br data-start=\"13\" data-end=\"16\">\r\nअब मैं आपको <strong data-start=\"28\" data-end=\"56\">E-commerce Return Policy</strong> का content और उसका SQL insert दे रहा हूँ।</p>\r\n<hr data-start=\"102\" data-end=\"105\">\r\n<h2 data-start=\"107\" data-end=\"158\">📑 Return Policy (Sample for E-Commerce Website)</h2>\r\n<p data-start=\"160\" data-end=\"336\"><strong data-start=\"160\" data-end=\"179\">1. Introduction</strong><br data-start=\"179\" data-end=\"182\">\r\nWe want you to be fully satisfied with your purchase. If you are not happy with your order, our Return Policy makes it easy to return eligible products.</p>\r\n<p data-start=\"338\" data-end=\"369\"><strong data-start=\"338\" data-end=\"367\">2. Eligibility for Return</strong></p>\r\n<ul data-start=\"370\" data-end=\"615\">\r\n<li data-start=\"370\" data-end=\"425\">\r\n<p data-start=\"372\" data-end=\"425\">Returns are accepted within <strong data-start=\"400\" data-end=\"410\">7 days</strong> of delivery.</p>\r\n</li>\r\n<li data-start=\"426\" data-end=\"495\">\r\n<p data-start=\"428\" data-end=\"495\">Items must be unused, undamaged, and in their original packaging.</p>\r\n</li>\r\n<li data-start=\"496\" data-end=\"615\">\r\n<p data-start=\"498\" data-end=\"615\">Certain items such as perishable goods, personalized/customized items, and gift cards are not eligible for returns.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"617\" data-end=\"640\"><strong data-start=\"617\" data-end=\"638\">3. Return Process</strong></p>\r\n<ul data-start=\"641\" data-end=\"919\">\r\n<li data-start=\"641\" data-end=\"746\">\r\n<p data-start=\"643\" data-end=\"746\">To initiate a return, contact us at 📧 support@[yourdomain].com within 7 days of receiving the order.</p>\r\n</li>\r\n<li data-start=\"747\" data-end=\"826\">\r\n<p data-start=\"749\" data-end=\"826\">Once approved, you will receive instructions for shipping the product back.</p>\r\n</li>\r\n<li data-start=\"827\" data-end=\"919\">\r\n<p data-start=\"829\" data-end=\"919\">The product must be shipped to us within the time frame mentioned in the approval email.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"921\" data-end=\"951\"><strong data-start=\"921\" data-end=\"949\">4. Inspection &amp; Approval</strong></p>\r\n<ul data-start=\"952\" data-end=\"1111\">\r\n<li data-start=\"952\" data-end=\"998\">\r\n<p data-start=\"954\" data-end=\"998\">Returned items are inspected upon receipt.</p>\r\n</li>\r\n<li data-start=\"999\" data-end=\"1111\">\r\n<p data-start=\"1001\" data-end=\"1111\">If the return is approved, you may choose between a <strong data-start=\"1053\" data-end=\"1063\">refund</strong> or <strong data-start=\"1067\" data-end=\"1082\">replacement</strong> (subject to availability).</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1113\" data-end=\"1136\"><strong data-start=\"1113\" data-end=\"1134\">5. Shipping Costs</strong></p>\r\n<ul data-start=\"1137\" data-end=\"1316\">\r\n<li data-start=\"1137\" data-end=\"1266\">\r\n<p data-start=\"1139\" data-end=\"1266\">Customers are responsible for paying return shipping costs unless the product delivered was defective, damaged, or incorrect.</p>\r\n</li>\r\n<li data-start=\"1267\" data-end=\"1316\">\r\n<p data-start=\"1269\" data-end=\"1316\">Original shipping charges are non-refundable.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1318\" data-end=\"1347\"><strong data-start=\"1318\" data-end=\"1345\">6. Non-Returnable Items</strong></p>\r\n<ul data-start=\"1348\" data-end=\"1487\">\r\n<li data-start=\"1348\" data-end=\"1384\">\r\n<p data-start=\"1350\" data-end=\"1384\">Products marked as “Final Sale.”</p>\r\n</li>\r\n<li data-start=\"1385\" data-end=\"1450\">\r\n<p data-start=\"1387\" data-end=\"1450\">Perishable items such as food, flowers, or other consumables.</p>\r\n</li>\r\n<li data-start=\"1451\" data-end=\"1487\">\r\n<p data-start=\"1453\" data-end=\"1487\">Custom or personalized products.</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1489\" data-end=\"1617\"><strong data-start=\"1489\" data-end=\"1506\">7. Contact Us</strong></p></div></div></div></div></div></div></article>', 1, 'g', '📑 Refund Policy (Sample for E-Commerce Website)\r\n1. Introduction\r\nOur Refund Policy ensures a smooth and transparent process in case you are not satisfied with y...', NULL, '2025-09-20 01:36:18', '2025-09-20 01:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`types`)),
  `weight` decimal(8,2) DEFAULT NULL,
  `weight_type` varchar(255) DEFAULT NULL,
  `min_order` int(11) NOT NULL DEFAULT 1,
  `max_order` int(11) DEFAULT NULL,
  `best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `specialities` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `featured_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `category_id`, `subcategory_id`, `name`, `slug`, `description`, `price`, `discount_price`, `product_image`, `types`, `weight`, `weight_type`, `min_order`, `max_order`, `best_seller`, `specialities`, `status`, `featured_type`, `created_at`, `updated_at`) VALUES
(1, 'PROD68ccec3fe6848', 1, 1, 'Special Kaju Kathli', 'special-kaju-kathli', 'Special Kaju Kathli', 633.00, 78.00, 'products/prod_68cd0936567ac.png', '[\"1000\"]', 56.00, 'gram', 1932, 83, 1, 1, 1, 'hot', '2025-09-19 00:08:07', '2025-09-19 02:12:09'),
(2, 'PROD68cd0aed34b0a', 5, 2, 'Khoya Barfi', 'khoya-barfi', 'hbejqh', 88.00, 87.00, 'products/prod_68cd0b5783eac.png', '[\"750\"]', 6.00, 'gram', 18, 66, 1, 1, 1, 'new_arrival', '2025-09-19 02:19:01', '2025-09-19 02:22:50'),
(3, 'PROD68cd0b308b180', 5, 2, 'Besan ki barfi', 'besan-ki-barfi', 'dssdf', 3223.00, 33.00, 'products/prod_68cd0b307ff27.png', '[\"1000\"]', 3.00, 'kilogram', 133, 3333, 1, 1, 1, 'new_arrival', '2025-09-19 02:20:08', '2025-09-19 02:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Hsst6e32qp0oOb4jjvKBHDZNoWNRIeV5xIhtbS9h', NULL, '192.168.1.14', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWHdvMDVpUXNib3lmNEZSbXRCVFRnRnNNdmlkNkN4NXBhUE54WFdRNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xOTIuMTY4LjEuMTg6ODAwMC9hZG1pbi9hZ2VudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1759589963),
('waNNbhZ4dAmMZxu3ffOpD60noHtXF9NT41Xm432L', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUVl1TndVZVVVZm9QWTBlc2VQbm1YUmRyWXZwNzlGODNBS0xGVVVCeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9icmFuY2giO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1759590544);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`, `subcategory_image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Laddu peda', 'subcategories/T0V7IuGoFPuYGxKbi30vrrdBTyLzTqaYmcOjoltR.png', 1, 0, '2025-09-18 23:47:58', '2025-09-18 23:47:58'),
(2, 5, 'Kadi Patta Namkeen', 'subcategories/tZ7l5eImxzAg3ud7RrmOwsYfvw9PybCRYPRUoqRb.png', 1, 0, '2025-09-19 02:16:10', '2025-09-19 02:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_logs`
--

CREATE TABLE `subscription_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `otp`, `purpose`, `is_verified`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'Saket', 'saket@gmail.com', '9936597936', '$2y$12$rkSdSjvGRQPWah1vi.DB1OqqvOBS/vvzZds0d2Pq7mudTjEikHqbO', NULL, NULL, 0, NULL, '2025-09-18 23:53:03', '2025-09-20 03:11:02'),
(2, 'anuj mishra', 'anuj@gmail.com', '8980119080', '$2y$12$P8sik8/VHUVUihVAFMOEM.DRK.0tmgs9T3LQnaXdlqhecApaXd2ta', '693793', 'signup', 0, NULL, '2025-09-18 23:58:24', '2025-09-18 23:58:24'),
(3, 'manish Doe', 'manish@gmail.com', '8980009090', '$2y$12$CvDt3AAre3ys5bgkbUR/m.YJWcce55EOc.frxpJsNywAv52XAHSqW', NULL, NULL, 1, '2025-09-19 00:03:59', '2025-09-19 00:00:47', '2025-09-20 07:30:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `advance_payments`
--
ALTER TABLE `advance_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`),
  ADD KEY `agents_bank_id_foreign` (`bank_id`),
  ADD KEY `agents_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `agent_tokens`
--
ALTER TABLE `agent_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `agent_tokens_agent_id_foreign` (`agent_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_code` (`bank_code`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_bank_id_foreign` (`bank_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `gold_items`
--
ALTER TABLE `gold_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gold_items_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_device_codes`
--
ALTER TABLE `oauth_device_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  ADD KEY `oauth_device_codes_user_id_index` (`user_id`),
  ADD KEY `oauth_device_codes_client_id_index` (`client_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_phone_index` (`phone`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `policies_type_unique` (`type`),
  ADD KEY `policies_last_updated_by_foreign` (`last_updated_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `subscription_logs`
--
ALTER TABLE `subscription_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_logs_user_id_foreign` (`user_id`),
  ADD KEY `subscription_logs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advance_payments`
--
ALTER TABLE `advance_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `agent_tokens`
--
ALTER TABLE `agent_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gold_items`
--
ALTER TABLE `gold_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_logs`
--
ALTER TABLE `subscription_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agents_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agent_tokens`
--
ALTER TABLE `agent_tokens`
  ADD CONSTRAINT `agent_tokens_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gold_items`
--
ALTER TABLE `gold_items`
  ADD CONSTRAINT `gold_items_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `policies_last_updated_by_foreign` FOREIGN KEY (`last_updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscription_logs`
--
ALTER TABLE `subscription_logs`
  ADD CONSTRAINT `subscription_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subscription_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
