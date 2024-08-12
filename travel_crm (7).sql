-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 03:53 PM
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
-- Database: `travel_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(155) DEFAULT NULL,
  `tag` varchar(155) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `pan_no` varchar(155) DEFAULT NULL,
  `hsc_code` varchar(155) DEFAULT NULL,
  `logo_path` varchar(155) DEFAULT NULL,
  `gst_no` varchar(155) DEFAULT NULL,
  `inv_f_part` varchar(50) DEFAULT NULL,
  `inv_l_part` int(25) NOT NULL DEFAULT 0,
  `inv_session_part` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `tag`, `address`, `phone`, `email`, `pan_no`, `hsc_code`, `logo_path`, `gst_no`, `inv_f_part`, `inv_l_part`, `inv_session_part`) VALUES
(1, 'TASKMANAGER', 'TASKMANAGER', 'HAIDERPARA, SILIGURI-734001', '0123456789', 'TASKMANAGER@GMAIL.COM', 'PAN12355', '987654', 'images/company/logo.png', '123GXYZ', 'INV/', 21, '/2023-24');

-- --------------------------------------------------------

--
-- Table structure for table `master_cab_tariff`
--

CREATE TABLE `master_cab_tariff` (
  `id` int(11) NOT NULL,
  `cab_id` varchar(250) NOT NULL,
  `rate` varchar(250) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_hotel_tariff`
--

