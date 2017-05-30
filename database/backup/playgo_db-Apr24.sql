-- phpMyAdmin SQL Dump
-- version 4.6.5.2deb1+deb.cihar.com~xenial.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2017 at 02:31 PM
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
  `confirm_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `speed` int(11) NOT NULL DEFAULT '0',
  `half_length` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
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
(6, 10, 'BA30D1FFE28D552E67063E1526EDF7BF', '2017-04-26 04:40:37', '2017-04-23 21:40:37', '2017-04-23 21:40:37');

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
(1, 1, 2, 'Call of duty', '', '', 5, '2017-04-21 03:57:50', '2017-04-21 03:57:50');

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
  `content` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
(1, 'xbox360', 2, NULL, '2017-04-21 03:36:41', '2017-04-21 03:36:41');

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
(5, 9, 'F15FE0E09B5C922DD3760D581FC0C664', '2017-04-24 09:05:20', 1, 7, '2017-04-24 00:05:20', '2017-04-24 00:05:20');

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
  `location_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `term` tinyint(1) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) NOT NULL DEFAULT '0',
  `is_subscribe` tinyint(1) NOT NULL DEFAULT '0',
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

INSERT INTO `users` (`id`, `role_id`, `location_id`, `username`, `email`, `password`, `social_type`, `social_id`, `last_login`, `is_deleted`, `phone`, `path`, `first_name`, `surname`, `gender`, `province`, `city`, `postal_code`, `address1`, `address2`, `term`, `privacy`, `is_subscribe`, `status`, `is_term_condition`, `is_privacy_policy`, `is_subscribe_email`, `coin`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'supadmin', 'super_admin@mail.com', '$2y$10$ZmbngznpledOym47caukZ.7PCnE26B9mtFwwNNAlp.0WwyPih8qeG', NULL, NULL, NULL, 0, NULL, NULL, 'Admin', 'SuperAdmin', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, '2017-04-21 02:57:57', '2017-04-21 02:57:57'),
(3, 2, 1, 'admin', 'admin@mail.com', '$2y$10$ZtnGk.Q1Xyd3ritD9j1eMOI4jtY8CEQSzUjNjbcbqGb0F/3Le7G2K', NULL, NULL, NULL, 0, NULL, NULL, 'Admin', 'Admin', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-04-21 02:57:58'),
(4, 3, 1, 'example', 'example@mail.com', '$2y$10$IE5bxj5uNQHl/fNY8FbwRe9pL/nVSKjvgsJCJPFI8bUf6aUCX8lxG', NULL, NULL, NULL, 0, NULL, NULL, 'Example', 'Example', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-04-21 02:57:58'),
(5, 3, 242, 'tridoan', 'dxtri94@gmail.com', '$2y$10$NNf.7kPl896Lnv3Yu4BheeuELamutI3hL0XgUSQiiSDoncIu7z6nq', NULL, NULL, NULL, 0, NULL, NULL, 'tridoan', 'tridoan', 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, '2017-04-21 02:57:58', '2017-04-21 02:57:58'),
(7, 3, 1, 'toanle', 'toan.le@beesightsoft.com', '$2y$10$QFr1UzuadViDxlQ/vCTCl.jnXw9K.PtnA0mtm2.fdgm.j2MvVucyK', NULL, NULL, '2017-04-21 10:08:45', 0, '1234567890', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 4, 1, 1, 1, 0.00, '2017-04-21 03:08:42', '2017-04-21 03:15:33'),
(8, 3, 12, 'test-register', 'test-register@gmail.com', '$2y$10$RzVf0YlsvvFkEn8Z091cjOAh4PGH76GRlm7X5Z8HQrum5AS1UoT9S', NULL, NULL, '2017-04-24 03:39:22', 0, '123456', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 1, 0.00, '2017-04-23 20:23:01', '2017-04-23 20:39:22'),
(9, 3, 12, 'test-tri', 'test-tri@gmail.com', '$2y$10$Tiy9lURRScH.GpbxnN3FV.NX5EHJYNy/w9mjdvhcQO0cn6ev0iAj6', NULL, NULL, '2017-04-24 07:05:20', 0, '123456789', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 0, 0.00, '2017-04-23 20:47:29', '2017-04-24 00:05:20'),
(10, 3, 12, 'test-tri123', 'test-tri123@gmail.com', '$2y$10$kPgt/zyeQ.4nxDgkHBL.huwxp7NnDOrK50Y24A98xN7UAv9jbPjLu', NULL, NULL, NULL, 0, '123456789', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 0, 0.00, '2017-04-23 21:40:37', '2017-04-23 21:40:37');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
