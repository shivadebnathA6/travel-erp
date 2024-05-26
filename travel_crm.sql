-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 04:49 PM
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
(5, 'TRAIN', '', '98867657657', '', '1', '', '2024-05-25', '0000-00-00', 0);

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
(2, 'SHIVA DEBNATH1', '8888888888', '88888888888', 'USYDCFUGVU@GGHV.COM', 'INDIA', 'MATHABHANGA, WEST BENGAL', '734006', 'WTEHBEB', '1', '1', '2024-05-19', '2024-05-19', 1),
(3, 'LAKSHMAN BISWAS', '8927931290', '98987555667', 'BISWAS.LAKSHMAN321@GMAIL.COM', 'INDIA', 'MAYNAGURI', '735224', 'WORK AS BUSINESS TRIP', '1', NULL, '2024-05-25', NULL, 1),
(4, 'RAMEN DAS', '8987654321', '', 'RRWWE@GMAIL.COM', 'INDIA', 'JALPAIGURI', '735224', 'NIL', '1', NULL, '2024-05-25', NULL, 0),
(5, '', '', '', '', '', '', '', '', '1', NULL, '2024-05-25', NULL, 0);

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
(5, 'KOTMATA', 'SIKKIM', '8976544456', '', '1', '', '2024-05-25', '0000-00-00', 0);

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
(3, '4', '', '', '', '', '', '', '1', '', '2024-05-26', '0000-00-00', 1);

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
(4, 'SIKKIM', '1', '', '2024-05-25', '0000-00-00', 0),
(5, 'E5E5YRT', '1', '', '2024-05-25', '0000-00-00', 1);

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
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_addon`
--

INSERT INTO `tbl_voucher_addon` (`id`, `addon_id`, `quotation_id`, `date`, `no_addon`, `cost`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '5', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 1),
(2, '5', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(3, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(4, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(5, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(6, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(7, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(8, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(9, '', '', '0000-00-00', '', '', '', '', '0000-00-00', '0000-00-00', 0);

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
  `created_by` varchar(250) NOT NULL,
  `updated_by` varchar(250) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_cab`
--

INSERT INTO `tbl_voucher_cab` (`id`, `cab_id`, `quotation_id`, `date`, `from`, `to`, `no_cab`, `pax`, `cost`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(2, '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', 0),
(3, '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', 1),
(4, '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', 1);

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

INSERT INTO `tbl_voucher_hotel` (`id`, `hotel_id`, `quotation_id`, `checkin`, `checkout`, `rooms`, `cost`, `total_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'vf  ', '', '0000-00-00', '0000-00-00', 'fv vbb', '', '', 'bv vb vb ', 'cvb ', '0000-00-00', '0000-00-00', 1);

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
(3, 'EMPLOYEE1', '9988556644', 'EMPLOYEE', 'employee', 'fa5473530e4d1a5a1e1eb53d2fedb10c', 'employee', 'EMPLOYEE'),
(7, 'SHIVA DEBNATH', '08768748595', 'SILIGURI, WEST BENGAL', 'storage1w@webihq.store', '3bc8d87b3e7dbdcd891bc7e998cd827c', 'storage1w@webihq.store', 'EMPLOYEE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
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
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_addon`
--
ALTER TABLE `tbl_addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_cab`
--
ALTER TABLE `tbl_cab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_guest`
--
ALTER TABLE `tbl_guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_leads`
--
ALTER TABLE `tbl_leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_voucher_addon`
--
ALTER TABLE `tbl_voucher_addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_voucher_cab`
--
ALTER TABLE `tbl_voucher_cab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_voucher_hotel`
--
ALTER TABLE `tbl_voucher_hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
