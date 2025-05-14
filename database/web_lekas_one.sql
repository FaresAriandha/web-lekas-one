-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2025 at 02:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_lekas_one`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_bills`
--

CREATE TABLE `client_bills` (
  `cb_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cb_type` enum('pasjay','paxel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bill_client` int UNSIGNED NOT NULL,
  `total_paid_client` int UNSIGNED NOT NULL DEFAULT '0',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_bills`
--

INSERT INTO `client_bills` (`cb_ID`, `cb_type`, `total_bill_client`, `total_paid_client`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01js4e75s6m633bhw4176vtdxx', 'paxel', 640000, 0, NULL, '2025-04-18 05:33:17', '2025-04-21 07:51:11', NULL),
('01js4fezmccy7ehqb2651jtzrw', 'paxel', 200000, 100000, 'aman', '2025-04-19 05:55:01', '2025-04-25 07:38:18', NULL),
('01jsc81966dxpt2d975nk4hz2g', 'pasjay', 1073600, 0, NULL, '2025-04-17 06:19:07', '2025-04-21 07:14:31', NULL),
('01jsc93x7mhmdh0mk2hf9kj5j9', 'pasjay', 697200, 0, NULL, '2025-04-18 06:38:02', '2025-04-21 07:16:39', NULL),
('01jscbgm6s8wpz6vse0een5ryg', 'pasjay', 774000, 0, NULL, '2025-04-19 07:19:56', '2025-04-21 07:41:30', NULL),
('01jscct8sqh8p0y38wnta2xh1n', 'pasjay', 774000, 1000000, NULL, '2025-04-20 07:42:41', '2025-04-25 07:38:50', NULL),
('01jsghs5w3nyrbrg8a6fm9gd7x', 'pasjay', 662800, 0, NULL, '2025-04-20 22:26:25', '2025-04-22 23:33:38', NULL),
('01jsgpa2dbzx1py4ca5nkzr77m', 'pasjay', 662800, 0, NULL, '2025-04-21 23:45:33', '2025-04-22 23:58:12', NULL),
('01jsgqb8x8pzrqrqnscps5txmg', 'pasjay', 490400, 0, NULL, '2025-04-23 00:03:41', '2025-04-23 03:51:59', NULL),
('01jsgrsd83qt6gxjjm3hyay88q', 'pasjay', 765400, 0, NULL, '2025-04-24 00:28:53', '2025-04-23 01:58:51', NULL),
('01jsh0cdqzgps6x30ytd4vk0de', 'pasjay', 300600, 0, NULL, '2025-04-25 02:41:36', '2025-04-23 03:20:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_NIK` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_birthplace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_birthdate` date NOT NULL,
  `courier_telp` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_telp_darurat` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_nama_rekening` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_no_rekening` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_docs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`courier_ID`, `courier_name`, `courier_NIK`, `courier_birthplace`, `courier_birthdate`, `courier_telp`, `courier_telp_darurat`, `courier_gender`, `courier_address`, `courier_nama_rekening`, `courier_no_rekening`, `courier_img`, `courier_docs`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jq1rkhv6rfj4jje7qphnzjc0', 'test', '3010232903902302', 'Jakarta Selatan', '1991-07-17', '089783298932', '08297328878', 'male', 'Jl. Bahagia Sederhana', 'test', '8329320129', 'couriers/images/1742871002.png', 'couriers/docs/1742743189.pdf', '2024-03-23 08:05:41', '2025-04-09 00:38:13', NULL),
('01jq1sz89ky1sz2fcgq8myhfky', 'test test', '0239029302932903', 'test test', '2025-03-22', '089374398989', '089598239293', 'female', 'test test', 'test test', '0283923929', 'couriers/images/1742743773.png', 'couriers/docs/1742743773.pdf', '2025-03-23 08:29:33', '2025-04-12 08:22:44', '2025-04-14 17:00:00'),
('01jq38td3bhxncmvh1bd83fjpe', 'test test test test', '3293209012102909', 'Tangerang', '2025-03-31', '08962938928', '0896239832989', 'male', 'Jl. Tenang', 'test test test', '2320901201', 'couriers/images/1742792897.jpeg', 'couriers/docs/1742792897.pdf', '2025-03-23 22:08:17', '2025-04-08 23:35:52', NULL),
('01jq3fnaa3cbkgw9sypw2yv2y1', 'Fares Lekas', '2320293029302092', 'Tangerang', '2025-03-26', '08970238929', '089683489389', 'male', 'test', 'Fares', '2102910931', 'couriers/images/1746514141.jpeg', 'couriers/docs/1742870928.pdf', '2025-03-24 00:07:50', '2025-05-05 23:49:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courier_assigns`
--

CREATE TABLE `courier_assigns` (
  `cas_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cas_type` enum('pasjay','paxel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cas_pickup_time` timestamp NOT NULL,
  `cas_arrived_time` timestamp NULL DEFAULT NULL,
  `cas_start_time` timestamp NULL DEFAULT NULL,
  `cas_finish_time` timestamp NULL DEFAULT NULL,
  `cas_status` enum('Ditugaskan','Siap Pickup','Dalam Tugas','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ditugaskan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_assigns`
--

INSERT INTO `courier_assigns` (`cas_ID`, `courier_ID`, `cas_type`, `cas_pickup_time`, `cas_arrived_time`, `cas_start_time`, `cas_finish_time`, `cas_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jrck1fpbmdeyntjfctgd2spw', '01jq3fnaa3cbkgw9sypw2yv2y1', 'pasjay', '2025-04-10 01:00:00', NULL, NULL, NULL, 'Ditugaskan', '2025-04-08 23:15:47', '2025-04-09 01:44:46', '2025-04-09 01:44:46'),
('01jrckqh08j0wtnnr9f7436727', '01jq3fnaa3cbkgw9sypw2yv2y1', 'pasjay', '2025-04-10 08:00:00', '2025-04-09 08:03:10', NULL, NULL, 'Siap Pickup', '2025-04-08 23:27:49', '2025-04-09 01:03:10', NULL),
('01jrckw77srzhqasqsevyd9tmb', '01jq38td3bhxncmvh1bd83fjpe', 'pasjay', '2025-04-10 04:00:00', '2025-04-09 07:28:18', '2025-04-09 07:28:35', '2025-04-09 07:29:54', 'Selesai', '2025-04-08 23:30:23', '2025-04-09 00:29:54', NULL),
('01jrcm48346b9nwfewzs96kgha', '01jq1rkhv6rfj4jje7qphnzjc0', 'paxel', '2025-04-10 04:00:00', NULL, NULL, NULL, 'Ditugaskan', '2025-04-08 23:34:46', '2025-04-09 00:38:13', '2025-04-09 00:38:13'),
('01jrevww6gjx4fbderzz93gbp0', '01jq3fnaa3cbkgw9sypw2yv2y1', 'pasjay', '2025-04-14 02:00:00', NULL, NULL, NULL, 'Ditugaskan', '2025-04-09 20:29:02', '2025-04-09 20:29:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `fleet_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fleet_nopol` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fleet_type` enum('Van','Pickup','CDE Box') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fleet_merk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fleet_status` enum('DIGUNAKAN','TERSEDIA','PERBAIKAN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fleet_KIR_date` date NOT NULL,
  `fleet_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fleet_docs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`fleet_ID`, `fleet_nopol`, `courier_ID`, `fleet_type`, `fleet_merk`, `fleet_status`, `fleet_KIR_date`, `fleet_img`, `fleet_docs`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jq5sdnaxbf6kd8befccr5bpt', 'B 9772 UXX', '01jq3fnaa3cbkgw9sypw2yv2y1', 'Van', 'Daihatsu Gran Max', 'TERSEDIA', '2025-03-04', 'fleets/images/1742877414.pdf', 'fleets/docs/1742877414.pdf', '2025-03-24 21:36:54', '2025-03-25 00:52:30', NULL),
('01jq5thqf1xy86gn9gqcya0dg6', 'B 9668 UXC', NULL, 'Van', 'Daihatsu Gran Max AT', 'TERSEDIA', '2025-03-13', 'fleets/images/1742878596.pdf', 'fleets/docs/1742889062.pdf', '2025-03-24 21:56:36', '2025-04-07 04:42:03', NULL),
('01jq5wwsgn58t361xts35tky5b', 'B 9882 UXC', NULL, 'CDE Box', 'Isuzu Traga', 'TERSEDIA', '2025-02-24', 'fleets/images/1742887030.pdf', 'fleets/docs/1742881055.pdf', '2025-03-24 22:37:36', '2025-04-12 08:22:44', NULL),
('01jq64fhejv0baj5n6kqwjjqbd', 'B 9882 UXX', '01jq38td3bhxncmvh1bd83fjpe', 'Van', 'Daihatsu Gran Max', 'TERSEDIA', '2025-03-19', 'fleets/images/1742889010.pdf', 'fleets/docs/1742889010.pdf', '2025-03-25 00:50:10', '2025-04-07 04:38:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_22_033702_create_couriers_table', 2),
(9, '2025_03_24_072417_create_fleets_table', 3),
(11, '2025_03_26_131223_create_shipment_pasjay_locations', 4),
(12, '2025_04_07_030414_create_prices_table', 5),
(18, '2025_04_07_132530_create_assignees_table', 6),
(27, '2025_04_10_034217_create_paxel_shipments_table', 7),
(28, '2025_04_10_131631_create_paxel_bills_table', 7),
(29, '2025_04_18_112127_update_shipment_pasjay_locations_table', 8),
(30, '2025_04_18_120730_create_client_bills_table', 9),
(31, '2025_04_18_130411_create_pasar_jaya_shipments_table', 10),
(36, '2025_04_19_122220_create_bills_pasar_jaya_table', 11),
(37, '2025_04_28_104732_update_users_table', 12),
(38, '2025_04_29_130032_update_sessions_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `pasjay_bills`
--

CREATE TABLE `pasjay_bills` (
  `pjb_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shploc_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rit` int UNSIGNED NOT NULL,
  `total_location` int UNSIGNED NOT NULL DEFAULT '0',
  `total_bill_client` int UNSIGNED NOT NULL DEFAULT '0',
  `total_charge` int UNSIGNED NOT NULL DEFAULT '0',
  `paid_to_courier` int UNSIGNED NOT NULL DEFAULT '0',
  `roundtrip` tinyint(1) NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasjay_bills`
--

INSERT INTO `pasjay_bills` (`pjb_ID`, `courier_ID`, `shploc_ID`, `rit`, `total_location`, `total_bill_client`, `total_charge`, `paid_to_courier`, `roundtrip`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jsc8195w3x1nq43a95zgqj6g', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, 2, 212400, 190000, 410000, 0, NULL, '2025-04-17 06:19:07', '2025-04-25 05:43:27', NULL),
('01jsc871vacnqgcpvvybn8bq8g', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, 2, 238000, 210000, 0, 0, NULL, '2025-04-17 06:22:17', '2025-04-21 06:24:52', NULL),
('01jsc8jy5jjwgyveqsvmgy2gfh', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 3, 2, 238000, 210000, 0, 0, NULL, '2025-04-17 06:28:46', '2025-04-21 06:29:39', NULL),
('01jsc91mr8k3jftcw0x37vvqjg', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 1, 1, 195400, 180000, 150000, 0, NULL, '2025-04-17 06:36:48', '2025-04-25 05:44:00', NULL),
('01jsc93x7gjjbqp3djfbry9w51', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 1, 2, 232400, 200000, 0, 1, NULL, '2025-04-18 06:38:02', '2025-04-21 06:38:25', NULL),
('01jsc9n632vh26t83vxfncwdw9', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 2, 2, 232400, 200000, 0, 1, NULL, '2025-04-18 06:47:28', '2025-04-21 06:48:39', NULL),
('01jscb6q2b0s9xtcrj32amzsq3', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 3, 1, 189800, 170000, 0, 1, NULL, '2025-04-17 07:14:31', '2025-04-21 07:14:31', NULL),
('01jscb9wgypz5hgw6hfh0bkzty', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 3, 2, 232400, 200000, 0, 1, NULL, '2025-04-18 07:16:15', '2025-04-21 07:16:39', NULL),
('01jscbgm6m20k5ypwpgtrz7jkx', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 1, 2, 258000, 231000, 0, 1, NULL, '2025-04-19 07:19:56', '2025-04-21 07:37:55', NULL),
('01jsccmxhgykm09j38rmjavvf5', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, 2, 258000, 231000, 0, 1, NULL, '2025-04-19 07:39:45', '2025-04-21 07:40:21', NULL),
('01jsccqjbtj0dc4t86gtmnjyx7', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 3, 2, 258000, 231000, 0, 1, NULL, '2025-04-19 07:41:12', '2025-04-21 07:41:30', NULL),
('01jscct8sjxrsvy1ys6s0fjmj0', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 1, 2, 258000, 231000, 0, 1, NULL, '2025-04-20 07:42:41', '2025-04-21 07:43:23', NULL),
('01jsccwwpwv98nbpmynxf7zxe1', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 2, 2, 258000, 231000, 0, 1, NULL, '2025-04-20 07:44:06', '2025-04-21 07:44:44', NULL),
('01jsccz9f0fbd1b9pdqqvc3eze', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 3, 2, 258000, 231000, 0, 1, NULL, '2025-04-20 07:45:25', '2025-04-21 07:45:42', NULL),
('01jsghs5vqxcsf4v8f0b3n0qgp', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, 2, 212400, 190000, 0, 0, NULL, '2025-04-20 22:26:25', '2025-04-22 23:03:24', NULL),
('01jsgnc5zjzrdvbt283fam0253', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, 2, 238000, 210000, 0, 0, NULL, '2025-04-20 23:29:14', '2025-04-22 23:30:45', NULL),
('01jsgnkrfy8jrxf7nt4m4bksgs', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgjd8w9vcevg82th134hkh8', 3, 2, 212400, 190000, 0, 0, NULL, '2025-04-20 23:33:22', '2025-04-22 23:36:07', NULL),
('01jsgpa2d4nxy3gkh1sne8gkd2', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 2, 2, 212400, 190000, 0, 0, NULL, '2025-04-21 23:45:33', '2025-04-22 23:47:30', NULL),
('01jsgpkmjzqchj8e3zfnddz27c', '01jq38td3bhxncmvh1bd83fjpe', '01jsgjd8w9vcevg82th134hkh8', 1, 2, 212400, 190000, 0, 0, NULL, '2025-04-21 23:50:47', '2025-04-22 23:53:38', NULL),
('01jsgpy46x88ce8dpmwrjnzjhv', '01jq38td3bhxncmvh1bd83fjpe', '01jsgq20zfszdt421c97am2dxq', 3, 2, 238000, 210000, 0, 0, NULL, '2025-04-21 23:56:30', '2025-04-23 00:00:25', NULL),
('01jsgqb8x31gwmqkprd0cxe509', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 1, 2, 258000, 231000, 0, 1, NULL, '2025-04-23 00:03:41', '2025-04-23 00:55:35', NULL),
('01jsgqzpd6h0gv3j8y3vw3bjkd', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 2, 1, 169800, 160000, 0, 0, NULL, '2025-04-23 00:14:50', '2025-04-23 03:51:59', '2025-04-23 03:51:59'),
('01jsgrh1y4vssqf71kwcek49xw', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 3, 2, 232400, 200000, 0, 1, NULL, '2025-04-23 00:24:19', '2025-04-23 00:26:42', NULL),
('01jsgrsd7zn1kq5f7bqpby034d', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, 2, 232400, 200000, 0, 1, NULL, '2025-04-24 00:28:53', '2025-04-23 00:30:26', NULL),
('01jsgs1tz686vp1enzetjarhjx', '01jq38td3bhxncmvh1bd83fjpe', '01jsgjd8w9vcevg82th134hkh8', 2, 2, 232400, 200000, 0, 1, NULL, '2025-04-24 00:33:29', '2025-04-23 00:36:02', NULL),
('01jsgs927y3q53tm2wkeevd9ff', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgq20zfszdt421c97am2dxq', 3, 3, 300600, 261000, 0, 1, NULL, '2025-04-24 00:37:26', '2025-04-23 01:58:51', NULL),
('01jsh0cdqt89ehdazpf0aw7ekz', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgq20zfszdt421c97am2dxq', 1, 3, 300600, 261000, 71000, 1, NULL, '2025-04-25 02:41:36', '2025-04-25 05:47:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paxel_bills`
--

CREATE TABLE `paxel_bills` (
  `pxb_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `awb_total` int UNSIGNED NOT NULL,
  `awb_slot` enum('Pagi','Siang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bill_client` int UNSIGNED NOT NULL,
  `total_paid_client` int UNSIGNED NOT NULL DEFAULT '0',
  `paid_to_courier` int UNSIGNED NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paxel_bills`
--

INSERT INTO `paxel_bills` (`pxb_ID`, `courier_ID`, `awb_total`, `awb_slot`, `total_bill_client`, `total_paid_client`, `paid_to_courier`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01js4e75rwcsm310qftjxm9epz', '01jq3fnaa3cbkgw9sypw2yv2y1', 2, 'Pagi', 200000, 0, 100000, NULL, '2025-04-18 05:33:17', '2025-04-25 05:26:07', NULL),
('01js4ebkh6mw6sx129854ge6cs', '01jq3fnaa3cbkgw9sypw2yv2y1', 1, 'Siang', 200000, 0, 0, NULL, '2025-04-18 05:35:42', '2025-04-18 05:49:21', NULL),
('01js4ee8gxcefmkp7ngs4g3daq', '01jq38td3bhxncmvh1bd83fjpe', 12, 'Pagi', 240000, 0, 40000, NULL, '2025-04-18 05:37:07', '2025-04-25 05:26:15', NULL),
('01js4fezm9sz3d1kdef0k38vfz', '01jq3fnaa3cbkgw9sypw2yv2y1', 1, 'Pagi', 200000, 0, 200000, NULL, '2025-04-19 05:55:01', '2025-04-25 05:48:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8wyubw9FS0nZ3x5UjRmkCT8l5DPlzRoehkF8XKsP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGk2MG1ZTGNRSENZa2hsSVRJVmdidHhjbzFGaFhYQzBPV3JFRUZuQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1746619707),
('iWkNZ5opyc1Re658T9aDjwJibVLeFoxK3Qkg8qaP', '01jsy9d396d4j0aqmr17st8tne', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOGdlaE9HVnFXUnlWVHhDU0NXbTE0U0dGYzd0Ykhzdk9tRHc0RWg0ZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2Vycy8wMWpzeTlkMzk2ZDRqMGFxbXIxN3N0OHRuZS9lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MjY6IjAxanN5OWQzOTZkNGowYXFtcjE3c3Q4dG5lIjt9', 1746675991);

-- --------------------------------------------------------

--
-- Table structure for table `shipments_pasjay`
--

CREATE TABLE `shipments_pasjay` (
  `shpsj_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shploc_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rit` int UNSIGNED NOT NULL,
  `roundtrip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments_pasjay`
--

INSERT INTO `shipments_pasjay` (`shpsj_ID`, `courier_ID`, `shploc_ID`, `rit`, `roundtrip`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jsc8194x3qg5esd3afyhnq9v', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745241547.jpeg', '2025-04-17 06:19:07', '2025-04-21 06:19:07', NULL),
('01jsc826g4jz4fvwaky659k563', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 1, NULL, 'pasjay/surat_jalan/1745241577.jpeg', '2025-04-17 06:19:37', '2025-04-21 06:19:37', NULL),
('01jsc871tec6scja6wx3n77t6y', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 2, NULL, 'pasjay/surat_jalan/1745241737.jpeg', '2025-04-17 06:22:17', '2025-04-21 06:22:17', NULL),
('01jsc8bsx48k808kqbx2tb8hc9', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, NULL, 'pasjay/surat_jalan/1745241892.jpeg', '2025-04-17 06:24:52', '2025-04-21 06:24:52', NULL),
('01jsc8jy4nmyrhxsf1ydv082d5', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 3, NULL, 'pasjay/surat_jalan/1745242126.jpeg', '2025-04-17 06:28:46', '2025-04-21 06:28:46', NULL),
('01jsc8mhv5azfvg149bybdkkyf', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 3, NULL, 'pasjay/surat_jalan/1745242179.jpeg', '2025-04-17 06:29:39', '2025-04-21 06:29:39', NULL),
('01jsc91mqwmn0jfgvedwp7t16r', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 1, NULL, 'pasjay/surat_jalan/1745242608.png', '2025-04-17 06:36:48', '2025-04-21 06:36:48', NULL),
('01jsc93x768krkvdxjxgtvz3gd', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 1, NULL, 'pasjay/surat_jalan/1745242682.jpeg', '2025-04-18 06:38:02', '2025-04-21 06:38:02', NULL),
('01jsc94m04g478zdgc21867gq9', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 1, 'pasjay/round_trip/1745242705.png', 'pasjay/surat_jalan/1745242705.png', '2025-04-18 06:38:25', '2025-04-21 06:38:25', NULL),
('01jsc9n62symddmbjxx4bhjhd6', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 2, 'pasjay/round_trip/1745243248.jpeg', 'pasjay/surat_jalan/1745243248.jpeg', '2025-04-18 06:47:28', '2025-04-21 06:47:28', NULL),
('01jsc9qaz2cw1zz4ap8vb1w27w', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 2, NULL, 'pasjay/surat_jalan/1745243319.png', '2025-04-18 06:48:39', '2025-04-21 06:48:39', NULL),
('01jscb6q1n263ws6qzp39gbnfq', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 3, 'pasjay/round_trip/1745244871.jpeg', 'pasjay/surat_jalan/1745244871.png', '2025-04-17 07:14:31', '2025-04-21 07:14:31', NULL),
('01jscb9wgj9hwyh158jgw16f40', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 3, 'pasjay/round_trip/1745244975.png', 'pasjay/surat_jalan/1745244975.jpeg', '2025-04-18 07:16:15', '2025-04-21 07:16:15', NULL),
('01jscbam5drzdxnhsx8wnv1p32', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 3, 'pasjay/round_trip/1745244999.jpeg', 'pasjay/surat_jalan/1745244999.jpeg', '2025-04-18 07:16:39', '2025-04-21 07:16:39', NULL),
('01jscbgm69jwzahkbqz13gtmbh', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745245196.jpeg', '2025-04-19 07:19:56', '2025-04-21 07:19:56', NULL),
('01jscchhf8dwc962qaa0d546j0', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 1, 'pasjay/round_trip/1745246275.jpeg', 'pasjay/surat_jalan/1745246275.jpeg', '2025-04-19 07:37:55', '2025-04-21 07:37:55', NULL),
('01jsccmxh6wvnq61qk9k47f1y5', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 2, 'pasjay/round_trip/1745246385.png', 'pasjay/surat_jalan/1745246385.jpeg', '2025-04-19 07:39:45', '2025-04-21 07:39:45', NULL),
('01jsccp0kj0mb95h2wkqshs3y3', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, NULL, 'pasjay/surat_jalan/1745246421.png', '2025-04-19 07:40:21', '2025-04-21 07:40:21', NULL),
('01jsccqjbf9wmm0gayq33b4r5p', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 3, 'pasjay/round_trip/1745246472.png', 'pasjay/surat_jalan/1745246472.jpeg', '2025-04-19 07:41:12', '2025-04-21 07:41:12', NULL),
('01jsccr3nkgcjbr6xysx31geny', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 3, 'pasjay/round_trip/1745246490.jpeg', 'pasjay/surat_jalan/1745246490.png', '2025-04-19 07:41:30', '2025-04-21 07:41:30', NULL),
('01jscct8s7xv9vyf3vwnms5r76', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 1, NULL, 'pasjay/surat_jalan/1745246561.png', '2025-04-20 07:42:41', '2025-04-21 07:42:41', NULL),
('01jsccvhttz5drvc0jv7r7mrv2', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 1, 'pasjay/round_trip/1745246603.png', 'pasjay/surat_jalan/1745246603.jpeg', '2025-04-20 07:43:23', '2025-04-21 07:43:23', NULL),
('01jsccwwpgmk7kdgbex7j2ev8t', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 2, 'pasjay/round_trip/1745246646.png', 'pasjay/surat_jalan/1745246646.png', '2025-04-20 07:44:06', '2025-04-21 07:44:06', NULL),
('01jsccy1c628vdxd0cqsww359q', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 2, NULL, 'pasjay/surat_jalan/1745246684.png', '2025-04-20 07:44:44', '2025-04-21 07:44:44', NULL),
('01jsccz9en4m624tf2z8dw6hmc', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 3, 'pasjay/round_trip/1745246725.jpeg', 'pasjay/surat_jalan/1745246725.png', '2025-04-20 07:45:25', '2025-04-21 07:45:25', NULL),
('01jscczspqrq2fyhvgqxy5sf53', '01jq38td3bhxncmvh1bd83fjpe', '01jsc30gvmyt049azdfqshq0m6', 3, 'pasjay/round_trip/1745246742.jpeg', 'pasjay/surat_jalan/1745246742.png', '2025-04-20 07:45:42', '2025-04-21 07:45:42', NULL),
('01jsghs5tbyr0t3rfjgr3wjsw4', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745385985.png', '2025-04-20 22:26:25', '2025-04-22 23:02:40', NULL),
('01jsghtz950sgf1yrhkc6hp8kz', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgjd8w9vcevg82th134hkh8', 1, NULL, 'pasjay/surat_jalan/1745386044.jpeg', '2025-04-20 22:27:24', '2025-04-22 23:03:24', NULL),
('01jsgnc5z5mf3rxw0sv45ss5hb', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, NULL, 'pasjay/surat_jalan/1745389754.jpeg', '2025-04-20 23:29:14', '2025-04-22 23:30:45', NULL),
('01jsgnddrh51z4kxt4qnvqy8ph', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgjd8w9vcevg82th134hkh8', 2, NULL, 'pasjay/surat_jalan/1745389795.png', '2025-04-20 23:29:55', '2025-04-22 23:29:55', NULL),
('01jsgnkrf8dj8s6v6z3rf1073j', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jses04axj5acncdzj1556mkb', 3, NULL, 'pasjay/surat_jalan/1745390002.png', '2025-04-20 23:33:22', '2025-04-22 23:36:07', NULL),
('01jsgnm8a0nyez6rdtc807f56j', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgjd8w9vcevg82th134hkh8', 3, NULL, 'pasjay/surat_jalan/1745390018.png', '2025-04-20 23:33:38', '2025-04-22 23:33:38', NULL),
('01jsgpa2cd40xy5a11xhwpsfs2', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 2, NULL, 'pasjay/surat_jalan/1745390733.png', '2025-04-21 23:45:33', '2025-04-22 23:45:33', NULL),
('01jsgpb9w5wyvxw1f5wts4bxyb', '01jq38td3bhxncmvh1bd83fjpe', '01jses04axj5acncdzj1556mkb', 2, NULL, 'pasjay/surat_jalan/1745390774.jpeg', '2025-04-21 23:46:14', '2025-04-22 23:47:30', NULL),
('01jsgpkmj9jvzzhd9xe985xb1c', '01jq38td3bhxncmvh1bd83fjpe', '01jsgjd8w9vcevg82th134hkh8', 1, NULL, 'pasjay/surat_jalan/1745391047.png', '2025-04-21 23:50:47', '2025-04-22 23:52:44', NULL),
('01jsgpn3aed71pk0nq72j9p6bd', '01jq38td3bhxncmvh1bd83fjpe', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745391095.png', '2025-04-21 23:51:35', '2025-04-22 23:53:38', NULL),
('01jsgpy467vvzkzq9drct59fd2', '01jq38td3bhxncmvh1bd83fjpe', '01js4bfpw7qw3sce5s71v4w1gv', 3, NULL, 'pasjay/surat_jalan/1745391390.jpeg', '2025-04-21 23:56:30', '2025-04-23 00:01:17', NULL),
('01jsgq17dp2ax3b339x50zmhpq', '01jq38td3bhxncmvh1bd83fjpe', '01jsgq20zfszdt421c97am2dxq', 3, NULL, 'pasjay/surat_jalan/1745391492.jpeg', '2025-04-21 23:58:12', '2025-04-23 00:00:25', NULL),
('01jsgqb8wcxsstvnfvr5z2j01b', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, 'pasjay/round_trip/1745394580.png', 'pasjay/surat_jalan/1745391821.jpeg', '2025-04-23 00:03:41', '2025-04-23 00:49:40', NULL),
('01jsgqbrtdj5rhgrevc41e9et3', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 1, 'pasjay/round_trip/1745394380.png', 'pasjay/surat_jalan/1745394380.jpeg', '2025-04-23 00:03:58', '2025-04-23 00:55:35', NULL),
('01jsgqzpcf0e88m8h9a027sfq2', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 2, NULL, 'pasjay/surat_jalan/1745392490.jpeg', '2025-04-23 00:14:50', '2025-04-23 03:51:59', '2025-04-23 03:51:59'),
('01jsgr5hbzq9hkbsnvytafj9jq', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bfpw7qw3sce5s71v4w1gv', 2, 'pasjay/round_trip/1745392775.jpeg', 'pasjay/surat_jalan/1745392682.jpeg', '2025-04-23 00:18:02', '2025-04-23 03:50:06', '2025-04-23 03:50:06'),
('01jsgrh1xs5n39y15srweddshz', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsc30gvmyt049azdfqshq0m6', 3, NULL, 'pasjay/surat_jalan/1745393059.jpeg', '2025-04-23 00:24:19', '2025-04-23 00:26:42', NULL),
('01jsgrhh0gsx99d6drvgjpyjfm', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jses04axj5acncdzj1556mkb', 3, 'pasjay/round_trip/1745393139.jpeg', 'pasjay/surat_jalan/1745393075.jpeg', '2025-04-23 00:24:35', '2025-04-23 00:25:40', NULL),
('01jsgrsd78901h7eb5ctc4jrh1', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745393333.png', '2025-04-24 00:28:53', '2025-04-23 00:28:53', NULL),
('01jsgrsyn839hxratwy242d275', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jses04axj5acncdzj1556mkb', 1, 'pasjay/round_trip/1745393426.png', 'pasjay/surat_jalan/1745393351.jpeg', '2025-04-24 00:29:11', '2025-04-23 00:30:26', NULL),
('01jsgs1tyfmg998gv7a2de2jrg', '01jq38td3bhxncmvh1bd83fjpe', '01jsgjd8w9vcevg82th134hkh8', 2, NULL, 'pasjay/surat_jalan/1745393609.jpeg', '2025-04-24 00:33:29', '2025-04-23 00:33:29', NULL),
('01jsgs2bjsgqe2tycyjacnmmb6', '01jq38td3bhxncmvh1bd83fjpe', '01jses04axj5acncdzj1556mkb', 2, 'pasjay/round_trip/1745395357.jpeg', 'pasjay/surat_jalan/1745393626.jpeg', '2025-04-24 00:33:46', '2025-04-23 01:02:37', NULL),
('01jsgs927mv73thjhr4vyvxbcq', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgq20zfszdt421c97am2dxq', 3, NULL, 'pasjay/surat_jalan/1745393846.jpeg', '2025-04-24 00:37:26', '2025-04-23 00:40:58', NULL),
('01jsgs9gv9jxs04f4csc1fycc5', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jses04axj5acncdzj1556mkb', 3, 'pasjay/round_trip/1745394098.jpeg', 'pasjay/surat_jalan/1745393861.jpeg', '2025-04-24 00:37:41', '2025-04-23 02:23:42', NULL),
('01jsgxy52g0nhxervxysg7aaen', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 3, 'pasjay/round_trip/1745398731.jpeg', 'pasjay/surat_jalan/1745398731.png', '2025-04-24 01:58:51', '2025-04-23 01:58:51', NULL),
('01jsh0cdqe8aer2470f1zvczq1', '01jq3fnaa3cbkgw9sypw2yv2y1', '01js4bprhjcnn38jphddnh0fae', 1, NULL, 'pasjay/surat_jalan/1745401296.jpeg', '2025-04-25 02:41:36', '2025-04-23 02:41:36', NULL),
('01jsh0fv16t5pjf0w0xf43ce30', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jses04axj5acncdzj1556mkb', 1, NULL, 'pasjay/surat_jalan/1745401408.png', '2025-04-25 02:43:28', '2025-04-23 02:43:28', NULL),
('01jsh0r4wacv003112ckqt42pg', '01jq3fnaa3cbkgw9sypw2yv2y1', '01jsgq20zfszdt421c97am2dxq', 1, 'pasjay/round_trip/1745403137.png', 'pasjay/surat_jalan/1745401680.jpeg', '2025-04-25 02:48:00', '2025-04-23 03:12:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipments_paxel`
--

CREATE TABLE `shipments_paxel` (
  `shpxl_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `awb_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `awb_slot` enum('Pagi','Siang') COLLATE utf8mb4_unicode_ci NOT NULL,
  `awb_status` enum('Siap Antar','Selesai','Dikembalikan','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Siap Antar',
  `awb_hub` enum('HALIM','MANGGA DUA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `awb_finish_time` timestamp NULL DEFAULT NULL,
  `awb_pod` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments_paxel`
--

INSERT INTO `shipments_paxel` (`shpxl_ID`, `courier_ID`, `awb_number`, `awb_slot`, `awb_status`, `awb_hub`, `awb_finish_time`, `awb_pod`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01js4e75qhj36g88xdzrxg3dnf', '01jq3fnaa3cbkgw9sypw2yv2y1', 'fares test tambah', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:33:17', '2025-04-18 05:33:17', NULL),
('01js4ea14aggjw46p4jvn70apx', '01jq3fnaa3cbkgw9sypw2yv2y1', 'tambah fares dua', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:34:50', '2025-04-18 05:34:50', NULL),
('01js4ebkght5b8f9q74f848zgn', '01jq3fnaa3cbkgw9sypw2yv2y1', 'tambah fares siang', 'Siang', 'Dikembalikan', 'HALIM', NULL, 'paxel/pod_awb/1744980476.jpeg', '2025-04-18 05:35:42', '2025-04-18 05:49:21', NULL),
('01js4ee8gqy2aw3znnz8nj31f7', '01jq38td3bhxncmvh1bd83fjpe', 'EM.YEFA881DYO-20250228-4-LPAPT8', 'Pagi', 'Dikembalikan', 'HALIM', NULL, 'paxel/pod_awb/1744980043.png', '2025-04-18 05:37:07', '2025-04-18 05:40:43', NULL),
('01js4ee8gqy2aw3znnz8nj31f8', '01jq38td3bhxncmvh1bd83fjpe', 'EM.0I6HEAK6VA-20250228-1-UEIST5', 'Pagi', 'Selesai', 'HALIM', NULL, 'paxel/pod_awb/1744980411.png', '2025-04-18 05:37:07', '2025-04-18 05:46:51', NULL),
('01js4ee8gqy2aw3znnz8nj31f9', '01jq38td3bhxncmvh1bd83fjpe', 'EM.5BWC1GXLNK-20250228-1-F8VO3H', 'Pagi', 'Dikembalikan', 'HALIM', NULL, 'paxel/pod_awb/1744980166.png', '2025-04-18 05:37:07', '2025-04-21 07:51:11', NULL),
('01js4ee8gqy2aw3znnz8nj31fa', '01jq38td3bhxncmvh1bd83fjpe', 'EM.5CYTPB81YD-20250228-1-O6ET3P', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:52:43', '2025-04-18 05:52:43'),
('01js4ee8gqy2aw3znnz8nj31fb', '01jq38td3bhxncmvh1bd83fjpe', 'EM.BNS4CU14SH-20250228-1-DXP6WP', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fc', '01jq38td3bhxncmvh1bd83fjpe', 'EM.6N5TL4TJOA-20250228-2-G15QNY', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fd', '01jq38td3bhxncmvh1bd83fjpe', 'EM.JBQG3O0ADX-20250227-1-GB76TA', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fe', '01jq38td3bhxncmvh1bd83fjpe', 'EM.21QRL5771O-20250228-2-KU3CO2', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31ff', '01jq38td3bhxncmvh1bd83fjpe', 'EM.FP237X6SGK-20250228-1-KJ4GL1', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fg', '01jq38td3bhxncmvh1bd83fjpe', 'EM.3L7TJGEY0S-20250228-1-L5M0BC', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fh', '01jq38td3bhxncmvh1bd83fjpe', 'EM.PKT5IKEMDP-20250228-2-Y8CADC', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fj', '01jq38td3bhxncmvh1bd83fjpe', 'EM.PKT5IKEMDP-20250228-1-KSLU5X', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4ee8gqy2aw3znnz8nj31fk', '01jq38td3bhxncmvh1bd83fjpe', 'EM.FFJ1DS2JDX-20250228-1-XR8CWM', 'Pagi', 'Siap Antar', 'HALIM', NULL, NULL, '2025-04-18 05:37:07', '2025-04-18 05:37:09', NULL),
('01js4fezm0pk4dwv221gr4js5t', '01jq3fnaa3cbkgw9sypw2yv2y1', 'fares tambah beda tanggal', 'Pagi', 'Siap Antar', 'MANGGA DUA', NULL, NULL, '2025-04-19 05:55:01', '2025-04-18 05:55:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_pasjay_locations`
--

CREATE TABLE `shipment_pasjay_locations` (
  `shploc_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shploc_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shploc_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `spl_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shploc_url_maps` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_pasjay_locations`
--

INSERT INTO `shipment_pasjay_locations` (`shploc_ID`, `shploc_name`, `shploc_address`, `spl_ID`, `shploc_url_maps`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01js4bfpw7qw3sce5s71v4w1gv', 'Jakmart Rusun Pesakih Baru', 'Duri Kosambi, Cengkareng, West Jakarta City, Jakarta', '01jr7gj3z0d9cd9hjrqh0641ff', 'https://www.google.com/maps/place/Rusun+Pesakih/@-6.16146,106.71701,1022m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2e69f8222f9975d9:0xd5b87563bbc3aac0!8m2!3d-6.16146!4d106.71701!16s%2Fg%2F11gtznrfsj?entry=ttu&g_ep=EgoyMDI1MDQxNC4xIKXMDSoASAFQAw%3D%3D', '2025-04-18 04:45:31', '2025-04-18 04:51:30', NULL),
('01js4bprhjcnn38jphddnh0fae', 'Jakmart Rusun Meruya', 'test', '01jr7gzd4jn9d3ggr6g3q2m6t2', 'https://www.google.com/maps/place/Matahari+Mall+Daan+Mogot+Baru/@-6.1528731,106.7135178,8179m/data=!3m2!1e3!5s0x2e69f810bbb3c2c1:0xc7e661a79c7c237e!4m14!1m7!3m6!1s0x2e69f8222f9975d9:0xd5b87563bbc3aac0!2sRusun+Pesakih!8m2!3d-6.16146!4d106.71701!16s%2Fg%2F11gtznrfsj!3m5!1s0x2e69f81afb4872a3:0xa71f7f357281548c!8m2!3d-6.1516476!4d106.7143072!16s%2Fg%2F11bc5bt4jd?entry=ttu&g_ep=EgoyMDI1MDQxNC4xIKXMDSoASAFQAw%3D%3D', '2025-04-18 04:49:22', '2025-04-18 04:50:31', NULL),
('01jsc30gvmyt049azdfqshq0m6', 'Jakmart Utara Satu', 'test', '01jr7gzd4jn9d3ggr6g3q2m6t2', 'https://www.figma.com/design/qVssraGUK2sHJzYg4BV75G/Mockup-Lekas-One?node-id=0-1&p=f&t=iob4dfPyDw0FxyjG-0', '2025-04-21 04:51:20', '2025-04-21 04:51:20', NULL),
('01jses04axj5acncdzj1556mkb', 'Jakmart Pasar Minggu', 'test', '01jr7k5x7sc5s1refqc36nkc70', 'https://www.figma.com/design/qVssraGUK2sHJzYg4BV75G/Mockup-Lekas-One?node-id=0-1&p=f&t=IVVO4T71eNOnjUVs-0', '2025-04-22 05:54:04', '2025-04-22 05:54:04', NULL),
('01jsgjd8w9vcevg82th134hkh8', 'Jakmart Utara Dua', 'test', '01jr7gzd4jn9d3ggr6g3q2m6t2', 'https://www.figma.com/design/qVssraGUK2sHJzYg4BV75G/Mockup-Lekas-One?node-id=0-1&p=f&t=CUSZvX1NtLqZ1CUm-0', '2025-04-22 22:37:24', '2025-04-22 22:37:24', NULL),
('01jsgq20zfszdt421c97am2dxq', 'Jakmart Grogol', 'test', '01jr7gj3z0d9cd9hjrqh0641ff', 'https://www.figma.com/design/qVssraGUK2sHJzYg4BV75G/Mockup-Lekas-One?node-id=0-1&p=f&t=CUSZvX1NtLqZ1CUm-0', '2025-04-22 23:58:38', '2025-04-22 23:58:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_price_lists`
--

CREATE TABLE `shipment_price_lists` (
  `spl_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spl_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spl_type` enum('pasjay','paxel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `spl_baseprice` int UNSIGNED NOT NULL,
  `spl_baseprice_client` int UNSIGNED NOT NULL,
  `spl_multidrop` int UNSIGNED NOT NULL,
  `spl_multidrop_client` int UNSIGNED NOT NULL,
  `spl_roundtrip` int UNSIGNED NOT NULL,
  `spl_roundtrip_client` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_price_lists`
--

INSERT INTO `shipment_price_lists` (`spl_ID`, `spl_name`, `spl_type`, `spl_baseprice`, `spl_baseprice_client`, `spl_multidrop`, `spl_multidrop_client`, `spl_roundtrip`, `spl_roundtrip_client`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jr7gj3z0d9cd9hjrqh0641ff', 'Jakarta Barat', 'pasjay', 180000, 195400, 30000, 42600, 21000, 20000, '2025-04-06 23:56:14', '2025-04-18 04:47:03', NULL),
('01jr7gzd4jn9d3ggr6g3q2m6t2', 'Jakarta Utara', 'pasjay', 160000, 169800, 30000, 42600, 10000, 20000, '2025-04-07 00:03:29', '2025-04-18 04:50:31', NULL),
('01jr7js2fd50zznvg30dapnsa5', 'AWB', 'paxel', 20000, 20000, 0, 0, 0, 0, '2025-04-07 00:34:59', '2025-04-07 00:34:59', NULL),
('01jr7k5x7sc5s1refqc36nkc70', 'Jakarta Selatan', 'pasjay', 150000, 161000, 30000, 42600, 13000, 20000, '2025-04-07 00:41:59', '2025-04-18 04:38:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_ID` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` enum('admin','korlap','kurir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `courier_ID`, `user_name`, `username`, `password`, `user_role`, `user_img`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
('01jsy8hx8ccszexe8ne95w33ep', NULL, 'Rizkyadi Ihwan', 'rizkylks21', '$2y$12$xjKlGy4WYBLKbZ1t/5ZQYeTr3Hs9.MRcf.mXQ0fI49YG5Gz9TDRrG', 'korlap', 'users/images/1746015998.png', NULL, '2025-04-28 06:14:32', '2025-04-30 05:31:43', NULL),
('01jsy9d396d4j0aqmr17st8tne', '01jq3fnaa3cbkgw9sypw2yv2y1', 'Fares Lekas', 'fareslks21', '$2y$12$ffU6Id0x82ExL86/paTgl.AoZgAJ4/aE7HhkXPauXY5W0URtI6f3G', 'kurir', 'couriers/images/1746514141.jpeg', NULL, '2025-04-28 06:29:23', '2025-05-05 23:49:01', NULL),
('01jsyg9hyms5pkn8b2evz8411n', NULL, 'Robby Gunawan Sinaga', 'robbylks21', '$2y$12$u0OtDjy80TWpk61WbL8EPuOpaGMdGJPcZSKtTIV1w0XLcDuok89j.', 'admin', 'users/images/1745854316.png', NULL, '2025-04-28 08:29:47', '2025-04-29 07:54:26', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `client_bills`
--
ALTER TABLE `client_bills`
  ADD PRIMARY KEY (`cb_ID`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`courier_ID`),
  ADD UNIQUE KEY `couriers_courier_nik_unique` (`courier_NIK`);

--
-- Indexes for table `courier_assigns`
--
ALTER TABLE `courier_assigns`
  ADD PRIMARY KEY (`cas_ID`),
  ADD KEY `courier_assigns_courier_id_foreign` (`courier_ID`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`fleet_ID`),
  ADD UNIQUE KEY `fleets_fleet_nopol_unique` (`fleet_nopol`),
  ADD UNIQUE KEY `fleets_courier_id_unique` (`courier_ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasjay_bills`
--
ALTER TABLE `pasjay_bills`
  ADD PRIMARY KEY (`pjb_ID`),
  ADD KEY `pasjay_bills_courier_id_foreign` (`courier_ID`),
  ADD KEY `pasjay_bills_shploc_id_foreign` (`shploc_ID`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `paxel_bills`
--
ALTER TABLE `paxel_bills`
  ADD PRIMARY KEY (`pxb_ID`),
  ADD KEY `paxel_bills_courier_id_foreign` (`courier_ID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipments_pasjay`
--
ALTER TABLE `shipments_pasjay`
  ADD PRIMARY KEY (`shpsj_ID`),
  ADD KEY `shipments_pasjay_courier_id_foreign` (`courier_ID`),
  ADD KEY `shipments_pasjay_shploc_id_foreign` (`shploc_ID`);

--
-- Indexes for table `shipments_paxel`
--
ALTER TABLE `shipments_paxel`
  ADD PRIMARY KEY (`shpxl_ID`),
  ADD UNIQUE KEY `shipments_paxel_awb_number_unique` (`awb_number`),
  ADD KEY `shipments_paxel_courier_id_foreign` (`courier_ID`);

--
-- Indexes for table `shipment_pasjay_locations`
--
ALTER TABLE `shipment_pasjay_locations`
  ADD PRIMARY KEY (`shploc_ID`),
  ADD UNIQUE KEY `shipment_pasjay_locations_shploc_name_unique` (`shploc_name`),
  ADD KEY `shipment_pasjay_locations_spl_id_foreign` (`spl_ID`);

--
-- Indexes for table `shipment_price_lists`
--
ALTER TABLE `shipment_price_lists`
  ADD PRIMARY KEY (`spl_ID`),
  ADD UNIQUE KEY `shipment_price_lists_spl_name_unique` (`spl_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_courier_id_foreign` (`courier_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courier_assigns`
--
ALTER TABLE `courier_assigns`
  ADD CONSTRAINT `courier_assigns_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE CASCADE;

--
-- Constraints for table `fleets`
--
ALTER TABLE `fleets`
  ADD CONSTRAINT `fleets_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`);

--
-- Constraints for table `pasjay_bills`
--
ALTER TABLE `pasjay_bills`
  ADD CONSTRAINT `pasjay_bills_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasjay_bills_shploc_id_foreign` FOREIGN KEY (`shploc_ID`) REFERENCES `shipment_pasjay_locations` (`shploc_ID`) ON DELETE CASCADE;

--
-- Constraints for table `paxel_bills`
--
ALTER TABLE `paxel_bills`
  ADD CONSTRAINT `paxel_bills_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE CASCADE;

--
-- Constraints for table `shipments_pasjay`
--
ALTER TABLE `shipments_pasjay`
  ADD CONSTRAINT `shipments_pasjay_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipments_pasjay_shploc_id_foreign` FOREIGN KEY (`shploc_ID`) REFERENCES `shipment_pasjay_locations` (`shploc_ID`) ON DELETE CASCADE;

--
-- Constraints for table `shipments_paxel`
--
ALTER TABLE `shipments_paxel`
  ADD CONSTRAINT `shipments_paxel_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE CASCADE;

--
-- Constraints for table `shipment_pasjay_locations`
--
ALTER TABLE `shipment_pasjay_locations`
  ADD CONSTRAINT `shipment_pasjay_locations_spl_id_foreign` FOREIGN KEY (`spl_ID`) REFERENCES `shipment_price_lists` (`spl_ID`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_courier_id_foreign` FOREIGN KEY (`courier_ID`) REFERENCES `couriers` (`courier_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
