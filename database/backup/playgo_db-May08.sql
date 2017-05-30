-- phpMyAdmin SQL Dump
-- version 4.6.5.2deb1+deb.cihar.com~xenial.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2017 at 11:06 AM
-- Server version: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playgo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `banned_by` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `reason` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `opponent_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT '0',
  `opponent_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `length` int(11) NOT NULL,
  `start_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `confirm_tokens`
--

CREATE TABLE `confirm_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `confirm_tokens`
--

INSERT INTO `confirm_tokens` (`id`, `user_id`, `token`, `expired_at`, `created_at`, `updated_at`) VALUES
(2, 7, 'CF8D6E1BD82E2644504C84280CCCA4C5', '2017-04-23 10:08:42', '2017-04-21 03:08:42', '2017-04-21 03:08:42'),
(4, 8, '7009F9FF8C77F5561D03BA9857FBBC92', '2017-04-26 03:23:01', '2017-04-23 20:23:01', '2017-04-23 20:23:01'),
(5, 9, 'CAA4B8B9EFE0E92E1BB6539500A0AFA9', '2017-04-26 03:47:29', '2017-04-23 20:47:29', '2017-04-23 20:47:29'),
(6, 10, 'BA30D1FFE28D552E67063E1526EDF7BF', '2017-04-26 04:40:37', '2017-04-23 21:40:37', '2017-04-23 21:40:37'),
(7, 11, 'BEB8E313A526F28B72345D82CE59B598', '2017-04-26 08:04:04', '2017-04-24 01:04:04', '2017-04-24 01:04:04'),
(10, 14, '2ED17267CF577FFB8E105BE10DC8B95D', '2017-04-26 09:31:11', '2017-04-24 02:31:11', '2017-04-24 02:31:11'),
(11, 15, 'B9EF8AA765C6BB8FF3D4B5DD3FEF260F', '2017-04-26 10:42:25', '2017-04-24 03:42:25', '2017-04-24 03:42:25'),
(13, 18, 'B6C6B0D5393D5835348250E59C538123', '2017-04-28 03:46:38', '2017-04-25 20:46:38', '2017-04-25 20:46:38'),
(14, 19, '294878C454DA021188487237D9F0B8B0', '2017-04-28 03:53:14', '2017-04-25 20:53:14', '2017-04-25 20:53:14'),
(15, 20, 'A6B7B195285E9C81027DC61AB630A023', '2017-04-28 03:54:12', '2017-04-25 20:54:12', '2017-04-25 20:54:12'),
(16, 21, '83762CA6C977FC647D8A8B169E5177D0', '2017-04-28 03:58:01', '2017-04-25 20:58:01', '2017-04-25 20:58:01'),
(17, 22, '0C6FF35C6497D86776EF009985EA4133', '2017-04-28 04:10:50', '2017-04-25 21:10:50', '2017-04-25 21:10:50'),
(18, 23, '792AEAA0768A05CC80240758B88EEA72', '2017-04-28 04:14:26', '2017-04-25 21:14:26', '2017-04-25 21:14:26'),
(19, 24, '9E32E8C807C62F631185669AF83D71B4', '2017-04-28 04:30:33', '2017-04-25 21:30:33', '2017-04-25 21:30:33'),
(20, 25, '59CE499F0C4F8880DE2E7B484D36C765', '2017-04-28 04:34:00', '2017-04-25 21:34:00', '2017-04-25 21:34:00'),
(21, 26, '19D8245F07375A0B74FD27717FF6DDA7', '2017-04-28 04:40:49', '2017-04-25 21:40:49', '2017-04-25 21:40:49'),
(22, 27, 'F9499C1FBABC4835B137886EB115C141', '2017-04-28 04:43:21', '2017-04-25 21:43:21', '2017-04-25 21:43:21'),
(23, 30, 'CFD736348B05223EEADE14470A9F30BA', '2017-04-28 07:09:00', '2017-04-26 00:09:00', '2017-04-26 00:09:00'),
(24, 31, '1504B4D9E47E9749EEE17B4F44616D53', '2017-04-28 07:23:49', '2017-04-26 00:23:49', '2017-04-26 00:23:49'),
(25, 32, '3BFED358DDF063CCF275039AFCD8220A', '2017-04-28 07:25:11', '2017-04-26 00:25:11', '2017-04-26 00:25:11'),
(26, 33, '04AD75531D7AC1EF0B711C12D01DF8F5', '2017-04-28 07:59:12', '2017-04-26 00:59:12', '2017-04-26 00:59:12'),
(29, 7, '30C61FDCBEA38B92DC2F539C75C89A37', '2017-04-27 04:29:40', '2017-04-26 19:29:40', '2017-04-26 19:29:40'),
(74, 23, '732788DF271FC3CB02A4143B7EEE77D0', '2017-05-03 05:49:08', '2017-05-02 20:49:08', '2017-05-02 20:49:08'),
(75, 5, 'F1583F1CE0DC40B60D194CB4BD67B664', '2017-05-03 05:51:55', '2017-05-02 20:51:55', '2017-05-02 20:51:55'),
(95, 4, 'AFFF128675311AE8C6E32FFBE221318D', '2017-05-04 12:02:45', '2017-05-04 03:02:45', '2017-05-04 03:02:45'),
(102, 102, 'A16428055DCC5A39580360F260A392BE', '2017-05-05 04:56:21', '2017-05-04 19:56:21', '2017-05-04 19:56:21'),
(103, 142, '05E4DB439F5DF09D673D1A2FD821C6F1', '2017-05-07 03:13:01', '2017-05-04 20:13:01', '2017-05-04 20:13:01'),
(104, 11, '9B607AA50E97A23F39EDC72D1DBCD301', '2017-05-05 05:32:25', '2017-05-04 20:32:25', '2017-05-04 20:32:25'),
(105, 151, '48666EDE6065EE3A6A7F1FC9CF42FE3E', '2017-05-07 07:03:56', '2017-05-05 00:03:56', '2017-05-05 00:03:56'),
(110, 161, '7E1ACCC67697109147CF8C9E9502C65E', '2017-05-07 08:20:44', '2017-05-05 01:20:44', '2017-05-05 01:20:44'),
(112, 142, 'CB0936C59D41F9F2F6F2A96B765768B5', '2017-05-05 11:05:04', '2017-05-05 02:05:04', '2017-05-05 02:05:04'),
(115, 142, '6EC845BBA54FE1D77CE8933890929DE8', '2017-05-05 11:14:07', '2017-05-05 02:14:07', '2017-05-05 02:14:07'),
(116, 142, '3A09B4353547581ADE1971A0644137AE', '2017-05-05 11:23:20', '2017-05-05 02:23:20', '2017-05-05 02:23:20'),
(117, 142, '4271D64B8A736F1EED24EE0C53FBB380', '2017-05-05 11:25:19', '2017-05-05 02:25:19', '2017-05-05 02:25:19'),
(118, 163, 'EE49446C01C01E330F9CD5409FAAD208', '2017-05-07 09:31:01', '2017-05-05 02:31:01', '2017-05-05 02:31:01'),
(119, 11, '58189C6F02671F7B4CEC19E18C6DFC8C', '2017-05-05 11:34:03', '2017-05-05 02:34:03', '2017-05-05 02:34:03'),
(120, 11, 'DD6202011B09D8F574776B7D50CDA85F', '2017-05-05 11:36:27', '2017-05-05 02:36:27', '2017-05-05 02:36:27'),
(122, 165, 'FEAE32C1F27605DE055E10D78F6B14AE', '2017-05-07 09:46:47', '2017-05-05 02:46:47', '2017-05-05 02:46:47'),
(123, 11, 'D53C1E591E11FFF00A372902FE2BC67D', '2017-05-05 11:48:12', '2017-05-05 02:48:12', '2017-05-05 02:48:12'),
(125, 166, '01BFC2BEBCCBB33DC3AFB65DC30EEAFA', '2017-05-07 09:54:59', '2017-05-05 02:54:59', '2017-05-05 02:54:59'),
(126, 167, '776F69D3318F21938D4E91D373225DC0', '2017-05-07 09:56:42', '2017-05-05 02:56:42', '2017-05-05 02:56:42'),
(130, 173, '3B7ED8E794B641BF53054E1BCE5D25D1', '2017-05-07 11:16:29', '2017-05-05 04:16:29', '2017-05-05 04:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `disputes`
--

CREATE TABLE `disputes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `challenge_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(10) UNSIGNED NOT NULL,
  `platform_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rate` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `platform_id`, `user_id`, `name`, `path`, `description`, `rate`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Call of duty', '/upload/games/game5.jpg', '', 5, '2017-04-21 03:57:50', '2017-04-21 03:57:50'),
(2, 1, 2, 'top game 1', '/upload/games/game4.jpg', '', 10, '2017-04-24 20:25:07', '2017-04-24 20:25:07'),
(3, 2, 2, 'top game 2', '/upload/games/game3.jpg\r\n', '', 7, '2017-04-24 20:25:07', '2017-04-24 20:25:07'),
(4, 3, 2, 'top game 3', '/upload/games/game2.jpg', '', 8, '2017-04-24 20:25:07', '2017-04-24 20:25:07'),
(5, 3, 2, 'top game 4', '/upload/games/game1.jpg', '', 9, '2017-04-24 20:28:30', '2017-04-24 20:28:30'),
(6, 1, 2, 'top game 1', '/upload/games/game1.jpg', '', 10, '2017-04-25 04:30:47', '2017-04-25 04:30:47'),
(7, 2, 2, 'top game 2', '/upload/games/game2.jpg', '', 7, '2017-04-25 04:30:47', '2017-04-25 04:30:47'),
(8, 3, 2, 'top game 3', '/upload/games/game3.jpg', '', 8, '2017-04-25 04:30:47', '2017-04-25 04:30:47'),
(9, 3, 2, 'top game 4', '/upload/games/game4.jpg', '', 9, '2017-04-25 04:30:47', '2017-04-25 04:30:47'),
(10, 1, 2, 'Call of duty', '/upload/games/game5.jpg', '', 9, '2017-04-25 04:30:47', '2017-04-25 04:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `result_id` int(10) UNSIGNED NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_code` int(11) NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location`, `short_name`, `path`, `phone_code`, `region`, `created_at`, `updated_at`) VALUES
(1, 'Andorra', 'AD', '.ad', 376, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(2, 'United Arab Emirates', 'AE', '.ae', 971, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(3, 'Afghanistan', 'AF', '.af', 93, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(4, 'Antigua and Barbuda', 'AG', '.ag', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(5, 'Anguilla', 'AI', '.ai', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(6, 'Albania', 'AL', '.al', 355, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(7, 'Armenia', 'AM', '.am', 374, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(8, 'Angola', 'AO', '.ao', 244, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(9, 'Antarctica', 'AQ', '.aq', 0, 'AN', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(10, 'Argentina', 'AR', '.ar', 54, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(11, 'American Samoa', 'AS', '.as', 1, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(12, 'Austria', 'AT', '.at', 43, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(13, 'Australia', 'AU', '.au', 61, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(14, 'Aruba', 'AW', '.aw', 297, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(15, 'Aland Islands', 'AX', '.ax', 358, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(16, 'Azerbaijan', 'AZ', '.az', 994, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(17, 'Bosnia and Herzegovina', 'BA', '.ba', 387, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(18, 'Barbados', 'BB', '.bb', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(19, 'Bangladesh', 'BD', '.bd', 880, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(20, 'Belgium', 'BE', '.be', 32, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(21, 'Burkina Faso', 'BF', '.bf', 226, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(22, 'Bulgaria', 'BG', '.bg', 359, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(23, 'Bahrain', 'BH', '.bh', 973, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(24, 'Burundi', 'BI', '.bi', 257, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(25, 'Benin', 'BJ', '.bj', 229, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(26, 'Saint Barthelemy', 'BL', '.gp', 590, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(27, 'Bermuda', 'BM', '.bm', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(28, 'Brunei', 'BN', '.bn', 673, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(29, 'Bolivia', 'BO', '.bo', 591, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(30, 'Bonaire, Saint Eustatius and Saba ', 'BQ', '.bq', 599, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(31, 'Brazil', 'BR', '.br', 55, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(32, 'Bahamas', 'BS', '.bs', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(33, 'Bhutan', 'BT', '.bt', 975, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(34, 'Bouvet Island', 'BV', '.bv', 0, 'AN', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(35, 'Botswana', 'BW', '.bw', 267, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(36, 'Belarus', 'BY', '.by', 375, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(37, 'Belize', 'BZ', '.bz', 501, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(38, 'Canada', 'CA', '.ca', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(39, 'Cocos Islands', 'CC', '.cc', 61, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(40, 'Democratic Republic of the Congo', 'CD', '.cd', 243, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(41, 'Central African Republic', 'CF', '.cf', 236, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(42, 'Republic of the Congo', 'CG', '.cg', 242, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(43, 'Switzerland', 'CH', '.ch', 41, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(44, 'Ivory Coast', 'CI', '.ci', 225, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(45, 'Cook Islands', 'CK', '.ck', 682, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(46, 'Chile', 'CL', '.cl', 56, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(47, 'Cameroon', 'CM', '.cm', 237, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(48, 'China', 'CN', '.cn', 86, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(49, 'Colombia', 'CO', '.co', 57, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(50, 'Costa Rica', 'CR', '.cr', 506, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(51, 'Cuba', 'CU', '.cu', 53, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(52, 'Cape Verde', 'CV', '.cv', 238, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(53, 'Curacao', 'CW', '.cw', 599, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(54, 'Christmas Island', 'CX', '.cx', 61, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(55, 'Cyprus', 'CY', '.cy', 357, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(56, 'Czechia', 'CZ', '.cz', 420, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(57, 'Germany', 'DE', '.de', 49, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(58, 'Djibouti', 'DJ', '.dj', 253, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(59, 'Denmark', 'DK', '.dk', 45, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(60, 'Dominica', 'DM', '.dm', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(61, 'Dominican Republic', 'DO', '.do', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(62, 'Algeria', 'DZ', '.dz', 213, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(63, 'Ecuador', 'EC', '.ec', 593, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(64, 'Estonia', 'EE', '.ee', 372, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(65, 'Egypt', 'EG', '.eg', 20, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(66, 'Western Sahara', 'EH', '.eh', 212, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(67, 'Eritrea', 'ER', '.er', 291, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(68, 'Spain', 'ES', '.es', 34, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(69, 'Ethiopia', 'ET', '.et', 251, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(70, 'Finland', 'FI', '.fi', 358, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(71, 'Fiji', 'FJ', '.fj', 679, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(72, 'Falkland Islands', 'FK', '.fk', 500, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(73, 'Micronesia', 'FM', '.fm', 691, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(74, 'Faroe Islands', 'FO', '.fo', 298, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(75, 'France', 'FR', '.fr', 33, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(76, 'Gabon', 'GA', '.ga', 241, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(77, 'United Kingdom', 'GB', '.uk', 44, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(78, 'Grenada', 'GD', '.gd', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(79, 'Georgia', 'GE', '.ge', 995, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(80, 'French Guiana', 'GF', '.gf', 594, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(81, 'Guernsey', 'GG', '.gg', 44, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(82, 'Ghana', 'GH', '.gh', 233, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(83, 'Gibraltar', 'GI', '.gi', 350, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(84, 'Greenland', 'GL', '.gl', 299, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(85, 'Gambia', 'GM', '.gm', 220, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(86, 'Guinea', 'GN', '.gn', 224, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(87, 'Guadeloupe', 'GP', '.gp', 590, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(88, 'Equatorial Guinea', 'GQ', '.gq', 240, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(89, 'Greece', 'GR', '.gr', 30, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(90, 'South Georgia and the South Sandwich Islands', 'GS', '.gs', 0, 'AN', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(91, 'Guatemala', 'GT', '.gt', 502, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(92, 'Guam', 'GU', '.gu', 1, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(93, 'Guinea-Bissau', 'GW', '.gw', 245, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(94, 'Guyana', 'GY', '.gy', 592, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(95, 'Hong Kong', 'HK', '.hk', 852, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(96, 'Heard Island and McDonald Islands', 'HM', '.hm', 0, 'AN', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(97, 'Honduras', 'HN', '.hn', 504, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(98, 'Croatia', 'HR', '.hr', 385, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(99, 'Haiti', 'HT', '.ht', 509, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(100, 'Hungary', 'HU', '.hu', 36, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(101, 'Indonesia', 'ID', '.id', 62, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(102, 'Ireland', 'IE', '.ie', 353, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(103, 'Israel', 'IL', '.il', 972, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(104, 'Isle of Man', 'IM', '.im', 44, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(105, 'India', 'IN', '.in', 91, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(106, 'British Indian Ocean Territory', 'IO', '.io', 246, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(107, 'Iraq', 'IQ', '.iq', 964, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(108, 'Iran', 'IR', '.ir', 98, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(109, 'Iceland', 'IS', '.is', 354, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(110, 'Italy', 'IT', '.it', 39, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(111, 'Jersey', 'JE', '.je', 44, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(112, 'Jamaica', 'JM', '.jm', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(113, 'Jordan', 'JO', '.jo', 962, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(114, 'Japan', 'JP', '.jp', 81, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(115, 'Kenya', 'KE', '.ke', 254, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(116, 'Kyrgyzstan', 'KG', '.kg', 996, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(117, 'Cambodia', 'KH', '.kh', 855, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(118, 'Kiribati', 'KI', '.ki', 686, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(119, 'Comoros', 'KM', '.km', 269, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(120, 'Saint Kitts and Nevis', 'KN', '.kn', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(121, 'North Korea', 'KP', '.kp', 850, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(122, 'South Korea', 'KR', '.kr', 82, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(123, 'Kosovo', 'XK', '', 0, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(124, 'Kuwait', 'KW', '.kw', 965, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(125, 'Cayman Islands', 'KY', '.ky', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(126, 'Kazakhstan', 'KZ', '.kz', 7, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(127, 'Laos', 'LA', '.la', 856, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(128, 'Lebanon', 'LB', '.lb', 961, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(129, 'Saint Lucia', 'LC', '.lc', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(130, 'Liechtenstein', 'LI', '.li', 423, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(131, 'Sri Lanka', 'LK', '.lk', 94, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(132, 'Liberia', 'LR', '.lr', 231, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(133, 'Lesotho', 'LS', '.ls', 266, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(134, 'Lithuania', 'LT', '.lt', 370, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(135, 'Luxembourg', 'LU', '.lu', 352, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(136, 'Latvia', 'LV', '.lv', 371, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(137, 'Libya', 'LY', '.ly', 218, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(138, 'Morocco', 'MA', '.ma', 212, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(139, 'Monaco', 'MC', '.mc', 377, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(140, 'Moldova', 'MD', '.md', 373, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(141, 'Montenegro', 'ME', '.me', 382, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(142, 'Saint Martin', 'MF', '.gp', 590, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(143, 'Madagascar', 'MG', '.mg', 261, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(144, 'Marshall Islands', 'MH', '.mh', 692, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(145, 'Macedonia', 'MK', '.mk', 389, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(146, 'Mali', 'ML', '.ml', 223, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(147, 'Myanmar', 'MM', '.mm', 95, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(148, 'Mongolia', 'MN', '.mn', 976, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(149, 'Macao', 'MO', '.mo', 853, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(150, 'Northern Mariana Islands', 'MP', '.mp', 1, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(151, 'Martinique', 'MQ', '.mq', 596, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(152, 'Mauritania', 'MR', '.mr', 222, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(153, 'Montserrat', 'MS', '.ms', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(154, 'Malta', 'MT', '.mt', 356, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(155, 'Mauritius', 'MU', '.mu', 230, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(156, 'Maldives', 'MV', '.mv', 960, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(157, 'Malawi', 'MW', '.mw', 265, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(158, 'Mexico', 'MX', '.mx', 52, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(159, 'Malaysia', 'MY', '.my', 60, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(160, 'Mozambique', 'MZ', '.mz', 258, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(161, 'Namibia', 'NA', '.na', 264, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(162, 'New Caledonia', 'NC', '.nc', 687, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(163, 'Niger', 'NE', '.ne', 227, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(164, 'Norfolk Island', 'NF', '.nf', 672, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(165, 'Nigeria', 'NG', '.ng', 234, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(166, 'Nicaragua', 'NI', '.ni', 505, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(167, 'Netherlands', 'NL', '.nl', 31, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(168, 'Norway', 'NO', '.no', 47, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(169, 'Nepal', 'NP', '.np', 977, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(170, 'Nauru', 'NR', '.nr', 674, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(171, 'Niue', 'NU', '.nu', 683, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(172, 'New Zealand', 'NZ', '.nz', 64, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(173, 'Oman', 'OM', '.om', 968, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(174, 'Panama', 'PA', '.pa', 507, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(175, 'Peru', 'PE', '.pe', 51, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(176, 'French Polynesia', 'PF', '.pf', 689, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(177, 'Papua New Guinea', 'PG', '.pg', 675, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(178, 'Philippines', 'PH', '.ph', 63, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(179, 'Pakistan', 'PK', '.pk', 92, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(180, 'Poland', 'PL', '.pl', 48, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(181, 'Saint Pierre and Miquelon', 'PM', '.pm', 508, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(182, 'Pitcairn', 'PN', '.pn', 870, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(183, 'Puerto Rico', 'PR', '.pr', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(184, 'Palestinian Territory', 'PS', '.ps', 970, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(185, 'Portugal', 'PT', '.pt', 351, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(186, 'Palau', 'PW', '.pw', 680, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(187, 'Paraguay', 'PY', '.py', 595, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(188, 'Qatar', 'QA', '.qa', 974, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(189, 'Reunion', 'RE', '.re', 262, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(190, 'Romania', 'RO', '.ro', 40, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(191, 'Serbia', 'RS', '.rs', 381, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(192, 'Russia', 'RU', '.ru', 7, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(193, 'Rwanda', 'RW', '.rw', 250, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(194, 'Saudi Arabia', 'SA', '.sa', 966, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(195, 'Solomon Islands', 'SB', '.sb', 677, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(196, 'Seychelles', 'SC', '.sc', 248, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(197, 'Sudan', 'SD', '.sd', 249, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(198, 'South Sudan', 'SS', '', 211, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(199, 'Sweden', 'SE', '.se', 46, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(200, 'Singapore', 'SG', '.sg', 65, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(201, 'Saint Helena', 'SH', '.sh', 290, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(202, 'Slovenia', 'SI', '.si', 386, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(203, 'Svalbard and Jan Mayen', 'SJ', '.sj', 47, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(204, 'Slovakia', 'SK', '.sk', 421, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(205, 'Sierra Leone', 'SL', '.sl', 232, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(206, 'San Marino', 'SM', '.sm', 378, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(207, 'Senegal', 'SN', '.sn', 221, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(208, 'Somalia', 'SO', '.so', 252, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(209, 'Suriname', 'SR', '.sr', 597, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(210, 'Sao Tome and Principe', 'ST', '.st', 239, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(211, 'El Salvador', 'SV', '.sv', 503, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(212, 'Sint Maarten', 'SX', '.sx', 599, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(213, 'Syria', 'SY', '.sy', 963, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(214, 'Swaziland', 'SZ', '.sz', 268, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(215, 'Turks and Caicos Islands', 'TC', '.tc', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(216, 'Chad', 'TD', '.td', 235, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(217, 'French Southern Territories', 'TF', '.tf', 0, 'AN', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(218, 'Togo', 'TG', '.tg', 228, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(219, 'Thailand', 'TH', '.th', 66, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(220, 'Tajikistan', 'TJ', '.tj', 992, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(221, 'Tokelau', 'TK', '.tk', 690, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(222, 'East Timor', 'TL', '.tl', 670, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(223, 'Turkmenistan', 'TM', '.tm', 993, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(224, 'Tunisia', 'TN', '.tn', 216, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(225, 'Tonga', 'TO', '.to', 676, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(226, 'Turkey', 'TR', '.tr', 90, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(227, 'Trinidad and Tobago', 'TT', '.tt', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(228, 'Tuvalu', 'TV', '.tv', 688, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(229, 'Taiwan', 'TW', '.tw', 886, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(230, 'Tanzania', 'TZ', '.tz', 255, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(231, 'Ukraine', 'UA', '.ua', 380, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(232, 'Uganda', 'UG', '.ug', 256, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(233, 'United States Minor Outlying Islands', 'UM', '.um', 1, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(234, 'United States', 'US', '.us', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(235, 'Uruguay', 'UY', '.uy', 598, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(236, 'Uzbekistan', 'UZ', '.uz', 998, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(237, 'Vatican', 'VA', '.va', 379, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(238, 'Saint Vincent and the Grenadines', 'VC', '.vc', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(239, 'Venezuela', 'VE', '.ve', 58, 'SA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(240, 'British Virgin Islands', 'VG', '.vg', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(241, 'U.S. Virgin Islands', 'VI', '.vi', 1, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(242, 'Vietnam', 'VN', '.vn', 84, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(243, 'Vanuatu', 'VU', '.vu', 678, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(244, 'Wallis and Futuna', 'WF', '.wf', 681, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(245, 'Samoa', 'WS', '.ws', 685, 'OC', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(246, 'Yemen', 'YE', '.ye', 967, 'AS', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(247, 'Mayotte', 'YT', '.yt', 262, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(248, 'South Africa', 'ZA', '.za', 27, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(249, 'Zambia', 'ZM', '.zm', 260, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(250, 'Zimbabwe', 'ZW', '.zw', 263, 'AF', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(251, 'Serbia and Montenegro', 'CS', '.cs', 381, 'EU', '2017-04-21 02:49:08', '2017-04-21 02:49:08'),
(252, 'Netherlands Antilles', 'AN', '.an', 599, 'NA', '2017-04-21 02:49:08', '2017-04-21 02:49:08');

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
('2016_05_19_031405_create_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `challenge_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `labels` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `is_new` tinyint(4) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `type`, `path`, `created_at`, `updated_at`) VALUES
(1, 'xbox360', 2, NULL, '2017-04-21 03:36:41', '2017-04-21 03:36:41'),
(2, 'ps4', 2, NULL, '2017-04-24 20:16:47', '2017-04-24 20:16:47'),
(3, 'PC', 1, NULL, '2017-04-24 20:16:47', '2017-04-24 20:16:47'),
(4, 'xbox_one', 2, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30'),
(5, 'ps3', 2, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30'),
(6, 'nintendo_wii', 2, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30'),
(7, 'nintendo_wiiu', 2, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30'),
(8, 'arcade', 3, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30'),
(9, 'smartphone_game', 4, NULL, '2017-04-25 03:40:30', '2017-04-25 03:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `challenge_id` int(10) UNSIGNED NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_positive` tinyint(1) NOT NULL DEFAULT '0',
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Super Administrator'),
(2, 'Administrator'),
(3, 'Normally User');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `is_remember` tinyint(1) NOT NULL DEFAULT '1',
  `timezone` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `expired_at`, `is_remember`, `timezone`, `created_at`, `updated_at`) VALUES
(1, 7, 'FA4076F0E3A580AEFC0467E389C8589A', '2017-04-21 12:29:19', 0, 0, '2017-04-21 03:08:45', '2017-04-21 03:29:19'),
(2, 8, '0265CF304C2A5E34BFE177EF7E4EBEAF', '2017-04-24 05:23:07', 0, 0, '2017-04-23 20:23:07', '2017-04-23 20:23:07'),
(3, 8, '33693AA3C3140335131913819C02ED15', '2017-04-24 05:39:22', 0, 7, '2017-04-23 20:39:22', '2017-04-23 20:39:22'),
(4, 9, '5FDC7845DD8FF4C9CB122FAF54E228ED', '2017-04-24 06:47:25', 0, 7, '2017-04-23 21:47:25', '2017-04-23 21:47:25'),
(5, 9, 'F15FE0E09B5C922DD3760D581FC0C664', '2017-04-24 09:05:20', 1, 7, '2017-04-24 00:05:20', '2017-04-24 00:05:20'),
(6, 11, 'C3A2FAD16CC4987483740B85C2DFD6AD', '2017-04-24 10:04:12', 0, 0, '2017-04-24 01:04:12', '2017-04-24 01:04:12'),
(10, 14, 'EBECDE318F8A3493AA6BB699E1C997EC', '2017-04-24 11:31:15', 0, 0, '2017-04-24 02:31:15', '2017-04-24 02:31:15'),
(11, 15, '0CB807B9D3B9366A3562802AF6F57427', '2017-04-24 12:42:31', 0, 0, '2017-04-24 03:42:31', '2017-04-24 03:42:31'),
(12, 7, '4B9E90464195E1AFA44C6FA7C5A31CAC', '2017-04-24 14:09:57', 0, 7, '2017-04-24 05:09:57', '2017-04-24 05:09:57'),
(13, 7, '8BCE8F2303F021524BB48037B06DC65A', '2017-04-24 14:11:46', 0, 7, '2017-04-24 05:11:07', '2017-04-24 05:11:46'),
(14, 7, '44DF96D12CACD5DAA1A255DDE1AFFF00', '2017-04-24 14:13:36', 0, 0, '2017-04-24 05:13:36', '2017-04-24 05:13:36'),
(15, 7, '4351B627AEBDBC90F075BC5CB0C99CCC', '2017-04-24 14:14:06', 0, 7, '2017-04-24 05:14:06', '2017-04-24 05:14:06'),
(16, 7, 'AE48CB7AC6817C5D3DEB4D0D06D36B41', '2017-04-24 14:15:44', 0, 0, '2017-04-24 05:15:44', '2017-04-24 05:15:44'),
(17, 7, 'C930C2210018FDE76F87634864E8FFEB', '2017-04-24 16:06:33', 0, 0, '2017-04-24 07:06:33', '2017-04-24 07:06:33'),
(18, 7, '27FF68DE91A0F2678B7E4EF522BDE62B', '2017-04-24 16:09:28', 0, 7, '2017-04-24 07:09:28', '2017-04-24 07:09:28'),
(20, 7, '822D40CA95972FB7AA2A7C90D14F07F8', '2017-04-24 16:10:57', 0, 7, '2017-04-24 07:10:57', '2017-04-24 07:10:57'),
(21, 7, 'D62051B895ABBEE8A041E0798E2174C7', '2017-04-24 17:09:30', 0, 7, '2017-04-24 08:09:30', '2017-04-24 08:09:30'),
(22, 7, '7B2BC14B121CE67BAE5D3B155B4D9F32', '2017-04-24 17:24:24', 0, 7, '2017-04-24 08:24:24', '2017-04-24 08:24:24'),
(23, 7, '9739CC73558C68102D66251B404A4C7A', '2017-04-24 17:24:37', 0, 0, '2017-04-24 08:24:37', '2017-04-24 08:24:37'),
(24, 7, 'FDEB50CB3367758B83E01E013C01418D', '2017-04-24 17:26:12', 0, 0, '2017-04-24 08:26:12', '2017-04-24 08:26:12'),
(25, 7, '2BE465C391C950F87A98BF662BFBFBC4', '2017-04-24 17:26:50', 1, 7, '2017-04-24 08:26:50', '2017-04-24 08:26:50'),
(26, 7, '3F746A38EB9255D81994D58F402F6CB0', '2017-04-24 17:26:58', 0, 0, '2017-04-24 08:26:58', '2017-04-24 08:26:58'),
(27, 7, '96159AFA28F2F5303057001EA54ED3BF', '2017-04-24 17:32:25', 0, 0, '2017-04-24 08:32:25', '2017-04-24 08:32:25'),
(28, 7, 'A9C0958616C4B10B0A9F0BC2E4B12748', '2017-04-24 17:34:34', 0, 0, '2017-04-24 08:34:34', '2017-04-24 08:34:34'),
(29, 7, 'D502058564A7CF589A2457E1FA9718C9', '2017-04-24 17:34:56', 0, 0, '2017-04-24 08:34:56', '2017-04-24 08:34:56'),
(30, 7, '0814DC2A05EBAD74BD0B519A81F424EF', '2017-04-24 17:35:21', 0, 0, '2017-04-24 08:35:21', '2017-04-24 08:35:21'),
(31, 7, 'A66565E73B1B8558542B50C2DFA8E609', '2017-04-24 17:35:32', 0, 0, '2017-04-24 08:35:32', '2017-04-24 08:35:32'),
(32, 7, 'F3CAEF0ED35A83F007BDAC589E57F619', '2017-04-24 17:37:09', 0, 7, '2017-04-24 08:37:09', '2017-04-24 08:37:09'),
(33, 7, 'ECF995F559D4983AD24046CAA1E1AD1C', '2017-04-24 17:37:30', 0, 7, '2017-04-24 08:37:30', '2017-04-24 08:37:30'),
(34, 7, '228B582117709752CC720BDFE1A2C67E', '2017-04-24 17:39:12', 0, 0, '2017-04-24 08:39:12', '2017-04-24 08:39:12'),
(35, 7, '21EBA63749757187FEDA9EB6620AA410', '2017-04-24 17:41:00', 0, 0, '2017-04-24 08:41:00', '2017-04-24 08:41:00'),
(36, 7, 'B5343E1D0729936A0E34A649B8BDDD29', '2017-04-24 17:42:32', 0, 7, '2017-04-24 08:42:32', '2017-04-24 08:42:32'),
(37, 7, 'D430146469F366CD1676EEA6E5246627', '2017-04-24 17:42:49', 0, 7, '2017-04-24 08:42:49', '2017-04-24 08:42:49'),
(38, 7, '1EB63A38040F98A523603D1EAD2DD817', '2017-04-24 17:46:39', 0, 7, '2017-04-24 08:46:39', '2017-04-24 08:46:39'),
(39, 7, 'B0E30EB508A7EC2F4E872DA74D9B1709', '2017-04-24 17:47:14', 0, 7, '2017-04-24 08:47:14', '2017-04-24 08:47:14'),
(41, 7, '7DD1452381F3BA222B6DBD92B8ACAB5A', '2017-04-24 17:53:42', 0, 7, '2017-04-24 08:53:42', '2017-04-24 08:53:42'),
(42, 7, '0D1167FA701335C23F53AF2FA3E2560E', '2017-04-24 17:56:15', 0, 7, '2017-04-24 08:56:15', '2017-04-24 08:56:15'),
(43, 7, 'F13035F0EEB5D10A31450B86E602A1A7', '2017-04-24 17:57:03', 0, 0, '2017-04-24 08:57:03', '2017-04-24 08:57:03'),
(44, 7, 'C190E2D8A789095BE8B65ADDC8E10E76', '2017-04-24 17:57:16', 0, 0, '2017-04-24 08:57:16', '2017-04-24 08:57:16'),
(52, 7, '8E9DB4D1A25FB90AE9DE0EE30A38A71D', '2017-04-24 18:09:12', 0, 0, '2017-04-24 09:09:12', '2017-04-24 09:09:12'),
(54, 7, '33F02A808639BE71C7B68936649A2130', '2017-04-24 18:13:21', 0, 7, '2017-04-24 09:13:21', '2017-04-24 09:13:21'),
(55, 7, '625CCB9A9468B99373F5CF4FE7D7DE14', '2017-04-24 18:15:06', 0, 7, '2017-04-24 09:15:06', '2017-04-24 09:15:06'),
(56, 7, '4CEF8DD139FEE2AAB97032F2510D549F', '2017-04-24 18:16:08', 0, 7, '2017-04-24 09:16:08', '2017-04-24 09:16:08'),
(57, 7, '86F9AB7CD0EF7F40DA329A425DE6A760', '2017-04-24 18:16:38', 0, 7, '2017-04-24 09:16:38', '2017-04-24 09:16:38'),
(58, 7, '4357D9424A6488EE369191ACCA219198', '2017-04-24 18:16:58', 0, 7, '2017-04-24 09:16:58', '2017-04-24 09:16:58'),
(59, 7, 'C263F3ED15144A4BFA2BAE3F55E7A22C', '2017-04-24 18:17:05', 0, 7, '2017-04-24 09:17:05', '2017-04-24 09:17:05'),
(60, 7, 'D8FE345C8EE7529C02861F71FF671CFB', '2017-04-24 18:17:12', 0, 7, '2017-04-24 09:17:12', '2017-04-24 09:17:12'),
(61, 7, '5E1976D324354F16FA078DB0565DD670', '2017-04-24 18:17:17', 0, 7, '2017-04-24 09:17:17', '2017-04-24 09:17:17'),
(62, 7, 'C0579958DA7197B7D6B3691C8ED0EF37', '2017-04-24 18:17:47', 0, 7, '2017-04-24 09:17:47', '2017-04-24 09:17:47'),
(63, 7, '94F07BCB3B9F1C10ED4A19E70BB6F2AD', '2017-04-24 18:17:55', 0, 7, '2017-04-24 09:17:55', '2017-04-24 09:17:55'),
(64, 7, '380BD8EC2CF452B005A8700C3E1026A9', '2017-04-24 18:18:01', 0, 7, '2017-04-24 09:18:01', '2017-04-24 09:18:01'),
(65, 7, 'A3F71908CDD98E453604C54A9C9921D4', '2017-04-24 18:19:27', 0, 7, '2017-04-24 09:19:27', '2017-04-24 09:19:27'),
(74, 7, '2026ACA34521C28BB4A375189436A56D', '2017-04-24 19:10:18', 0, 0, '2017-04-24 10:10:18', '2017-04-24 10:10:18'),
(143, 17, '629A8EDF44F339493D6F5A52B8F8194F', '2017-04-26 05:01:23', 0, 7, '2017-04-25 20:01:23', '2017-04-25 20:01:23'),
(144, 17, 'F30347344F2983A232D98FB39829C7F1', '2017-04-26 05:05:18', 0, 8, '2017-04-25 20:05:18', '2017-04-25 20:05:18'),
(152, 18, '297E50E61371597647AD8D77B1477BC7', '2017-04-26 05:46:45', 0, 0, '2017-04-25 20:46:45', '2017-04-25 20:46:45'),
(153, 19, 'B0DA706970B030C79D38105DF08B802D', '2017-04-26 05:53:18', 0, 0, '2017-04-25 20:53:18', '2017-04-25 20:53:18'),
(154, 20, '0D415F272B39B3FA07E9B841608B3A78', '2017-04-26 05:54:15', 0, 0, '2017-04-25 20:54:15', '2017-04-25 20:54:15'),
(155, 21, '303D1437AA6B0C5F59120628E9AD6B91', '2017-04-26 05:58:05', 0, 0, '2017-04-25 20:58:05', '2017-04-25 20:58:05'),
(158, 22, 'E8CF1414A5966ADF09B5C2E366D65D52', '2017-04-26 06:10:54', 0, 0, '2017-04-25 21:10:54', '2017-04-25 21:10:54'),
(160, 23, '913EAD997A70728D275A54FF8A7EC867', '2017-04-26 06:14:29', 0, 0, '2017-04-25 21:14:29', '2017-04-25 21:14:29'),
(163, 24, 'F834AC102B03E609038B525D660C3EC5', '2017-04-26 06:30:36', 0, 0, '2017-04-25 21:30:36', '2017-04-25 21:30:36'),
(164, 25, '16D3F4BA7B74C138E112A23AABD96946', '2017-04-26 06:34:04', 0, 0, '2017-04-25 21:34:04', '2017-04-25 21:34:04'),
(166, 26, '2D4EF56B86228BC8B11C791C711E11B3', '2017-04-26 06:40:53', 0, 0, '2017-04-25 21:40:53', '2017-04-25 21:40:53'),
(167, 27, '4481B41A5AE7941EADC7CBBFBEB5B0F9', '2017-04-26 06:43:24', 0, 0, '2017-04-25 21:43:24', '2017-04-25 21:43:24'),
(168, 30, '670D9E37834A50E1BF31093DA32B03EF', '2017-04-26 09:09:05', 0, 0, '2017-04-26 00:09:05', '2017-04-26 00:09:05'),
(169, 31, '4CCC48AE5014CE0D9ADFE911BE7CAFE9', '2017-04-26 09:23:53', 0, 0, '2017-04-26 00:23:53', '2017-04-26 00:23:53'),
(170, 32, '762AD2DA593CBEA0A9E39D409B8B80A4', '2017-04-26 09:25:17', 0, 0, '2017-04-26 00:25:17', '2017-04-26 00:25:17'),
(171, 33, 'D7C3995B38455B16B762BF84A59AA6FA', '2017-04-26 09:59:16', 0, 0, '2017-04-26 00:59:16', '2017-04-26 00:59:16'),
(172, 35, '25C9F1447BBC2BB79DDBA839897A7928', '2017-08-04 08:19:17', 0, 7, '2017-04-26 01:19:17', '2017-04-26 01:19:17'),
(173, 37, '1EB76BEC2E9C8D00EF748FB19C0DDE85', '2017-08-04 09:05:41', 0, 7, '2017-04-26 02:05:41', '2017-04-26 02:05:41'),
(174, 38, 'FFE5980E6222AC4D6B9C6CBF7808A1C0', '2017-08-04 09:10:40', 0, 7, '2017-04-26 02:10:40', '2017-04-26 02:10:40'),
(177, 39, '2656725A585D32498D8AE9792DC5236B', '2017-08-04 09:16:37', 0, 7, '2017-04-26 02:16:37', '2017-04-26 02:16:37'),
(178, 40, 'D9797B06A1E4F03B39CA9DDF576E066C', '2017-08-04 09:17:38', 0, 7, '2017-04-26 02:17:38', '2017-04-26 02:17:38'),
(182, 21, '83C63EBBBE4DD701B671F77432F7083A', '2017-04-26 12:51:19', 0, 8, '2017-04-26 03:13:13', '2017-04-26 03:51:19'),
(191, 22, 'E21C6425D0973736B3AE4A771DC4A875', '2017-04-26 13:23:58', 0, 8, '2017-04-26 03:51:57', '2017-04-26 04:23:58'),
(195, 17, 'E7606BF575A2763C89A13A7D7A726DDC', '2017-04-26 13:06:54', 0, 7, '2017-04-26 04:04:01', '2017-04-26 04:06:54'),
(196, 17, '6641B7666AD30A04A2FEA07FB6ABCC75', '2017-04-26 13:23:06', 0, 7, '2017-04-26 04:23:06', '2017-04-26 04:23:06'),
(197, 22, 'E73701D7967F7B52B04F2D50445CB36C', '2017-04-26 13:33:56', 0, 8, '2017-04-26 04:27:47', '2017-04-26 04:33:56'),
(209, 17, 'BEE55EAD1F02D012A643CDA0B77E7D6E', '2017-04-27 09:06:46', 0, 7, '2017-04-27 00:06:46', '2017-04-27 00:06:46'),
(210, 17, '84AEE11ECCFCB14DD9E6D5375BC2F242', '2017-04-27 09:07:58', 0, 7, '2017-04-27 00:07:58', '2017-04-27 00:07:58'),
(211, 17, 'A7D680A342E342A7121242E8E77126A1', '2017-04-27 09:08:10', 0, 7, '2017-04-27 00:08:10', '2017-04-27 00:08:10'),
(212, 17, 'BDEEFC8EB71285F5935946C3152DAA14', '2017-04-27 09:08:35', 0, 7, '2017-04-27 00:08:35', '2017-04-27 00:08:35'),
(213, 17, '55DADFB32952659EEFB6CBBC9EC25B92', '2017-04-27 09:10:07', 0, 7, '2017-04-27 00:10:07', '2017-04-27 00:10:07'),
(214, 17, 'F9EE367F5E5BA048FA453F8260EA2AD8', '2017-04-27 09:10:39', 0, 7, '2017-04-27 00:10:39', '2017-04-27 00:10:39'),
(215, 17, '7A6C9CEAD1AFC4A259D1049A758FA747', '2017-04-27 09:13:55', 0, 7, '2017-04-27 00:13:55', '2017-04-27 00:13:55'),
(216, 17, '83661A7A97785B545BE778B635BFAD5C', '2017-04-27 09:16:45', 0, 7, '2017-04-27 00:16:45', '2017-04-27 00:16:45'),
(217, 17, 'AB67CB1D90406DBCFAC36C0715B87E7A', '2017-04-27 09:22:10', 0, 7, '2017-04-27 00:20:06', '2017-04-27 00:22:10'),
(218, 17, 'FE3B445ECEABD5A4485F209E5707A315', '2017-04-27 09:21:49', 0, 7, '2017-04-27 00:21:49', '2017-04-27 00:21:49'),
(219, 17, '1693D8F0241261E59818B64F9F85FF21', '2017-04-27 09:23:46', 0, 7, '2017-04-27 00:23:46', '2017-04-27 00:23:46'),
(220, 17, 'B9590AF4E82A61D7AD3E9A1B430112D3', '2017-04-27 09:24:10', 0, 7, '2017-04-27 00:24:10', '2017-04-27 00:24:10'),
(221, 17, '4EA37532F65603B244AD783404C171CF', '2017-04-27 09:24:58', 0, 7, '2017-04-27 00:24:58', '2017-04-27 00:24:58'),
(224, 17, '0B7BE6C62BA1DF9C298E184043AE4E44', '2017-04-27 09:28:38', 0, 7, '2017-04-27 00:28:38', '2017-04-27 00:28:38'),
(237, 17, 'CC2990EED7691266EAFB5F472E174E03', '2017-04-27 12:52:59', 0, 7, '2017-04-27 03:52:59', '2017-04-27 03:52:59'),
(241, 17, 'E6E54CD5316DE6B21D2D8AB265DDC1EC', '2017-04-27 12:53:48', 0, 7, '2017-04-27 03:53:48', '2017-04-27 03:53:48'),
(242, 17, '7140726531B3A85561AFC76CE7537209', '2017-04-27 13:10:55', 0, 7, '2017-04-27 04:10:55', '2017-04-27 04:10:55'),
(243, 17, '2E03887EC13DD1A586C57E6C2AB7D65F', '2017-04-27 13:17:57', 0, 7, '2017-04-27 04:17:57', '2017-04-27 04:17:57'),
(301, 11, '9D75BD632873F52495F1120DD6BBD903', '2017-05-03 04:48:46', 0, 8, '2017-05-02 19:46:16', '2017-05-02 19:48:46'),
(302, 11, '01AFFCC3A49AAC5436FAF3CD2063F33E', '2017-05-03 04:49:57', 0, 8, '2017-05-02 19:49:29', '2017-05-02 19:49:57'),
(303, 17, 'D52C0EB909B92DF67489C3F8AEBE4F92', '2017-05-03 04:53:41', 0, 8, '2017-05-02 19:53:26', '2017-05-02 19:53:41'),
(305, 69, '41D105D08DAFDB2AD06CF1CD134D60F6', '2017-05-03 05:02:19', 0, 8, '2017-05-02 20:00:24', '2017-05-02 20:02:19'),
(312, 35, '1695C72B3565443D2C420C53795BE6EC', '2017-08-11 04:38:13', 0, 7, '2017-05-02 21:38:13', '2017-05-02 21:38:13'),
(313, 35, '42D7FB8D452BE348D6BF6B93EE9A0CD8', '2017-08-11 04:41:54', 0, 7, '2017-05-02 21:41:54', '2017-05-02 21:41:54'),
(314, 35, 'EBA105ED16909AA2026F4BB31816EE41', '2017-08-11 04:41:56', 0, 7, '2017-05-02 21:41:56', '2017-05-02 21:41:56'),
(315, 35, '373ADE5D02F326CF723E3C75A71C1010', '2017-08-11 04:43:01', 0, 7, '2017-05-02 21:43:01', '2017-05-02 21:43:01'),
(316, 35, '259B8D2B2C04091015D10AF0EBAC1FD1', '2017-08-11 04:44:10', 0, 7, '2017-05-02 21:44:10', '2017-05-02 21:44:10'),
(317, 35, '5C73FA019FD7F95BD3FA1834028D4BC6', '2017-08-11 04:46:04', 0, 7, '2017-05-02 21:46:04', '2017-05-02 21:46:04'),
(319, 35, 'B633C3A5F1501D47341AEA3B0C00D5CE', '2017-08-11 04:50:39', 0, 7, '2017-05-02 21:50:39', '2017-05-02 21:50:39'),
(320, 35, '497A090FB28642251CD7CFED6D59F659', '2017-08-11 04:52:12', 0, 7, '2017-05-02 21:52:12', '2017-05-02 21:52:12'),
(321, 35, '321F174FF278785731C903105934CECB', '2017-08-11 04:53:46', 0, 7, '2017-05-02 21:53:46', '2017-05-02 21:53:46'),
(322, 69, '60C2314EB4E467B7428D07CA080C2C3D', '2017-05-03 06:55:12', 0, 8, '2017-05-02 21:55:12', '2017-05-02 21:55:12'),
(323, 32, '84FA9D701A42ADCD01D845CC436543CB', '2017-05-03 06:56:03', 0, 8, '2017-05-02 21:56:03', '2017-05-02 21:56:03'),
(324, 35, 'B8B762FF8D8F99FCDAA934C85738E5E6', '2017-08-11 04:58:30', 0, 7, '2017-05-02 21:58:30', '2017-05-02 21:58:30'),
(327, 35, 'C3D48681AF5543863A73C0360A6E75F1', '2017-08-11 06:55:21', 0, 7, '2017-05-02 23:55:21', '2017-05-02 23:55:21'),
(328, 35, '8F056F4AAD910394EED9DDFE33C60631', '2017-08-11 07:07:57', 0, 7, '2017-05-03 00:07:57', '2017-05-03 00:07:57'),
(352, 23, 'F739EBB25ADF945F50F4B9F2C66D6FB8', '2017-05-04 05:13:40', 0, 8, '2017-05-03 20:13:40', '2017-05-03 20:13:40'),
(355, 102, '128EDE2D7FB553FF49308BD03CAD10D4', '2017-05-04 05:37:16', 0, 0, '2017-05-03 20:37:16', '2017-05-03 20:37:16'),
(356, 102, '680A51C3564EB9DB422B48D8F1761697', '2017-05-04 05:40:04', 0, 8, '2017-05-03 20:40:04', '2017-05-03 20:40:04'),
(357, 35, '89157508F768D6420073EBBC1E64B25A', '2017-08-12 04:05:09', 0, 7, '2017-05-03 21:05:09', '2017-05-03 21:05:09'),
(358, 38, '7C114AD518E1314C3FF45529978BA91A', '2017-08-12 04:12:03', 0, 7, '2017-05-03 21:12:03', '2017-05-03 21:12:03'),
(359, 38, '7E2FF2FF70F62774DEAE7EF513A0AD2A', '2017-08-12 04:12:42', 0, 7, '2017-05-03 21:12:42', '2017-05-03 21:12:42'),
(360, 38, 'A989B625397EB540FEAC60C12C37EC54', '2017-08-12 04:19:05', 0, 7, '2017-05-03 21:19:05', '2017-05-03 21:19:05'),
(361, 38, 'D8EA5C8AAC07AE6DB9EDA7CB642AD94C', '2017-08-12 04:19:41', 0, 7, '2017-05-03 21:19:41', '2017-05-03 21:19:41'),
(362, 38, '37B68280316401C449ABC6783FE65ABA', '2017-08-12 04:19:58', 0, 7, '2017-05-03 21:19:58', '2017-05-03 21:19:58'),
(363, 38, 'C8FAD7FB35F6A96D372E42022FB72FE0', '2017-08-12 04:28:21', 0, 7, '2017-05-03 21:28:21', '2017-05-03 21:28:21'),
(364, 38, '204E0283FC4430180FBEAA12B3A0F924', '2017-08-12 04:28:27', 0, 7, '2017-05-03 21:28:27', '2017-05-03 21:28:27'),
(365, 38, '78A6F5C1C2038C37E245FAA5A4ADFD92', '2017-08-12 04:35:36', 0, 7, '2017-05-03 21:35:36', '2017-05-03 21:35:36'),
(366, 38, '2C04175E23AC023233E0BAA936073D64', '2017-08-12 04:36:37', 0, 7, '2017-05-03 21:36:37', '2017-05-03 21:36:37'),
(367, 38, '34288E98AEF0B9C2A8DEEECDA9434A54', '2017-08-12 04:38:31', 0, 7, '2017-05-03 21:38:31', '2017-05-03 21:38:31'),
(368, 38, '50E987614E640AF1C0367A7E3A1F1B52', '2017-08-12 04:38:39', 0, 7, '2017-05-03 21:38:39', '2017-05-03 21:38:39'),
(369, 38, '6D4B9D617944526DA73C11B63CF20190', '2017-08-12 04:40:37', 0, 7, '2017-05-03 21:40:37', '2017-05-03 21:40:37'),
(370, 38, '2938A635FEC17ACB773FDCAB7283534B', '2017-08-12 04:47:27', 0, 7, '2017-05-03 21:47:27', '2017-05-03 21:47:27'),
(371, 38, '4477CE4715E3591072DB57DC9CEB44B7', '2017-08-12 04:47:48', 0, 7, '2017-05-03 21:47:48', '2017-05-03 21:47:48'),
(372, 38, 'C99E48E1841F53443BBD5EA9C2DC65D5', '2017-08-12 04:49:07', 0, 7, '2017-05-03 21:49:07', '2017-05-03 21:49:07'),
(373, 38, '4412645B2639A5F8E32A7AC16C8811E1', '2017-08-12 04:49:19', 0, 7, '2017-05-03 21:49:19', '2017-05-03 21:49:19'),
(374, 38, '29EFD9CFA434DD4487953CC9FC9B71E1', '2017-08-12 04:49:20', 0, 7, '2017-05-03 21:49:20', '2017-05-03 21:49:20'),
(375, 38, '4F4A9B0A0FEDF9DAA452E6B0F940E557', '2017-08-12 04:49:21', 0, 7, '2017-05-03 21:49:21', '2017-05-03 21:49:21'),
(376, 38, '464F8AEBA9F9E8DFDBD5DAE68BAB698B', '2017-08-12 04:49:30', 0, 7, '2017-05-03 21:49:30', '2017-05-03 21:49:30'),
(377, 38, '69320C75EC944306139A64F8D2996987', '2017-08-12 04:50:26', 0, 7, '2017-05-03 21:50:26', '2017-05-03 21:50:26'),
(378, 38, 'B4785C48C11A36CCE5D750242C7270F5', '2017-08-12 04:50:29', 0, 7, '2017-05-03 21:50:29', '2017-05-03 21:50:29'),
(379, 38, '4D667C6B595B2EEF75DD66F852C2402C', '2017-08-12 04:58:53', 0, 7, '2017-05-03 21:58:53', '2017-05-03 21:58:53'),
(381, 38, '337275302093B24EC691DBE4157E58DA', '2017-08-12 05:01:56', 0, 7, '2017-05-03 22:01:56', '2017-05-03 22:01:56'),
(382, 38, '77BC116DB323285114C3848B1B89C97F', '2017-08-12 05:02:48', 0, 7, '2017-05-03 22:02:48', '2017-05-03 22:02:48'),
(384, 38, 'C0B33B5929926E7D027B2CE509FDAFD6', '2017-08-12 06:50:08', 0, 7, '2017-05-03 23:50:08', '2017-05-03 23:50:08'),
(386, 106, '0B332192E92ECAB795A78DB5D1E7B087', '2017-05-04 08:58:35', 0, 7, '2017-05-03 23:55:09', '2017-05-03 23:58:35'),
(387, 106, 'C3D88231866E3ECA1AB7E6857E3DE781', '2017-05-04 09:07:43', 0, 7, '2017-05-04 00:02:49', '2017-05-04 00:07:43'),
(388, 107, '82ABFD70606F1FC9FF8B9E18DE81D900', '2017-05-04 09:11:01', 0, 7, '2017-05-04 00:09:55', '2017-05-04 00:11:01'),
(389, 110, 'FD9AFE3923C8384C96A7F100872EC86B', '2017-05-04 09:13:59', 0, 7, '2017-05-04 00:12:27', '2017-05-04 00:13:59'),
(439, 4, 'EC89F3A8759A82AB7704CD679EA9E4EF', '2017-05-04 14:09:55', 0, 7, '2017-05-04 03:16:27', '2017-05-04 05:09:55'),
(452, 4, '40C32832144F14F92BCBB23651A91DF2', '2017-05-05 05:50:44', 0, 7, '2017-05-04 19:04:18', '2017-05-04 20:50:44'),
(456, 132, '44D781BF370AE4EF132CB5A7732D5958', '2017-05-05 04:30:19', 0, 7, '2017-05-04 19:29:14', '2017-05-04 19:30:19'),
(458, 134, '8183CE7D13133C166A12C763930862F5', '2017-05-05 04:32:39', 0, 7, '2017-05-04 19:31:51', '2017-05-04 19:32:39'),
(459, 135, '6AE3C8ED2C9EA1009961470089DC9AA7', '2017-05-05 04:35:02', 0, 7, '2017-05-04 19:34:09', '2017-05-04 19:35:02'),
(460, 136, 'BFE62C0B4F68C0C0425E9EACC70B1D80', '2017-05-05 04:46:13', 0, 7, '2017-05-04 19:45:21', '2017-05-04 19:46:13'),
(462, 138, '3BC86E955F3EB956786DBBF9FBDB360F', '2017-05-05 04:48:39', 0, 7, '2017-05-04 19:47:48', '2017-05-04 19:48:39'),
(466, 142, 'D10DC28E01DB4556F1254BFE474DDAE7', '2017-05-05 05:13:05', 0, 0, '2017-05-04 20:13:05', '2017-05-04 20:13:05'),
(468, 142, 'EC978DBF6B281E9D5046F2D13E9B1CAE', '2017-05-05 05:30:32', 0, 7, '2017-05-04 20:29:33', '2017-05-04 20:30:32'),
(471, 107, '10EDFA3D571BA0288CC6A78A12A387AC', '2017-08-13 03:57:35', 0, 7, '2017-05-04 20:57:35', '2017-05-04 20:57:35'),
(475, 111, '54599F5761313AA638765FBB849F5386', '2017-08-13 06:42:45', 0, 7, '2017-05-04 23:42:45', '2017-05-04 23:42:45'),
(476, 111, '5204F8745583F76E9653FB5D7DBC3B70', '2017-08-13 06:42:52', 0, 7, '2017-05-04 23:42:52', '2017-05-04 23:42:52'),
(477, 111, 'F0091F33238F2E5BEFAE8665B254C2BF', '2017-08-13 06:43:46', 0, 7, '2017-05-04 23:43:46', '2017-05-04 23:43:46'),
(478, 111, '22695E141FB42780DE55FD11275F069F', '2017-08-13 06:44:45', 0, 7, '2017-05-04 23:44:45', '2017-05-04 23:44:45'),
(479, 111, '92A1C04DD2644DEF9144B35D583B8206', '2017-08-13 06:47:21', 0, 7, '2017-05-04 23:47:21', '2017-05-04 23:47:21'),
(480, 111, 'C0061DF892DC7578AFEB5BE52CB69893', '2017-08-13 06:50:34', 0, 7, '2017-05-04 23:50:34', '2017-05-04 23:50:34'),
(481, 111, 'A30A3AC1E1D4903244360A31A8A5E536', '2017-08-13 06:50:56', 0, 7, '2017-05-04 23:50:56', '2017-05-04 23:50:56'),
(482, 111, '61A670EAFEE3CD1640FF0CAE67C6A9FF', '2017-08-13 06:51:48', 0, 7, '2017-05-04 23:51:48', '2017-05-04 23:51:48'),
(483, 111, '7584210E6BD353B71004A451BDDADF3E', '2017-08-13 06:53:22', 0, 7, '2017-05-04 23:53:22', '2017-05-04 23:53:22'),
(486, 35, 'C0A83AE6F96391D707E42E72904DA6F8', '2017-08-13 06:56:18', 0, 7, '2017-05-04 23:56:18', '2017-05-04 23:56:18'),
(487, 35, '3230DFA8C5F22D64201711F85753368B', '2017-08-13 06:56:33', 0, 7, '2017-05-04 23:56:33', '2017-05-04 23:56:33'),
(488, 138, '382C103016AFAF3434F75B3418F5DA2B', '2017-08-13 07:00:52', 0, 7, '2017-05-05 00:00:52', '2017-05-05 00:00:52'),
(490, 151, 'F29B8DF4027444F92283EFFE995B1070', '2017-05-05 09:04:00', 0, 0, '2017-05-05 00:04:00', '2017-05-05 00:04:00'),
(502, 38, '9D58EFA59E404CA647F9D2ADCC5BB825', '2017-08-13 08:19:02', 0, 7, '2017-05-05 01:19:02', '2017-05-05 01:19:02'),
(504, 159, 'B77A7831D5EF5BD8404EE8549BD4531A', '2017-05-05 10:32:51', 0, 7, '2017-05-05 01:20:06', '2017-05-05 01:32:51'),
(507, 161, '92FDCFFB80110222A1BD582BF73B9421', '2017-05-05 10:20:47', 0, 0, '2017-05-05 01:20:47', '2017-05-05 01:20:47'),
(508, 159, 'F81E0CDE2F47E3FEB2705508AC4BDF86', '2017-08-13 08:21:35', 0, 7, '2017-05-05 01:21:35', '2017-05-05 01:21:35'),
(509, 159, '9562B8512A1FFE96276E5B71B3984ABE', '2017-08-13 08:21:42', 0, 7, '2017-05-05 01:21:42', '2017-05-05 01:21:42'),
(510, 162, 'A57BC086CF0EB002FA812B670E7BF981', '2017-05-05 10:33:43', 0, 7, '2017-05-05 01:24:14', '2017-05-05 01:33:43'),
(519, 163, '715098A6505944F49F78917A413DAF42', '2017-05-05 11:31:08', 0, 0, '2017-05-05 02:31:08', '2017-05-05 02:31:08'),
(521, 165, 'C23AB8EB97313D05A3AB400FC484817E', '2017-05-05 11:46:50', 0, 0, '2017-05-05 02:46:50', '2017-05-05 02:46:50'),
(525, 11, 'B175C3A0F44F9D228BBBD6D884070592', '2017-05-05 11:53:44', 0, 7, '2017-05-05 02:52:38', '2017-05-05 02:53:44'),
(527, 4, '7FFB6C5E47CF6992836AF8C5060A587E', '2017-05-05 12:15:23', 0, 7, '2017-05-05 02:54:04', '2017-05-05 03:15:23'),
(528, 166, '399E36A5E2CFA9CADB77061824859DFB', '2017-05-05 11:55:02', 0, 0, '2017-05-05 02:55:02', '2017-05-05 02:55:02'),
(529, 167, '19117CDF5BCCED6F968FF5E49D36849D', '2017-05-05 11:56:45', 0, 0, '2017-05-05 02:56:45', '2017-05-05 02:56:45'),
(530, 167, 'B69BE4C424E0860E1D594BC833AE4974', '2017-05-05 12:10:09', 0, 7, '2017-05-05 02:56:53', '2017-05-05 03:10:09'),
(541, 173, 'E9A20948A976DF68BC65F0FE12E8602B', '2017-05-05 13:16:32', 0, 0, '2017-05-05 04:16:32', '2017-05-05 04:16:32'),
(543, 173, 'DA601F256DFCB3AD3CA743526EF21F9E', '2017-05-05 13:42:01', 0, 7, '2017-05-05 04:39:34', '2017-05-05 04:42:01'),
(544, 4, 'DF8D6FB8B1DB9A5998EC1268A51115E7', '2017-05-08 05:11:53', 0, 7, '2017-05-07 20:09:46', '2017-05-07 20:11:53'),
(545, 163, '30D6D731C407EF722077B3FAB49A79EA', '2017-05-08 05:55:16', 0, 8, '2017-05-07 20:55:16', '2017-05-07 20:55:16'),
(546, 142, '11533067F82173122E937627D5608598', '2017-05-08 05:57:11', 0, 7, '2017-05-07 20:57:10', '2017-05-07 20:57:11'),
(547, 142, 'E40A862B2BD1E82BC92F37266597B7F5', '2017-05-08 06:03:57', 0, 7, '2017-05-07 21:00:07', '2017-05-07 21:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `actor_id` int(10) UNSIGNED NOT NULL,
  `challenge_id` int(10) UNSIGNED NOT NULL,
  `gateway_transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) UNSIGNED NOT NULL DEFAULT '3',
  `date` datetime NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `social_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `date_of_birth` date DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `is_term_condition` tinyint(1) NOT NULL,
  `is_privacy_policy` tinyint(1) NOT NULL,
  `is_subscribe_email` tinyint(1) NOT NULL,
  `coin` double(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `location_id`, `username`, `email`, `password`, `social_type`, `social_id`, `last_login`, `is_deleted`, `phone`, `path`, `first_name`, `surname`, `gender`, `date_of_birth`, `province`, `city`, `postal_code`, `address1`, `address2`, `status`, `is_term_condition`, `is_privacy_policy`, `is_subscribe_email`, `coin`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'supadmin', 'super_admin@mail.com', '$2y$10$ZmbngznpledOym47caukZ.7PCnE26B9mtFwwNNAlp.0WwyPih8qeG', NULL, NULL, NULL, 0, NULL, NULL, 'Admin', 'SuperAdmin', 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 0, 0, 0, 0.00, '2017-04-21 02:57:57', '2017-04-21 02:57:57'),
(3, 2, 1, 'admin', 'admin@mail.com', '$2y$10$ZtnGk.Q1Xyd3ritD9j1eMOI4jtY8CEQSzUjNjbcbqGb0F/3Le7G2K', NULL, NULL, NULL, 0, NULL, NULL, 'Admin', 'Admin', 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-04-21 02:57:58'),
(4, 3, 1, 'test', 'test@mail.com', '$2y$10$brTzdRvaqVgzLH6ozN1pRe6P94KH8hSku94EPtEJNbnflfDpSgc86', NULL, NULL, '2017-05-08 03:09:46', 0, NULL, NULL, 'Example', 'Example', 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-05-07 20:09:46'),
(5, 3, 242, 'tridoan', 'dxtri94@gmail.com', '$2y$10$brTzdRvaqVgzLH6ozN1pRe6P94KH8hSku94EPtEJNbnflfDpSgc86', NULL, NULL, NULL, 0, NULL, NULL, 'tridoan', 'tridoan', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-04-21 02:57:58'),
(7, 3, 1, 'toanle', 'toan.le@beesightsoft.com', '$2y$10$QFr1UzuadViDxlQ/vCTCl.jnXw9K.PtnA0mtm2.fdgm.j2MvVucyK', NULL, NULL, '2017-04-25 11:08:00', 0, '1234567890', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-04-21 03:08:42', '2017-04-25 04:08:00'),
(8, 3, 12, 'test-register', 'test-register@gmail.com', '$2y$10$RzVf0YlsvvFkEn8Z091cjOAh4PGH76GRlm7X5Z8HQrum5AS1UoT9S', NULL, NULL, '2017-04-24 03:39:22', 0, '123456', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-23 20:23:01', '2017-04-23 20:39:22'),
(9, 3, 12, 'test-tri', 'test-tri@gmail.com', '$2y$10$Tiy9lURRScH.GpbxnN3FV.NX5EHJYNy/w9mjdvhcQO0cn6ev0iAj6', NULL, NULL, '2017-04-24 07:05:20', 0, '123456789', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0.00, '2017-04-23 20:47:29', '2017-04-24 00:05:20'),
(10, 3, 12, 'test-tri123', 'test-tri123@gmail.com', '$2y$10$kPgt/zyeQ.4nxDgkHBL.huwxp7NnDOrK50Y24A98xN7UAv9jbPjLu', NULL, NULL, NULL, 0, '123456789', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0.00, '2017-04-23 21:40:37', '2017-04-23 21:40:37'),
(11, 3, 20, 'trileser', 'tri.doan@beesightsoft.com', '$2y$10$8ss5U2V2wtdF194id1qPbuLi/WhAQRuVNFtN753SFp2QnHpp.DrSS', NULL, NULL, '2017-05-05 09:52:38', 0, '123456789', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0.00, '2017-04-24 01:04:04', '2017-05-05 02:52:38'),
(14, 3, 100, 'test-date', 'test-date@gmail.com', '$2y$10$bf8v2ssiLK8/MoX5kW41i.R1Sq5KNSuB6w7DLOwN8zqNQ8jERgOwW', NULL, NULL, '2017-04-24 09:31:15', 0, '123456789', NULL, NULL, NULL, 0, '2017-04-24', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0.00, '2017-04-24 02:31:11', '2017-04-24 02:31:15'),
(15, 3, 1, 'test-policy', 'test-policy@gmail.com', '$2y$10$URPPV7T4MVnJoWy.kT9Kp.2WOB2tlGqL2W1PIMwa80CBdygDKQrEa', NULL, NULL, '2017-04-24 10:42:31', 0, '123456', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-24 03:42:25', '2017-04-24 03:42:31'),
(17, 1, 1, 'supadmin2', 'super_admin2@mail.com', '$2y$10$bubeAz.8rdxWiUfLfP3NEe63EEfk1Tk8hNl.athcFY2qtraDLcLai', NULL, NULL, '2017-05-03 02:53:26', 0, NULL, NULL, 'Admin', 'SuperAdmin2', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.00, '2017-04-25 20:00:51', '2017-05-02 19:53:26'),
(18, 3, 67, '12345678911234567891123456789112345678911234567891123456789112345678911234567891123456789112345678911', 'user1@gmail.com', '$2y$10$ls0EBD7CvxcudLJbbAAJfexe5qyht2S/MG6swV3UlTtqdDknH.Cs.', NULL, NULL, '2017-04-26 03:46:45', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-25 20:46:38', '2017-04-25 20:46:45'),
(19, 3, 67, '123456', 'user2@gmail.com', '$2y$10$tIYQ/Ajtp9XoKtDpOmpFlePzFF4l6pVC.if9l8ZUhNJwiHpVdMM5q', NULL, NULL, '2017-04-26 03:53:18', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-25 20:53:14', '2017-04-25 20:53:18'),
(20, 3, 67, '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890', 'user3@gmail.com', '$2y$10$cK9vi4VWoHE7driHdBorWedIvJ/mMQxk62WT262YOPDzsVf5LnWZK', NULL, NULL, '2017-04-26 03:54:16', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0.00, '2017-04-25 20:54:12', '2017-04-25 20:54:16'),
(21, 3, 67, 'user333-fix2', 'user333-fix2@mail.com', '$2y$10$jNx4AiNbX9SGuie5FqXlD.6z0sqmNr8PxqaPZcf0wdRxW8qTxBJMy', NULL, NULL, '2017-04-26 10:13:13', 0, '13', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0.00, '2017-04-25 20:58:01', '2017-04-26 03:47:29'),
(22, 3, 123, 'user333-fix', 'user4-fix1111111111111111@gmail.com', '$2y$10$Xpomr8pRu1rPD879i4l5euv6ser9ztzg0cX6vjXDBxSLWuqDALwp2', NULL, NULL, '2017-04-26 11:27:47', 0, '12345678', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:10:50', '2017-04-26 04:28:30'),
(23, 3, 123, 'user55', 'user55@gmail.com', '$2y$10$rM7mPs60MUdHJXjJE5N5wOP6.jTbxv4j8rewS7s9x.kIbcEz9xIBq', NULL, NULL, '2017-05-04 03:13:40', 0, '', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:14:26', '2017-05-03 20:13:40'),
(24, 3, 123, 'user66', 'user66@gmail.com', '$2y$10$urml2rFp7XvSJ9Be3FY0besm5Ty4pDfdeMjwUB7KzO3TpGfWkGLBW', NULL, NULL, '2017-04-26 04:30:36', 0, '1221321321', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:30:33', '2017-04-25 21:30:36'),
(25, 3, 123, 'user77', 'user77@gmail.com', '$2y$10$mZ2Su5oRx1TlciR.NlciWens3/e1aQfjp1Fwt55PtfvTTYW4Aci16', NULL, NULL, '2017-04-26 04:34:04', 0, '1221321321', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:34:00', '2017-04-25 21:34:04'),
(26, 3, 123, 'user88', 'user88@gmail.com', '$2y$10$XNCE/Tvcjzctrw9Z7YDGAe4C5C8Py7h.EzqiV6pyCRww.bHtgo.C6', NULL, NULL, '2017-04-26 04:40:53', 0, '1221321321', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:40:49', '2017-04-25 21:40:53'),
(27, 3, 123, 'user99', 'user99@gmail.com', '$2y$10$obFXeYjy2R6nsoQVdj2VL.sMWiahn9egMPDAr.tPE.EGe70zVK0QC', NULL, NULL, '2017-04-26 04:43:24', 0, '1221321321', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0.00, '2017-04-25 21:43:21', '2017-04-25 21:43:24'),
(30, 3, 1, '4444444444444', 'test@gmail.com', '$2y$10$lReGTzD90UQEV4iY6zqPHOj1/90CC3pt3OPTZQaWc7GDMGc/lj9Im', NULL, NULL, '2017-04-26 07:09:05', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 00:09:00', '2017-04-26 00:09:05'),
(31, 3, 1, 'test_no_term', 'test_no_term@gmail.com', '$2y$10$QjJj/TeP1zAiPZ6Rcm.M3uLNaNPg/rcqrpIX88o8lK1c3DGOImpf6', NULL, NULL, '2017-04-26 07:23:53', 0, 'aaaaa', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 00:23:49', '2017-04-26 00:23:53'),
(32, 3, 123, 'user99999', 'user9999@gmail.com', '$2y$10$Qv4UH83VNjGkHZBFfs3ZXeq05hCGei.zsN1PvmbELPqdJrP/BgaLW', NULL, NULL, '2017-05-03 04:56:03', 0, 'hdkvjbxkjbvkj', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-04-26 00:25:11', '2017-05-02 21:56:03'),
(33, 3, 1, 'test_no_term1', 'test_no_term1@gmail.com', '$2y$10$u4ihlpoPZOXIl3BypNJpTOTQLZk0XC/0PDTdQSomfBzA1UihqyPDW', NULL, NULL, '2017-04-26 07:59:16', 0, 'aaaaa', NULL, NULL, NULL, 0, '2000-01-01', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 00:59:12', '2017-04-26 00:59:16'),
(35, 3, 12, 'test', '123456@facebook.com', '', 'facebook', '123456', '2017-05-05 06:56:33', 0, NULL, 'https://graph.facebook.com/123456/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0.00, '2017-04-26 01:19:17', '2017-05-04 23:56:33'),
(37, 3, 12, 'tes-loginfb', 'tes-loginfb@facebook.com', '', 'facebook', '123456', '2017-04-26 09:05:41', 0, NULL, 'https://graph.facebook.com/123456/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 02:05:41', '2017-04-26 02:05:41'),
(38, 3, 12, 'tes-loginfb23222', 'tes-loginfb222@facebook.com', '', 'facebook', '12345677', '2017-05-05 08:19:02', 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 02:10:40', '2017-05-05 01:19:02'),
(39, 3, 12, 'tes-loginfb12321321', 'tes-loginfb22213213212@facebook.com', '', 'facebook', '12345677', '2017-04-26 09:16:37', 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 02:16:37', '2017-04-26 02:16:37'),
(40, 3, 12, 'tes-loginfb2', 'tes-loginfb2@facebook.com', '', 'facebook', '12345677', '2017-04-26 09:17:38', 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-04-26 02:17:38', '2017-04-26 02:17:38'),
(69, 2, 1, 'admin2', 'admin2@mail.com', '$2y$10$LtGzECzEV3DEn9663mOh/uB05mujysnDfJfhOEAbgX6OGP.PZNGuO', NULL, NULL, '2017-05-03 04:55:12', 0, NULL, NULL, 'Admin2', 'Admin2', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.00, '2017-05-02 20:00:00', '2017-05-02 21:55:12'),
(79, 3, NULL, NULL, 'testloginfb@facebook.com', '', 'facebook', '123456', NULL, 0, NULL, 'https://graph.facebook.com/123456/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-03 00:07:57', '2017-05-03 00:07:57'),
(102, 3, 1, 'test_token', 'a816152@mvrht.net', '$2y$10$jFj6NXDDAQl3q4CA.NoxBuOGXdWwNl.jztO6SyWZ3J6fIW5FQq5hS', NULL, NULL, '2017-05-04 03:40:04', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-05-03 20:37:10', '2017-05-04 19:58:02'),
(103, 3, NULL, NULL, '', '', 'facebook', '12345677', NULL, 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-05-03 21:19:05', '2017-05-03 21:19:05'),
(104, 3, NULL, NULL, 'asdasd@dasdas.com', '', 'facebook', '12345677', NULL, 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-05-03 21:19:58', '2017-05-03 21:19:58'),
(106, 3, 1, 'add_username1', 'add_email@email.com', '$2y$10$n4PQBD9QcboWWmKd2z.rIecBlPegWH05n5PFlJnU1myAez11rQ.r2', 'facebook', '01264407020', '2017-05-04 07:02:49', 0, '0988950519', 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-03 23:49:36', '2017-05-04 00:07:43'),
(107, 3, 1, 'add_username2', 'add_email2@email.com', '$2y$10$JvsqfxZBk6C2Wx0k5xTLlOUVvFMcdpE1XbcxCI2REgDGMPOYY3tl6', 'facebook', '1182100228582240', '2017-05-05 03:57:36', 0, '0988950519', 'https://graph.facebook.com/1182100228582240/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-03 23:54:18', '2017-05-04 20:57:36'),
(110, 3, 113, 'add_username3', 'add_email3@email.com', '$2y$10$BV6D8TfNagz90jqFZ3RjqeuV6jj6R5LVh8DOBQ.GTk3Ol6sfkZPAO', 'facebook', '113113113', '2017-05-04 07:14:46', 0, '0988950519', 'https://graph.facebook.com/113113113/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 00:12:27', '2017-05-04 00:14:46'),
(111, 3, NULL, NULL, NULL, '', 'facebook', '113113113', '2017-05-05 06:53:22', 0, NULL, 'https://graph.facebook.com/113113113/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 00:14:46', '2017-05-04 23:53:22'),
(132, 3, 113, 'retest', 're-test@facebook.com', '$2y$10$S9GipKdZdMKRhKrXMqienuXxgVpiXr//FK1472F3UQQa90IVKVv.q', 'facebook', '0123123456789', '2017-05-05 02:29:14', 0, '0123654789', 'https://graph.facebook.com/0123123456789/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 19:29:14', '2017-05-04 19:30:19'),
(134, 3, 113, 'retest2', 'retest2@mail.com', '$2y$10$PCXHll2qCmqqmAwPrLK7ZuhJ4/ch5eieSqpqZI9Pz1/zOS4SLefMG', 'facebook', '01231234567890', '2017-05-05 02:31:51', 0, '0123654789', 'https://graph.facebook.com/01231234567890/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 19:31:51', '2017-05-04 19:32:39'),
(135, 3, 113, 'retest3', 're-test3@facebook.com', '$2y$10$c0ryVDmLdjIv30R2p5EXMe2bFUMOywzDAIBPwGw8vWl.qaY.Ujqc6', 'facebook', '01231234567891', '2017-05-05 02:34:09', 0, '0123654789', 'https://graph.facebook.com/01231234567891/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 19:34:09', '2017-05-04 19:35:02'),
(136, 3, 113, 'retest4', 're-test4@facebook.com', '', 'facebook', '01231234567892', '2017-05-05 02:45:21', 0, '0123654789', 'https://graph.facebook.com/01231234567892/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 0, 0.00, '2017-05-04 19:45:21', '2017-05-04 19:46:13'),
(138, 3, 113, 'retest5', 're-test5@facebook.com', '', 'facebook', '01231234567893', '2017-05-05 07:00:52', 0, '0123654789', 'https://graph.facebook.com/01231234567893/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 0, 0.00, '2017-05-04 19:47:48', '2017-05-05 00:00:52'),
(142, 3, 3, 'Le@tie', 'playorgotest1@gmail.com', '$2y$10$2fiblkE5BWCnKlLUO9TIx.RKoV8hJQMUC60pXzJqL0Hseb/vZbpn.', NULL, NULL, '2017-05-08 04:00:07', 0, '+84988950519', NULL, NULL, NULL, 0, '1947-02-10', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 0, 0.00, '2017-05-04 20:13:01', '2017-05-07 21:00:07'),
(149, 3, NULL, NULL, NULL, '', 'facebook', '123456', NULL, 0, NULL, 'https://graph.facebook.com/123456/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-04 23:56:18', '2017-05-04 23:56:18'),
(150, 3, NULL, NULL, NULL, '', 'facebook', '01231234567893', NULL, 0, NULL, 'https://graph.facebook.com/01231234567893/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-05 00:00:52', '2017-05-05 00:00:52'),
(151, 3, 242, 'Leotie 2017', 'a1080619@mvrht.net', '$2y$10$j/VmFQbDLZq/F90f7nXwBu1AwpoO5s6TbmE5msIS/SxfgXKm/3CMS', NULL, NULL, '2017-05-05 07:12:43', 0, '+842516343323', NULL, NULL, NULL, 0, '1983-02-10', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-05-05 00:03:56', '2017-05-05 00:12:43'),
(158, 3, NULL, NULL, NULL, '', 'facebook', '12345677', NULL, 0, NULL, 'https://graph.facebook.com/12345677/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-05-05 01:19:02', '2017-05-05 01:19:02'),
(159, 3, 114, 'retest7', 'retest7@facebook.com', '', 'facebook', '9999', '2017-05-05 08:21:42', 0, '0123654789', 'https://graph.facebook.com/9999/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-05-05 01:20:06', '2017-05-05 01:23:29'),
(161, 3, 242, 'g$$sightsoft2017beesightsoft2017beesightbeesightsoft2017beesightsoft2017beesightbeesightsoft2017bees', 'a1093273@mvrht.net', '$2y$10$4xkJCvyrlKm9Ng0xiF2yF.evW8BdlbCoFColIc2pDA0XB6pd7XOo2', NULL, NULL, '2017-05-05 08:20:47', 0, '0123456789', NULL, NULL, NULL, 0, '2005-10-10', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0.00, '2017-05-05 01:20:44', '2017-05-05 01:20:47'),
(162, 3, 114, 'retest8', 'retest8@fb.com', '', 'facebook', '1111', '2017-05-05 08:24:14', 0, '0123654789', 'https://graph.facebook.com/1111/picture?type=large', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-05-05 01:24:14', '2017-05-05 01:33:43'),
(163, 3, 1, 'test_verify', 'a1104867@mvrht.net', '$2y$10$d4bQyZ3olwNgLKlZhMRJE.rfvLwB1qgphxp.Y15LnF.SUIijzO5Ce', NULL, NULL, '2017-05-08 03:55:16', 0, '123456', NULL, NULL, NULL, 0, '0000-00-00', NULL, NULL, NULL, NULL, NULL, 4, 1, 1, 1, 0.00, '2017-05-05 02:31:01', '2017-05-07 20:55:16'),
(165, 3, 62, 'a1106506', 'a1106506@mvrht.net', '$2y$10$TBrfKq44tE58ffr858Lmz.VIqru016p7avRwBzf2m0u0OL2M3UlD6', NULL, NULL, '2017-05-05 09:54:00', 0, '0123456789', NULL, NULL, NULL, 0, '2001-03-04', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 1, 0.00, '2017-05-05 02:46:47', '2017-05-05 02:54:00'),
(166, 3, 13, 'dfasdasd', 'asdas@gmail.com', '$2y$10$q8XVfoAVKwPXOtcdXIU1VOqsy1mLVHu8m7ulE.AW8LY0QqeHx5wQS', NULL, NULL, '2017-05-05 09:55:02', 0, '0123456789', NULL, NULL, NULL, 0, '1998-05-06', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-05-05 02:54:59', '2017-05-05 02:55:02'),
(167, 3, 8, 'asdasd', 'asd@gmail.com', '$2y$10$JRJ34SNwIDWNGR6kDTttSuV9KqrF79sLQf7qgBLlKCo5dG4DqWGMm', NULL, NULL, '2017-05-05 09:56:53', 0, '0123456789', NULL, NULL, NULL, 0, '2003-03-03', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0.00, '2017-05-05 02:56:42', '2017-05-05 02:56:53'),
(173, 3, 239, 'lyquangthai1993', 'thai.ly@beesightsoft.com', '$2y$10$hAzbsS7Sxds3koaCfQarjuwdVjxxxjsNe7aqauq0GmSI0aChGyFYm', NULL, NULL, '2017-05-05 11:39:34', 0, '0988950519', NULL, NULL, NULL, 0, '1993-09-05', NULL, NULL, NULL, NULL, NULL, 5, 1, 1, 0, 0.00, '2017-05-05 04:16:29', '2017-05-05 04:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_platforms`
--

CREATE TABLE `user_platforms` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `platform_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verify_codes`
--

CREATE TABLE `verify_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bans_user_id_foreign` (`user_id`),
  ADD KEY `bans_game_id_foreign` (`game_id`);

--
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenges_user_id_foreign` (`user_id`),
  ADD KEY `challenges_game_id_foreign` (`game_id`);

--
-- Indexes for table `confirm_tokens`
--
ALTER TABLE `confirm_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `confirm_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disputes_challenge_id_foreign` (`challenge_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favourites_user_id_foreign` (`user_id`),
  ADD KEY `favourites_game_id_foreign` (`game_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_platform_id_foreign` (`platform_id`),
  ADD KEY `games_user_id_foreign` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_result_id_foreign` (`result_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletters_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_challenge_id_foreign` (`challenge_id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_user_id_foreign` (`user_id`),
  ADD KEY `results_challenge_id_foreign` (`challenge_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_challenge_id_foreign` (`challenge_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_location_id_foreign` (`location_id`);

--
-- Indexes for table `user_platforms`
--
ALTER TABLE `user_platforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_platforms_user_id_foreign` (`user_id`),
  ADD KEY `user_platforms_platform_id_foreign` (`platform_id`);

--
-- Indexes for table `verify_codes`
--
ALTER TABLE `verify_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verify_codes_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `confirm_tokens`
--
ALTER TABLE `confirm_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `disputes`
--
ALTER TABLE `disputes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;
--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=548;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT for table `user_platforms`
--
ALTER TABLE `user_platforms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `verify_codes`
--
ALTER TABLE `verify_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `bans_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `confirm_tokens`
--
ALTER TABLE `confirm_tokens`
  ADD CONSTRAINT `confirm_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disputes`
--
ALTER TABLE `disputes`
  ADD CONSTRAINT `disputes_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `games_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_result_id_foreign` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD CONSTRAINT `newsletters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_platforms`
--
ALTER TABLE `user_platforms`
  ADD CONSTRAINT `user_platforms_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_platforms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verify_codes`
--
ALTER TABLE `verify_codes`
  ADD CONSTRAINT `verify_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