CREATE TABLE `master_hotel_tariff` (
  `id` int(11) NOT NULL,
  `hotel_id` varchar(250) NOT NULL,
  `type_id` varchar(250) NOT NULL,
  `meal_id` varchar(250) NOT NULL,
  `child_id` varchar(250) NOT NULL,
  `rate` varchar(250) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_hotel_tariff`
--

INSERT INTO `master_hotel_tariff` (`id`, `hotel_id`, `type_id`, `meal_id`, `child_id`, `rate`, `valid_from`, `valid_to`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '5', '1', '1', '1', '200', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(2, '5', '1', '1', '', '400', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(3, '5', '2', '1', '1', '300', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(4, '5', '2', '1', '', '600', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(5, '5', '1', '2', '1', '400', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(6, '5', '1', '2', '', '800', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(7, '5', '2', '2', '1', '500', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0),
(8, '5', '2', '2', '', '1000', '2024-07-01', '2024-07-05', '1', '', '2024-07-03', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `due_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `added_by` varchar(250) NOT NULL,
  `gen_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `status`, `due_date`, `user_id`, `added_by`, `gen_date`) VALUES
(3, 'LARAVEL TASK MANAGEMENT SYSTEM', '&amp;lt;p&amp;gt;**Objective:** The objective of this assignment is to evaluate your ability to learn and apply Laravel concepts while building a unique Task Management System. This project will not only test your PHP and Laravel skills but also your problem-solving and creativity. **Requirements:** 1. **Setup:** - Install Laravel on your local development environment. - Create a new Laravel project named &amp;quot;TaskManager.&amp;quot; 2. **Database:** - Set up a SQLite / MySQL database for the task management system. - Create migrations for the following tables: - `tasks` (id, title, description, status, due_date, user_id) - `users` (id, name, email, password) 3. **Models and Relationships:** - Create models for `Task` and `User`. - Define relationships between tasks and users (e.g., a task belongsTo a user, and a user hasMany tasks). 4. **Controllers:** - Build controllers to manage tasks. - Implement CRUD operations for tasks. - Include functionality for assigning tasks to users. 5. **Views:** - Develop views for listing all tasks, displaying a single task, and a form for adding/editing a task. - Create a dashboard for users to see their assigned tasks. 6. **Authentication and Authorization:** - Implement user authentication using Laravel&amp;#039;s built-in system. - Ensure that only authenticated users can create, update, or delete tasks. - Users should only be able to view and modify tasks assigned to them. 7. **Task Status:** - Introduce task statuses (e.g., &amp;quot;To-Do,&amp;quot; &amp;quot;In Progress,&amp;quot; &amp;quot;Done&amp;quot;). - Implement functionality to update the status of a task. 8. **Task Comments:** - Implement a commenting system for tasks. - Users should be able to add comments to a task, providing updates or additional information. 9. Notifications: (Optional) - Implement a basic notification system. - Users should receive notifications when a task is assigned to them or when a task they are assigned to is updated. 10. **Advanced Feature (Optional, Choose One):** - Option A: Implement a tagging system for tasks, allowing users to categorize tasks with multiple tags. - Option B: Implement a basic reporting system, displaying insights such as the number of tasks completed, tasks overdue, etc. **Submission:** - Share your project repository (e.g., GitHub) **Note:** - Prioritize code quality, readability, and adherence to Laravel best practices. - The assignment is designed to be both challenging and rewarding, showcasing your ability to tackle real-world scenarios using Laravel.&amp;lt;/p&amp;gt;', 2, '2024-05-20', 2, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addon`
--

CREATE TABLE `tbl_addon` (
  `id` int(11) NOT NULL,
  `addon_name` varchar(250) NOT NULL,
  `addon_loc` varchar(250) NOT NULL,
  `addon_ph` varchar(250) NOT NULL,
  `addon_email` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_addon`
--

INSERT INTO `tbl_addon` (`id`, `addon_name`, `addon_loc`, `addon_ph`, `addon_email`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(5, 'TRAIN', '', '98867657657', '', '1', '', '2024-05-25', '0000-00-00', 0),
(6, 'PERA GLADING', '', '797667777', '', '1', '', '2024-06-08', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cab`
--

CREATE TABLE `tbl_cab` (
  `id` int(11) NOT NULL,
  `cab_name` varchar(250) NOT NULL,
  `cab_loc` varchar(250) NOT NULL,
  `cab_ph` varchar(250) NOT NULL,
  `cab_email` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cab`
--

INSERT INTO `tbl_cab` (`id`, `cab_name`, `cab_loc`, `cab_ph`, `cab_email`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(3, 'RAM AUTO', '', '654647556', '', '1', '', '2024-06-08', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guest`
--

CREATE TABLE `tbl_guest` (
  `id` int(11) NOT NULL,
  `guest_name` varchar(250) DEFAULT NULL,
  `guest_phone` varchar(250) DEFAULT NULL,
  `altphone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `pincode` varchar(250) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `created_by` varchar(250) DEFAULT NULL,
  `updated_by` varchar(250) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `is_deleted` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_guest`
--

INSERT INTO `tbl_guest` (`id`, `guest_name`, `guest_phone`, `altphone`, `email`, `country`, `address`, `pincode`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'SHIVA DEBNATH1', '8888888888', '88888888888', 'USYDCFUGVU@GGHV.COM', 'INDIA', 'MATHABHANGA, WEST BENGAL', '734006', 'WTEHBEB', '1', '1', '2024-05-19', '2024-05-19', 1),
(2, 'SHIVA DEBNATH1', '8888888888', '88888888888', 'USYDCFUGVU@GGHV.COM', 'INDIA', 'MATHABHANGA, WEST BENGAL', '734006', 'WTEHBEB', '1', '1', '2024-05-19', '2024-05-19', 0),
(3, 'LAKSHMAN BISWAS', '8927931290', '98987555667', 'BISWAS.LAKSHMAN321@GMAIL.COM', 'INDIA', 'MAYNAGURI', '735224', 'WORK AS BUSINESS TRIP', '1', NULL, '2024-05-25', NULL, 0),
(4, 'RAMEN DAS', '8987654321', '', 'RRWWE@GMAIL.COM', 'INDIA', 'JALPAIGURI', '735224', 'NIL', '1', NULL, '2024-05-25', NULL, 0),
(5, '', '', '', '', '', '', '', '', '1', NULL, '2024-05-25', NULL, 0),
(6, 'LAKSHMAN BISWAS', '8927931290', '', 'BISWAS.LAKSHMAN321@GMAIL.COM', '', '', '', '0', '1', NULL, '2024-05-27', NULL, 0),
(7, 'LAKSHMAN BISWAS', '8927931290', '', 'BISWAS.LAKSHMAN321@GMAIL.COM', '', '', '', '', '1', '1', '2024-05-27', '2024-05-31', 0),
(8, 'CHHUTTU SAHA', '87544667567', '', 'BISWAS@GAMILM.COM', 'INDIA', 'MAYNAGURI', '735224', 'GO TO SIKKIM', '1', NULL, '2024-05-31', NULL, 0),
(9, 'TAPAS KR SARKAR', '8927931290', '', 'BISWAS.LAKSHMAN321@GMAIL.COM', 'INDUA', 'MAYNAGURI', '735224', '', '1', NULL, '2024-06-08', NULL, 0),
(10, 'JOY MANDAL', '8250123795', '', 'CHIRANJITD455@GMAIL.COM', 'INDIA', 'DHUPGURI', '735210', '', '1', NULL, '2024-06-08', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel`
--

CREATE TABLE `tbl_hotel` (
  `id` int(11) NOT NULL,
  `hotel_name` varchar(250) NOT NULL,
  `hotel_loc` varchar(250) NOT NULL,
  `hotel_ph` varchar(250) NOT NULL,
  `hotel_email` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_hotel`
--

INSERT INTO `tbl_hotel` (`id`, `hotel_name`, `hotel_loc`, `hotel_ph`, `hotel_email`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(5, 'KOTMATA', 'SIKKIM', '8976544456', '', '1', '', '2024-05-25', '0000-00-00', 0),
(6, 'DREAMED HOTEL', 'JALPAIGURI', '8787686877', '', '1', '', '2024-06-08', '0000-00-00', 0),
(7, 'PAHUNA RETREAT', 'GANGTOK', '', '', '1', '', '2024-06-08', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itinerary`
--

CREATE TABLE `tbl_itinerary` (
  `id` int(11) NOT NULL,
  `package_title` text NOT NULL,
  `day_itinerary_header` text NOT NULL,
  `day_itinerary_description` text NOT NULL,
  `no_of_day` varchar(250) NOT NULL,
  `no_of_night` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itinerary`
--

INSERT INTO `tbl_itinerary` (`id`, `package_title`, `day_itinerary_header`, `day_itinerary_description`, `no_of_day`, `no_of_night`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'TEST PACK', '1||2||3||4', '<p>1</p>||<p>2</p>||<p>3</p>||<p>4</p>', 'TEST PACK', '3', '1', '1', '2024-06-25', '2024-06-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leads`
--

CREATE TABLE `tbl_leads` (
  `id` int(11) NOT NULL,
  `guest_id` varchar(250) NOT NULL,
  `male_pax` varchar(250) NOT NULL DEFAULT '0',
  `female_pax` varchar(250) NOT NULL DEFAULT '0',
  `child_pax` varchar(250) NOT NULL DEFAULT '0',
  `infant_pax` varchar(250) NOT NULL DEFAULT '0',
  `loc_id` varchar(250) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_leads`
--

INSERT INTO `tbl_leads` (`id`, `guest_id`, `male_pax`, `female_pax`, `child_pax`, `infant_pax`, `loc_id`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '3', '1', '1', '', '', '4', 'WTEHBEB', '1', '', '2024-05-26', '0000-00-00', 0),
(2, '4', '4', '', '', '', '4', 'PAID', '1', '', '2024-05-26', '0000-00-00', 0),
(3, '4', '', '', '', '', '', '', '1', '', '2024-05-26', '0000-00-00', 1),
(4, '2', '1', '', '', '', '4', 'TEST', '1', '', '2024-05-31', '0000-00-00', 0),
(5, '4', '2', '3', '5', '4', '4', '', '1', '', '2024-05-31', '0000-00-00', 0),
(6, '8', '1', '1', '', '', '4', 'OK', '1', '', '2024-05-31', '0000-00-00', 0),
(7, '9', '1', '2', '', '', '6', 'BUSINESS', '1', '', '2024-06-08', '0000-00-00', 0),
(8, '10', '3', '3', '', '', '8', '', '1', '', '2024-06-08', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int(11) NOT NULL,
  `location` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `location`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(4, 'SIKKIM', '1', '1', '2024-05-25', '2024-05-31', 0),
(5, 'E5E5YRT', '1', '', '2024-05-25', '0000-00-00', 1),
(6, 'JALPAIGURI', '1', '', '2024-06-08', '0000-00-00', 0),
(7, 'BHUTAN', '1', '', '2024-06-08', '0000-00-00', 0),
(8, 'GANGTOK', '1', '', '2024-06-08', '0000-00-00', 0),
(9, '', '1', '', '2024-06-25', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_child`
--

CREATE TABLE `tbl_master_child` (
  `id` int(11) NOT NULL,
  `category_type` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_child`
--

INSERT INTO `tbl_master_child` (`id`, `category_type`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'UNDER 18', '1', '', '2024-06-30', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_meals`
--

CREATE TABLE `tbl_master_meals` (
  `id` int(11) NOT NULL,
  `meal_plan` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_meals`
--

INSERT INTO `tbl_master_meals` (`id`, `meal_plan`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'CP', '1', '', '2024-06-16', '0000-00-00', 0),
(2, 'MAP', '1', '', '2024-06-16', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_rooms`
--

CREATE TABLE `tbl_master_rooms` (
  `id` int(11) NOT NULL,
  `room_type` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_rooms`
--

INSERT INTO `tbl_master_rooms` (`id`, `room_type`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'DELUX', '1', '', '2024-06-16', '0000-00-00', 0),
(2, 'CLASIC', '1', '', '2024-06-16', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_guest`
--

CREATE TABLE `tbl_payment_guest` (
  `id` int(11) NOT NULL,
  `quotation_id` varchar(250) NOT NULL,
  `guest_id` varchar(250) NOT NULL,
  `lead_id` varchar(250) NOT NULL,
  `total_amount` varchar(250) NOT NULL,
  `paid_amount` varchar(250) NOT NULL,
  `due_amount` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment_guest`
--

INSERT INTO `tbl_payment_guest` (`id`, `quotation_id`, `guest_id`, `lead_id`, `total_amount`, `paid_amount`, `due_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(24, '9', '4', '', '', '10', '10190', '1', '', '2024-05-31', '0000-00-00', 0),
(25, '9', '4', '', '', '10', '10380', '1', '', '2024-05-31', '0000-00-00', 0),
(26, '9', '4', '', '', '200', '10180', '1', '', '2024-05-31', '0000-00-00', 0),
(27, '9', '4', '', '', '30', '10150', '1', '', '2024-05-30', '0000-00-00', 0),
(28, '9', '4', '', '', '15', '10135', '1', '', '2024-05-16', '0000-00-00', 0),
(29, '13', '8', '', '', '4000', '6000', '1', '', '2024-06-01', '0000-00-00', 0),
(30, '15', '10', '', '', '8000', '10000', '1', '', '2024-06-08', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation`
--

CREATE TABLE `tbl_quotation` (
  `id` int(11) NOT NULL,
  `guest_id` varchar(250) NOT NULL,
  `lead_id` varchar(250) NOT NULL,
  `hotel_total` varchar(250) NOT NULL,
  `cab_total` varchar(250) NOT NULL,
  `addon_total` varchar(250) NOT NULL,
  `grand_total` varchar(250) NOT NULL,
  `pack_total` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quotation`
--

INSERT INTO `tbl_quotation` (`id`, `guest_id`, `lead_id`, `hotel_total`, `cab_total`, `addon_total`, `grand_total`, `pack_total`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(4, '10', '8', '2000.00', '400.00', '400.00', '2800.00', '123300', '1', '', '2024-07-10', '0000-00-00', 0),
(5, '10', '8', '2000.00', '400.00', '400.00', '2800.00', '123300', '1', '', '2024-07-10', '0000-00-00', 0),
(6, '10', '8', '2000.00', '400.00', '400.00', '2800.00', '123300', '1', '', '2024-07-10', '0000-00-00', 0),
(7, '10', '8', '2000.00', '400.00', '400.00', '2800.00', '123300', '1', '', '2024-07-10', '0000-00-00', 0),
(8, '10', '8', '2000.00', '400.00', '400.00', '2800.00', '123300', '1', '', '2024-07-10', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_addon`
--

CREATE TABLE `tbl_voucher_addon` (
  `id` int(11) NOT NULL,
  `addon_id` varchar(250) NOT NULL,
  `quotation_id` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `no_addon` varchar(250) NOT NULL,
  `cost` varchar(250) NOT NULL,
  `customer_price` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_addon`
--

INSERT INTO `tbl_voucher_addon` (`id`, `addon_id`, `quotation_id`, `date`, `no_addon`, `cost`, `customer_price`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '5', '8', '2024-07-01', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_cab`
--

CREATE TABLE `tbl_voucher_cab` (
  `id` int(11) NOT NULL,
  `cab_id` varchar(250) NOT NULL,
  `quotation_id` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `from` varchar(250) NOT NULL,
  `to` varchar(250) NOT NULL,
  `no_cab` varchar(250) NOT NULL,
  `pax` varchar(250) NOT NULL,
  `cost` varchar(250) NOT NULL,
  `customer_price` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_cab`
--

INSERT INTO `tbl_voucher_cab` (`id`, `cab_id`, `quotation_id`, `date`, `from`, `to`, `no_cab`, `pax`, `cost`, `customer_price`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '3', '4', '2024-07-01', 'sdg', 'sdg', '1', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0),
(2, '3', '5', '2024-07-01', 'sdg', 'sdg', '1', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0),
(3, '3', '6', '2024-07-01', 'sdg', 'sdg', '1', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0),
(4, '3', '7', '2024-07-01', 'sdg', 'sdg', '1', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0),
(5, '3', '8', '2024-07-01', 'sdg', 'sdg', '1', '1', '250', '400', '1', '', '2024-07-10', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_hotel`
--

CREATE TABLE `tbl_voucher_hotel` (
  `id` int(11) NOT NULL,
  `hotel_id` varchar(250) NOT NULL,
  `quotation_id` varchar(250) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `rooms` varchar(250) NOT NULL,
  `cost` varchar(250) NOT NULL,
  `customer_price` varchar(250) NOT NULL,
  `total_amount` varchar(250) NOT NULL,
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_hotel`
--

INSERT INTO `tbl_voucher_hotel` (`id`, `hotel_id`, `quotation_id`, `checkin`, `checkout`, `rooms`, `cost`, `customer_price`, `total_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(4, '5', '4', '2024-07-01', '2024-07-02', '1', '600', '2000', '', '1', '', '2024-07-10', '0000-00-00', 0),
(5, '5', '5', '2024-07-01', '2024-07-02', '1', '600', '2000', '', '1', '', '2024-07-10', '0000-00-00', 0),
(6, '5', '6', '2024-07-01', '2024-07-02', '1', '600', '2000', '', '1', '', '2024-07-10', '0000-00-00', 0),
(7, '5', '7', '2024-07-01', '2024-07-02', '1', '600', '2000', '', '1', '', '2024-07-10', '0000-00-00', 0),
(8, '5', '8', '2024-07-01', '2024-07-02', '1', '600', '2000', '', '1', '', '2024-07-10', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `user_email` varchar(155) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `tmp_pass` varchar(200) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `address`, `user_email`, `password`, `tmp_pass`, `role`) VALUES
(1, 'ADMIN', '', '', 'myuser', '5d5a582e5adf896ed6e1474c700b481a', 'myuser', 'ADMIN'),
(2, 'Test User', '9988774455', 'Siliguri,', 'TEST', 'ceb6c970658f31504a901b89dcd3e461', 'test@123', 'EMPLOYEE'),
(3, 'EMPLOYEE1', '9988556644', 'EMPLOYEE', 'employee', 'fa5473530e4d1a5a1e1eb53d2fedb10c', 'employee', 'EMPLOYEE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_cab_tariff`
--
ALTER TABLE `master_cab_tariff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_hotel_tariff`
--
ALTER TABLE `master_hotel_tariff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_addon`
--
ALTER TABLE `tbl_addon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cab`
--
ALTER TABLE `tbl_cab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_guest`
--
ALTER TABLE `tbl_guest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_itinerary`
--
ALTER TABLE `tbl_itinerary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_leads`
--
ALTER TABLE `tbl_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_child`
--
ALTER TABLE `tbl_master_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_meals`
--
ALTER TABLE `tbl_master_meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_rooms`
--
ALTER TABLE `tbl_master_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_guest`
--
ALTER TABLE `tbl_payment_guest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_voucher_addon`
--
ALTER TABLE `tbl_voucher_addon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_voucher_cab`
--
ALTER TABLE `tbl_voucher_cab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_voucher_hotel`
--
ALTER TABLE `tbl_voucher_hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_cab_tariff`
--
ALTER TABLE `master_cab_tariff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_hotel_tariff`
--
ALTER TABLE `master_hotel_tariff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_addon`
--
ALTER TABLE `tbl_addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cab`
--
ALTER TABLE `tbl_cab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_guest`
--
ALTER TABLE `tbl_guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_itinerary`
--
ALTER TABLE `tbl_itinerary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_leads`
--
ALTER TABLE `tbl_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_master_child`
--
ALTER TABLE `tbl_master_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_master_meals`
--
ALTER TABLE `tbl_master_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_master_rooms`
--
ALTER TABLE `tbl_master_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_payment_guest`
--
ALTER TABLE `tbl_payment_guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_voucher_addon`
--
ALTER TABLE `tbl_voucher_addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_voucher_cab`
--
ALTER TABLE `tbl_voucher_cab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_voucher_hotel`
--
ALTER TABLE `tbl_voucher_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
