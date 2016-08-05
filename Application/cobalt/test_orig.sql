-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2014 at 08:56 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_orig`
--

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE IF NOT EXISTS `award` (
  `award_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`award_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_short_name` varchar(255) NOT NULL,
  `dept_official_name` varchar(255) NOT NULL,
  `dept_head` varchar(255) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `hiring_date` date NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `salary_grade_id` int(11) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_awards`
--

CREATE TABLE IF NOT EXISTS `employee_awards` (
  `emp_id` varchar(255) NOT NULL,
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` int(11) NOT NULL,
  `date_received` date NOT NULL,
  PRIMARY KEY (`emp_id`,`auto_id`),
  KEY `auto_id` (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_hobbies`
--

CREATE TABLE IF NOT EXISTS `employee_hobbies` (
  `emp_id` varchar(255) NOT NULL,
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `hobby` varchar(255) NOT NULL,
  PRIMARY KEY (`emp_id`,`auto_id`),
  KEY `auto_id` (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `experiments`
--

CREATE TABLE IF NOT EXISTS `experiments` (
  `experiment_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `preliminary_result` varchar(255) NOT NULL,
  `intermediate_result` varchar(255) NOT NULL,
  `final_result` varchar(255) NOT NULL,
  PRIMARY KEY (`experiment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `office_docs`
--

CREATE TABLE IF NOT EXISTS `office_docs` (
  `code_1` char(4) NOT NULL,
  `code_2` char(2) NOT NULL,
  `code_3` char(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file_upload` varchar(255) NOT NULL,
  PRIMARY KEY (`code_1`,`code_2`,`code_3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `salary_grade`
--

CREATE TABLE IF NOT EXISTS `salary_grade` (
  `salary_grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`salary_grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
