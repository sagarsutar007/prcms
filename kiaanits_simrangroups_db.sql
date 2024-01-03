-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2023 at 09:05 PM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kiaanits_simrangroups_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer_text_en` text NOT NULL,
  `answer_text_hi` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer_text_en`, `answer_text_hi`, `question_id`, `created_at`) VALUES
(1, 'Series motor', 'शृंखला मोटर', 1, '2023-10-27 18:09:54'),
(2, 'Shunt motor', 'शंट मोटर', 1, '2023-10-27 18:09:54'),
(3, 'Cumulative compound motor', 'संचयी यौगिक मोटर', 1, '2023-10-27 18:09:54'),
(4, 'Differentiate compound motor', 'विभेदक यौगिक मोटर', 1, '2023-10-27 18:09:54'),
(5, 'Interchanging field terminals', 'फ़ील्ड टर्मिनलों का आदान-प्रदान', 2, '2023-10-27 18:12:20'),
(6, 'Interchanging supply terminals', ' आपूर्ति टर्मिनलों की अदला-बदली', 2, '2023-10-27 18:12:20'),
(7, 'Either of A. and B. above', 'उपरोक्त A. और B. में से कोई एक', 2, '2023-10-27 18:12:20'),
(8, 'None of the above', 'इनमे से कोई भी नहीं', 2, '2023-10-27 18:12:20'),
(33, 'Shunt motor', 'शंट मोटर', 6, '2023-10-27 19:42:55'),
(34, 'Series motor', 'शृंखला मोटर', 6, '2023-10-27 19:42:55'),
(35, 'Cumulative compound motor', 'संचयी यौगिक मोटर', 6, '2023-10-27 19:42:55'),
(36, 'Differential compound motor', 'विभेदक यौगिक मोटर', 6, '2023-10-27 19:42:55'),
(37, 'Series motor', 'शृंखला मोटर', 5, '2023-10-27 19:43:00'),
(38, 'Shunt motor', 'शंट मोटर', 5, '2023-10-27 19:43:00'),
(39, 'Differentially compound motor', 'विभेदक रूप से मिश्रित मोटर', 5, '2023-10-27 19:43:00'),
(40, 'Cumulative compound motor', 'संचयी यौगिक मोटर', 5, '2023-10-27 19:43:00'),
(45, 'Locomotive', 'लोकोमोटिव', 4, '2023-10-27 19:43:03'),
(46, 'Lathe machine', 'LATHE मशीन', 4, '2023-10-27 19:43:03'),
(47, 'Centrifugal pump', 'केंद्रत्यागी पम्प', 4, '2023-10-27 19:43:03'),
(48, 'Air blower', 'हवा भरने वाला', 4, '2023-10-27 19:43:03'),
(49, 'low starting torque', 'कम शुरुआती टॉर्क', 7, '2023-10-27 19:46:07'),
(50, 'High starting torque', 'उच्च आरंभिक टॉर्क', 7, '2023-10-27 19:46:07'),
(51, 'Variable Speed', 'चर गति', 7, '2023-10-27 19:46:07'),
(52, 'Frequent on-off cycles', 'बार-बार चालू-बंद चक्र', 7, '2023-10-27 19:46:07'),
(53, 'Cumulative compound motor', 'संचयी यौगिक मोटर', 8, '2023-10-27 19:47:47'),
(54, 'Shunt motor', 'शंट मोटर', 8, '2023-10-27 19:47:47'),
(55, 'Series motor', 'शृंखला मोटर', 8, '2023-10-27 19:47:47'),
(56, 'Differential compound motor', 'विभेदक यौगिक मोटर', 8, '2023-10-27 19:47:47'),
(73, 'Has its field winding consisting of wire and less turns', 'इसकी फ़ील्ड वाइंडिंग में तार और कम घुमाव होते हैं', 12, '2023-10-27 19:55:21'),
(74, 'Has a poor torque', 'ख़राब टॉर्क है', 12, '2023-10-27 19:55:21'),
(75, 'Can be started easily without load', 'बिना लोड के आसानी से शुरू किया जा सकता है', 12, '2023-10-27 19:55:21'),
(76, 'Has almost constant speed', 'लगभग स्थिर गति है', 12, '2023-10-27 19:55:21'),
(77, 'It limits the starting current to a safe value', 'यह आरंभिक धारा को सुरक्षित मान तक सीमित करता है', 13, '2023-10-27 19:57:33'),
(78, 'It limits the speed of the motor', 'यह मोटर की गति को सीमित करता है', 13, '2023-10-27 19:57:33'),
(79, 'It starts the motor', 'यह मोटर चालू करता है', 13, '2023-10-27 19:57:33'),
(80, 'None of the above', 'इनमे से कोई भी नहीं', 13, '2023-10-27 19:57:33'),
(81, 'Cumulative compound D.C. motor', 'संचयी यौगिक डी.सी. मोटर', 14, '2023-10-27 19:59:18'),
(82, 'Shunt motor', 'शंट मोटर', 14, '2023-10-27 19:59:18'),
(83, 'Series motor', 'शृंखला मोटर', 14, '2023-10-27 19:59:18'),
(84, 'Differential compoutid D.C. motor', 'डिफरेंशियल कंप्यूटिड डी.सी. मोटर', 14, '2023-10-27 19:59:18'),
(85, 'Burn due to heat produced in the field winding by eddy currents', 'भंवर धाराओं द्वारा क्षेत्र घुमावदार में उत्पन्न गर्मी के कारण जलना', 15, '2023-10-27 20:00:46'),
(86, 'Run at normal speed', 'सामान्य गति से दौड़ें', 15, '2023-10-27 20:00:46'),
(87, 'Not run', 'नहीं दौड़ा', 15, '2023-10-27 20:00:46'),
(88, 'Run at lower speed', 'कम गति से दौड़ें', 15, '2023-10-27 20:00:46'),
(103, 'Ward Leonard control', 'वार्ड लियोनार्ड नियंत्रण', 16, '2023-11-05 23:22:41'),
(104, 'Rheostatic control', 'रिओस्टैटिक नियंत्रण', 16, '2023-11-05 23:22:41'),
(105, 'Any of the above method', 'उपरोक्त विधि में से कोई भी', 16, '2023-11-05 23:22:41'),
(106, 'None of the above method', 'उपरोक्त विधि में से कोई नहीं', 16, '2023-11-05 23:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `app_preferences`
--

CREATE TABLE `app_preferences` (
  `id` int(11) NOT NULL,
  `app_name` varchar(120) DEFAULT NULL,
  `app_icon` text DEFAULT NULL,
  `app_subtitle` text NOT NULL,
  `translate_api_key` text DEFAULT NULL,
  `sms_api_key` text DEFAULT NULL,
  `out_smtp` text DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_email` text DEFAULT NULL,
  `smtp_pass` text DEFAULT NULL,
  `scheduled_exam` text DEFAULT NULL,
  `new_registered` text DEFAULT NULL,
  `candidate_login` text DEFAULT NULL,
  `scheduled_exam_mail` text DEFAULT NULL,
  `new_user_mail` text DEFAULT NULL,
  `candidate_login_mail` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_preferences`
--

INSERT INTO `app_preferences` (`id`, `app_name`, `app_icon`, `app_subtitle`, `translate_api_key`, `sms_api_key`, `out_smtp`, `smtp_port`, `smtp_email`, `smtp_pass`, `scheduled_exam`, `new_registered`, `candidate_login`, `scheduled_exam_mail`, `new_user_mail`, `candidate_login_mail`, `created_at`, `updated_at`) VALUES
(1, 'Simran Group', '30357915610c0615ba6c0c0d1aa91756.png', 'Your Next Milestone', 'bd39d03c6amsh3cf4c1e98dcf502p127c49jsn84175010c71f', 'MB9EDqYGQsK3JPace48Wr5gTHxdSXZIbnkOwhoj0Lv1N7uCiRyMlmQAXGbZu4DxJU5CYBWRjL6a1SzTe', 'mail.simrangroups.com', 465, 'support@simrangroups.com', 'Simran@1234', 'Hello there, Your exam is scheduled on ${exam_date} at ${exam_time}. Please login earlier to avoid any disruptions.', 'Hello there, Thank you for registering on ${company_name}. We are delighted to have you with us!!!', 'Hello ${name}, Please use below link to login into your dashboard\r\nhttps://simrangroups.com/candidate-login', '&lt;p&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;${firstname}&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem; font-weight: bolder;&quot;&gt;,&lt;/span&gt;&lt;/div&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;&lt;br&gt;&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Your exam is scheduled on&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; font-weight: bolder;&quot;&gt;${exam_date}&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;&amp;nbsp;at&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;font-size: 1rem; font-weight: bolder;&quot;&gt;${exam_time}&lt;/span&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;. Please login earlier and be available to avoid any disruptions.&lt;/span&gt;&lt;/div&gt;&lt;/span&gt;&lt;p&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center; &quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;${company_name} &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;', '&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;${firstname}&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem; font-weight: bolder;&quot;&gt;,&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;${company_name}.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;${company_name} &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;', '&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;${firstname}&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem; font-weight: bolder;&quot;&gt;,&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Here&#039;s your link to login page.&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); text-align: left;&quot;&gt;${login_qr}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;or&amp;nbsp;&lt;br&gt;Just click on the link below&lt;br&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); text-align: left;&quot;&gt;${login_url}&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;${company_name}&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;', '2023-10-28 07:01:19', '2023-11-07 20:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `business_units`
--

CREATE TABLE `business_units` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) DEFAULT NULL,
  `middlename` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `profile_img` tinytext DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `logged_in_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_units`
--

INSERT INTO `business_units` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `phone`, `email`, `password`, `profile_img`, `status`, `created_at`, `edited_at`, `created_by`, `edited_by`, `logged_in_at`) VALUES
(1, 'Samir', '', 'Gaikward', 'male', '9856321123', 'samir@businessunit.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'e8faa2c0648454b50e67479a4971b743.jpg', 'active', '2023-11-02 10:24:13', NULL, NULL, NULL, NULL),
(4, 'Kartik', '', 'Prajapati', 'other', '9337845548', 'kartik@businessunit.com', 'b670eab762c7013782d240ea562305e8', '', 'active', '2023-11-07 09:59:29', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) DEFAULT NULL,
  `middlename` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `profile_img` tinytext DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `company_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `logged_in_at` datetime DEFAULT NULL,
  `authtoken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `phone`, `email`, `password`, `profile_img`, `status`, `company_id`, `created_at`, `edited_at`, `created_by`, `edited_by`, `logged_in_at`, `authtoken`) VALUES
(13, 'Sagar', NULL, 'Sutar', 'male', '8339042376', '1sagarsutar@gmail.com', '16d7a4fca7442dda3ad93c9a726597e4', 'user8-128x128.jpg', 'active', 1, '2023-11-07 20:14:29', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_details`
--

CREATE TABLE `candidate_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `highest_qualification` varchar(120) DEFAULT NULL,
  `passout_year` varchar(4) DEFAULT NULL,
  `percentage_secured` varchar(10) DEFAULT NULL,
  `aadhaar_card_front_pic` text DEFAULT NULL,
  `aadhaar_card_back_pic` text DEFAULT NULL,
  `pancard_pic` text DEFAULT NULL,
  `voter_id` text DEFAULT NULL,
  `pa_address` varchar(250) DEFAULT NULL,
  `pa_address_landmark` varchar(120) DEFAULT NULL,
  `pa_city` varchar(120) DEFAULT NULL,
  `pa_dist` varchar(120) DEFAULT NULL,
  `pa_pin` varchar(6) DEFAULT NULL,
  `pa_state` varchar(120) DEFAULT NULL,
  `ca_address` varchar(250) DEFAULT NULL,
  `ca_address_landmark` varchar(120) DEFAULT NULL,
  `ca_city` varchar(120) DEFAULT NULL,
  `ca_dist` varchar(120) DEFAULT NULL,
  `ca_pin` int(6) DEFAULT NULL,
  `ca_state` varchar(120) DEFAULT NULL,
  `whatsapp_number` varchar(10) DEFAULT NULL,
  `father_name` varchar(120) DEFAULT NULL,
  `bank_name` varchar(120) DEFAULT NULL,
  `account_num` varchar(120) DEFAULT NULL,
  `ifsc_code` varchar(120) DEFAULT NULL,
  `marital_status` enum('married','un-married','divorced') NOT NULL DEFAULT 'un-married',
  `passbook_pic` text DEFAULT NULL,
  `chequebook_pic` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_details`
--

INSERT INTO `candidate_details` (`id`, `user_id`, `company_id`, `dob`, `highest_qualification`, `passout_year`, `percentage_secured`, `aadhaar_card_front_pic`, `aadhaar_card_back_pic`, `pancard_pic`, `voter_id`, `pa_address`, `pa_address_landmark`, `pa_city`, `pa_dist`, `pa_pin`, `pa_state`, `ca_address`, `ca_address_landmark`, `ca_city`, `ca_dist`, `ca_pin`, `ca_state`, `whatsapp_number`, `father_name`, `bank_name`, `account_num`, `ifsc_code`, `marital_status`, `passbook_pic`, `chequebook_pic`) VALUES
(13, 13, 1, '1995-01-16', 'MCA', NULL, NULL, '', '', '', 'AdminLTELogo.png', 'Pwd/La-200, Ramnagar', 'Behind Kalyan Mandap', 'Rourkela', 'Sundergarh', '769004', 'Odisha', 'Pwd/La-200, Ramnagar', 'Behind Kalyan Mandap', 'Rourkela', 'Sundergarh', 769004, 'Odisha', '8339042376', 'Mukteswar Sutar', 'Bank of India', '55771110000122', 'BKID012', 'un-married', 'boxed-bg.jpg', 'boxed-bg.png');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_exam_records`
--

CREATE TABLE `candidate_exam_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `entered_at` datetime NOT NULL,
  `left_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(120) NOT NULL,
  `category_desc` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `category_desc`, `created_by`, `edited_by`, `created_at`, `edited_at`) VALUES
(8, 'Others', '', 0, 0, '2023-11-04 08:23:40', NULL),
(10, 'Electrical', '', 1, 0, '2023-11-04 08:25:11', NULL),
(11, 'Mechanical', '', 1, 0, '2023-11-04 08:25:17', NULL),
(12, 'Ceramics', '', 1, 0, '2023-11-04 08:25:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) DEFAULT NULL,
  `middlename` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `profile_img` tinytext DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `company_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `logged_in_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `phone`, `email`, `password`, `profile_img`, `status`, `company_id`, `created_at`, `edited_at`, `created_by`, `edited_by`, `logged_in_at`) VALUES
(1, 'Jay', 'Chandra', 'Prakash', 'female', '9874565410', 'jayprakash@client.com', '16d7a4fca7442dda3ad93c9a726597e4', '53802c9059d568fecde4b980a817bf14.png', 'active', 1, '2023-11-02 11:05:44', '0000-00-00 00:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(120) NOT NULL,
  `company_logo` tinytext DEFAULT NULL,
  `company_about` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_logo`, `company_about`, `created_at`, `edited_at`) VALUES
(1, 'B.S Enterprises', 'ee3ab071b9605e61d19b0de3d3c85de2.jpg', '', '2023-10-27 23:46:05', NULL),
(2, 'Kamal Enterprises', '822cbc803f7a59c5071d510ab72bc42f.jpeg', '', '2023-10-27 23:46:30', NULL),
(3, 'JP Cement', 'cd464a023e5d30ea85841a2ea7497d6e.png', 'Welcome to JP Cement!', '2023-10-27 23:48:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `com_usr_link`
--

CREATE TABLE `com_usr_link` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `type` enum('business unit','client') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `com_usr_link`
--

INSERT INTO `com_usr_link` (`id`, `user_id`, `company_id`, `type`) VALUES
(1, 1, 1, 'business unit'),
(3, 1, 3, 'client'),
(14, 1, 2, 'business unit'),
(15, 4, 2, 'business unit');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `duration` int(3) DEFAULT NULL,
  `lang` enum('eng','hindi','both') NOT NULL,
  `exam_datetime` datetime DEFAULT NULL,
  `status` enum('scheduled','cancelled','draft') NOT NULL,
  `url` tinytext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `name`, `company_id`, `duration`, `lang`, `exam_datetime`, `status`, `url`, `created_by`, `created_at`) VALUES
(1, 'Electronic Dept. Exam', 1, 60, 'eng', '2023-11-05 20:55:00', 'scheduled', 'exam-654732b87ea46', NULL, '2023-11-05 11:44:16'),
(8, 'Basic Computer Test', 1, 60, 'eng', '2023-11-05 23:30:00', 'scheduled', 'exam-6547d7d5117c6', NULL, '2023-11-05 23:28:45'),
(12, 'Some New Exam', 1, 30, 'eng', '2023-11-06 21:45:00', 'draft', 'exam-654910f3a511b', NULL, '2023-11-06 21:44:43'),
(16, 'Some New Exam-cloned', 1, 30, 'eng', '2023-11-06 23:26:00', 'scheduled', 'exam-65491ad5397cc', NULL, '2023-11-06 22:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `exam_candidates`
--

CREATE TABLE `exam_candidates` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_candidates`
--

INSERT INTO `exam_candidates` (`id`, `candidate_id`, `exam_id`, `created_at`) VALUES
(8, 2, 1, '2023-11-05 16:36:46'),
(9, 1, 1, '2023-11-05 16:36:54'),
(12, 4, 8, '2023-11-05 23:31:54'),
(13, 2, 8, '2023-11-05 23:31:54'),
(14, 5, 8, '2023-11-05 23:37:15'),
(20, 4, 16, '2023-11-06 22:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `exam_clients`
--

CREATE TABLE `exam_clients` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_clients`
--

INSERT INTO `exam_clients` (`id`, `client_id`, `exam_id`, `created_at`) VALUES
(1, 3, 1, '2023-11-05 11:44:16'),
(2, 3, 4, '2023-11-05 20:28:48'),
(3, 3, 8, '2023-11-05 23:28:45'),
(5, 3, 12, '2023-11-06 21:44:43'),
(12, 3, 16, '2023-11-06 22:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 1, 7),
(5, 1, 8),
(6, 1, 9),
(7, 1, 10),
(8, 1, 13),
(9, 1, 14),
(10, 1, 15),
(31, 4, 1),
(32, 4, 2),
(33, 4, 4),
(34, 4, 7),
(35, 4, 8),
(36, 4, 9),
(37, 4, 10),
(38, 4, 13),
(39, 4, 14),
(40, 4, 15),
(71, 8, 1),
(72, 8, 2),
(73, 8, 4),
(74, 8, 5),
(75, 8, 6),
(76, 8, 1),
(77, 8, 2),
(78, 8, 4),
(79, 8, 5),
(80, 8, 6),
(112, 12, 12),
(113, 12, 7),
(114, 12, 13),
(115, 12, 15),
(116, 12, 14),
(117, 12, 16),
(118, 12, 8),
(119, 12, 6),
(144, 16, 12),
(145, 16, 7),
(146, 16, 13),
(147, 16, 15),
(148, 16, 14),
(149, 16, 16),
(150, 16, 8),
(151, 16, 6);

-- --------------------------------------------------------

--
-- Table structure for table `exam_records`
--

CREATE TABLE `exam_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` text NOT NULL,
  `exam_id` int(11) NOT NULL,
  `status` enum('correct','incorrect','unknown') NOT NULL DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs_tbl`
--

CREATE TABLE `notification_logs_tbl` (
  `id` int(11) NOT NULL,
  `type` enum('sms','email','whatsapp') NOT NULL,
  `text` text NOT NULL,
  `to_recipient` varchar(120) NOT NULL,
  `response` varchar(20) NOT NULL,
  `req_response` text NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification_logs_tbl`
--

INSERT INTO `notification_logs_tbl` (`id`, `type`, `text`, `to_recipient`, `response`, `req_response`, `created_on`) VALUES
(1, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;img src=&quot;https://simrangroups.com/assets/img/30357915610c0615ba6c0c0d1aa91756.png&quot; height=&quot;50px&quot;&gt;\n                &lt;br&gt;\n                &lt;h2&gt;Simran Group&lt;/h2&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;padding: 20px;&quot;&gt;\n                &lt;p&gt;Dear  Sagar,&lt;/p&gt;\n                &lt;p&gt;Here is your login link to get into the dashboard and accessing features that are private to you.&lt;/p&gt;\n                &lt;div style=&quot;text-align:center&quot;&gt;&lt;img src=&quot;https://simrangroups.com/assets/admin/img/qrcodes/candidate-login.png&quot; width=&quot;50%&quot;&gt;&lt;/div&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;Scan this link to land into login page. Use correct credentials to login.&lt;/p&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;If you have any questions or need assistance, please feel free to contact our support team.&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;p&gt;Visit our website: &lt;a href=&quot;https://simrangroups.com/&quot;&gt;Click Here!&lt;/a&gt;&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;\n', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(2, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;img src=&quot;https://simrangroups.com/assets/img/30357915610c0615ba6c0c0d1aa91756.png&quot; height=&quot;50px&quot;&gt;\n                &lt;br&gt;\n                &lt;h2&gt;Simran Group&lt;/h2&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;padding: 20px;&quot;&gt;\n                &lt;p&gt;Dear  Sagar,&lt;/p&gt;\n                &lt;p&gt;Here is your login link to get into the dashboard and accessing features that are private to you.&lt;/p&gt;\n                &lt;div style=&quot;text-align:center&quot;&gt;&lt;img src=&quot;https://simrangroups.com/assets/admin/img/qrcodes/candidate-login.png&quot; width=&quot;50%&quot;&gt;&lt;/div&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;Scan this link to land into login page. Use correct credentials to login.&lt;/p&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;If you have any questions or need assistance, please feel free to contact our support team.&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;p&gt;Visit our website: &lt;a href=&quot;https://simrangroups.com/&quot;&gt;Click Here!&lt;/a&gt;&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;\n', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(3, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;img src=&quot;https://simrangroups.com/assets/img/30357915610c0615ba6c0c0d1aa91756.png&quot; height=&quot;50px&quot;&gt;\n                &lt;br&gt;\n                &lt;h2&gt;Simran Group&lt;/h2&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;padding: 20px;&quot;&gt;\n                &lt;p&gt;Dear  Samar,&lt;/p&gt;\n                &lt;p&gt;Here is your login link to get into the dashboard and accessing features that are private to you.&lt;/p&gt;\n                &lt;div style=&quot;text-align:center&quot;&gt;&lt;img src=&quot;https://simrangroups.com/assets/admin/img/qrcodes/candidate-login.png&quot; width=&quot;50%&quot;&gt;&lt;/div&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;Scan this link to land into login page. Use correct credentials to login.&lt;/p&gt;\n                &lt;p style=&quot;text-align:center&quot;&gt;If you have any questions or need assistance, please feel free to contact our support team.&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;background-color: #f8f8f8; padding: 20px; text-align: center;&quot;&gt;\n                &lt;p&gt;Visit our website: &lt;a href=&quot;https://simrangroups.com/&quot;&gt;Click Here!&lt;/a&gt;&lt;/p&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;\n', 'sagar.sync99@gmail.com', 'success', '', '2023-11-07'),
(4, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8984589109', 'success', '', '2023-11-07'),
(5, 'sms', 'Hello there, Thank you for registering on . We are delighted to have you with us!!!', '8984589109', 'failed', '', '2023-11-07'),
(6, 'sms', 'Hello there, Thank you for registering on . We are delighted to have you with us!!!', '8984589109', 'failed', '{\"return\":false,\"status_code\":412,\"message\":\"Invalid Authentication, Check Authorization Key\"}', '2023-11-07'),
(7, 'sms', 'Hello Sagar Kumar Sutar, Please use below link to login into your dashboard\nhttps://simrangroups.com/candidate-login', '8339042376', 'success', '', '2023-11-07'),
(8, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(9, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(10, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(11, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(12, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(13, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(14, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(15, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(16, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(17, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(18, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello &lt;/span&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;span style=&quot;font-weight: bolder;&quot;&gt;${&lt;/span&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;first&lt;/span&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64); font-size: 1rem;&quot;&gt;name},&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on &lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group &lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07'),
(19, 'sms', 'Hello there, Thank you for registering on Simran Group. We are delighted to have you with us!!!', '8339042376', 'success', '', '2023-11-07'),
(20, 'email', '&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;table align=&quot;center&quot; width=&quot;600&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; border=&quot;0&quot;&gt;\n        &lt;tr&gt;\n            &lt;td&gt;\n                &lt;div style=&quot;width: 100%; background:#f2f2f2;&quot;&gt;\n                &lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Hello&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Sagar&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64); font-size: 1rem; font-weight: bolder;&quot;&gt;,&lt;/span&gt;&lt;/div&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=&quot;text-align: center;&quot;&gt;Thank you for registering a candidate account on&amp;nbsp;&lt;span style=&quot;color: rgb(52, 58, 64); font-weight: bolder; font-size: 1rem; text-align: left;&quot;&gt;Simran Group.&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: center;&quot;&gt;We are happy to serve you best at our end.&lt;/div&gt;&lt;p&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-size: 1rem; color: rgb(52, 58, 64);&quot;&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-weight: bolder; color: rgb(52, 58, 64);&quot;&gt;Simran Group&amp;nbsp;&lt;/span&gt;&lt;span style=&quot;color: rgb(52, 58, 64);&quot;&gt;All Rights Reserved&lt;/span&gt;&lt;/p&gt;                &lt;/div&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/table&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '1sagarsutar@gmail.com', 'success', '', '2023-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_en` text DEFAULT NULL,
  `question_hi` text DEFAULT NULL,
  `question_img` text DEFAULT NULL,
  `question_type` enum('mcq','text') NOT NULL DEFAULT 'text',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `category_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_en`, `question_hi`, `question_img`, `question_type`, `status`, `category_id`, `created_by`, `created_at`, `edited_by`, `edited_at`) VALUES
(1, 'No-load speed of which of the following motor will be highest ?', 'निम्नलिखित में से किस मोटर की नो-लोड गति सबसे अधिक होगी?', '', 'mcq', 'active', 11, 1, '2023-10-27 06:09:54', NULL, NULL),
(2, 'The direction of rotation of a D.C. series motor can be changed by?', 'D.C. श्रृंखला मोटर के घूर्णन की दिशा किसके द्वारा बदली जा सकती है?', '', 'mcq', 'active', 11, 1, '2023-10-27 06:12:20', NULL, NULL),
(4, 'Which of the following application requires high starting torque?', 'निम्नलिखित में से किस एप्लिकेशन के लिए उच्च प्रारंभिक टॉर्क की आवश्यकता होती है?', '', 'mcq', 'active', 11, 11, '2023-10-27 07:15:48', NULL, NULL),
(5, 'If a D.C. motor is to be selected for conveyors, which rriotor would be preferred?', 'यदि कन्वेयर के लिए डी.सी. मोटर का चयन किया जाना है, तो किस राइटर को प्राथमिकता दी जाएगी?', '', 'mcq', 'active', 11, 11, '2023-10-27 07:18:06', NULL, NULL),
(6, 'Which D.C. motor will be preferred for machine tools?', 'मशीन टूल्स के लिए कौन सी डी.सी. मोटर को प्राथमिकता दी जाएगी?', '', 'mcq', 'active', 10, 11, '2023-10-27 07:19:56', NULL, NULL),
(7, 'Differentially compound D.C. motors can find applications requiring', 'विभेदित रूप से मिश्रित डी.सी. मोटरों के लिए आवश्यक अनुप्रयोग मिल सकते हैं', '', 'mcq', 'active', 10, 11, '2023-10-27 07:46:07', NULL, NULL),
(8, 'Which D.C. motor is preferred for elevators?', 'लिफ्ट के लिए कौन सी डी.सी. मोटर को प्राथमिकता दी जाती है?', '', 'mcq', 'active', 10, 11, '2023-10-27 07:47:47', NULL, NULL),
(12, 'A D.C. series motor is that which', 'डी.सी. सीरीज मोटर वह है जो', '', 'mcq', 'active', 11, 11, '2023-10-27 07:55:21', NULL, NULL),
(13, 'For starting a D.C. motor a starter is required because', 'डी.सी. मोटर शुरू करने के लिए स्टार्टर की आवश्यकता होती है क्योंकि', '', 'mcq', 'active', 8, 11, '2023-10-27 07:57:33', NULL, NULL),
(14, 'The type of D.C. motor used for shears and punches is', 'कैंची और पंच के लिए उपयोग की जाने वाली डी.सी. मोटर का प्रकार है', '', 'mcq', 'active', 8, 11, '2023-10-27 07:59:18', NULL, NULL),
(15, 'If a D.C. motor is connected across the A.C. supply it will', 'यदि एक डी.सी. मोटर को ए.सी. आपूर्ति से जोड़ दिया जाए तो ऐसा होगा', '', 'mcq', 'active', 8, 11, '2023-10-27 08:00:46', NULL, NULL),
(16, 'To get the speed of D.C, motor below the normal without wastage of electrical energy is used.', 'डी.सी. की गति प्राप्त करने के लिए, विद्युत ऊर्जा की बर्बादी के बिना सामान्य से कम मोटर का उपयोग किया जाता है।', '', 'mcq', 'active', 8, 11, '2023-10-27 08:02:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) DEFAULT NULL,
  `middlename` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` tinytext NOT NULL,
  `profile_img` tinytext DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `login_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `phone`, `email`, `password`, `profile_img`, `status`, `created_at`, `login_datetime`) VALUES
(1, 'Samir', '', 'Behera', 'male', '9856321123', 'user@admin.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'avatar5.jpeg', 'active', '2023-04-10 06:46:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_preferences`
--
ALTER TABLE `app_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_units`
--
ALTER TABLE `business_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_details`
--
ALTER TABLE `candidate_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_exam_records`
--
ALTER TABLE `candidate_exam_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `com_usr_link`
--
ALTER TABLE `com_usr_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_candidates`
--
ALTER TABLE `exam_candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_clients`
--
ALTER TABLE `exam_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_records`
--
ALTER TABLE `exam_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs_tbl`
--
ALTER TABLE `notification_logs_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `app_preferences`
--
ALTER TABLE `app_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_units`
--
ALTER TABLE `business_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `candidate_details`
--
ALTER TABLE `candidate_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `candidate_exam_records`
--
ALTER TABLE `candidate_exam_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `com_usr_link`
--
ALTER TABLE `com_usr_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `exam_candidates`
--
ALTER TABLE `exam_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `exam_clients`
--
ALTER TABLE `exam_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `exam_records`
--
ALTER TABLE `exam_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs_tbl`
--
ALTER TABLE `notification_logs_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
