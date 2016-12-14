-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2016 at 10:36 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apc_prereg`
--

-- --------------------------------------------------------

--
-- Table structure for table `approver`
--

CREATE TABLE `approver` (
  `approver_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cobalt_reporter`
--

CREATE TABLE `cobalt_reporter` (
  `module_name` varchar(255) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `show_field` blob NOT NULL,
  `operator` blob NOT NULL,
  `text_field` blob NOT NULL,
  `sum_field` blob NOT NULL,
  `count_field` blob NOT NULL,
  `group_field1` blob NOT NULL,
  `group_field2` blob NOT NULL,
  `group_field3` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobalt_sst`
--

CREATE TABLE `cobalt_sst` (
  `auto_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `config_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `gp_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `department_id`, `course_code`, `course_name`, `is_active`, `gp_num`) VALUES
(1, 4, 'ABMA', 'Bachelor of Arts in Multimedia Arts', 'Yes', 'Y'),
(2, 29, 'ACT', 'Associate in Computer Technology', 'No', 'Y'),
(3, 32, 'BSA', 'Bachelor of Science in Accountancy', 'Yes', 'Y'),
(4, 2, 'BSC-BM', 'Bachelor of Science in Commerce major in Business Management', 'No', 'Y'),
(5, 2, 'BSC-CISM', 'Bachelor of Science in Commerce major in Computer Information Systems Management', 'No', 'Y'),
(6, 2, 'BSC-EBWT', 'Bachelor of Science in Commerce major in EBusiness and Web Technology', 'No', 'Y'),
(7, 2, 'BSC-MA', 'Bachelor of Science in Commerce major in Marketing and Advertising', 'No', 'Y'),
(8, 2, 'BSC-MIS', 'Bachelor of Science in Commerce major in Management Information Systems', 'No', 'Y'),
(9, 6, 'BSCOE', 'Bachelor of Science in Computer Engineering', 'Yes', 'Y'),
(10, 1, 'BSCSIT-CEE', 'Bachelor of Science in Computer Science and Information Technology with specialization in Computer Electronics Engineering', 'No', 'Y'),
(11, 1, 'BSCSIT-CNE', 'Bachelor of Science in Computer Science and Information Technology with specialization in Computer Network Engineering', 'No', 'Y'),
(12, 1, 'BSCSIT-SSE', 'Bachelor of Science in Computer Science and Information Technology with specialization in Systems Software Engineering', 'No', 'Y'),
(13, 6, 'BSECE', 'Bachelor of Science in Electronics and Communications Engineering', 'Yes', 'Y'),
(14, 2, 'BSEM', 'Bachelor of Science in Entrepreneurial Management', 'No', 'Y'),
(15, 5, 'BSIM', 'Bachelor of Science in Information Management', 'No', 'N'),
(16, 29, 'MIM', 'Master in Information Management', 'Yes', 'Y'),
(17, 29, 'SIM', 'Strategic Information Management', 'No', 'N'),
(18, 29, 'EP', 'Executive Program', 'No', 'N'),
(19, 2, 'BSCIS', 'Bachelor of Science in Computer and Information Science', 'No', 'N'),
(20, 1, 'BSC-CISM', 'Bachelor of Science in Commerce major in Computer Information Systems Management', 'No', 'N'),
(21, 1, 'BSIT', 'Bachelor of Science in Information Technology', 'No', 'Y'),
(22, 0, 'MITE', 'Master in Information Technology Education', 'No', 'N'),
(23, 2, 'BSC-CCWT', 'Bachelor of Science in Commerce major in Corporate Communications and Web Technology', 'No', 'N'),
(24, 2, 'BSC-MMA', 'Bachelor of Science in Commerce major in Multimedia Arts', 'No', 'N'),
(25, 2, 'BSC-BA', 'Bachelor of Science in Commerce major in Business Administration', 'No', 'N'),
(26, 2, 'BSC-EB', 'Bachelor of Science in Commerce major in EBusiness', 'No', 'N'),
(27, 2, 'BSBA-BM', 'Bachelor of Science in Business Administration major in Business Management', 'No', 'Y'),
(28, 2, 'BSBA-MA', 'Bachelor of Science in Business Administration major in Marketing and Advertising', 'No', 'Y'),
(29, 2, 'BSBA-MIS', 'Bachelor of Science in Business Administration major in Management Information Systems', 'No', 'N'),
(30, 6, 'BSECE', 'Bachelor of Science in Electronics Engineering', 'No', 'Y'),
(31, 6, 'BSCpE', 'Bachelor of Science in Computer Engineering', 'No', 'Y'),
(32, 2, 'BSTM', 'Bachelor of Science in Tourism Management', 'Yes', 'Y'),
(33, 2, 'BSBA-FM', 'Bachelor of Science in Business Administration major in Financial Management', 'No', 'Y'),
(34, 1, 'BSCSIT-IT', 'Bachelor of Science in Computer Science and Information Technology with specialization in Information Technology', 'No', 'Y'),
(35, 1, 'BSCSIT-CN', 'Bachelor of Science in Computer Science and Information Technology with specialization in Computer Network', 'No', 'Y'),
(36, 1, 'BSCSIT-SS', 'Bachelor of Science in Computer Science and Information Technology with specialization in Systems Software', 'No', 'Y'),
(37, 29, 'MIS', 'Master in Information Systems', 'No', 'Y'),
(38, 29, 'MIT', 'Master in Information Technology', 'No', 'Y'),
(39, 32, 'BSACT', 'Bachelor of Science in Accounting Technology', 'No', 'Y'),
(40, 29, 'ACT-SE', 'Associate in Computer Technology specializing in Software Engineering', 'No', 'Y'),
(41, 29, 'ACT-CE', 'Associate in Computer Technology specializing in Computer Electronics', 'No', 'Y'),
(42, 29, 'ACT-DA', 'Associate in Computer Technology specializing in Digital Animation', 'No', 'Y'),
(43, 1, 'BSCSIT', 'Bachelor of Science in Computer Science and Information Technology', 'No', 'Y'),
(44, 1, 'BSCS-SS', 'Bachelor of Science in Computer Science with specialization in Software and Systems', 'Yes', 'Y'),
(45, 1, 'BSCS-CN', 'Bachelor of Science in Computer Science with specialization in Computer Networking', 'Yes', 'Y'),
(46, 29, 'MM', 'Master in Management', 'No', 'Y'),
(47, 1, 'BSCS-DF', 'Bachelor of Science in Computer Science with specialization in Security & Digital Forensics', 'Yes', 'Y'),
(48, 1, 'BSIT-MI', 'Bachelor of Science in Information Technology with specialization in Mobile and Internet Technology', 'Yes', 'Y'),
(49, 1, 'BSIT-GD', 'Bachelor of Science in Information Technology with specialization in Game Design & Development', 'Yes', 'Y'),
(50, 4, 'ABPsych', 'Bachelor of Arts in Psychology', 'Yes', 'Y'),
(51, 2, 'BSBA-BMBA', 'Bachelor of Science in Business Administration major in Business Management with Specialization in Business Analytics', 'No', 'Y'),
(52, 1, 'BSEMC-GD', 'Bachelor of Science in Entertainment and Multimedia Computing with specialization in Game Development', 'Yes', 'Y'),
(53, 2, 'BSBA-BMAA', 'Bachelor of Science in Business Administration major in Business Management with specialization in Accounting Application', 'No', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_code` varchar(255) NOT NULL,
  `department_description` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `department_assign` varchar(255) NOT NULL,
  `is_deleted` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Master List of Functional Units of APC';

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_code`, `department_description`, `is_active`, `department_assign`, `is_deleted`) VALUES
(1, 'CSIT', 'School of Computer Science and Information Technology (SoCSIT)', 'Yes', 'Academic', 'No'),
(2, 'Commerce', 'School of Accountancy and Business (SoAB)', 'Yes', 'Academic', 'No'),
(3, 'GE-Math Cluster', 'School of Engineering (SoE)', 'Yes', 'Academic', 'No'),
(4, 'ABMA', 'School of Multimedia Arts (SoMA)', 'Yes', 'Academic', 'No'),
(5, 'IM', 'Department of Information Management', 'No', 'Academic', 'Yes'),
(6, 'COE', 'School of Engineering (SoE)', 'Yes', 'Academic', 'No'),
(7, 'ITRG', 'Office of Information Technology Resources', 'No', 'Admin', 'No'),
(8, 'Registrar', 'Office of the Registrar', 'No', 'Admin', 'No'),
(9, 'Accounting', 'Office of Finance', 'No', 'Admin', 'No'),
(10, 'HR', 'Office of Human Resources', 'No', 'Admin', 'No'),
(11, 'Admission', 'Office of Corporate Communications', 'No', 'Admin', 'No'),
(12, 'Guidance', 'Office of Student Services', 'No', 'Admin', 'No'),
(13, 'SSD', 'Office of Student Services', 'No', 'Admin', 'No'),
(14, 'DO', 'Office of Student Services', 'No', 'Admin', 'No'),
(15, 'GE-English Cluster', 'School of Multimedia Arts (SoMA)', 'No', 'Academic', 'No'),
(16, 'GE-InterDisciplinary Cluster', 'School of Multimedia Arts (SoMA)', 'No', 'Academic', 'No'),
(17, 'Payroll', 'Office of the President', 'No', 'Admin', 'No'),
(18, 'Library', 'Office of the President', 'No', 'Admin', 'No'),
(19, 'Reception', 'Office of the President', 'No', 'Admin', 'No'),
(20, 'Logistics', 'Office of Logistics', 'No', 'Admin', 'No'),
(21, 'Facilities', 'Office of Physical Facilities', 'No', 'Admin', 'No'),
(22, 'Marketing', 'Office of Corporate Communications', 'No', 'Admin', 'No'),
(23, 'CPO', 'Office of Student Services', 'No', 'Admin', 'No'),
(24, 'Office of the President', 'Office of the President', 'No', 'Admin', 'No'),
(25, 'Eduquest', 'EduQuest, Inc.', 'No', 'Admin', 'Yes'),
(26, 'NATSER', 'Office of Student Services', 'No', 'Admin', 'No'),
(27, 'INTELLECT', 'INTELLECT', 'No', 'Admin', 'Yes'),
(28, 'UTILITIES', 'Outsourced Maintenance Services like Reliance, AV Paule, Utility personnel ', 'No', 'Admin', 'No'),
(29, 'MIM', 'School of Computer Science and Information Technology (SoCSIT)', 'No', 'Academic', 'No'),
(30, 'ECE', 'Department of Engineering and Sciences', 'No', 'Academic', 'Yes'),
(31, 'APC Center Operation', 'APC Center Operation', 'No', 'Admin', 'No'),
(32, 'Accountancy', 'School of Accountancy and Business (SoAB)', 'No', 'Academic', 'No'),
(33, 'ISD', 'Information System Development Team', 'No', 'Admin', 'No'),
(34, 'SNT', 'System and Network Team', 'No', 'Admin', 'No'),
(35, 'TST', 'Technical Support Team', 'No', 'Admin', 'No'),
(36, 'The  APC Center', 'The APC Center', 'No', 'Admin', 'No'),
(37, 'Lab Central Office', 'Chemisty and Physics Laboratory Office', 'No', 'Admin', 'No'),
(38, 'COE', 'School of Engineering (SoE)', 'No', 'Admin', 'No'),
(39, 'SAO', 'Office of Student Services', 'No', 'Admin', 'No'),
(40, 'HS', 'Higher School', 'No', 'Academic', 'No'),
(41, 'External Relations', 'External Relations', 'No', 'Admin', 'No'),
(42, 'IP&QA', 'Information, Planning and Quality Assurance', 'No', 'Admin', 'No'),
(43, 'Psychology Cluster', 'School of Multimedia Arts (SoMA)', 'No', 'Academic', 'No'),
(44, 'SHS', 'Senior High School', 'No', 'Academic', 'No'),
(45, 'CSO', 'Consulting Services Office', 'No', 'Admin', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `flowchart`
--

CREATE TABLE `flowchart` (
  `flowchart_id` int(11) NOT NULL,
  `flowchart_code` varchar(255) NOT NULL,
  `flowchart_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flowchart`
--

INSERT INTO `flowchart` (`flowchart_id`, `flowchart_code`, `flowchart_name`) VALUES
(1, 'ghjk', 'fghgjkl');

-- --------------------------------------------------------

--
-- Table structure for table `flowchart_details`
--

CREATE TABLE `flowchart_details` (
  `flowchart_details_id` int(11) NOT NULL,
  `flowchart_header_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flowchart_details`
--

INSERT INTO `flowchart_details` (`flowchart_details_id`, `flowchart_header_id`, `term_id`, `subject_id`) VALUES
(1, 2, 86, 1),
(2, 2, 86, 2),
(3, 2, 86, 3),
(4, 2, 86, 4);

-- --------------------------------------------------------

--
-- Table structure for table `flowchart_header`
--

CREATE TABLE `flowchart_header` (
  `flowchart_header_id` int(11) NOT NULL,
  `flowchart_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `school_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flowchart_header`
--

INSERT INTO `flowchart_header` (`flowchart_header_id`, `flowchart_id`, `student_id`, `course_id`, `school_year`) VALUES
(1, 1, 1, 1, '1'),
(2, 1, 1, 1, '2016');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `first_name`, `middle_name`, `last_name`, `gender`) VALUES
(1, 'Super User', 'X', 'Root', 'Male'),
(2, 'Kamila', '', 'Lagman', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `pre_reg_request_details`
--

CREATE TABLE `pre_reg_request_details` (
  `pre_reg_request_id` int(11) NOT NULL,
  `pre_reg_request_header_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pre_reg_request_details`
--

INSERT INTO `pre_reg_request_details` (`pre_reg_request_id`, `pre_reg_request_header_id`, `subject_id`, `section_id`, `schedule_id`) VALUES
(1, 0, 1, 2, 1),
(2, 0, 2, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pre_reg_request_header`
--

CREATE TABLE `pre_reg_request_header` (
  `pre_reg_request_header_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `date_applied` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `is_approved` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `enrollment_status` varchar(255) NOT NULL,
  `schedule_day` varchar(255) NOT NULL,
  `schedule_from` time NOT NULL,
  `schedule_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `subject_id`, `term_id`, `date`, `is_active`, `enrollment_status`, `schedule_day`, `schedule_from`, `schedule_to`) VALUES
(1, 1, 88, '2016-12-02', 'Yes', 'Registered', 'Monday', '07:30:00', '11:30:00'),
(2, 1, 88, '2016-12-06', 'Yes', 'Registered', 'Tuesday', '11:30:00', '15:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_description` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `department_id`, `course_id`, `section_name`, `section_description`, `is_active`) VALUES
(1, 4, 1, 'ABMA 131', 'Multimedia Arts', 'No'),
(2, 4, 1, 'ABMA 141', 'Multimedia Arts', 'Yes'),
(3, 4, 1, 'ABMA 151', 'Multimedia Arts', 'Yes'),
(4, 1, 44, 'SS 131', 'System Software', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_num` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `middle_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `gender` varchar(255) CHARACTER SET latin1 NOT NULL,
  `civil_status` varchar(255) CHARACTER SET latin1 NOT NULL,
  `mobile_num` varchar(255) CHARACTER SET latin1 NOT NULL,
  `tel_num` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nationality` varchar(255) CHARACTER SET latin1 NOT NULL,
  `religion` varchar(255) CHARACTER SET latin1 NOT NULL,
  `postal_code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admission_date` date NOT NULL,
  `entry_level` varchar(255) CHARACTER SET latin1 NOT NULL,
  `admission_credential` varchar(255) CHARACTER SET latin1 NOT NULL,
  `mail_grades_to` varchar(255) CHARACTER SET latin1 NOT NULL,
  `exit_level` varchar(255) CHARACTER SET latin1 NOT NULL,
  `box_num` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Masterlist of Student Main Profile';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `course_id`, `department_id`, `section_id`, `student_num`, `last_name`, `first_name`, `middle_name`, `birth_date`, `birth_place`, `gender`, `civil_status`, `mobile_num`, `tel_num`, `email`, `address`, `nationality`, `religion`, `postal_code`, `username`, `password`, `admission_date`, `entry_level`, `admission_credential`, `mail_grades_to`, `exit_level`, `box_num`) VALUES
(1, 44, 1, 4, '2013-100154', 'Lagman', 'Kamila', '', '1997-01-11', 'Makati City', 'Female', 'Single', '09858548418', '', 'hahah@sample.com', 'lols', 'there', 'yow', '', 'krlagman', 'password', '2016-06-11', 'First Year', '', 'hehe@sample.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_unit` varchar(255) NOT NULL,
  `is_active` varchar(255) NOT NULL,
  `pay_unit` varchar(255) NOT NULL,
  `compute_gpa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `term_id`, `subject_code`, `subject_name`, `subject_description`, `subject_unit`, `is_active`, `pay_unit`, `compute_gpa`) VALUES
(1, 1, '2DANIM1', '2D Animation', 'This course introduces students to the techniques in developing 2D animation in digital format. Although part of the curriculum includes traditional 2D cartooning and animation, this course plays an important role in forming the student''s understanding of', '3', 'Yes', '3', ''),
(2, 1, '2DANIM2', '2D Animation 2', 'This Course provides students the knowledge to produce visual components based on the objectives and develop digital imaging concepts. it also trains the students to carry out with confidence the activities of 2D computer animator with the use of the comp', '3', 'Yes', '3', ''),
(3, 1, '3DANIM1', '3D Animation 1', 'The course offers instruction on the theories and practices in 3D computer graphics, including high-end computer visualization and special effects for film and television, concept development, character animation, camera angles and planning, advanced mode', '3', 'Yes', '3', ''),
(4, 1, '3DANIM2', '3D Animation 2', 'The course enables the students to pursue advanced studies in 3D modeling and animation in the context of creating synthetic characters and complex models. students will be able to produce realistic 3D worlds and images that can be incorporated in film, v', '3', 'Yes', '3', ''),
(5, 1, '3DMODEL', '3D Modeling', 'This course exposes students to methods and techniques in creating 3D models and images derived from primitive shapes like cone, cube, cylinder and sphere with the used of the computer graphics program. Subjects areas cover low polygon models, texture map', '3', 'Yes', '3', ''),
(6, 1, 'AACOMAP', 'Computer Applications for Business', 'Computer terminology, hardware, software, operating systems, and information systems relating to the business environment will be covered. The main focus of this course is on business applications of software, including word processing, spreadsheets, data', '3', 'No', '3', ''),
(7, 1, 'AADVCPP', 'Advanced C++', '', '3', 'No', '3', 'Y'),
(8, 1, 'AADVPRG', 'Advanced Programming', '', '3', 'No', '3', 'Y'),
(9, 1, 'ABUPRO', 'Information Systems and Business Process', '', '3', 'No', '3', 'Y'),
(10, 1, 'ABUSCOM', 'Business Communications', 'Introduction to Business Communication presents frameworks for writing documents, managing email, and preparing presentations. Cases and exercises emphasize informative\r\ncommunication and strategies for collaboration. Methods for organizing ideas, analyzi', '3', 'No', '3', ''),
(11, 1, 'ABUSPRO', 'Information Systems and Business Process', 'A course on effective strategic management of an organization''s business processes focused on the dynamic requirements of the marketplace and the developing capabilities of the organization''s resources building on the concepts from strategic management, o', '3', 'No', '3', ''),
(12, 1, 'ACAPBUS', 'Computer Applications in Business', '', '3', 'No', '3', 'Y'),
(13, 1, 'ACCCOUNT', 'Accounting', 'The course is an introduction to the accounting principles, its process, memorability, and reporting for assets, liabilities, owner''s equity, revenues, and expense.', '3', 'Yes', '3', ''),
(14, 1, 'ACCOUN1', 'Accounting1', 'This course is geared towards developing the students'' knowledge and skills in the basic accounting concepts and procedures. It will emphasize what accounting information is and its importance on how it is used to make effective and wise business decision', '3', 'Yes', '3', ''),
(15, 1, 'ACCOUN2', 'Accounting2', 'The course is a continuation of the first course in accounting. It deals with transactions, financial statements, and problems peculiar to the operations of partnerships and corporations as distinguished from sole proprietorship. Topics include: partnersh', '3', 'Yes', '3', ''),
(16, 1, 'ACCOUN3', 'Accounting3', 'This course is the last part of Advance Accounting and deals mainly with consolidates and merges, parent-subsidiary relationships, and consolidated statements, including foreign exchange rates and other similar current issues. ', '3', 'Yes', '3', ''),
(17, 1, 'ACCOUNT', 'Accounting', 'The course is an introduction to the accounting principles, its process, memorability, and reporting for assets, liabilities, owner''s equity, revenues, and expense.', '3', 'Yes', '3', ''),
(18, 1, 'ACCOUNT1', 'Foundations of Accounting', '', '3', 'Yes', '3', 'Y'),
(19, 1, 'ACCOUNT2', 'Accounting2', 'The course is a continuation of the first course in accounting. It deals with transactions, financial statements, and problems peculiar to the operations of partnerships and corporations as distinguished from sole proprietorship. Topics include: partnersh', '3', 'Yes', '3', ''),
(20, 1, 'ACCTNG', 'Accounting', 'The course is an introduction to the accounting principles, its process, memorability, and reporting for assets, liabilities, owner''s equity, revenues, and expense.', '3', 'Yes', '3', ''),
(21, 1, 'ACLIEN1', 'Client Server Project 1', 'This course will teach Microsoft Visual Basic programmers, who currently build desktop applications and access corporate databases, the basics of how to build three-tier client/server solutions.', '3', 'No', '3', ''),
(22, 1, 'ACLIEN2', 'Client Server Project 2', 'The objective of this course is to teach the principles and development of multi-tiered distributed systems. It is introduced with a basic review of internet communications and the architecture of client and server sites, including the functions of and re', '3', 'No', '3', ''),
(23, 1, 'ACLIENT', 'Client Server Project', 'Deals with client server applications with business oriented emphasis. Microsoft Visual Basic will be used as the tool for client-centered application, and JavaScript and PHP for a thin client server-centered application. It also gives emphasis on open da', '3', 'No', '3', ''),
(24, 1, 'ACOBOL1', 'Cobol Programming1', 'This course provides an overview of fundamental principles and terminology of the programming language ANSI COBOL, which is primarily used to implement business systems. The student will study the syntax and details of the COBOL programming language. Prog', '6', 'No', '6', ''),
(25, 1, 'ACOBOL2', 'Cobol Programming2', 'Advanced COBOL Programming is a self-paced audiocassette course providing comprehensive, practical training in advanced COBOL/400 tips and techniques for those with experience in interactive COBOL/400 programming.', '3', 'No', '3', ''),
(26, 1, 'ACOMORG', 'Computer Organization', '', '3', 'Yes', '3', 'Y'),
(27, 1, 'ADAS400', 'Advanced AS400 Programming', '', '3', 'No', '3', 'Y'),
(28, 1, 'ADATCOM', 'Data Communication', '', '3', 'Yes', '3', 'Y'),
(29, 1, 'ADATMAN', 'DBMS Concepts', 'The course will give the students the ability to evaluate a business situation and build a database application.  The course is focused on the use of relational database technology for building applications, as it is what the students will encounter in th', '3', 'No', '3', ''),
(30, 1, 'ADATNET', 'Data Networks', 'Provides the necessary knowledge on the technology, architecture and applications of data networks today. Topics include wired and wireless LANs, traditional and new WAN alternatives, internetworking devices, network applications and security. Specific ca', '3', 'Yes', '3', ''),
(31, 1, 'ADCOBOL', 'Advanced Cobol Programming', '', '3', 'Yes', '3', 'Y'),
(32, 1, 'ADDRNET', 'Network Addressing', '', '3', 'No', '3', 'Y'),
(33, 1, 'ADNETWK', 'Advanced Networking', '', '3', 'No', '3', 'Y'),
(34, 1, 'ADVALOG', 'Advanced Logic Circuit Design', '', '3', 'No', '3', 'Y'),
(35, 1, 'ADVANET', 'Advanced Networking', '', '3', 'No', '3', 'Y'),
(36, 1, 'ADVARPG', 'Advanced RPG Programming', '', '3', 'No', '3', 'Y'),
(37, 1, 'ADVELEC', 'Advanced Electronics', '', '3', 'No', '3', 'Y'),
(38, 1, 'ADVERTI', 'Advertising', 'The course highlights the principles and practice of advertising and its salient role in Integrated Marketing Communications. It also introduces advertising as both an art and science while providing a broad overview or advertising issues and functions. C', '3', 'No', '3', ''),
(39, 1, 'ADVLOG', 'Advanced Logic Circuits', '', '3', 'Yes', '3', 'Y'),
(40, 1, 'ADVMATH', 'Advanced Engineering Math', 'A study of selected topics in mathematics and their applications in advanced courses in engineering and other allied sciences. It covers the study of Complex numbers and complex variables, Laplace and Inverse Laplace Transforms, Power series, Fourier seri', '3', 'Yes', '3', ''),
(41, 1, 'ADVUNIX', 'Advanced Unix', 'This is a course on the advance concepts, design and application of Linux Kernel Operating System. The course will give emphasis on the Red Hat Linux Core System Administration enabling students to learn the skills in system administration such as attachi', '3', 'Yes', '3', ''),
(42, 1, 'AELECT1', 'IM elective 1', '', '3', 'No', '3', 'Y'),
(43, 1, 'AELECT2', 'IM elective 2', '', '3', 'No', '3', 'Y'),
(44, 1, 'AEOPSYS', 'Operating Systems', '', '3', 'Yes', '3', 'Y'),
(45, 1, 'AESTHET', 'Aesthetics', 'This course aids in developing of creativity by focusing  on vital principles that come into play when producing designs with aesthetic value. Topics on history of design, process and management of design, color theories and philosophy of creativity are e', '3', 'No', '3', ''),
(46, 1, 'AFSCI11', 'Air Force Science 1', '', '1.5', 'No', '1.5', 'N'),
(47, 1, 'AFSCI12', 'Air Force Science 2', '', '1.5', 'No', '1.5', 'N'),
(48, 1, 'AFSCI21', 'Air Force Science 3', '', '1.5', 'No', '1.5', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `subject_offering`
--

CREATE TABLE `subject_offering` (
  `subject_offering_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_offering`
--

INSERT INTO `subject_offering` (`subject_offering_id`, `term_id`, `subject_id`, `section_id`, `schedule_id`, `course_id`) VALUES
(1, 88, 1, 2, 1, 0),
(2, 88, 2, 3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE `system_log` (
  `entry_id` bigint(20) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `action` mediumtext NOT NULL,
  `module` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(1, '::1', 'root', '2016-11-30 19:25:10', 'Logged in', '/apc_pre_reg/login.php'),
(2, '::1', 'root', '2016-11-30 19:25:11', 'Query Executed: UPDATE user SET `password`=?, `salt`=?, `iteration`=?, `method`=? WHERE username=?\r\nArray\n(\n    [0] => ssiss\n    [1] => $2y$12$RsaU2REfFREvr0s6WJclhuBB3vQTnsqAzCCg1pN5U6DNFTdYEVUC.\n    [2] => RsaU2REfFREvr0s6WJclhw\n    [3] => 12\n    [4] => blowfish\n    [5] => root\n)\n', '/apc_pre_reg/login.php'),
(3, '::1', 'root', '2016-11-30 19:31:50', 'Pressed submit button', '/apc_pre_reg/modules/section/add_section.php'),
(4, '::1', 'root', '2016-11-30 19:31:50', 'Query Executed: INSERT INTO section(section_id, section_name, section_description, is_active) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isss\n    [1] => \n    [2] => SS131\n    [3] => System Software\n    [4] => Yes\n)\n', '/apc_pre_reg/modules/section/add_section.php'),
(5, '::1', 'root', '2016-11-30 19:32:08', 'Pressed submit button', '/apc_pre_reg/modules/section/add_section.php'),
(6, '::1', 'root', '2016-11-30 19:32:08', 'Query Executed: INSERT INTO section(section_id, section_name, section_description, is_active) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isss\n    [1] => \n    [2] => SS141\n    [3] => System Software\n    [4] => Yes\n)\n', '/apc_pre_reg/modules/section/add_section.php'),
(7, '::1', 'root', '2016-11-30 19:32:13', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(8, '::1', 'root', '2016-11-30 19:32:13', 'Query Executed: UPDATE section SET section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => sssi\n    [1] => SS131\n    [2] => System Software\n    [3] => No\n    [4] => 1\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(9, '::1', 'root', '2016-11-30 19:32:29', 'Pressed submit button', '/apc_pre_reg/modules/section/add_section.php'),
(10, '::1', 'root', '2016-11-30 19:32:30', 'Query Executed: INSERT INTO section(section_id, section_name, section_description, is_active) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isss\n    [1] => \n    [2] => SS151\n    [3] => System Software\n    [4] => Yes\n)\n', '/apc_pre_reg/modules/section/add_section.php'),
(11, '::1', 'root', '2016-12-01 16:32:34', 'Logged in', '/apc_pre_reg/login.php'),
(12, '::1', 'root', '2016-12-01 16:33:41', 'Pressed cancel button', '/apc_pre_reg/modules/section/add_section.php'),
(13, '::1', 'root', '2016-12-01 16:36:58', 'Pressed cancel button', '/apc_pre_reg/modules/section/add_section.php'),
(14, '::1', 'root', '2016-12-02 18:10:40', 'Logged in', '/apc_pre_reg/login.php'),
(15, '::1', 'root', '2016-12-02 18:54:26', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(16, '::1', 'root', '2016-12-02 18:54:26', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Add flowchart\n    [3] => modules/flowchart/flowchart/add_flowchart.php\n    [4] => Add Flowchart\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(17, '::1', 'root', '2016-12-02 18:55:15', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(18, '::1', 'root', '2016-12-02 18:55:16', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Edit flowchart\n    [3] => modules/flowchart/flowchart/edit_flowchart.php\n    [4] => Edit Flowchart\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(19, '::1', 'root', '2016-12-02 18:56:07', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(20, '::1', 'root', '2016-12-02 18:56:07', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Delete flowchart\n    [3] => modules/flowchart/flowchart/delete_flowchart.php\n    [4] => Delete Flowchart\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(21, '::1', 'root', '2016-12-02 18:56:38', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(22, '::1', 'root', '2016-12-02 18:56:38', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => View flowchart\n    [3] => modules/flowchart/flowchart/listview_flowchart.php\n    [4] => Flowchart\n    [5] => x\n    [6] => 1\n    [7] => Yes\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(23, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: DELETE FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions.php'),
(24, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''33'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(25, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''37'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(26, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''41'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(27, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''69'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(28, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''4'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(29, '::1', 'root', '2016-12-02 18:56:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''45'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(30, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''49'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(31, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''53'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(32, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''57'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(33, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''61'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(34, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''16'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(35, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''28'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(36, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''65'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(37, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''8'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(38, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''20'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(39, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''24'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(40, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''12'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(41, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''35'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(42, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''39'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(43, '::1', 'root', '2016-12-02 18:56:51', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''36'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(44, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''40'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(45, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''44'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(46, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''71'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(47, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''7'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(48, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''48'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(49, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''52'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(50, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''56'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(51, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''60'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(52, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''64'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(53, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''19'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(54, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''31'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(55, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''68'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(56, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''11'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(57, '::1', 'root', '2016-12-02 18:56:52', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''23'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(58, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''27'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(59, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''15'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(60, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''43'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(61, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''34'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(62, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''38'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(63, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''42'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(64, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''70'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(65, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''5'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(66, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''46'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(67, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''50'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(68, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''54'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(69, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''58'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(70, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''62'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(71, '::1', 'root', '2016-12-02 18:56:53', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''17'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(72, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''29'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(73, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''66'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(74, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''9'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(75, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''21'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(76, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''25'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(77, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''13'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(78, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''72'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(79, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''1'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(80, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''6'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(81, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''32'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(82, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''47'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(83, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''51'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(84, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''3'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(85, '::1', 'root', '2016-12-02 18:56:54', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''2'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(86, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''55'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(87, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''59'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(88, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''63'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(89, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''18'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(90, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''30'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(91, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''67'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(92, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''10'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(93, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''22'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(94, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''26'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(95, '::1', 'root', '2016-12-02 18:56:55', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''14'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(96, '::1', 'root', '2016-12-02 18:57:00', 'Query executed: DELETE FROM user_passport WHERE username IN (''root'')', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(97, '::1', 'root', '2016-12-02 18:57:00', 'Query executed: INSERT `user_passport` SELECT ''root'', `link_id` FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(98, '::1', 'root', '2016-12-02 18:59:09', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(99, '::1', 'root', '2016-12-02 18:59:09', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Add flowchart header\n    [3] => modules/flowchart/flowchart_header/add_flowchart_header.php\n    [4] => Add Flowchart Header\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(100, '::1', 'root', '2016-12-02 18:59:47', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(101, '::1', 'root', '2016-12-02 18:59:47', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Edit flowchart header\n    [3] => modules/flowchart/flowchart_header/edit_flowchart_header.php\n    [4] => Edit Flowchart Header\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(102, '::1', 'root', '2016-12-02 19:00:25', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(103, '::1', 'root', '2016-12-02 19:00:25', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Delete flowchart header\n    [3] => modules/flowchart/flowchart_header/delete_flowchart_header.php\n    [4] => Delete Flowchart Header\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(104, '::1', 'root', '2016-12-02 19:00:56', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(105, '::1', 'root', '2016-12-02 19:00:56', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => View flowchart header\n    [3] => modules/flowchart/flowchart_header/listview_flowchart_header.php\n    [4] => Flowchart Header\n    [5] => x\n    [6] => 1\n    [7] => Yes\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(106, '::1', 'root', '2016-12-02 19:02:45', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(107, '::1', 'root', '2016-12-02 19:02:45', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Add flowchart details\n    [3] => modules/flowchart/flowchart_details/add_flowchart_details.php\n    [4] => Add Flowchart Details\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(108, '::1', 'root', '2016-12-02 19:03:42', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(109, '::1', 'root', '2016-12-02 19:03:42', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Edit flowchart details\n    [3] => modules/flowchart/flowchart_details/edit_flowchart_details.php\n    [4] => Edit Flowchart Details\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(110, '::1', 'root', '2016-12-02 19:04:18', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(111, '::1', 'root', '2016-12-02 19:04:18', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Delete flowchart details\n    [3] => modules/flowchart/flowchart_details/delete_flowchart_details.php\n    [4] => Delete Flowchart Details\n    [5] => x\n    [6] => 1\n    [7] => No\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(112, '::1', 'root', '2016-12-02 19:05:48', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(113, '::1', 'root', '2016-12-02 19:05:48', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => View flowchart details\n    [3] => modules/flowchart/flowchart_details/listview_flowchart_details.php\n    [4] => Flowchart Details\n    [5] => x\n    [6] => 1\n    [7] => Yes\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(114, '::1', 'root', '2016-12-02 19:06:08', 'Query executed: DELETE FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions.php'),
(115, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''33'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(116, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''37'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(117, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''41'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(118, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''69'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(119, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''77'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(120, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''73'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(121, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''4'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(122, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''45'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(123, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''49'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(124, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''53'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(125, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''57'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(126, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''61'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(127, '::1', 'root', '2016-12-02 19:06:09', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''16'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(128, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''28'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(129, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''65'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(130, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''8'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(131, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''20'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(132, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''24'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(133, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''12'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(134, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''35'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(135, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''39'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(136, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''36'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(137, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''40'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(138, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''44'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(139, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''71'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(140, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''79'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(141, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''75'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(142, '::1', 'root', '2016-12-02 19:06:10', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''7'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(143, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''48'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(144, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''52'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(145, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''56'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(146, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''60'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(147, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''64'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(148, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''19'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(149, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''31'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(150, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''68'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(151, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''11'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(152, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''23'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(153, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''27'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(154, '::1', 'root', '2016-12-02 19:06:11', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''15'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(155, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''43'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(156, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''34'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(157, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''38'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(158, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''42'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(159, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''70'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(160, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''78'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(161, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''74'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(162, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''5'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(163, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''46'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(164, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''50'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(165, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''54'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(166, '::1', 'root', '2016-12-02 19:06:12', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''58'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(167, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''62'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(168, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''17'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(169, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''29'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(170, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''66'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(171, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''9'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(172, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''21'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(173, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''25'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(174, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''13'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(175, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''72'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(176, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''80'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(177, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''76'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(178, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''1'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(179, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''6'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(180, '::1', 'root', '2016-12-02 19:06:13', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''32'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(181, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''47'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(182, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''51'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(183, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''3'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(184, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''2'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(185, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''55'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(186, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''59'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(187, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''63'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(188, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''18'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(189, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''30'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(190, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''67'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(191, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''10'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(192, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''22'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(193, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''26'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(194, '::1', 'root', '2016-12-02 19:06:14', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''14'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(195, '::1', 'root', '2016-12-02 19:06:22', 'Query executed: DELETE FROM user_passport WHERE username IN (''root'')', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(196, '::1', 'root', '2016-12-02 19:06:23', 'Query executed: INSERT `user_passport` SELECT ''root'', `link_id` FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(197, '::1', 'root', '2016-12-02 19:06:24', 'Pressed cancel button', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(198, '::1', 'root', '2016-12-02 19:08:03', 'Pressed submit button', '/apc_pre_reg/modules/flowchart/flowchart/add_flowchart.php'),
(199, '::1', 'root', '2016-12-02 19:08:03', 'Query Executed: INSERT INTO flowchart(flowchart_id, flowchart_code, flowchart_name) VALUES(?,?,?)\r\nArray\n(\n    [0] => iss\n    [1] => \n    [2] => ghjk\n    [3] => fghgjkl\n)\n', '/apc_pre_reg/modules/flowchart/flowchart/add_flowchart.php'),
(200, '::1', 'root', '2016-12-02 19:08:03', 'Query Executed: INSERT INTO flowchart_header(flowchart_header_id, flowchart_id, student_id, course_id, school_year) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiis\n    [1] => \n    [2] => 1\n    [3] => 1\n    [4] => 1\n    [5] => 1\n)\n', '/apc_pre_reg/modules/flowchart/flowchart/add_flowchart.php'),
(201, '::1', 'root', '2016-12-02 19:08:49', 'Pressed cancel button', '/apc_pre_reg/modules/flowchart/flowchart_header/edit_flowchart_header.php'),
(202, '::1', 'root', '2016-12-02 19:16:42', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_passport_groups.php'),
(203, '::1', 'root', '2016-12-02 19:16:42', 'Query Executed: INSERT INTO user_passport_groups(passport_group_id, passport_group, priority, icon) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isis\n    [1] => \n    [2] => Setup Tables\n    [3] => 10\n    [4] => blue_folder3.png\n)\n', '/apc_pre_reg/sysadmin/add_user_passport_groups.php'),
(204, '::1', 'root', '2016-12-02 19:16:57', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(205, '::1', 'root', '2016-12-02 19:16:57', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add department\n    [2] => modules/department/add_department.php\n    [3] => Add Department\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 41\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(206, '::1', 'root', '2016-12-02 19:17:03', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(207, '::1', 'root', '2016-12-02 19:17:03', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit department\n    [2] => modules/department/edit_department.php\n    [3] => Edit Department\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 42\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(208, '::1', 'root', '2016-12-02 19:17:09', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(209, '::1', 'root', '2016-12-02 19:17:09', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View department\n    [2] => modules/department/listview_department.php\n    [3] => Department\n    [4] => \n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 43\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(210, '::1', 'root', '2016-12-02 19:17:14', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(211, '::1', 'root', '2016-12-02 19:17:14', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete department\n    [2] => modules/department/delete_department.php\n    [3] => Delete Department\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 44\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(212, '::1', 'root', '2016-12-02 19:18:40', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(213, '::1', 'root', '2016-12-02 19:18:40', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add flowchart\n    [2] => modules/flowchart/flowchart/add_flowchart.php\n    [3] => Add Flowchart\n    [4] => x\n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 69\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(214, '::1', 'root', '2016-12-02 19:18:45', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(215, '::1', 'root', '2016-12-02 19:18:45', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit flowchart\n    [2] => modules/flowchart/flowchart/edit_flowchart.php\n    [3] => Edit Flowchart\n    [4] => x\n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 70\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(216, '::1', 'root', '2016-12-02 19:18:53', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(217, '::1', 'root', '2016-12-02 19:18:53', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete flowchart\n    [2] => modules/flowchart/flowchart/delete_flowchart.php\n    [3] => Delete Flowchart\n    [4] => x\n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 71\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(218, '::1', 'root', '2016-12-02 19:18:58', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(219, '::1', 'root', '2016-12-02 19:18:58', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View flowchart\n    [2] => modules/flowchart/flowchart/listview_flowchart.php\n    [3] => Flowchart\n    [4] => x\n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 72\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(220, '::1', 'root', '2016-12-02 19:19:18', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(221, '::1', 'root', '2016-12-02 19:19:18', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add course\n    [2] => modules/course/add_course.php\n    [3] => Add Course\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 37\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(222, '::1', 'root', '2016-12-02 19:19:22', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(223, '::1', 'root', '2016-12-02 19:19:22', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit course\n    [2] => modules/course/edit_course.php\n    [3] => Edit Course\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 38\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(224, '::1', 'root', '2016-12-02 19:19:27', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(225, '::1', 'root', '2016-12-02 19:19:28', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View course\n    [2] => modules/course/listview_course.php\n    [3] => Course\n    [4] => \n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 39\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(226, '::1', 'root', '2016-12-02 19:19:32', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(227, '::1', 'root', '2016-12-02 19:19:33', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete course\n    [2] => modules/course/delete_course.php\n    [3] => Delete Course\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 40\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(228, '::1', 'root', '2016-12-02 19:20:11', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(229, '::1', 'root', '2016-12-02 19:20:11', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add subject\n    [2] => modules/subject/subject/add_subject.php\n    [3] => Add Subject\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 57\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(230, '::1', 'root', '2016-12-02 19:20:16', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(231, '::1', 'root', '2016-12-02 19:20:16', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit subject\n    [2] => modules/subject/subject/edit_subject.php\n    [3] => Edit Subject\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 58\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(232, '::1', 'root', '2016-12-02 19:20:21', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(233, '::1', 'root', '2016-12-02 19:20:21', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View subject\n    [2] => modules/subject/subject/listview_subject.php\n    [3] => Subject\n    [4] => \n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 59\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(234, '::1', 'root', '2016-12-02 19:20:30', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(235, '::1', 'root', '2016-12-02 19:20:30', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete subject\n    [2] => modules/subject/subject/delete_subject.php\n    [3] => Delete Subject\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 60\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(236, '::1', 'root', '2016-12-02 19:21:00', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(237, '::1', 'root', '2016-12-02 19:21:01', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add term\n    [2] => modules/term/add_term.php\n    [3] => Add Term\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 65\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(238, '::1', 'root', '2016-12-02 19:21:06', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(239, '::1', 'root', '2016-12-02 19:21:07', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit term\n    [2] => modules/term/edit_term.php\n    [3] => Edit Term\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 66\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(240, '::1', 'root', '2016-12-02 19:21:11', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(241, '::1', 'root', '2016-12-02 19:21:11', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View term\n    [2] => modules/term/listview_term.php\n    [3] => Term\n    [4] => \n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 67\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(242, '::1', 'root', '2016-12-02 19:21:17', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(243, '::1', 'root', '2016-12-02 19:21:18', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete term\n    [2] => modules/term/delete_term.php\n    [3] => Delete Term\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 68\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(244, '::1', 'root', '2016-12-02 19:37:07', 'Pressed cancel button', '/apc_pre_reg/modules/subject/subject/add_subject.php'),
(245, '::1', 'root', '2016-12-02 19:54:44', 'Pressed submit button', '/apc_pre_reg/modules/schedule/add_schedule.php'),
(246, '::1', 'root', '2016-12-02 19:54:44', 'Query Executed: INSERT INTO schedule(schedule_id, subject_id, term_id, date, is_active, enrollment_status, schedule_day, schedule_from, schedule_to) VALUES(?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => iiissssss\n    [1] => \n    [2] => 1\n    [3] => 88\n    [4] => 2016-12-02\n    [5] => Yes\n    [6] => Registered\n    [7] => Monday\n    [8] => 7:30:00\n    [9] => 11:30:00\n)\n', '/apc_pre_reg/modules/schedule/add_schedule.php'),
(247, '::1', 'root', '2016-12-02 19:55:11', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(248, '::1', 'root', '2016-12-02 19:55:11', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add section\n    [2] => modules/section/add_section.php\n    [3] => Add Section\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 49\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(249, '::1', 'root', '2016-12-02 19:55:17', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(250, '::1', 'root', '2016-12-02 19:55:18', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Edit section\n    [2] => modules/section/edit_section.php\n    [3] => Edit Section\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 50\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(251, '::1', 'root', '2016-12-02 19:55:23', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(252, '::1', 'root', '2016-12-02 19:55:23', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View section\n    [2] => modules/section/listview_section.php\n    [3] => Section\n    [4] => \n    [5] => 3\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 51\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(253, '::1', 'root', '2016-12-02 19:55:28', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(254, '::1', 'root', '2016-12-02 19:55:28', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Delete section\n    [2] => modules/section/delete_section.php\n    [3] => Delete Section\n    [4] => \n    [5] => 3\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 52\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(255, '::1', 'root', '2016-12-02 19:56:27', 'Pressed cancel button', '/apc_pre_reg/modules/schedule/edit_schedule.php'),
(256, '::1', 'root', '2016-12-06 18:19:54', 'Logged in', '/apc_pre_reg/login.php'),
(257, '::1', 'root', '2016-12-06 18:22:03', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_links.php'),
(258, '::1', 'root', '2016-12-06 18:22:04', 'Query Executed: INSERT INTO user_links(link_id, name, target, descriptive_title, description, passport_group_id, show_in_tasklist, status, icon, priority) VALUES(?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => issssisssi\n    [1] => \n    [2] => Add subject\n    [3] => modules/custom/add_subject\n    [4] => Add/Remove Subject\n    [5] => X\n    [6] => 1\n    [7] => Yes\n    [8] => On\n    [9] => form3.png\n    [10] => 0\n)\n', '/apc_pre_reg/sysadmin/add_user_links.php'),
(259, '::1', 'root', '2016-12-06 18:23:00', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_passport_groups.php'),
(260, '::1', 'root', '2016-12-06 18:23:00', 'Query Executed: INSERT INTO user_passport_groups(passport_group_id, passport_group, priority, icon) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isis\n    [1] => \n    [2] => Custom Page\n    [3] => 9\n    [4] => b\n)\n', '/apc_pre_reg/sysadmin/add_user_passport_groups.php'),
(261, '::1', 'root', '2016-12-06 18:23:07', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_passport_groups.php'),
(262, '::1', 'root', '2016-12-06 18:23:08', 'Query Executed: UPDATE user_passport_groups SET passport_group = ?, priority = ?, icon = ? WHERE passport_group_id = ?\r\nArray\n(\n    [0] => sisi\n    [1] => Custom Page\n    [2] => 9\n    [3] => blue_folder3.png\n    [4] => 4\n)\n', '/apc_pre_reg/sysadmin/edit_user_passport_groups.php'),
(263, '::1', 'root', '2016-12-06 18:23:29', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(264, '::1', 'root', '2016-12-06 18:23:29', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add subject\n    [2] => modules/custom/add_subject\n    [3] => Add/Remove Subject\n    [4] => X\n    [5] => 4\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 81\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(265, '::1', 'root', '2016-12-06 18:23:39', 'Query executed: DELETE FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions.php'),
(266, '::1', 'root', '2016-12-06 18:23:39', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''33'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(267, '::1', 'root', '2016-12-06 18:23:39', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''37'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(268, '::1', 'root', '2016-12-06 18:23:39', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''41'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(269, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''69'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(270, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''77'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(271, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''73'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(272, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''4'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(273, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''45'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(274, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''49'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(275, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''53'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(276, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''57'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(277, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''61'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(278, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''16'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(279, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''28'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(280, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''65'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(281, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''8'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(282, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''20'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(283, '::1', 'root', '2016-12-06 18:23:40', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''24'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(284, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''12'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(285, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''81'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(286, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''35'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(287, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''39'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(288, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''36'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(289, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''40'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(290, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''44'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(291, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''71'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(292, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''79'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(293, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''75'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(294, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''7'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(295, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''48'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(296, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''52'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(297, '::1', 'root', '2016-12-06 18:23:41', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''56'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(298, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''60'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(299, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''64'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(300, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''19'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(301, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''31'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(302, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''68'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(303, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''11'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(304, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''23'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(305, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''27'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(306, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''15'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(307, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''43'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(308, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''34'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(309, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''38'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(310, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''42'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(311, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''70'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(312, '::1', 'root', '2016-12-06 18:23:42', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''78'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(313, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''74'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(314, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''5'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(315, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''46'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(316, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''50'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(317, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''54'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(318, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''58'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(319, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''62'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(320, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''17'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(321, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''29'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(322, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''66'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(323, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''9'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(324, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''21'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(325, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''25'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(326, '::1', 'root', '2016-12-06 18:23:43', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''13'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(327, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''72'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(328, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''80'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(329, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''76'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(330, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''1'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(331, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''6'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(332, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''32'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(333, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''47'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(334, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''51'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(335, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''3'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(336, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''2'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(337, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''55'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(338, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''59'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(339, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''63'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(340, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''18'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(341, '::1', 'root', '2016-12-06 18:23:44', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''30'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(342, '::1', 'root', '2016-12-06 18:23:45', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''67'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(343, '::1', 'root', '2016-12-06 18:23:45', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''10'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(344, '::1', 'root', '2016-12-06 18:23:45', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''22'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(345, '::1', 'root', '2016-12-06 18:23:45', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''26'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(346, '::1', 'root', '2016-12-06 18:23:45', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''1'', ''14'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(347, '::1', 'root', '2016-12-06 18:23:59', 'Query executed: DELETE FROM user_passport WHERE username IN (''root'')', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(348, '::1', 'root', '2016-12-06 18:23:59', 'Query executed: INSERT `user_passport` SELECT ''root'', `link_id` FROM user_role_links WHERE role_id=''1''', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(349, '::1', 'root', '2016-12-06 18:24:45', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(350, '::1', 'root', '2016-12-06 18:24:45', 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add subject\n    [2] => modules/custom/add_subject.php\n    [3] => Add/Remove Subject\n    [4] => X\n    [5] => 4\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 81\n)\n', '/apc_pre_reg/sysadmin/edit_user_links.php'),
(351, '::1', 'root', '2016-12-06 18:28:19', 'Pressed submit button', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(352, '::1', 'root', '2016-12-06 18:28:19', 'Query Executed: INSERT INTO subject_offering(subject_offering_id, term_id, subject_id, section_id, schedule_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 88\n    [3] => 1\n    [4] => 2\n    [5] => 1\n)\n', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(353, '::1', 'root', '2016-12-06 18:52:30', 'Pressed cancel button', '/apc_pre_reg/modules/subject/subject_offering/detailview_subject_offering.php'),
(354, '::1', 'root', '2016-12-06 18:54:30', 'Pressed cancel button', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(355, '::1', 'root', '2016-12-06 18:58:42', 'Pressed cancel button', '/apc_pre_reg/modules/subject/subject_offering/detailview_subject_offering.php'),
(356, '::1', 'root', '2016-12-06 19:25:40', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(357, '::1', 'root', '2016-12-06 19:25:59', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(358, '::1', 'root', '2016-12-06 19:26:09', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(359, '::1', 'root', '2016-12-06 19:27:08', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(360, '::1', 'root', '2016-12-06 19:27:12', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(361, '::1', 'root', '2016-12-06 19:27:31', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(362, '::1', 'root', '2016-12-06 19:27:45', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(363, '::1', 'root', '2016-12-06 19:29:32', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(364, '::1', 'root', '2016-12-06 19:30:15', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(365, '::1', 'root', '2016-12-06 19:30:19', 'Query executed: SELECT 	subject.subject_code,\r\n            		  subject.subject_name,\r\n                  subject.subject_unit,\r\n                 	section.section_name,\r\n                  schedule.schedule_day,\r\n                  schedule.schedule_from,\r\n                  schedule.schedule_to\r\n\r\n            FROM 	subject_offering\r\n\r\n            LEFT JOIN 	subject\r\n            ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n            LEFT JOIN   section\r\n            ON 			section.section_id = subject_offering.section_id\r\n\r\n            LEFT JOIN	schedule\r\n            ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(366, '::1', 'root', '2016-12-06 19:33:21', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(367, '::1', 'root', '2016-12-06 19:33:25', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(368, '::1', 'root', '2016-12-06 19:46:08', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(369, '::1', 'root', '2016-12-06 19:46:22', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(370, '::1', 'root', '2016-12-06 19:47:01', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(371, '::1', 'root', '2016-12-06 19:48:01', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(372, '::1', 'root', '2016-12-06 19:50:03', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(373, '::1', 'root', '2016-12-06 19:52:28', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(374, '::1', 'root', '2016-12-06 19:52:42', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(375, '::1', 'root', '2016-12-06 19:53:29', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(376, '::1', 'root', '2016-12-06 19:53:32', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(377, '::1', 'root', '2016-12-06 19:54:34', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(378, '::1', 'root', '2016-12-06 19:56:05', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(379, '::1', 'root', '2016-12-06 19:56:15', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(380, '::1', 'root', '2016-12-06 19:56:29', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id', '/apc_pre_reg/modules/custom/add_subject.php'),
(381, '::1', 'root', '2016-12-06 19:59:56', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''  \r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(382, '::1', 'root', '2016-12-06 20:00:00', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''  \r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(383, '::1', 'root', '2016-12-06 20:00:04', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%2%''  \r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(384, '::1', 'root', '2016-12-06 20:00:20', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n                \r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(385, '::1', 'root', '2016-12-06 20:00:58', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(386, '::1', 'root', '2016-12-06 20:00:59', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(387, '::1', 'root', '2016-12-06 20:01:00', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(388, '::1', 'root', '2016-12-06 20:01:11', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(389, '::1', 'root', '2016-12-06 20:01:13', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(390, '::1', 'root', '2016-12-06 20:02:29', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(391, '::1', 'root', '2016-12-06 20:03:43', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(392, '::1', 'root', '2016-12-06 20:04:33', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(393, '::1', 'root', '2016-12-06 20:04:53', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(394, '::1', 'root', '2016-12-06 20:05:23', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(395, '::1', 'root', '2016-12-06 20:05:47', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(396, '::1', 'root', '2016-12-06 20:05:49', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(397, '::1', 'root', '2016-12-06 20:05:51', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(398, '::1', 'root', '2016-12-06 20:06:09', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(399, '::1', 'root', '2016-12-06 20:06:11', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(400, '::1', 'root', '2016-12-06 20:06:28', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(401, '::1', 'root', '2016-12-06 20:06:31', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(402, '::1', 'root', '2016-12-06 20:06:32', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(403, '::1', 'root', '2016-12-06 20:06:49', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(404, '::1', 'root', '2016-12-06 20:08:17', 'Pressed submit button', '/apc_pre_reg/modules/schedule/add_schedule.php'),
(405, '::1', 'root', '2016-12-06 20:08:18', 'Query Executed: INSERT INTO schedule(schedule_id, subject_id, term_id, date, is_active, enrollment_status, schedule_day, schedule_from, schedule_to) VALUES(?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => iiissssss\n    [1] => \n    [2] => 1\n    [3] => 88\n    [4] => 2016-12-06\n    [5] => Yes\n    [6] => Registered\n    [7] => Tuesday\n    [8] => 11:30:00\n    [9] => 15:30:00\n)\n', '/apc_pre_reg/modules/schedule/add_schedule.php'),
(406, '::1', 'root', '2016-12-06 20:08:39', 'Pressed submit button', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(407, '::1', 'root', '2016-12-06 20:08:39', 'Query Executed: INSERT INTO subject_offering(subject_offering_id, term_id, subject_id, section_id, schedule_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 88\n    [3] => 1\n    [4] => 3\n    [5] => 2\n)\n', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(408, '::1', 'root', '2016-12-06 20:08:41', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(409, '::1', 'root', '2016-12-06 20:08:44', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(410, '::1', 'root', '2016-12-06 20:08:46', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%4%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(411, '::1', 'root', '2016-12-06 20:08:50', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(412, '::1', 'root', '2016-12-08 00:32:27', 'Logged in', '/apc_pre_reg/login.php'),
(413, '::1', 'root', '2016-12-08 00:32:31', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(414, '::1', 'root', '2016-12-08 00:32:37', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%16%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(415, '::1', 'root', '2016-12-08 00:32:38', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%16%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(416, '::1', 'root', '2016-12-08 00:32:39', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%16%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(417, '::1', 'root', '2016-12-08 00:32:41', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(418, '::1', 'root', '2016-12-08 00:32:43', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(419, '::1', 'root', '2016-12-08 00:32:46', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(420, '::1', 'root', '2016-12-08 00:32:49', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(421, '::1', 'root', '2016-12-08 00:32:51', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(422, '::1', 'root', '2016-12-08 00:32:56', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(423, '::1', 'root', '2016-12-08 00:33:02', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(424, '::1', 'root', '2016-12-08 10:37:51', 'Logged in', '/apc_pre_reg/login.php'),
(425, '::1', 'root', '2016-12-08 10:37:54', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(426, '::1', 'root', '2016-12-08 10:37:59', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(427, '::1', 'root', '2016-12-08 10:38:01', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(428, '::1', 'root', '2016-12-08 10:38:32', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(429, '::1', 'root', '2016-12-08 10:39:42', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(430, '::1', 'root', '2016-12-08 10:39:49', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(431, '::1', 'root', '2016-12-08 10:39:52', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(432, '::1', 'root', '2016-12-08 10:40:03', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(433, '::1', 'root', '2016-12-08 10:40:35', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(434, '::1', 'root', '2016-12-08 10:48:03', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(435, '::1', 'root', '2016-12-08 10:48:06', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(436, '::1', 'root', '2016-12-08 10:48:07', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(437, '::1', 'root', '2016-12-08 10:48:15', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(438, '::1', 'root', '2016-12-08 10:51:07', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(439, '::1', 'root', '2016-12-08 10:51:09', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(440, '::1', 'root', '2016-12-08 10:51:12', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(441, '::1', 'root', '2016-12-08 10:51:24', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(442, '::1', 'root', '2016-12-08 16:19:22', 'Logged in', '/apc_pre_reg/login.php'),
(443, '::1', 'root', '2016-12-08 16:19:25', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(444, '::1', 'root', '2016-12-08 16:21:00', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(445, '::1', 'root', '2016-12-08 16:32:47', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(446, '::1', 'root', '2016-12-08 16:34:14', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(447, '::1', 'root', '2016-12-08 17:56:36', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(448, '::1', 'root', '2016-12-08 18:00:34', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(449, '::1', 'root', '2016-12-08 18:07:39', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(450, '::1', 'root', '2016-12-08 18:12:59', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(451, '::1', 'root', '2016-12-08 18:14:29', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(452, '::1', 'root', '2016-12-08 18:14:46', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(453, '::1', 'root', '2016-12-08 18:14:50', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(454, '::1', 'root', '2016-12-08 18:15:06', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(455, '::1', 'root', '2016-12-08 18:36:45', 'Logged in', '/apc_pre_reg/login.php'),
(456, '::1', 'root', '2016-12-10 15:43:40', 'Logged in', '/apc_pre_reg/login.php'),
(457, '::1', 'root', '2016-12-10 15:44:16', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(458, '::1', 'root', '2016-12-11 20:33:47', 'Logged in', '/apc_pre_reg/login.php'),
(459, '::1', 'root', '2016-12-11 20:33:52', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(460, '::1', 'root', '2016-12-11 20:33:53', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(461, '::1', 'root', '2016-12-11 20:33:59', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(462, '::1', 'root', '2016-12-11 21:01:04', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(463, '::1', 'root', '2016-12-11 21:01:04', 'Query Executed: UPDATE section SET department_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => isssi\n    [1] => 1\n    [2] => SS131\n    [3] => System Software\n    [4] => No\n    [5] => 1\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(464, '::1', 'root', '2016-12-11 21:03:04', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(465, '::1', 'root', '2016-12-11 21:03:04', 'Query Executed: UPDATE section SET department_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => isssi\n    [1] => 4\n    [2] => ABMA 131\n    [3] => System Software\n    [4] => No\n    [5] => 1\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(466, '::1', 'root', '2016-12-11 21:03:16', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(467, '::1', 'root', '2016-12-11 21:03:16', 'Query Executed: UPDATE section SET department_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => isssi\n    [1] => 4\n    [2] => ABMA141\n    [3] => System Software\n    [4] => Yes\n    [5] => 2\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(468, '::1', 'root', '2016-12-11 21:03:23', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(469, '::1', 'root', '2016-12-11 21:03:23', 'Query Executed: UPDATE section SET department_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => isssi\n    [1] => 4\n    [2] => ABMA 141\n    [3] => System Software\n    [4] => Yes\n    [5] => 2\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(470, '::1', 'root', '2016-12-11 21:03:31', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(471, '::1', 'root', '2016-12-11 21:03:31', 'Query Executed: UPDATE section SET department_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => isssi\n    [1] => 4\n    [2] => ABMA 151\n    [3] => System Software\n    [4] => Yes\n    [5] => 3\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(472, '::1', 'root', '2016-12-11 21:13:29', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(473, '::1', 'root', '2016-12-11 21:13:29', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 131\n    [4] => System Software\n    [5] => No\n    [6] => 1\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(474, '::1', 'root', '2016-12-11 21:13:33', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(475, '::1', 'root', '2016-12-11 21:13:33', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 141\n    [4] => System Software\n    [5] => Yes\n    [6] => 2\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(476, '::1', 'root', '2016-12-11 21:13:39', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(477, '::1', 'root', '2016-12-11 21:13:39', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 151\n    [4] => System Software\n    [5] => Yes\n    [6] => 3\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(478, '::1', 'root', '2016-12-11 21:20:42', 'Pressed submit button', '/apc_pre_reg/modules/section/add_section.php'),
(479, '::1', 'root', '2016-12-11 21:20:42', 'Query Executed: INSERT INTO section(section_id, department_id, course_id, section_name, section_description, is_active) VALUES(?,?,?,?,?,?)\r\nArray\n(\n    [0] => iiisss\n    [1] => \n    [2] => 44\n    [3] => 1\n    [4] => SS 131\n    [5] => System Software\n    [6] => Yes\n)\n', '/apc_pre_reg/modules/section/add_section.php'),
(480, '::1', 'root', '2016-12-11 21:20:57', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(481, '::1', 'root', '2016-12-11 21:20:57', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 131\n    [4] => Multimedia Arts\n    [5] => No\n    [6] => 1\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(482, '::1', 'root', '2016-12-11 21:21:03', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(483, '::1', 'root', '2016-12-11 21:21:03', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 141\n    [4] => Multimedia Arts\n    [5] => Yes\n    [6] => 2\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(484, '::1', 'root', '2016-12-11 21:21:08', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(485, '::1', 'root', '2016-12-11 21:21:09', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 4\n    [2] => 1\n    [3] => ABMA 151\n    [4] => Multimedia Arts\n    [5] => Yes\n    [6] => 3\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(486, '::1', 'root', '2016-12-11 21:21:27', 'Pressed cancel button', '/apc_pre_reg/modules/section/edit_section.php'),
(487, '::1', 'root', '2016-12-11 21:21:38', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(488, '::1', 'root', '2016-12-11 21:21:38', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 1\n    [2] => 36\n    [3] => SS 131\n    [4] => System Software\n    [5] => Yes\n    [6] => 4\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(489, '::1', 'root', '2016-12-11 21:22:05', 'Pressed submit button', '/apc_pre_reg/modules/section/edit_section.php'),
(490, '::1', 'root', '2016-12-11 21:22:05', 'Query Executed: UPDATE section SET department_id = ?, course_id = ?, section_name = ?, section_description = ?, is_active = ? WHERE section_id = ?\r\nArray\n(\n    [0] => iisssi\n    [1] => 1\n    [2] => 44\n    [3] => SS 131\n    [4] => System Software\n    [5] => Yes\n    [6] => 4\n)\n', '/apc_pre_reg/modules/section/edit_section.php'),
(491, '::1', 'root', '2016-12-11 21:25:54', 'Pressed submit button', '/apc_pre_reg/modules/student/student/add_student.php'),
(492, '::1', 'root', '2016-12-11 21:27:32', 'Pressed submit button', '/apc_pre_reg/modules/student/student/add_student.php'),
(493, '::1', 'root', '2016-12-11 21:27:32', 'Query Executed: INSERT INTO student(student_id, course_id, department_id, section_id, student_num, last_name, first_name, middle_name, birth_date, birth_place, gender, civil_status, mobile_num, tel_num, email, address, nationality, religion, postal_code, username, password, admission_date, entry_level, admission_credential, mail_grades_to, exit_level, box_num) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => iiiisssssssssssssssssssssss\n    [1] => \n    [2] => 44\n    [3] => 1\n    [4] => 4\n    [5] => 2013-100154\n    [6] => Lagman\n    [7] => Kamila\n    [8] => \n    [9] => 1997-01-11\n    [10] => Makati City\n    [11] => Female\n    [12] => Single\n    [13] => 09858548418\n    [14] => \n    [15] => hahah@sample.com\n    [16] => lols\n    [17] => there\n    [18] => yow\n    [19] => \n    [20] => krlagman\n    [21] => password\n    [22] => 2016-06-11\n    [23] => First Year\n    [24] => \n    [25] => hehe@sample.com\n    [26] => \n    [27] => \n)\n', '/apc_pre_reg/modules/student/student/add_student.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(494, '::1', 'root', '2016-12-11 21:27:32', 'Query Executed: INSERT INTO person(person_id, first_name, middle_name, last_name, gender) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => issss\n    [1] => \n    [2] => Kamila\n    [3] => \n    [4] => Lagman\n    [5] => Female\n)\n', '/apc_pre_reg/modules/student/student/add_student.php'),
(495, '::1', 'root', '2016-12-11 21:27:32', 'Query Executed: INSERT INTO user(username, password, salt, iteration, method, person_id, role_id, skin_id) VALUES(?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => sssisiii\n    [1] => krlagman\n    [2] => $2y$12$EeufHfozRAKW8y69U80twerkft2yyZvzpPkYABfa927AGv6PG21ii\n    [3] => EeufHfozRAKW8y69U80twg\n    [4] => 12\n    [5] => blowfish\n    [6] => 2\n    [7] => 3\n    [8] => 1\n)\n', '/apc_pre_reg/modules/student/student/add_student.php'),
(496, '::1', 'root', '2016-12-11 21:27:58', 'Pressed submit button', '/apc_pre_reg/sysadmin/add_user_role.php'),
(497, '::1', 'root', '2016-12-11 21:27:58', 'Query Executed: INSERT INTO user_role(role_id, role, description) VALUES(?,?,?)\r\nArray\n(\n    [0] => iss\n    [1] => \n    [2] => Student\n    [3] => Lols\n)\n', '/apc_pre_reg/sysadmin/add_user_role.php'),
(498, '::1', 'root', '2016-12-11 21:38:34', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(499, '::1', 'root', '2016-12-11 21:38:41', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(500, '::1', 'root', '2016-12-11 21:38:57', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(501, '::1', 'root', '2016-12-11 21:39:08', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(502, '::1', 'root', '2016-12-11 21:42:13', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			  AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(503, '::1', 'root', '2016-12-11 21:42:14', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			  AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(504, '::1', 'root', '2016-12-11 21:43:17', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(505, '::1', 'root', '2016-12-11 21:44:07', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%2%''\r\n			        AND		      section.section_name LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(506, '::1', 'root', '2016-12-11 21:44:12', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(507, '::1', 'root', '2016-12-11 21:44:15', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(508, '::1', 'root', '2016-12-11 21:45:48', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(509, '::1', 'root', '2016-12-11 21:45:56', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(510, '::1', 'root', '2016-12-11 21:46:02', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(511, '::1', 'root', '2016-12-11 21:46:17', 'Logged out', '/apc_pre_reg/end.php'),
(512, '::1', 'root', '2016-12-11 21:46:28', 'Logged in', '/apc_pre_reg/login.php'),
(513, '::1', 'root', '2016-12-11 21:46:32', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(514, '::1', 'root', '2016-12-11 21:46:36', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(515, '::1', 'root', '2016-12-11 21:46:40', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(516, '::1', 'root', '2016-12-11 21:46:58', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(517, '::1', 'root', '2016-12-11 21:47:25', 'Pressed submit button', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(518, '::1', 'root', '2016-12-11 21:47:26', 'Query Executed: INSERT INTO subject_offering(subject_offering_id, term_id, subject_id, section_id, schedule_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 88\n    [3] => 1\n    [4] => 2\n    [5] => 1\n)\n', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(519, '::1', 'root', '2016-12-11 21:47:27', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(520, '::1', 'root', '2016-12-11 21:47:32', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(521, '::1', 'root', '2016-12-11 21:48:53', 'Pressed submit button', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(522, '::1', 'root', '2016-12-11 21:48:54', 'Query Executed: INSERT INTO subject_offering(subject_offering_id, term_id, subject_id, section_id, schedule_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 88\n    [3] => 2\n    [4] => 3\n    [5] => 2\n)\n', '/apc_pre_reg/modules/subject/subject_offering/add_subject_offering.php'),
(523, '::1', 'root', '2016-12-11 21:49:36', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(524, '::1', 'root', '2016-12-11 21:49:49', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(525, '::1', 'root', '2016-12-11 21:49:52', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(526, '::1', 'root', '2016-12-11 21:50:08', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(527, '::1', 'root', '2016-12-11 21:50:13', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(528, '::1', 'root', '2016-12-11 21:50:19', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(529, '::1', 'root', '2016-12-11 21:50:34', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(530, '::1', 'root', '2016-12-11 21:50:37', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(531, '::1', 'root', '2016-12-11 21:50:54', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(532, '::1', 'root', '2016-12-11 21:52:17', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(533, '::1', 'root', '2016-12-11 21:53:10', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(534, '::1', 'root', '2016-12-11 21:53:13', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(535, '::1', 'root', '2016-12-11 21:53:17', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(536, '::1', 'root', '2016-12-11 21:53:28', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(537, '::1', 'root', '2016-12-11 21:53:30', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(538, '::1', 'root', '2016-12-11 21:53:33', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(539, '::1', 'root', '2016-12-11 21:54:06', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(540, '::1', 'root', '2016-12-11 21:54:19', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(541, '::1', 'root', '2016-12-11 21:54:21', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(542, '::1', 'root', '2016-12-11 21:54:29', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(543, '::1', 'root', '2016-12-11 21:54:31', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(544, '::1', 'root', '2016-12-11 21:54:35', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(545, '::1', 'root', '2016-12-11 21:54:36', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(546, '::1', 'root', '2016-12-11 21:54:39', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(547, '::1', 'root', '2016-12-11 21:54:43', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(548, '::1', 'root', '2016-12-11 21:55:27', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(549, '::1', 'root', '2016-12-11 21:58:40', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(550, '::1', 'root', '2016-12-11 22:01:32', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%1%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(551, '::1', 'root', '2016-12-11 22:01:35', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(552, '::1', 'root', '2016-12-11 22:01:37', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(553, '::1', 'root', '2016-12-11 22:01:39', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(554, '::1', 'root', '2016-12-11 22:01:43', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%4%''\r\n			        AND		      section.section_id LIKE ''%4%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(555, '::1', 'root', '2016-12-11 22:01:47', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(556, '::1', 'root', '2016-12-11 22:03:33', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(557, '::1', 'root', '2016-12-11 22:03:36', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(558, '::1', 'root', '2016-12-11 22:04:06', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		  section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(559, '::1', 'root', '2016-12-11 22:04:07', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		  section.section_name LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(560, '::1', 'root', '2016-12-11 22:04:08', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%1%''\r\n			        AND		  section.section_name LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(561, '::1', 'root', '2016-12-11 22:04:20', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(562, '::1', 'root', '2016-12-11 22:04:21', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(563, '::1', 'root', '2016-12-11 22:04:45', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(564, '::1', 'root', '2016-12-11 22:04:58', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(565, '::1', 'root', '2016-12-11 22:05:22', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(566, '::1', 'root', '2016-12-11 22:07:05', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_code LIKE ''%%''\r\n			        AND		  section.section_name LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(567, '::1', 'root', '2016-12-11 22:07:55', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(568, '::1', 'root', '2016-12-11 22:07:57', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(569, '::1', 'root', '2016-12-11 22:08:01', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(570, '::1', 'root', '2016-12-11 22:08:35', 'Query executed: SELECT 	subject.subject_code,\r\n              		  subject.subject_name,\r\n                    subject.subject_unit,\r\n                   	section.section_name,\r\n                    schedule.schedule_day,\r\n                    schedule.schedule_from,\r\n                    schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%%''\r\n			        AND		      section.section_id LIKE ''%%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(571, '::1', 'root', '2016-12-11 22:11:03', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			  AND		  section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(572, '::1', 'root', '2016-12-11 22:11:04', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(573, '::1', 'root', '2016-12-11 22:11:05', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(574, '::1', 'root', '2016-12-11 22:11:09', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			  AND		  section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(575, '::1', 'root', '2016-12-11 22:13:02', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(576, '::1', 'root', '2016-12-11 22:13:05', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(577, '::1', 'root', '2016-12-11 22:13:09', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(578, '::1', 'root', '2016-12-11 22:13:12', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(579, '::1', 'root', '2016-12-11 22:16:31', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(580, '::1', 'root', '2016-12-11 22:16:50', 'Query executed: DELETE FROM user_role_links WHERE role_id=''3'' AND link_id IN (''81'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(581, '::1', 'root', '2016-12-11 22:16:50', 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''3'', ''81'')', '/apc_pre_reg/sysadmin/role_permissions.php'),
(582, '::1', 'root', '2016-12-11 22:16:54', 'Query executed: DELETE FROM user_passport WHERE username IN (''krlagman'')', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(583, '::1', 'root', '2016-12-11 22:16:54', 'Query executed: INSERT `user_passport` SELECT ''krlagman'', `link_id` FROM user_role_links WHERE role_id=''3''', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(584, '::1', 'root', '2016-12-11 22:16:57', 'Logged out', '/apc_pre_reg/end.php'),
(585, '::1', 'krlagman', '2016-12-11 22:17:02', 'Logged in', '/apc_pre_reg/login.php'),
(586, '::1', 'krlagman', '2016-12-11 22:17:04', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(587, '::1', 'krlagman', '2016-12-11 22:21:10', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(588, '::1', 'krlagman', '2016-12-11 22:21:17', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(589, '::1', 'krlagman', '2016-12-11 22:21:23', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(590, '::1', 'krlagman', '2016-12-11 22:39:18', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(591, '::1', 'krlagman', '2016-12-11 22:39:32', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(592, '::1', 'krlagman', '2016-12-11 22:41:40', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(593, '::1', 'krlagman', '2016-12-11 22:41:59', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(594, '::1', 'krlagman', '2016-12-11 22:42:08', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(595, '::1', 'krlagman', '2016-12-11 22:42:15', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(596, '::1', 'krlagman', '2016-12-11 22:42:24', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(597, '::1', 'krlagman', '2016-12-11 22:43:11', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(598, '::1', 'krlagman', '2016-12-11 22:43:16', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(599, '::1', 'krlagman', '2016-12-11 22:47:03', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(600, '::1', 'krlagman', '2016-12-11 22:47:05', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(601, '::1', 'krlagman', '2016-12-11 22:48:36', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(602, '::1', 'krlagman', '2016-12-11 22:49:05', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(603, '::1', 'krlagman', '2016-12-11 22:49:40', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(604, '::1', 'krlagman', '2016-12-11 22:49:49', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(605, '::1', 'krlagman', '2016-12-11 22:50:03', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(606, '::1', 'krlagman', '2016-12-11 22:50:17', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(607, '::1', 'krlagman', '2016-12-11 22:50:21', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(608, '::1', 'krlagman', '2016-12-11 22:50:43', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(609, '::1', 'krlagman', '2016-12-11 22:51:10', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(610, '::1', 'krlagman', '2016-12-11 22:51:13', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(611, '::1', 'krlagman', '2016-12-11 22:51:15', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(612, '::1', 'krlagman', '2016-12-11 22:51:38', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(613, '::1', 'krlagman', '2016-12-11 22:51:42', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(614, '::1', 'krlagman', '2016-12-11 22:51:43', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(615, '::1', 'krlagman', '2016-12-11 22:52:18', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(616, '::1', 'krlagman', '2016-12-11 22:52:22', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(617, '::1', 'krlagman', '2016-12-11 22:52:23', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(618, '::1', 'krlagman', '2016-12-11 22:52:24', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(619, '::1', 'krlagman', '2016-12-11 22:52:35', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(620, '::1', 'krlagman', '2016-12-11 22:52:36', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(621, '::1', 'krlagman', '2016-12-11 22:54:34', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(622, '::1', 'krlagman', '2016-12-11 22:54:36', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%2%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(623, '::1', 'krlagman', '2016-12-11 22:55:19', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(624, '::1', 'krlagman', '2016-12-11 22:55:27', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(625, '::1', 'krlagman', '2016-12-11 22:55:39', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(626, '::1', 'krlagman', '2016-12-11 22:56:41', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(627, '::1', 'krlagman', '2016-12-11 22:56:49', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(628, '::1', 'krlagman', '2016-12-11 22:56:53', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(629, '::1', 'krlagman', '2016-12-11 22:58:27', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(630, '::1', 'krlagman', '2016-12-11 22:58:30', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(631, '::1', 'krlagman', '2016-12-11 22:58:32', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(632, '::1', 'krlagman', '2016-12-11 22:58:32', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(633, '::1', 'krlagman', '2016-12-11 22:58:32', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(634, '::1', 'krlagman', '2016-12-11 23:02:35', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(635, '::1', 'krlagman', '2016-12-11 23:02:35', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(636, '::1', 'krlagman', '2016-12-11 23:02:35', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(637, '::1', 'krlagman', '2016-12-11 23:02:36', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(638, '::1', 'krlagman', '2016-12-11 23:03:35', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(639, '::1', 'krlagman', '2016-12-11 23:03:41', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(640, '::1', 'krlagman', '2016-12-11 23:03:41', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(641, '::1', 'krlagman', '2016-12-11 23:03:41', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(642, '::1', 'krlagman', '2016-12-11 23:04:07', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(643, '::1', 'krlagman', '2016-12-11 23:04:11', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(644, '::1', 'krlagman', '2016-12-11 23:04:26', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(645, '::1', 'krlagman', '2016-12-11 23:04:30', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(646, '::1', 'krlagman', '2016-12-11 23:04:34', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(647, '::1', 'krlagman', '2016-12-11 23:04:34', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(648, '::1', 'krlagman', '2016-12-11 23:04:34', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(649, '::1', 'root', '2016-12-11 23:23:27', 'Logged out', '/apc_pre_reg/end.php'),
(650, '::1', 'root', '2016-12-11 23:23:32', 'Logged in', '/apc_pre_reg/login.php'),
(651, '::1', 'root', '2016-12-11 23:23:34', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(652, '::1', 'root', '2016-12-11 23:23:45', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(653, '::1', 'root', '2016-12-11 23:23:48', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => \n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(654, '::1', 'root', '2016-12-11 23:23:48', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(655, '::1', 'root', '2016-12-11 23:23:48', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(656, '::1', 'root', '2016-12-11 23:25:25', 'Logged out', '/apc_pre_reg/end.php'),
(657, '::1', 'krlagman', '2016-12-11 23:25:31', 'Logged in', '/apc_pre_reg/login.php'),
(658, '::1', 'krlagman', '2016-12-11 23:25:33', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(659, '::1', 'krlagman', '2016-12-11 23:25:39', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(660, '::1', 'krlagman', '2016-12-11 23:25:43', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(661, '::1', 'krlagman', '2016-12-11 23:25:43', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(662, '::1', 'krlagman', '2016-12-11 23:25:43', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(663, '::1', 'krlagman', '2016-12-11 23:28:18', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%3%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(664, '::1', 'krlagman', '2016-12-11 23:37:24', 'Logged out', '/apc_pre_reg/end.php'),
(665, '::1', 'root', '2016-12-11 23:37:29', 'Logged in', '/apc_pre_reg/login.php'),
(666, '::1', 'root', '2016-12-11 23:39:24', 'Pressed cancel button', '/apc_pre_reg/modules/schedule/add_schedule.php'),
(667, '::1', 'root', '2016-12-11 23:41:44', 'Pressed cancel button', '/apc_pre_reg/sysadmin/role_permissions.php'),
(668, '::1', 'root', '2016-12-11 23:41:49', 'Pressed cancel button', '/apc_pre_reg/sysadmin/role_permissions.php'),
(669, '::1', 'root', '2016-12-11 23:42:06', 'Pressed cancel button', '/apc_pre_reg/sysadmin/role_permissions.php'),
(670, '::1', 'root', '2016-12-12 00:03:58', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(671, '::1', 'root', '2016-12-12 03:32:19', 'Logged in', '/apc_pre_reg/login.php'),
(672, '::1', 'root', '2016-12-12 03:41:46', 'Logged out', '/apc_pre_reg/end.php'),
(673, '::1', 'root', '2016-12-12 17:50:47', 'Logged in', '/apc_pre_reg/login.php'),
(674, '::1', 'root', '2016-12-12 17:50:49', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(675, '::1', 'root', '2016-12-12 17:50:53', 'Logged out', '/apc_pre_reg/end.php'),
(676, '::1', 'krlagman', '2016-12-12 17:50:57', 'Logged in', '/apc_pre_reg/login.php'),
(677, '::1', 'krlagman', '2016-12-12 17:50:58', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(678, '::1', 'krlagman', '2016-12-12 17:51:05', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(679, '::1', 'krlagman', '2016-12-12 17:51:07', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, student_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(680, '::1', 'krlagman', '2016-12-12 17:51:07', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(681, '::1', 'krlagman', '2016-12-12 17:51:07', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(682, '::1', 'krlagman', '2016-12-12 17:52:37', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(683, '::1', 'krlagman', '2016-12-12 17:55:22', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(684, '::1', 'krlagman', '2016-12-12 17:56:57', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(685, '::1', 'krlagman', '2016-12-12 17:57:05', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%3%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(686, '::1', 'krlagman', '2016-12-12 17:57:12', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(687, '::1', 'krlagman', '2016-12-12 18:00:07', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(688, '::1', 'krlagman', '2016-12-12 18:01:04', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(689, '::1', 'krlagman', '2016-12-12 18:03:32', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(690, '::1', 'krlagman', '2016-12-12 18:03:55', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(691, '::1', 'krlagman', '2016-12-12 18:07:16', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(692, '::1', 'krlagman', '2016-12-12 18:07:52', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(693, '::1', 'krlagman', '2016-12-12 18:08:38', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(694, '::1', 'krlagman', '2016-12-12 18:11:59', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(695, '::1', 'krlagman', '2016-12-12 18:12:44', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n								section.section_name,\r\n                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''%1%''\r\n			        AND		      section.section_id LIKE ''%2%''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(696, '::1', 'krlagman', '2016-12-12 18:59:50', 'Logged out', '/apc_pre_reg/end.php'),
(697, '::1', 'root', '2016-12-12 18:59:56', 'Logged in', '/apc_pre_reg/login.php'),
(698, '::1', 'root', '2016-12-12 19:00:05', 'Logged out', '/apc_pre_reg/end.php'),
(699, '::1', 'root', '2016-12-12 19:00:33', 'Logged in', '/apc_pre_reg/login.php'),
(700, '::1', 'root', '2016-12-12 19:03:12', 'Pressed submit button', '/apc_pre_reg/sysadmin/security_monitor.php'),
(701, '::1', 'root', '2016-12-12 19:03:35', 'Pressed submit button', '/apc_pre_reg/sysadmin/security_monitor.php'),
(702, '::1', 'root', '2016-12-12 20:07:43', 'Logged out', '/apc_pre_reg/end.php'),
(703, '::1', 'root', '2016-12-12 23:17:14', 'Logged in', '/apc_pre_reg/login.php'),
(704, '::1', 'root', '2016-12-12 23:18:00', 'Pressed submit button', '/apc_pre_reg/sysadmin/edit_user_role.php'),
(705, '::1', 'root', '2016-12-12 23:18:00', 'Query Executed: UPDATE user_role SET role = ?, description = ? WHERE role_id = ?\r\nArray\n(\n    [0] => ssi\n    [1] => Student\n    [2] => Add or remove subject\n    [3] => 3\n)\n', '/apc_pre_reg/sysadmin/edit_user_role.php'),
(706, '::1', 'root', '2016-12-12 23:18:03', 'Query executed: DELETE FROM user_passport WHERE username IN (''krlagman'')', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(707, '::1', 'root', '2016-12-12 23:18:03', 'Query executed: INSERT `user_passport` SELECT ''krlagman'', `link_id` FROM user_role_links WHERE role_id=''3''', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(708, '::1', 'root', '2016-12-12 23:18:05', 'Pressed cancel button', '/apc_pre_reg/sysadmin/role_permissions_cascade.php'),
(709, '::1', 'root', '2016-12-13 00:27:07', 'Logged out', '/apc_pre_reg/end.php'),
(710, '::1', 'root', '2016-12-14 00:13:03', 'Logged in', '/apc_pre_reg/login.php'),
(711, '::1', 'root', '2016-12-14 00:13:08', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(712, '::1', 'root', '2016-12-14 00:13:15', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(713, '::1', 'root', '2016-12-14 00:13:26', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(714, '::1', 'root', '2016-12-14 00:13:33', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(715, '::1', 'root', '2016-12-14 00:13:38', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(716, '::1', 'root', '2016-12-14 00:13:49', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(717, '::1', 'root', '2016-12-14 00:13:50', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(718, '::1', 'root', '2016-12-14 00:13:52', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(719, '::1', 'root', '2016-12-14 00:22:50', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(720, '::1', 'root', '2016-12-14 00:22:52', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(721, '::1', 'root', '2016-12-14 00:22:52', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n    [5] => \n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(722, '::1', 'root', '2016-12-14 00:22:52', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(723, '::1', 'root', '2016-12-14 00:22:56', 'Logged out', '/apc_pre_reg/end.php'),
(724, '::1', 'krlagman', '2016-12-14 00:23:01', 'Logged in', '/apc_pre_reg/login.php'),
(725, '::1', 'krlagman', '2016-12-14 00:23:02', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(726, '::1', 'krlagman', '2016-12-14 00:23:07', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(727, '::1', 'krlagman', '2016-12-14 00:23:13', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(728, '::1', 'krlagman', '2016-12-14 00:23:21', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(729, '::1', 'krlagman', '2016-12-14 00:23:23', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(730, '::1', 'krlagman', '2016-12-14 00:23:24', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n    [5] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(731, '::1', 'krlagman', '2016-12-14 00:23:24', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 2\n    [3] => 3\n    [4] => 2\n    [5] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(732, '::1', 'krlagman', '2016-12-14 00:23:24', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(733, '::1', 'root', '2016-12-14 13:50:49', 'Logged in', '/apc_pre_reg/login.php'),
(734, '::1', 'root', '2016-12-14 13:50:56', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(735, '::1', 'root', '2016-12-14 13:51:01', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(736, '::1', 'root', '2016-12-14 13:51:05', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(737, '::1', 'root', '2016-12-14 13:51:05', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n    [5] => \n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(738, '::1', 'root', '2016-12-14 13:51:06', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(739, '::1', 'root', '2016-12-14 13:51:36', 'Logged out', '/apc_pre_reg/end.php'),
(740, '::1', 'krlagman', '2016-12-14 13:51:42', 'Logged in', '/apc_pre_reg/login.php'),
(741, '::1', 'krlagman', '2016-12-14 13:51:45', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(742, '::1', 'krlagman', '2016-12-14 13:51:53', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''1''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(743, '::1', 'krlagman', '2016-12-14 13:51:59', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(744, '::1', 'krlagman', '2016-12-14 13:52:37', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(745, '::1', 'krlagman', '2016-12-14 13:52:37', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 1\n    [3] => 2\n    [4] => 1\n    [5] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(746, '::1', 'krlagman', '2016-12-14 13:52:38', 'Query Executed: INSERT INTO pre_reg_request(pre_reg_request_id, subject_id, section_id, schedule_id, student_id) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiii\n    [1] => \n    [2] => 2\n    [3] => 3\n    [4] => 2\n    [5] => 1\n)\n', '/apc_pre_reg/modules/custom/add_subject.php'),
(747, '::1', 'krlagman', '2016-12-14 13:52:38', 'Pressed submit button', '/apc_pre_reg/modules/custom/add_subject.php'),
(748, '::1', 'krlagman', '2016-12-14 13:53:35', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(749, '::1', 'krlagman', '2016-12-14 13:54:12', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''3''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(750, '::1', 'krlagman', '2016-12-14 13:55:19', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(751, '::1', 'krlagman', '2016-12-14 13:55:22', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php');
INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(752, '::1', 'krlagman', '2016-12-14 13:55:25', 'Query executed: SELECT 	subject.subject_code,\r\n								subject.subject_name,\r\n								subject.subject_unit,\r\n                                subject.subject_id,\r\n                                section.section_id,\r\n								section.section_name,\r\n                                schedule.schedule_id,\r\n								schedule.schedule_day,\r\n								schedule.schedule_from,\r\n								schedule.schedule_to\r\n\r\n              FROM 	subject_offering\r\n\r\n              LEFT JOIN 	subject\r\n              ON 			subject.subject_id = subject_offering.subject_id\r\n\r\n              LEFT JOIN   section\r\n              ON 			section.section_id = subject_offering.section_id\r\n\r\n              LEFT JOIN	schedule\r\n              ON			schedule.schedule_id = subject_offering.schedule_id\r\n\r\n              WHERE       subject.subject_id LIKE ''2''\r\n			        AND		      section.section_id LIKE ''2''\r\n\r\n              ', '/apc_pre_reg/modules/custom/add_subject.php'),
(753, '::1', 'krlagman', '2016-12-14 14:14:56', 'Logged out', '/apc_pre_reg/end.php'),
(754, '::1', 'root', '2016-12-14 14:15:00', 'Logged in', '/apc_pre_reg/login.php'),
(755, '::1', 'root', '2016-12-14 14:19:08', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(756, '::1', 'root', '2016-12-14 14:19:10', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(757, '::1', 'root', '2016-12-14 14:20:56', 'Pressed cancel button', '/apc_pre_reg/modules/flowchart/flowchart/add_flowchart.php'),
(758, '::1', 'root', '2016-12-14 14:21:51', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(759, '::1', 'root', '2016-12-14 14:31:32', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(760, '::1', 'root', '2016-12-14 14:40:32', 'Pressed submit button', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(761, '::1', 'root', '2016-12-14 14:40:33', 'Query Executed: INSERT INTO flowchart_header(flowchart_header_id, flowchart_id, student_id, course_id, school_year) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => iiiis\n    [1] => \n    [2] => 1\n    [3] => 1\n    [4] => 1\n    [5] => 2016\n)\n', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(762, '::1', 'root', '2016-12-14 14:40:33', 'Query Executed: INSERT INTO flowchart_details(flowchart_details_id, flowchart_header_id, term_id, subject_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 2\n    [3] => 86\n    [4] => 1\n)\n', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(763, '::1', 'root', '2016-12-14 14:40:33', 'Query Executed: INSERT INTO flowchart_details(flowchart_details_id, flowchart_header_id, term_id, subject_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 2\n    [3] => 86\n    [4] => 2\n)\n', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(764, '::1', 'root', '2016-12-14 14:40:33', 'Query Executed: INSERT INTO flowchart_details(flowchart_details_id, flowchart_header_id, term_id, subject_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 2\n    [3] => 86\n    [4] => 3\n)\n', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(765, '::1', 'root', '2016-12-14 14:40:33', 'Query Executed: INSERT INTO flowchart_details(flowchart_details_id, flowchart_header_id, term_id, subject_id) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => iiii\n    [1] => \n    [2] => 2\n    [3] => 86\n    [4] => 4\n)\n', '/apc_pre_reg/modules/flowchart/flowchart_header/add_flowchart_header.php'),
(766, '::1', 'krlagman', '2016-12-14 14:41:26', 'Logged in', '/apc_pre_reg/login.php'),
(767, '::1', 'krlagman', '2016-12-14 14:41:28', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(768, '::1', 'root', '2016-12-14 14:43:45', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(769, '::1', 'root', '2016-12-14 14:46:30', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(770, '::1', 'root', '2016-12-14 14:49:23', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(771, '::1', 'root', '2016-12-14 14:51:33', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(772, '::1', 'root', '2016-12-14 14:59:27', 'Pressed cancel button', '/apc_pre_reg/sysadmin/add_person.php'),
(773, '::1', 'root', '2016-12-14 14:59:32', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(774, '::1', 'root', '2016-12-14 15:08:40', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(775, '::1', 'root', '2016-12-14 15:11:42', 'Pressed cancel button', '/apc_pre_reg/sysadmin/add_person.php'),
(776, '::1', 'root', '2016-12-14 15:13:41', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php'),
(777, '::1', 'root', '2016-12-14 15:18:50', 'Query executed: SELECT subject_offering_id FROM subject_offering WHERE subject_offering_id = ''0''', '/apc_pre_reg/modules/custom/add_subject.php');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting`, `value`) VALUES
('Max Attachment Height', '0'),
('Max Attachment Size (MB)', '0'),
('Max Attachment Width', '0'),
('Security Level', 'HIGH');

-- --------------------------------------------------------

--
-- Table structure for table `system_skins`
--

CREATE TABLE `system_skins` (
  `skin_id` int(11) NOT NULL,
  `skin_name` varchar(255) NOT NULL,
  `header` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `master_css` varchar(255) NOT NULL,
  `colors_css` varchar(255) NOT NULL,
  `fonts_css` varchar(255) NOT NULL,
  `override_css` varchar(255) NOT NULL,
  `icon_set` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_skins`
--

INSERT INTO `system_skins` (`skin_id`, `skin_name`, `header`, `footer`, `master_css`, `colors_css`, `fonts_css`, `override_css`, `icon_set`) VALUES
(1, 'Cobalt Default', 'skins/default_header.php', 'skins/default_footer.php', 'cobalt_master.css', 'cobalt_colors.css', 'cobalt_fonts.css', 'cobalt_override.css', 'cobalt'),
(2, 'Cobalt Minimal', 'skins/minimal_header.php', 'skins/minimal_footer.php', 'cobalt_minimal.css', 'cobalt_minimal.css', 'cobalt_minimal.css', 'cobalt_minimal.css', 'cobalt'),
(3, 'After Sunset', 'skins/default_header.php', 'skins/default_footer.php', 'after_sunset_master.css', 'after_sunset_colors.css', 'after_sunset_fonts.css', 'after_sunset_override.css', 'cobalt'),
(4, 'Hello There', 'skins/default_header.php', 'skins/default_footer.php', 'hello_there_master.css', 'hello_there_colors.css', 'hello_there_fonts.css', 'hello_there_override.css', 'cobalt'),
(5, 'Gold Titanium', 'skins/default_header.php', 'skins/default_footer.php', 'gold_titanium_master.css', 'gold_titanium_colors.css', 'gold_titanium_fonts.css', 'gold_titanium_override.css', 'cobalt'),
(6, 'Summer Rain', 'skins/default_header.php', 'skins/default_footer.php', 'summer_rain_master.css', 'summer_rain_colors.css', 'summer_rain_fonts.css', 'summer_rain_override.css', 'cobalt'),
(7, 'Salmon Impression', 'skins/default_header.php', 'skins/default_footer.php', 'salmon_impression_master.css', 'salmon_impression_colors.css', 'salmon_impression_fonts.css', 'salmon_impression_override.css', 'cobalt'),
(8, 'Royal Amethyst', 'skins/default_header.php', 'skins/default_footer.php', 'royal_amethyst_master.css', 'royal_amethyst_colors.css', 'royal_amethyst_fonts.css', 'royal_amethyst_override.css', 'cobalt'),
(9, 'Red Decadence', 'skins/default_header.php', 'skins/default_footer.php', 'red_decadence_master.css', 'red_decadence_colors.css', 'red_decadence_fonts.css', 'red_decadence_override.css', 'cobalt'),
(10, 'Modern Eden', 'skins/default_header.php', 'skins/default_footer.php', 'modern_eden_master.css', 'modern_eden_colors.css', 'modern_eden_fonts.css', 'modern_eden_override.css', 'cobalt'),
(11, 'Warm Teal', 'skins/default_header.php', 'skins/default_footer.php', 'warm_teal_master.css', 'warm_teal_colors.css', 'warm_teal_fonts.css', 'warm_teal_override.css', 'cobalt'),
(12, 'Purple Rain', 'skins/default_header.php', 'skins/default_footer.php', 'purple_rain_master.css', 'purple_rain_colors.css', 'purple_rain_fonts.css', 'purple_rain_override.css', 'cobalt');

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `term_id` int(11) NOT NULL,
  `school_year` year(4) NOT NULL,
  `term` varchar(255) NOT NULL,
  `term_start` date NOT NULL,
  `term_end` date NOT NULL,
  `reg_start` date NOT NULL,
  `reg_end` date NOT NULL,
  `install1` date NOT NULL,
  `install2` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Masterlist of Term Schedule';

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`term_id`, `school_year`, `term`, `term_start`, `term_end`, `reg_start`, `reg_end`, `install1`, `install2`) VALUES
(1, 1993, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(2, 1993, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(3, 1993, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(4, 1994, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(5, 1994, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(6, 1994, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(7, 1995, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(8, 1995, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(9, 1995, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(10, 1996, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(11, 1996, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(12, 1996, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(13, 1997, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(14, 1997, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(15, 1997, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(16, 1998, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(17, 1998, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(18, 1998, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(19, 1999, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(20, 1999, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(21, 1999, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(22, 2000, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(23, 2000, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(24, 2000, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(25, 2001, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(26, 2001, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(27, 2001, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(28, 2002, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(29, 2002, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(30, 2002, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(31, 2003, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(32, 2003, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(33, 2003, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(34, 1998, 'S', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(35, 2004, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(36, 2004, '2', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(37, 2004, '3', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(38, 2005, '1', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(39, 2005, '2', '2005-09-14', '2005-12-22', '2005-11-15', '2005-12-01', '0000-00-00', '0000-00-00'),
(40, 2005, '3', '2006-01-09', '2006-04-19', '2006-03-13', '2006-03-31', '0000-00-00', '0000-00-00'),
(41, 1999, 'S', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(42, 2000, 'S', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(43, 2006, 'S', '2007-04-23', '2007-05-17', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(44, 2006, '1', '2006-06-05', '2006-09-08', '2006-08-08', '2006-08-24', '0000-00-00', '0000-00-00'),
(45, 2006, '2', '2006-09-16', '2006-12-22', '2006-11-21', '2006-12-08', '0000-00-00', '0000-00-00'),
(46, 2006, '3', '2007-01-10', '2007-04-19', '2007-03-14', '2007-03-28', '0000-00-00', '0000-00-00'),
(47, 2003, 'S', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(48, 2005, 'S', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(49, 2007, '1', '2007-06-06', '2007-09-10', '2007-08-07', '2007-08-22', '0000-00-00', '0000-00-00'),
(50, 2007, '2', '2007-09-17', '2007-12-19', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(51, 2007, '3', '2008-01-09', '2008-04-17', '2007-11-20', '2007-12-07', '0000-00-00', '0000-00-00'),
(53, 2008, '1', '2008-06-02', '2008-09-16', '2008-08-05', '2008-08-19', '0000-00-00', '0000-00-00'),
(52, 2007, 'S', '2008-04-23', '2008-05-16', '2008-04-19', '2008-04-19', '0000-00-00', '0000-00-00'),
(54, 2008, '2', '2008-09-17', '2008-12-19', '2008-08-05', '2008-08-22', '0000-00-00', '0000-00-00'),
(55, 2008, '3', '2009-01-06', '2009-04-12', '2008-01-01', '2008-01-06', '0000-00-00', '0000-00-00'),
(56, 2008, 'S', '2009-04-27', '2009-05-23', '2009-05-18', '2009-05-23', '0000-00-00', '0000-00-00'),
(57, 2009, '1', '2009-06-04', '2009-09-14', '2009-08-04', '2009-08-19', '0000-00-00', '0000-00-00'),
(58, 2009, '2', '2009-09-22', '2010-01-23', '2009-09-01', '2009-09-14', '0000-00-00', '0000-00-00'),
(59, 2009, '3', '2010-01-25', '2010-05-03', '2009-12-01', '2009-12-16', '0000-00-00', '0000-00-00'),
(61, 2010, '1', '2010-05-31', '2010-09-08', '2010-03-30', '2010-04-17', '2010-07-10', '2010-08-31'),
(60, 2009, 'S', '2010-05-12', '2010-05-29', '2010-05-11', '2010-05-15', '0000-00-00', '0000-00-00'),
(62, 2010, '2', '2010-09-15', '2010-12-22', '2010-08-10', '2010-08-25', '2010-10-25', '2010-12-15'),
(63, 2010, '3', '2011-01-10', '2011-04-16', '2011-03-15', '2011-03-31', '2011-02-16', '2011-04-01'),
(65, 2011, '1', '2011-05-27', '2011-09-13', '2011-03-17', '2011-03-26', '2011-07-16', '2011-09-03'),
(64, 2010, 'S', '2011-04-15', '2011-05-20', '2011-04-30', '2011-05-15', '0000-00-00', '0000-00-00'),
(75, 2013, '2', '2013-09-14', '2013-12-21', '2013-08-05', '2013-08-17', '2013-10-26', '2013-12-17'),
(66, 2011, '2', '2011-09-13', '2011-12-23', '2011-08-16', '2011-08-31', '2011-10-29', '2011-12-16'),
(67, 2011, '3', '2012-01-05', '2012-04-19', '2011-11-22', '2011-12-06', '2012-02-17', '2012-04-12'),
(68, 2011, 'S', '2011-04-23', '2011-05-21', '1999-11-30', '1999-11-30', '0000-00-00', '0000-00-00'),
(69, 2012, '1', '2012-05-29', '2012-09-10', '1999-11-30', '1999-11-30', '2012-07-14', '2012-09-03'),
(70, 2012, '2', '2012-09-11', '2012-12-22', '2012-08-06', '2012-08-18', '2012-10-25', '2012-12-14'),
(73, 2012, '3', '2013-01-07', '2013-05-15', '2012-11-19', '2012-11-29', '2013-02-16', '2013-04-13'),
(74, 2013, '1', '2013-06-05', '2013-09-20', '2013-03-18', '2013-03-27', '2013-07-16', '2013-09-03'),
(76, 2013, '3', '2014-01-03', '2014-04-28', '2013-11-23', '2013-12-04', '2014-02-22', '2014-04-11'),
(77, 2014, '1', '2014-05-09', '2014-09-08', '2014-03-17', '2014-03-29', '2014-07-12', '2014-08-30'),
(78, 2013, 'S', '2014-04-28', '2014-05-21', '2014-04-23', '2014-04-27', '0000-00-00', '0000-00-00'),
(79, 2014, '2', '2014-09-11', '2015-01-04', '2014-11-22', '2014-12-05', '2014-10-28', '2014-12-13'),
(80, 2014, '3', '2015-01-05', '2015-04-22', '2015-03-16', '2015-03-28', '2015-02-20', '2015-04-13'),
(81, 2014, 'S', '2015-04-24', '2015-06-02', '2015-01-15', '2015-01-30', '0000-00-00', '0000-00-00'),
(82, 2015, '1', '2015-06-03', '2015-09-12', '2015-03-16', '2015-03-28', '2015-07-10', '2015-08-28'),
(83, 2015, '2', '2015-09-16', '2016-01-06', '2015-08-03', '2015-08-15', '2015-10-31', '2015-12-16'),
(84, 2015, '3', '2016-01-18', '2016-04-22', '2015-11-23', '2015-12-07', '2016-02-29', '2016-04-19'),
(85, 2015, 'S', '2016-04-27', '2016-05-20', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00'),
(86, 2016, '1', '2016-06-06', '2016-09-09', '2016-03-21', '2016-04-02', '2016-07-16', '2016-09-03'),
(87, 2016, '2', '2016-09-19', '2017-01-03', '2016-08-08', '2016-08-20', '2016-10-29', '2016-12-17'),
(88, 2016, '3', '2017-01-09', '2017-04-19', '2016-11-21', '2016-12-05', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `iteration` int(11) NOT NULL,
  `method` varchar(255) NOT NULL,
  `person_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `skin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `salt`, `iteration`, `method`, `person_id`, `role_id`, `skin_id`) VALUES
('krlagman', '$2y$12$EeufHfozRAKW8y69U80twerkft2yyZvzpPkYABfa927AGv6PG21ii', 'EeufHfozRAKW8y69U80twg', 12, 'blowfish', 2, 3, 1),
('root', '$2y$12$RsaU2REfFREvr0s6WJclhuBB3vQTnsqAzCCg1pN5U6DNFTdYEVUC.', 'RsaU2REfFREvr0s6WJclhw', 12, 'blowfish', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_links`
--

CREATE TABLE `user_links` (
  `link_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `descriptive_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `passport_group_id` int(11) NOT NULL,
  `show_in_tasklist` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_links`
--

INSERT INTO `user_links` (`link_id`, `name`, `target`, `descriptive_title`, `description`, `passport_group_id`, `show_in_tasklist`, `status`, `icon`, `priority`) VALUES
(1, 'Module Control', 'sysadmin/module_control.php', 'Module Control', 'Enable or disable system modules', 2, 'Yes', 'On', 'modulecontrol.png', 0),
(2, 'Set User Passports', 'sysadmin/set_user_passports.php', 'Set User Passports', 'Change the passport settings of system users', 2, 'Yes', 'On', 'passport.png', 0),
(3, 'Security Monitor', 'sysadmin/security_monitor.php', 'Security Monitor', 'Examine the system log', 2, 'Yes', 'On', 'security3.png', 0),
(4, 'Add person', 'sysadmin/add_person.php', 'Add Person', '', 2, 'No', 'On', 'form.png', 0),
(5, 'Edit person', 'sysadmin/edit_person.php', 'Edit Person', '', 2, 'No', 'On', 'form.png', 0),
(6, 'View person', 'sysadmin/listview_person.php', 'Person', '', 2, 'Yes', 'On', 'persons.png', 0),
(7, 'Delete person', 'sysadmin/delete_person.php', 'Delete Person', '', 2, 'No', 'On', 'form.png', 0),
(8, 'Add user', 'sysadmin/add_user.php', 'Add User', '', 2, 'No', 'On', 'form.png', 0),
(9, 'Edit user', 'sysadmin/edit_user.php', 'Edit User', '', 2, 'No', 'On', 'form.png', 0),
(10, 'View user', 'sysadmin/listview_user.php', 'User', '', 2, 'Yes', 'On', 'card.png', 0),
(11, 'Delete user', 'sysadmin/delete_user.php', 'Delete User', '', 2, 'No', 'On', 'form.png', 0),
(12, 'Add user role', 'sysadmin/add_user_role.php', 'Add User Role', '', 2, 'No', 'On', 'form.png', 0),
(13, 'Edit user role', 'sysadmin/edit_user_role.php', 'Edit User Role', '', 2, 'No', 'On', 'form.png', 0),
(14, 'View user role', 'sysadmin/listview_user_role.php', 'User Roles', '', 2, 'Yes', 'On', 'roles.png', 0),
(15, 'Delete user role', 'sysadmin/delete_user_role.php', 'Delete User Role', '', 2, 'No', 'On', 'form.png', 0),
(16, 'Add system settings', 'sysadmin/add_system_settings.php', 'Add System Settings', '', 2, 'No', 'On', 'form.png', 0),
(17, 'Edit system settings', 'sysadmin/edit_system_settings.php', 'Edit System Settings', '', 2, 'No', 'On', 'form.png', 0),
(18, 'View system settings', 'sysadmin/listview_system_settings.php', 'System Settings', '', 2, 'Yes', 'On', 'system_settings.png', 0),
(19, 'Delete system settings', 'sysadmin/delete_system_settings.php', 'Delete System Settings', '', 2, 'No', 'On', 'form.png', 0),
(20, 'Add user links', 'sysadmin/add_user_links.php', 'Add User Links', '', 2, 'No', 'On', 'form.png', 0),
(21, 'Edit user links', 'sysadmin/edit_user_links.php', 'Edit User Links', '', 2, 'No', 'On', 'form.png', 0),
(22, 'View user links', 'sysadmin/listview_user_links.php', 'User Links', '', 2, 'Yes', 'On', 'links.png', 0),
(23, 'Delete user links', 'sysadmin/delete_user_links.php', 'Delete User Links', '', 2, 'No', 'On', 'form.png', 0),
(24, 'Add user passport groups', 'sysadmin/add_user_passport_groups.php', 'Add User Passport Groups', '', 2, 'No', 'On', 'form.png', 0),
(25, 'Edit user passport groups', 'sysadmin/edit_user_passport_groups.php', 'Edit User Passport Groups', '', 2, 'No', 'On', 'form.png', 0),
(26, 'View user passport groups', 'sysadmin/listview_user_passport_groups.php', 'User Passport Groups', '', 2, 'Yes', 'On', 'passportgroup.png', 0),
(27, 'Delete user passport groups', 'sysadmin/delete_user_passport_groups.php', 'Delete User Passport Groups', '', 2, 'No', 'On', 'form.png', 0),
(28, 'Add system skins', 'sysadmin/add_system_skins.php', 'Add System Skins', '', 2, 'No', 'On', 'form.png', 0),
(29, 'Edit system skins', 'sysadmin/edit_system_skins.php', 'Edit System Skins', '', 2, 'No', 'On', 'form.png', 0),
(30, 'View system skins', 'sysadmin/listview_system_skins.php', 'System Skins', '', 2, 'Yes', 'On', 'system_skins.png', 0),
(31, 'Delete system skins', 'sysadmin/delete_system_skins.php', 'Delete System Skins', '', 2, 'No', 'On', 'form.png', 0),
(32, 'Reset Password', 'sysadmin/reset_password.php', 'Reset Password', '', 2, 'Yes', 'On', 'lock_big.png', 0),
(33, 'Add cobalt sst', 'sst/add_cobalt_sst.php', 'Add Cobalt SST', '', 2, 'No', 'On', 'form3.png', 0),
(34, 'Edit cobalt sst', 'sst/edit_cobalt_sst.php', 'Edit Cobalt SST', '', 2, 'No', 'On', 'form3.png', 0),
(35, 'View cobalt sst', 'sst/listview_cobalt_sst.php', 'Cobalt SST', '', 2, 'Yes', 'On', 'form3.png', 0),
(36, 'Delete cobalt sst', 'sst/delete_cobalt_sst.php', 'Delete Cobalt SST', '', 2, 'No', 'On', 'form3.png', 0),
(37, 'Add course', 'modules/course/add_course.php', 'Add Course', '', 3, 'No', 'On', 'form3.png', 0),
(38, 'Edit course', 'modules/course/edit_course.php', 'Edit Course', '', 3, 'No', 'On', 'form3.png', 0),
(39, 'View course', 'modules/course/listview_course.php', 'Course', '', 3, 'Yes', 'On', 'form3.png', 0),
(40, 'Delete course', 'modules/course/delete_course.php', 'Delete Course', '', 3, 'No', 'On', 'form3.png', 0),
(41, 'Add department', 'modules/department/add_department.php', 'Add Department', '', 3, 'No', 'On', 'form3.png', 0),
(42, 'Edit department', 'modules/department/edit_department.php', 'Edit Department', '', 3, 'No', 'On', 'form3.png', 0),
(43, 'View department', 'modules/department/listview_department.php', 'Department', '', 3, 'Yes', 'On', 'form3.png', 0),
(44, 'Delete department', 'modules/department/delete_department.php', 'Delete Department', '', 3, 'No', 'On', 'form3.png', 0),
(45, 'Add schedule', 'modules/schedule/add_schedule.php', 'Add Schedule', '', 1, 'No', 'On', 'form3.png', 0),
(46, 'Edit schedule', 'modules/schedule/edit_schedule.php', 'Edit Schedule', '', 1, 'No', 'On', 'form3.png', 0),
(47, 'View schedule', 'modules/schedule/listview_schedule.php', 'Schedule', '', 1, 'Yes', 'On', 'form3.png', 0),
(48, 'Delete schedule', 'modules/schedule/delete_schedule.php', 'Delete Schedule', '', 1, 'No', 'On', 'form3.png', 0),
(49, 'Add section', 'modules/section/add_section.php', 'Add Section', '', 3, 'No', 'On', 'form3.png', 0),
(50, 'Edit section', 'modules/section/edit_section.php', 'Edit Section', '', 3, 'No', 'On', 'form3.png', 0),
(51, 'View section', 'modules/section/listview_section.php', 'Section', '', 3, 'Yes', 'On', 'form3.png', 0),
(52, 'Delete section', 'modules/section/delete_section.php', 'Delete Section', '', 3, 'No', 'On', 'form3.png', 0),
(53, 'Add student', 'modules/student/student/add_student.php', 'Add Student', '', 1, 'No', 'On', 'form3.png', 0),
(54, 'Edit student', 'modules/student/student/edit_student.php', 'Edit Student', '', 1, 'No', 'On', 'form3.png', 0),
(55, 'View student', 'modules/student/student/listview_student.php', 'Student', '', 1, 'Yes', 'On', 'form3.png', 0),
(56, 'Delete student', 'modules/student/student/delete_student.php', 'Delete Student', '', 1, 'No', 'On', 'form3.png', 0),
(57, 'Add subject', 'modules/subject/subject/add_subject.php', 'Add Subject', '', 3, 'No', 'On', 'form3.png', 0),
(58, 'Edit subject', 'modules/subject/subject/edit_subject.php', 'Edit Subject', '', 3, 'No', 'On', 'form3.png', 0),
(59, 'View subject', 'modules/subject/subject/listview_subject.php', 'Subject', '', 3, 'Yes', 'On', 'form3.png', 0),
(60, 'Delete subject', 'modules/subject/subject/delete_subject.php', 'Delete Subject', '', 3, 'No', 'On', 'form3.png', 0),
(61, 'Add subject offering', 'modules/subject/subject_offering/add_subject_offering.php', 'Add Subject Offering', '', 1, 'No', 'On', 'form3.png', 0),
(62, 'Edit subject offering', 'modules/subject/subject_offering/edit_subject_offering.php', 'Edit Subject Offering', '', 1, 'No', 'On', 'form3.png', 0),
(63, 'View subject offering', 'modules/subject/subject_offering/listview_subject_offering.php', 'Subject Offering', '', 1, 'Yes', 'On', 'form3.png', 0),
(64, 'Delete subject offering', 'modules/subject/subject_offering/delete_subject_offering.php', 'Delete Subject Offering', '', 1, 'No', 'On', 'form3.png', 0),
(65, 'Add term', 'modules/term/add_term.php', 'Add Term', '', 3, 'No', 'On', 'form3.png', 0),
(66, 'Edit term', 'modules/term/edit_term.php', 'Edit Term', '', 3, 'No', 'On', 'form3.png', 0),
(67, 'View term', 'modules/term/listview_term.php', 'Term', '', 3, 'Yes', 'On', 'form3.png', 0),
(68, 'Delete term', 'modules/term/delete_term.php', 'Delete Term', '', 3, 'No', 'On', 'form3.png', 0),
(69, 'Add flowchart', 'modules/flowchart/flowchart/add_flowchart.php', 'Add Flowchart', 'x', 3, 'No', 'On', 'form3.png', 0),
(70, 'Edit flowchart', 'modules/flowchart/flowchart/edit_flowchart.php', 'Edit Flowchart', 'x', 3, 'No', 'On', 'form3.png', 0),
(71, 'Delete flowchart', 'modules/flowchart/flowchart/delete_flowchart.php', 'Delete Flowchart', 'x', 3, 'No', 'On', 'form3.png', 0),
(72, 'View flowchart', 'modules/flowchart/flowchart/listview_flowchart.php', 'Flowchart', 'x', 3, 'Yes', 'On', 'form3.png', 0),
(73, 'Add flowchart header', 'modules/flowchart/flowchart_header/add_flowchart_header.php', 'Add Flowchart Header', 'x', 1, 'No', 'On', 'form3.png', 0),
(74, 'Edit flowchart header', 'modules/flowchart/flowchart_header/edit_flowchart_header.php', 'Edit Flowchart Header', 'x', 1, 'No', 'On', 'form3.png', 0),
(75, 'Delete flowchart header', 'modules/flowchart/flowchart_header/delete_flowchart_header.php', 'Delete Flowchart Header', 'x', 1, 'No', 'On', 'form3.png', 0),
(76, 'View flowchart header', 'modules/flowchart/flowchart_header/listview_flowchart_header.php', 'Flowchart Header', 'x', 1, 'Yes', 'On', 'form3.png', 0),
(77, 'Add flowchart details', 'modules/flowchart/flowchart_details/add_flowchart_details.php', 'Add Flowchart Details', 'x', 1, 'No', 'On', 'form3.png', 0),
(78, 'Edit flowchart details', 'modules/flowchart/flowchart_details/edit_flowchart_details.php', 'Edit Flowchart Details', 'x', 1, 'No', 'On', 'form3.png', 0),
(79, 'Delete flowchart details', 'modules/flowchart/flowchart_details/delete_flowchart_details.php', 'Delete Flowchart Details', 'x', 1, 'No', 'On', 'form3.png', 0),
(80, 'View flowchart details', 'modules/flowchart/flowchart_details/listview_flowchart_details.php', 'Flowchart Details', 'x', 1, 'Yes', 'On', 'form3.png', 0),
(81, 'Add subject', 'modules/custom/add_subject.php', 'Add/Remove Subject', 'X', 4, 'Yes', 'On', 'form3.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_passport`
--

CREATE TABLE `user_passport` (
  `username` varchar(255) NOT NULL,
  `link_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_passport`
--

INSERT INTO `user_passport` (`username`, `link_id`) VALUES
('krlagman', 81),
('root', 1),
('root', 2),
('root', 3),
('root', 4),
('root', 5),
('root', 6),
('root', 7),
('root', 8),
('root', 9),
('root', 10),
('root', 11),
('root', 12),
('root', 13),
('root', 14),
('root', 15),
('root', 16),
('root', 17),
('root', 18),
('root', 19),
('root', 20),
('root', 21),
('root', 22),
('root', 23),
('root', 24),
('root', 25),
('root', 26),
('root', 27),
('root', 28),
('root', 29),
('root', 30),
('root', 31),
('root', 32),
('root', 33),
('root', 34),
('root', 35),
('root', 36),
('root', 37),
('root', 38),
('root', 39),
('root', 40),
('root', 41),
('root', 42),
('root', 43),
('root', 44),
('root', 45),
('root', 46),
('root', 47),
('root', 48),
('root', 49),
('root', 50),
('root', 51),
('root', 52),
('root', 53),
('root', 54),
('root', 55),
('root', 56),
('root', 57),
('root', 58),
('root', 59),
('root', 60),
('root', 61),
('root', 62),
('root', 63),
('root', 64),
('root', 65),
('root', 66),
('root', 67),
('root', 68),
('root', 69),
('root', 70),
('root', 71),
('root', 72),
('root', 73),
('root', 74),
('root', 75),
('root', 76),
('root', 77),
('root', 78),
('root', 79),
('root', 80),
('root', 81);

-- --------------------------------------------------------

--
-- Table structure for table `user_passport_groups`
--

CREATE TABLE `user_passport_groups` (
  `passport_group_id` int(11) NOT NULL,
  `passport_group` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_passport_groups`
--

INSERT INTO `user_passport_groups` (`passport_group_id`, `passport_group`, `priority`, `icon`) VALUES
(1, 'Default', 0, 'blue_folder3.png'),
(2, 'Admin', 0, 'preferences-system.png'),
(3, 'Setup Tables', 10, 'blue_folder3.png'),
(4, 'Custom Page', 9, 'blue_folder3.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role`, `description`) VALUES
(1, 'Super Admin', 'Super admin role with 100% system privileges'),
(2, 'System Admin', 'System admin role with all sysadmin permissions'),
(3, 'Student', 'Add or remove subject');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_links`
--

CREATE TABLE `user_role_links` (
  `role_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role_links`
--

INSERT INTO `user_role_links` (`role_id`, `link_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(3, 81);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approver`
--
ALTER TABLE `approver`
  ADD PRIMARY KEY (`approver_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `cobalt_reporter`
--
ALTER TABLE `cobalt_reporter`
  ADD PRIMARY KEY (`module_name`,`report_name`);

--
-- Indexes for table `cobalt_sst`
--
ALTER TABLE `cobalt_sst`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `dept_id` (`department_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `flowchart`
--
ALTER TABLE `flowchart`
  ADD PRIMARY KEY (`flowchart_id`);

--
-- Indexes for table `flowchart_details`
--
ALTER TABLE `flowchart_details`
  ADD PRIMARY KEY (`flowchart_details_id`),
  ADD KEY `flowchart_header_id` (`flowchart_header_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `flowchart_header`
--
ALTER TABLE `flowchart_header`
  ADD PRIMARY KEY (`flowchart_header_id`),
  ADD KEY `flowchart_id` (`flowchart_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `pre_reg_request_details`
--
ALTER TABLE `pre_reg_request_details`
  ADD PRIMARY KEY (`pre_reg_request_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `pre_reg_request_header_id` (`pre_reg_request_header_id`);

--
-- Indexes for table `pre_reg_request_header`
--
ALTER TABLE `pre_reg_request_header`
  ADD PRIMARY KEY (`pre_reg_request_header_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `subject_offering`
--
ALTER TABLE `subject_offering`
  ADD PRIMARY KEY (`subject_offering_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `system_log`
--
ALTER TABLE `system_log`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting`);

--
-- Indexes for table `system_skins`
--
ALTER TABLE `system_skins`
  ADD PRIMARY KEY (`skin_id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`term_id`),
  ADD UNIQUE KEY `school_year` (`school_year`,`term`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user_links`
--
ALTER TABLE `user_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `user_passport`
--
ALTER TABLE `user_passport`
  ADD PRIMARY KEY (`username`,`link_id`);

--
-- Indexes for table `user_passport_groups`
--
ALTER TABLE `user_passport_groups`
  ADD PRIMARY KEY (`passport_group_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user_role_links`
--
ALTER TABLE `user_role_links`
  ADD PRIMARY KEY (`role_id`,`link_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approver`
--
ALTER TABLE `approver`
  MODIFY `approver_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cobalt_sst`
--
ALTER TABLE `cobalt_sst`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `flowchart`
--
ALTER TABLE `flowchart`
  MODIFY `flowchart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `flowchart_details`
--
ALTER TABLE `flowchart_details`
  MODIFY `flowchart_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `flowchart_header`
--
ALTER TABLE `flowchart_header`
  MODIFY `flowchart_header_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pre_reg_request_details`
--
ALTER TABLE `pre_reg_request_details`
  MODIFY `pre_reg_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pre_reg_request_header`
--
ALTER TABLE `pre_reg_request_header`
  MODIFY `pre_reg_request_header_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `subject_offering`
--
ALTER TABLE `subject_offering`
  MODIFY `subject_offering_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `system_log`
--
ALTER TABLE `system_log`
  MODIFY `entry_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;
--
-- AUTO_INCREMENT for table `system_skins`
--
ALTER TABLE `system_skins`
  MODIFY `skin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `user_links`
--
ALTER TABLE `user_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `user_passport_groups`
--
ALTER TABLE `user_passport_groups`
  MODIFY `passport_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
