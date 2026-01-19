-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2026 at 03:13 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `category_id`, `title`, `author`, `description`, `cover_path`, `stock`, `created_at`, `updated_at`) VALUES
(1, 3, 'Bumi', 'Tereliye', 'buku fantasi', 'covers/sT1GHBJLz0Jx2hawk55JEXQybAdUrxGNa2xQPjfl.jpg', 17, '2026-01-11 00:16:47', '2026-01-18 22:23:22'),
(2, 3, 'Matahari Minor', 'Tereliye', 'novel fiksi', 'covers/rWtkB6Atqd6ifqeFj8laVVNmvL5CM8MbXgkaxh9P.jpg', 14, '2026-01-11 01:19:20', '2026-01-18 23:44:09'),
(3, 3, 'Bulan', 'Tereliye', 'series dari novel bumi', 'covers/q6Uw4TOlTuNe7lSl7DLcCCC3aK05fkjafZB6NZ5o.jpg', 8, '2026-01-13 00:30:27', '2026-01-19 08:05:48'),
(4, 8, 'Kuasai Bahasa Inggris', 'Suyana Hasan', 'Buku ini berisi ulasan lengkap tentang belajar Bahasa Inggris, meliputi membaca (reading), menulis (writing), dan berbicara (speaking). Disusun secara praktis sehingga sangat mudah dipahami serta mudah dibaca kapan saja dan di mana saja. Buku ini juga membahas tentang 13 tenses “terlarang”, parts of speech, time (waktu), jurus-juru merakit kalimat dalam Bahasa Inggris, dan sebagainya.', 'covers/HTMKUA0NPWhq8P53utXaCWF89IybhAgmYRzj4r8S.jpg', 10, '2026-01-18 18:09:41', '2026-01-18 22:46:15'),
(5, 3, 'Bintang', 'Tereliye', 'Serial \"Bintang\" adalah judul buku ke-4 dalam Serial Bumi karya Tere Liye, yang melanjutkan petualangan Raib, Seli, dan Ali di dunia paralel, mengungkap rahasia Klan Bintang, dan memperkenalkan karakter Miss Selena serta petualangan ke Klan Bintang yang penuh misteri, menjadi bagian dari saga besar yang melibatkan Klan Bumi, Bulan, Matahari, dan Bintang dengan kemampuan unik mereka.', 'covers/AMgEhwzIYBbP4nctVnWuzzZmYvIWvn8SzrhgOpxL.jpg', 10, '2026-01-19 06:22:55', '2026-01-19 06:22:55'),
(6, 3, 'Matahari', 'Tereliye', 'Matahari adalah novel ketiga dalam Seri Bumi Tere Liye, melanjutkan petualangan Raib, Seli, dan Ali ke dunia paralel Klan Matahari , mengungkap lebih banyak misteri, tokoh baru seperti Faar, dan teknologi canggih, dengan cerita yang lebih menegangkan dan mendalam tentang persahabatan mereka di dunia fantasi.', 'covers/WiO5TBL6rRR8PVtiMerrRiLNDRM0ldndr13lREu6.jpg', 10, '2026-01-19 06:25:48', '2026-01-19 06:25:48'),
(7, 8, 'Belajar Bahasa Inggris', 'Wahida Murriska', 'Buku Praktis Belajar Bahasa Inggris', 'covers/aEiBFhRcOtKZRJs1Rr8tkJaN0PHdIgtlaQAQzTfk.jpg', 8, '2026-01-19 06:32:20', '2026-01-19 06:32:34'),
(8, 1, 'Teknologi untuk Masa Depan', 'NAJELAA SHIHAB & KOMUNITAS GURU BELAJAR', 'Buku ini berisi kumpulan praktik baik pengajaran guru dengan tema teknologi yang terbagi ke dalam lima topik, yakni Teknologi untuk Memanusiakan hubungan (Praktik pembelajaran yang dilandasi orientasi pada anak berdasarkan relasi positif yang saling memahami antara guru, murid, dan orang tua); Teknologi untuk Memahami Konsep (Strategi pembelajaran yang memandu murid menguasai pemahaman mendalam terhadap berbagai konsep); Teknologi untuk membangun Keberlanjutan (Strategi pembelajaran yang memandu murid mengalami rute pengalaman belajar yang terarah dan berkelanjutan melalui umpan balik dan berbagi praktik baik);', 'covers/ieEWDHWBzOvzMm8q71JZqJLDiri2yY4wGnxLdagS.jpg', 10, '2026-01-19 06:37:07', '2026-01-19 06:37:07');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(2, 'Pemrograman', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(3, 'Novel', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(4, 'Bisnis', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(5, 'Sains', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(6, 'Agama', '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(8, 'Bahasa', '2026-01-18 18:06:06', '2026-01-18 18:06:06');

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
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` bigint UNSIGNED NOT NULL,
  `loan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `days_late` int NOT NULL,
  `amount` int NOT NULL,
  `status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `loan_id`, `user_id`, `days_late`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(2, 25, 4, 2, 4000, 'unpaid', NULL, '2026-01-18 23:04:59', '2026-01-18 23:04:59'),
(3, 25, 4, 2, 4000, 'unpaid', NULL, '2026-01-18 23:05:06', '2026-01-18 23:05:06');

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
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('pending','approved','returned','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `loan_date`, `due_date`, `return_date`, `status`, `created_at`, `updated_at`) VALUES
(12, 2, 3, '2026-01-17', '2026-01-24', '2026-01-19', 'returned', '2026-01-17 06:36:47', '2026-01-18 17:57:46'),
(13, 2, 2, '2026-01-18', '2026-01-25', NULL, 'rejected', '2026-01-18 06:12:48', '2026-01-18 19:29:15'),
(14, 4, 3, '2026-01-18', '2026-01-19', '2026-01-19', 'returned', '2026-01-18 09:39:48', '2026-01-18 19:12:58'),
(15, 4, 2, '2026-01-18', '2026-01-25', '2026-01-19', 'returned', '2026-01-18 09:53:28', '2026-01-18 19:20:23'),
(16, 2, 4, '2026-01-19', '2026-01-20', NULL, 'rejected', '2026-01-18 18:31:12', '2026-01-18 18:52:29'),
(17, 2, 4, '2026-01-19', '2026-01-20', NULL, 'rejected', '2026-01-18 18:54:08', '2026-01-18 19:29:10'),
(18, 2, 3, '2026-01-19', '2026-01-20', NULL, 'rejected', '2026-01-18 19:01:16', '2026-01-18 19:29:06'),
(19, 4, 1, '2026-01-19', '2026-01-20', NULL, 'rejected', '2026-01-18 19:04:49', '2026-01-18 19:29:05'),
(20, 4, 4, '2026-01-19', '2026-01-20', NULL, 'rejected', '2026-01-18 19:21:16', '2026-01-18 19:29:01'),
(21, 4, 3, '2026-01-15', '2026-01-18', '2026-01-19', 'returned', '2026-01-18 19:30:16', '2026-01-18 19:38:51'),
(22, 4, 1, '2026-01-15', '2026-01-17', '2026-01-19', 'returned', '2026-01-18 19:37:04', '2026-01-18 21:59:42'),
(23, 4, 4, '2026-01-18', '2026-01-19', '2026-01-19', 'returned', '2026-01-18 21:42:26', '2026-01-18 22:46:15'),
(24, 4, 1, '2026-01-19', '2026-01-18', '2026-01-19', 'returned', '2026-01-18 22:15:42', '2026-01-18 22:23:22'),
(25, 4, 3, '2026-01-16', '2026-01-17', '2026-01-19', 'returned', '2026-01-18 22:51:37', '2026-01-18 23:44:19'),
(26, 4, 2, '2026-01-19', '2026-01-20', '2026-01-19', 'returned', '2026-01-18 23:07:29', '2026-01-18 23:44:09'),
(27, 4, 3, '2026-01-19', '2026-01-20', '2026-01-19', 'returned', '2026-01-19 00:12:47', '2026-01-19 08:05:48'),
(28, 4, 1, '2026-01-19', '2026-01-21', NULL, 'pending', '2026-01-19 05:20:55', '2026-01-19 05:20:55');

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
(4, '2025_11_21_072959_create_categories_table', 1),
(5, '2025_11_21_073053_create_books_table', 1),
(6, '2025_11_21_073113_create_loans_table', 1),
(7, '2025_11_21_073133_create_reviews_table', 1),
(8, '2026_01_06_121422_remove_loan_duration_from_books_table', 1),
(9, '2026_01_06_121436_remove_loan_duration_from_books_table', 1),
(10, '2026_01_06_124841_create_fines_table', 1),
(11, '2026_01_13_051102_add_is_admin_to_users_table', 2),
(12, '2026_01_17_130024_change_status_enum_on_loans_table', 3),
(13, '2026_01_19_011922_create_notifications_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0b442656-0f75-4c0f-8730-9f00c7a22dc8', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":27,\"user\":\"Tiara\",\"book\":\"Bulan\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-19 05:21:36', '2026-01-19 00:12:51', '2026-01-19 05:21:36'),
('151669ba-4b58-43b1-b60c-3af87bc5a85a', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":27,\"user\":\"Tiara\",\"book\":\"Bulan\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-19 00:12:51', '2026-01-19 00:12:51'),
('1ea58a97-00d2-49f1-b1cc-9a7852d98749', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Kuasai Bahasa Inggris\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:29', '2026-01-18 21:43:13', '2026-01-19 05:20:29'),
('361892bf-1f85-4f87-ac53-eb21b43d3a2c', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":25,\"user\":\"Tiara\",\"book\":\"Bulan\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-18 22:51:37', '2026-01-18 22:51:37'),
('558f1e9e-3f1b-4d68-badb-ee1136ff9e0e', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Buku \'Matahari Minor\' telah dikembalikan.\"}', '2026-01-18 19:29:50', '2026-01-18 19:20:23', '2026-01-18 19:29:50'),
('5fee334e-f804-41aa-b2c3-accceeff8705', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Bulan\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:29', '2026-01-18 19:38:51', '2026-01-19 05:20:29'),
('6784ba59-1103-4ce4-ae6d-56501ddb6978', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 2, '{\"message\":\"Pengajuan pinjaman buku \'Bulan\' DITOLAK.\"}', NULL, '2026-01-18 19:29:06', '2026-01-18 19:29:06'),
('69760fa5-e4a2-4e64-9e3e-12d2754a9821', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Bumi\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:29', '2026-01-18 19:38:56', '2026-01-19 05:20:29'),
('6d4958ed-1da1-4c78-a8a5-3001474076da', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Matahari Minor\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:28', '2026-01-18 23:08:07', '2026-01-19 05:20:28'),
('78f5ca18-62cd-4fed-a08f-b1c561534afe', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":26,\"user\":\"Tiara\",\"book\":\"Matahari Minor\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-18 23:07:29', '2026-01-18 23:07:29'),
('80299d59-e234-433c-b66e-621c961406f8', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":25,\"user\":\"Tiara\",\"book\":\"Bulan\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-19 05:21:36', '2026-01-18 22:51:37', '2026-01-19 05:21:36'),
('8e5260be-f160-4bc1-adb3-98612dd3e7dd', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Bumi\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:29', '2026-01-18 22:16:55', '2026-01-19 05:20:29'),
('9e97e51f-1a54-4bfa-9b9a-a189b4086f6f', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":22,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-18 19:37:33', '2026-01-18 19:37:04', '2026-01-18 19:37:33'),
('b8a57024-a603-4e15-93c2-af4c2d28ee1f', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 2, '{\"message\":\"Pengajuan pinjaman buku \'Kuasai Bahasa Inggris\' DITOLAK.\"}', NULL, '2026-01-18 19:29:10', '2026-01-18 19:29:10'),
('ba6b16d8-5056-440b-aa6f-84fcbcc88ce3', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Matahari Minor\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-18 19:29:50', '2026-01-18 19:20:16', '2026-01-18 19:29:50'),
('bbf7ca11-f4bd-4ac8-a9e7-d2bb3caa3458', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Bulan\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', NULL, '2026-01-19 05:23:51', '2026-01-19 05:23:51'),
('cc42320a-cba6-4880-b63d-779d06dddc48', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":24,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-18 22:48:39', '2026-01-18 22:15:42', '2026-01-18 22:48:39'),
('cd7a9151-ed98-4895-ba5f-7dc1ffc9f96b', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan pinjaman buku \'Bumi\' DITOLAK.\"}', '2026-01-18 19:29:50', '2026-01-18 19:29:05', '2026-01-18 19:29:50'),
('ce53e13d-3129-4245-b0ef-7ca9cca12c0e', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":28,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-19 05:20:59', '2026-01-19 05:20:59'),
('d0a48325-39ed-4e3d-a0d5-23c88a1a160d', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 2, '{\"message\":\"Pengajuan pinjaman buku \'Matahari Minor\' DITOLAK.\"}', NULL, '2026-01-18 19:29:15', '2026-01-18 19:29:15'),
('d12d3746-1ad0-4a4d-89a6-d7604fec229e', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":28,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-19 05:21:36', '2026-01-19 05:20:59', '2026-01-19 05:21:36'),
('e2597609-1b69-4a33-8f1b-48cfddc61fe2', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":24,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-18 22:15:42', '2026-01-18 22:15:42'),
('e96aae3c-4d59-4c35-b73b-b6e46c14b99d', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":23,\"user\":\"Tiara\",\"book\":\"Kuasai Bahasa Inggris\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-18 21:43:03', '2026-01-18 21:42:30', '2026-01-18 21:43:03'),
('e9bcbe2f-ef94-464b-ac52-5be8939c7ba3', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":23,\"user\":\"Tiara\",\"book\":\"Kuasai Bahasa Inggris\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-18 21:42:30', '2026-01-18 21:42:30'),
('ef7e91cb-af7a-4154-8e10-1205bbafb743', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan pinjaman buku \'Kuasai Bahasa Inggris\' DITOLAK.\"}', '2026-01-18 19:29:50', '2026-01-18 19:29:01', '2026-01-18 19:29:50'),
('f1bbd4ea-51f3-4da6-80e4-582d94fbdc17', 'App\\Notifications\\LoanStatusNotification', 'App\\Models\\User', 4, '{\"message\":\"Pengajuan buku \'Bulan\' disetujui. \\n                Buku bisa diambil di perpustakaan.\"}', '2026-01-19 05:20:29', '2026-01-18 22:52:17', '2026-01-19 05:20:29'),
('fbeaba43-b083-4ddd-a7cb-54f6a3ba6b26', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 1, '{\"loan_id\":26,\"user\":\"Tiara\",\"book\":\"Matahari Minor\",\"message\":\"Pengajuan pinjaman baru\"}', '2026-01-19 05:21:36', '2026-01-18 23:07:29', '2026-01-19 05:21:36'),
('ff6ce0ba-9f5c-47c6-a1a9-ac8cf754441a', 'App\\Notifications\\NewLoanNotification', 'App\\Models\\User', 3, '{\"loan_id\":22,\"user\":\"Tiara\",\"book\":\"Bumi\",\"message\":\"Pengajuan pinjaman baru\"}', NULL, '2026-01-18 19:37:04', '2026-01-18 19:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL DEFAULT '1',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('caCFM62BAIJrPywYV7KmrpFpojs05QIE6YmBeU3B', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWpzcmRoUGYyeWJZeURqcXBqRkRhTG9FM3U4bjZ3a1NmYWJQUm9RYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9fQ==', 1768835167);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Perpus', 'admin@mail.com', NULL, '$2y$12$8oh.GQNdVokiQ72AuF2rPublWSBmyze3yOIeWnq2p/BdjZHtMrNvO', 'admin', NULL, '2026-01-07 20:51:58', '2026-01-07 20:51:58'),
(2, 'Mahasiswa Ganteng', 'user@mail.com', NULL, '$2y$12$nXCvJtkyTs9z4jpBX2KHOuWXmR4.ZUyfRb9cyuYd/sGUOO8g0d5L6', 'user', NULL, '2026-01-07 20:51:59', '2026-01-07 20:51:59'),
(3, 'Adminperpus', 'admin@perpus.com', NULL, '$2y$12$jpBZIVKTu8KtERg0YvpHTOFbWWMuTORWYEzt5UD6o5V3ZwTSuzp36', 'admin', NULL, '2026-01-10 23:35:25', '2026-01-10 23:35:25'),
(4, 'Tiara', 'tiara@mail.com', NULL, '$2y$12$zG3Wafd.hCEqFgK/Th2R6eIVjC/Dx1YbjJMobumaatCRNSRIlqvnq', 'user', NULL, '2026-01-18 08:18:25', '2026-01-18 08:18:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_category_id_foreign` (`category_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fines_loan_id_foreign` (`loan_id`),
  ADD KEY `fines_user_id_foreign` (`user_id`);

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
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`),
  ADD KEY `loans_book_id_foreign` (`book_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_book_id_foreign` (`book_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
