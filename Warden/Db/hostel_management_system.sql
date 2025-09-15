-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 10:28 PM
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
-- Database: `hostel_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountants`
--

CREATE TABLE `accountants` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountants`
--

INSERT INTO `accountants` (`id`, `username`, `email`, `phone`, `gender`, `dob`, `address`, `password`) VALUES
(1, 'sefat', 'sefat@gmail.com', '01456789023', 'Male', '2002-01-01', 'Uttara', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent') NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `fullname`, `date`, `status`) VALUES
(1, 1, 'John', '2025-09-14', 'Absent');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `category` enum('Room','Mess','Health','Maintenance','Other') NOT NULL,
  `details` text NOT NULL,
  `status` enum('Pending','Resolved','Escalated','Dismissed') DEFAULT 'Pending',
  `feedback` text DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `student_id`, `fullname`, `category`, `details`, `status`, `feedback`, `date_submitted`) VALUES
(1, 4, 'John Doe', 'Room', 'needs clearing.', 'Pending', NULL, '2025-09-13 21:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_visits`
--

CREATE TABLE `doctor_visits` (
  `id` int(11) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` time NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `max_slots` int(11) NOT NULL DEFAULT 10,
  `booked_slots` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_visits`
--

INSERT INTO `doctor_visits` (`id`, `doctor_name`, `visit_date`, `visit_time`, `purpose`, `max_slots`, `booked_slots`, `created_at`) VALUES
(1, 'Dr. Hamid', '2025-10-07', '15:22:00', 'General health checkup', 10, 2, '2025-09-13 21:27:29'),
(2, 'Dr. Ayesha Noor', '2025-10-10', '11:00:00', 'Flu and seasonal fever treatment', 12, 5, '2025-09-13 21:27:29'),
(3, 'Dr. Imran Ali', '2025-10-12', '14:30:00', 'Sports injury consultation', 8, 3, '2025-09-13 21:27:29'),
(4, 'Dr. Farzana Yasmin', '2025-10-15', '09:45:00', 'Routine student health checkup', 15, 10, '2025-09-13 21:27:29'),
(5, 'Dr. Kamran Khan', '2025-10-20', '16:10:00', 'Eye and vision screening', 10, 4, '2025-09-13 21:27:29'),
(6, 'Dr Hamim', '2025-09-20', '18:30:00', 'neuron specialist', 10, 0, '2025-09-13 21:29:32'),
(7, 'rerewr', '2025-09-13', '19:55:00', 'erer', 10, 0, '2025-09-14 01:54:25');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_type` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_applications`
--

CREATE TABLE `health_applications` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `issue_type` enum('Fever','Injury','Checkup','Other') NOT NULL,
  `description` text NOT NULL,
  `appointment_date` date NOT NULL,
  `emergency` enum('Yes','No') NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_officers`
--

CREATE TABLE `health_officers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_officers`
--

INSERT INTO `health_officers` (`id`, `username`, `email`, `phone`, `gender`, `dob`, `address`, `password`) VALUES
(1, 'leo', 'leo@gmail.com', '01567890234', 'Male', '2000-12-04', 'Arg', '123456'),
(2, 'hazary', 'jobayedhazary@gmail.com', '9998887777', 'Male', '1995-01-01', 'Unknown Address', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `health_reports`
--

CREATE TABLE `health_reports` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `report_date` date NOT NULL,
  `diagnosis` varchar(255) NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_reports`
--

INSERT INTO `health_reports` (`id`, `student_id`, `report_date`, `diagnosis`, `treatment`, `doctor_name`, `notes`) VALUES
(1, '1', '2025-09-01', 'High Fever', 'Paracetamol 500mg, 3 days rest', 'Dr. Hamid', 'Student had high fever, monitored temperature daily.'),
(2, '2', '2025-09-05', 'Leg Injury', 'Pain relief ointment, bandage', 'Dr. Imran Ali', 'Minor football injury, no fracture found'),
(3, '3', '2025-09-07', 'Routine Checkup', 'No treatment required', 'Dr. Ayesha Noor', 'All vitals normal'),
(4, '4', '2025-09-10', 'Headache', 'Painkiller prescribed', 'Dr. Kamran Khan', 'Advised to drink more water and rest'),
(5, '5', '2025-09-12', 'Sore Throat', 'Antibiotics + warm saline gargle', 'Dr. Farzana Yasmin', 'Emergency case, admitted for overnight observation');

-- --------------------------------------------------------

--
-- Table structure for table `health_requests`
--

CREATE TABLE `health_requests` (
  `id` int(11) NOT NULL,
  `status` enum('Pending','In Progress','Resolved') NOT NULL DEFAULT 'Pending',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_requests`
--

INSERT INTO `health_requests` (`id`, `status`, `notes`) VALUES
(1, 'In Progress', 'Under treatment, prescribed medicine'),
(2, 'Resolved', 'Checkup completed, all good'),
(3, 'Pending', 'Scheduled for further tests'),
(4, 'In Progress', 'Emergency case, admitted to clinic');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `feedback` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `student_id`, `student_name`, `leave_start_date`, `leave_end_date`, `reason`, `status`, `feedback`, `file_path`, `created_at`) VALUES
(1, 1, 'John', '2025-09-20', '2025-09-25', 'Family emergency', 'Approved', 'OK.', 'uploads/leave_docs/john_leave.pdf', '2025-09-15 08:34:03'),
(2, 2, 'starc', '2025-09-22', '2025-09-24', 'Medical checkup', 'Pending', 'Leave for 3 days.', 'uploads/leave_docs/starc_medical.pdf', '2025-09-15 08:34:03'),
(3, 3, 'John Doe', '2025-09-18', '2025-09-20', 'Attending cousin’s wedding', 'Approved', 'test.', 'uploads/leave_docs/johndoe_wedding.pdf', '2025-09-15 08:34:03'),
(4, 4, 'Jane Smith', '2025-09-19', '2025-09-21', 'Personal reasons', 'Pending', NULL, 'uploads/leave_docs/jane_personal.pdf', '2025-09-15 08:34:03'),
(5, 5, 'Michael Lee', '2025-09-23', '2025-09-25', 'Festival at home', 'Pending', NULL, 'uploads/leave_docs/mike_festival.pdf', '2025-09-15 08:34:03'),
(6, 6, 'Sarah Khan', '2025-09-26', '2025-09-28', 'Going home', 'Pending', NULL, 'uploads/leave_docs/sarah_home.pdf', '2025-09-15 08:34:03'),
(7, 7, 'Ali Rahman', '2025-09-21', '2025-09-23', 'Medical leave', 'Pending', NULL, 'uploads/leave_docs/ali_medical.pdf', '2025-09-15 08:34:03'),
(8, 8, 'Nusrat Jahan', '2025-09-24', '2025-09-27', 'University program outside Dhaka', 'Pending', NULL, 'uploads/leave_docs/nusrat_program.pdf', '2025-09-15 08:34:03'),
(9, 9, 'arpon', '2025-09-25', '2025-09-28', 'Family function', 'Pending', NULL, 'uploads/leave_docs/arpon_family.pdf', '2025-09-15 08:34:03'),
(10, 1, 'John', '2025-10-01', '2025-10-03', 'Job interview preparation', 'Approved', 'OK.', 'uploads/leave_docs/john_interview.pdf', '2025-09-15 08:34:03');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `threshold` int(11) NOT NULL DEFAULT 5,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `quantity`, `threshold`, `expiry_date`, `supplier`) VALUES
(1, 'Paracetamol 500mg', 120, 10, '2026-01-15', 'Square Pharma'),
(2, 'Amoxicillin 250mg', 60, 8, '2025-12-30', 'Beximco Pharma'),
(3, 'Cough Syrup', 25, 5, '2025-11-20', 'ACI Limited'),
(4, 'Vitamin C Tablets', 200, 15, '2027-05-10', 'Renata Limited'),
(5, 'Ibuprofen 400mg', 40, 10, '2025-10-25', 'Getz Pharma'),
(6, 'Antacid Suspension', 15, 5, '2025-09-30', 'Eskayef Pharma'),
(7, 'Zinc Supplement', 100, 12, '2026-08-12', 'Aristopharma'),
(8, 'ORS Sachets', 500, 20, '2027-03-01', 'Opsonin Pharma');

-- --------------------------------------------------------

--
-- Table structure for table `mess_feedback`
--

CREATE TABLE `mess_feedback` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `feedback` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mess_feedback`
--

INSERT INTO `mess_feedback` (`id`, `student_id`, `feedback`, `submitted_at`) VALUES
(1, '', 'Chor', '2025-09-15 09:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `mess_menu`
--

CREATE TABLE `mess_menu` (
  `id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `breakfast` varchar(200) DEFAULT NULL,
  `lunch` varchar(200) DEFAULT NULL,
  `dinner` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mess_menu`
--

INSERT INTO `mess_menu` (`id`, `day_of_week`, `breakfast`, `lunch`, `dinner`) VALUES
(1, 'Monday', 'Pancakes, Tea', 'Rice, Chicken Curry, Salad', 'Chapati, Vegetable Curry'),
(2, 'Tuesday', 'Oatmeal, Milk', 'Fried Rice, Fish Fry, Soup', 'Noodles, Veg Stir Fry'),
(3, 'Wednesday', 'Bread, Egg, Juice', 'Rice, Beef Curry, Salad', 'Paratha, Dal, Yogurt'),
(4, 'Thursday', 'Cereal, Milk', 'Rice, Chicken Roast, Vegetable Curry', 'Chapati, Paneer Curry'),
(5, 'Friday', 'Pancakes, Tea', 'Rice, Fish Curry, Salad', 'Noodles, Vegetable Soup'),
(6, 'Saturday', 'Omelette, Toast, Juice', 'Biryani, Raita, Salad', 'Paratha, Vegetable Curry'),
(7, 'Sunday', 'French Toast, Milk', 'Rice, Chicken Curry, Dal', 'Chapati, Mixed Veg Curry');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `note` text DEFAULT NULL,
  `notice_path` varchar(255) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice_recipients`
--

CREATE TABLE `notice_recipients` (
  `id` int(11) NOT NULL,
  `notice_id` int(11) DEFAULT NULL,
  `recipient` enum('Student','Health Officer','Accountant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_reminders`
--

CREATE TABLE `payment_reminders` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `due_date` date NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_name` varchar(20) NOT NULL,
  `block` varchar(10) NOT NULL,
  `room_type` enum('Single','Double','Shared') NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 1,
  `occupied` int(11) NOT NULL DEFAULT 0,
  `available` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `block`, `room_type`, `capacity`, `occupied`, `available`) VALUES
(1, 'A101', 'A Block', 'Single', 1, 1, 0),
(2, 'A102', 'A Block', 'Shared', 3, 1, 1),
(3, 'A103', 'A Block', 'Double', 2, 0, 1),
(4, 'B201', 'B Block', 'Single', 1, 1, 0),
(5, 'B202', 'B Block', 'Shared', 3, 2, 1),
(6, 'B203', 'B Block', 'Shared', 3, 3, 0),
(7, 'C301', 'C Block', 'Double', 2, 0, 1),
(8, 'C302', 'C Block', 'Double', 2, 2, 0),
(9, 'C303', 'C Block', 'Shared', 4, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_applications`
--

CREATE TABLE `room_applications` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  `room_preference` varchar(20) NOT NULL,
  `hostel_block` varchar(20) NOT NULL,
  `additional_notes` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `room_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_applications`
--

INSERT INTO `room_applications` (`id`, `fullname`, `student_id`, `semester`, `department`, `room_preference`, `hostel_block`, `additional_notes`, `status`, `room_id`) VALUES
(11, 'Jane Smith', 4, '2nd', 'EEE', 'Double', 'C Block', 'Near window', 'Approved', 8),
(12, 'Michael Lee', 5, '3rd', 'BBA', 'Shared', 'B Block', 'No preference', 'Pending', NULL),
(13, 'Sarah Khan', 6, '1st', 'CSE', 'Single', 'A Block', 'Quiet room preferred', 'Pending', NULL),
(14, 'Ali Rahman', 7, '2nd', 'EEE', 'Shared', 'C Block', 'Close to washroom', 'Pending', NULL),
(15, 'Nusrat Jahan', 8, '4th', 'CSE', 'Single', 'A Block', 'Needs lower floor', 'Approved', 1),
(16, 'Jane Smith', 4, '2nd', 'EEE', 'Single', 'A Block', 'need 2nd floors room.', 'Approved', 4);

-- --------------------------------------------------------

--
-- Table structure for table `salary_history`
--

CREATE TABLE `salary_history` (
  `salary_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) NOT NULL,
  `deductions` decimal(10,2) NOT NULL,
  `net_salary` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `processed_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_history`
--

INSERT INTO `salary_history` (`salary_id`, `username`, `month_year`, `basic_salary`, `allowances`, `deductions`, `net_salary`, `payment_status`, `payment_date`, `processed_by`) VALUES
(1, 'Hazary', 'Mar 2025', 28000.00, 3800.00, 1400.00, 30400.00, 'Paid', '2025-03-31', 'accountant1@example.com'),
(2, 'Hazary', 'Feb 2025', 28000.00, 3500.00, 1200.00, 30300.00, 'Paid', '2025-02-28', 'accountant2@example.com'),
(3, 'Hazary', 'Jan 2025', 28000.00, 3200.00, 1000.00, 30200.00, 'Paid', '2025-01-31', 'accountant1@example.com'),
(4, 'Hazary', 'Dec 2024', 28000.00, 3000.00, 900.00, 30100.00, 'Pending', NULL, 'accountant2@example.com'),
(5, 'Hazary', 'Nov 2024', 28000.00, 2800.00, 800.00, 30000.00, 'Paid', '2024-11-30', 'accountant1@example.com'),
(6, 'Hazary', 'Oct 2024', 28000.00, 2500.00, 700.00, 29800.00, 'Paid', '2024-10-31', 'accountant1@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `service_type` enum('Room Cleaning','Wi-Fi Issue','Laundry','Maintenance','Other') NOT NULL,
  `details` text NOT NULL,
  `preferred_date` date NOT NULL,
  `assign_date` date DEFAULT NULL,
  `status` enum('Pending','Scheduled','Completed','In Progress') DEFAULT 'Pending',
  `feedback` text DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `student_id`, `fullname`, `service_type`, `details`, `preferred_date`, `assign_date`, `status`, `feedback`, `date_submitted`) VALUES
(6, 1, 'John', 'Room Cleaning', 'Need Room cleaning', '2025-09-14', NULL, 'Pending', NULL, '2025-09-12 21:06:01'),
(7, 2, 'starc', 'Laundry', 'Need Room cleaning', '2025-09-14', '2025-09-14', 'In Progress', 'Assign the staff.', '2025-09-12 21:06:01'),
(8, 4, 'John Doe', 'Wi-Fi Issue', 'wifi is off.', '2025-09-15', NULL, 'Pending', NULL, '2025-09-13 21:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `staff_salary`
--

CREATE TABLE `staff_salary` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `status` enum('Paid','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `semester` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fullname`, `email`, `phone`, `gender`, `dob`, `semester`, `department`, `address`, `password`, `created_at`) VALUES
(1, 'John', 'john@gmail.com', '01345678909', 'Male', '2003-12-31', '8', 'CSE', 'Kuril,Dhaka', '12345678', '2025-09-12 21:01:59'),
(2, 'starc', 's@gmail.com', '01345678919', 'Male', '2003-01-10', '6', 'BBA', ',Australia', '012345678', '2025-09-12 21:03:05'),
(3, 'John Doe', 't1@gmail.com', '0000000000', 'Male', '2005-01-13', '4th', 'BBA', 'kuril', '$2y$10$9HUO6/vr9a/WcDZpDJV/oejFas3fr9RhhMAh/irQtcJuafB0cWKUy', '2025-09-13 14:54:41'),
(4, 'Jane Smith', 'jane@gmail.com', '01711111111', 'Female', '2004-02-14', '2nd', 'EEE', 'Banani, Dhaka', '12345678', '2025-09-13 19:54:59'),
(5, 'Michael Lee', 'mike@gmail.com', '01822222222', 'Male', '2003-09-21', '3rd', 'BBA', 'Uttara, Dhaka', '12345678', '2025-09-13 19:54:59'),
(6, 'Sarah Khan', 'sarah@gmail.com', '01933333333', 'Female', '2004-05-30', '1st', 'CSE', 'Dhanmondi, Dhaka', '12345678', '2025-09-13 19:54:59'),
(7, 'Ali Rahman', 'ali@gmail.com', '01644444444', 'Male', '2003-11-18', '2nd', 'EEE', 'Mirpur, Dhaka', '12345678', '2025-09-13 19:54:59'),
(8, 'Nusrat Jahan', 'nusrat@gmail.com', '01555555555', 'Female', '2005-03-12', '4th', 'CSE', 'Bashundhara, Dhaka', '12345678', '2025-09-13 19:54:59'),
(9, 'arpon', 'arpon.paul55@gmail.com', '01772292817', 'Male', '2001-12-15', '4th', 'CSE', 'Bashundhara', '$2y$10$xI64CKQGGwzNMgOo6YDwKOXAT0kakWbvM2tDg0FsIeq7qDdfqAmtW', '2025-09-15 08:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `status` enum('Paid','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_health_feedback`
--

CREATE TABLE `student_health_feedback` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_health_feedback`
--

INSERT INTO `student_health_feedback` (`id`, `student_id`, `student_name`, `rating`, `comments`, `created_at`) VALUES
(1, '3', 'Abdul Karim', 5, 'Very satisfied with the health services.', '2025-09-14 04:05:28'),
(2, '4', 'Rahim Uddin', 4, 'Doctor was helpful but waiting time was long.', '2025-09-14 04:05:28'),
(3, '5', 'Nusrat Jahan', 3, 'Medicine stock was low, but service was okay.', '2025-09-14 04:05:28'),
(4, '6', 'Ali Raza', 4, 'Good overall, need more frequent checkups.', '2025-09-14 04:05:28'),
(5, '7', 'Mehwish Khan', 5, 'Excellent care and quick response.', '2025-09-14 04:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `wardens`
--

CREATE TABLE `wardens` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wardens`
--

INSERT INTO `wardens` (`id`, `username`, `email`, `phone`, `gender`, `dob`, `address`, `password`, `status`, `created_at`) VALUES
(1, 'starc1', 'tutulmajumder255@gmail.com', '01345678903', 'Male', '2003-02-28', 'Aus', '$2y$10$jjtjvvT85U.9AFNPSDTcR.f.1wX6iqkFiCcT8n45FKha8oMcZvT8u', 'Active', '2025-09-13 15:07:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountants`
--
ALTER TABLE `accountants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `doctor_visits`
--
ALTER TABLE `doctor_visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_applications`
--
ALTER TABLE `health_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `health_officers`
--
ALTER TABLE `health_officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `health_reports`
--
ALTER TABLE `health_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_requests`
--
ALTER TABLE `health_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mess_feedback`
--
ALTER TABLE `mess_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mess_menu`
--
ALTER TABLE `mess_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_recipients`
--
ALTER TABLE `notice_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notice_id` (`notice_id`);

--
-- Indexes for table `payment_reminders`
--
ALTER TABLE `payment_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_applications`
--
ALTER TABLE `room_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `salary_history`
--
ALTER TABLE `salary_history`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `staff_salary`
--
ALTER TABLE `staff_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_health_feedback`
--
ALTER TABLE `student_health_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wardens`
--
ALTER TABLE `wardens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountants`
--
ALTER TABLE `accountants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_visits`
--
ALTER TABLE `doctor_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `health_applications`
--
ALTER TABLE `health_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_officers`
--
ALTER TABLE `health_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `health_reports`
--
ALTER TABLE `health_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `health_requests`
--
ALTER TABLE `health_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mess_feedback`
--
ALTER TABLE `mess_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mess_menu`
--
ALTER TABLE `mess_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice_recipients`
--
ALTER TABLE `notice_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_reminders`
--
ALTER TABLE `payment_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_applications`
--
ALTER TABLE `room_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `salary_history`
--
ALTER TABLE `salary_history`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff_salary`
--
ALTER TABLE `staff_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_health_feedback`
--
ALTER TABLE `student_health_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wardens`
--
ALTER TABLE `wardens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `health_applications`
--
ALTER TABLE `health_applications`
  ADD CONSTRAINT `health_applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `notice_recipients`
--
ALTER TABLE `notice_recipients`
  ADD CONSTRAINT `notice_recipients_ibfk_1` FOREIGN KEY (`notice_id`) REFERENCES `notices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_applications`
--
ALTER TABLE `room_applications`
  ADD CONSTRAINT `room_applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `room_applications_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_health_feedback`
--
ALTER TABLE `student_health_feedback`
  ADD CONSTRAINT `student_feedback_fk` FOREIGN KEY (`id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
