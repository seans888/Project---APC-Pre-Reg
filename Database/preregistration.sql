-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2016 at 07:30 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `preregistration`
--

-- --------------------------------------------------------

--
-- Table structure for table `addsubject`
--

CREATE TABLE `addsubject` (
  `subject_code` varchar(7) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_section` varchar(10) NOT NULL,
  `subject_schedule` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addsubject`
--

INSERT INTO `addsubject` (`subject_code`, `subject_description`, `subject_section`, `subject_schedule`) VALUES
('SYSADD1', 'STRUCTURED SYSTEMS ANALYSIS AND DESIGN 1', 'SS141', '1:00-2:00');

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
  `course` int(5) NOT NULL,
  `course_id` varchar(13) DEFAULT NULL,
  `course_name` varchar(125) NOT NULL,
  `GP_num` enum('Y','N') NOT NULL DEFAULT 'Y',
  `dept_id` varchar(255) NOT NULL,
  `is_offered` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Masterlist of Courses';

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
(2, 'Angel', 'Serrano', 'Ruiz', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `refstudent`
--

CREATE TABLE `refstudent` (
  `student_id` char(11) NOT NULL,
  `student_last_name` varchar(25) NOT NULL,
  `student_first_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `student_middle_name` varchar(25) CHARACTER SET latin1 NOT NULL,
  `birth_date` date NOT NULL DEFAULT '0000-00-00',
  `birth_place` varchar(35) NOT NULL,
  `admission_date` date NOT NULL DEFAULT '0000-00-00',
  `entry_level` enum('Freshman','Transferee','Cross Enrollee','2nd Degree','Graduate School') CHARACTER SET latin1 DEFAULT 'Freshman',
  `admission_credential` varchar(2500) CHARACTER SET latin1 DEFAULT NULL,
  `mail_grades_to` enum('Father','Mother','Guardian','Student') CHARACTER SET latin1 NOT NULL DEFAULT 'Father',
  `exit_level` enum('NA','Graduate','Transferred') CHARACTER SET latin1 DEFAULT 'NA',
  `nationality` enum('Filipino','Others') CHARACTER SET latin1 NOT NULL DEFAULT 'Filipino',
  `gender` enum('Male','Female') CHARACTER SET latin1 NOT NULL DEFAULT 'Male',
  `address` varchar(250) CHARACTER SET latin1 NOT NULL,
  `postal_code` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `tel_num` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `mobile_num` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `religion` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `civil_status` enum('Single','Married','Separated','Widowed') CHARACTER SET latin1 NOT NULL DEFAULT 'Single',
  `box_num` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Masterlist of Student Main Profile';

-- --------------------------------------------------------

--
-- Table structure for table `refsubjectofferingdtl`
--

CREATE TABLE `refsubjectofferingdtl` (
  `subject_offering_id` int(5) NOT NULL,
  `time` char(17) DEFAULT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  `day` char(3) DEFAULT NULL,
  `room` varchar(5) NOT NULL,
  `room_type` enum('Lec','Lab') NOT NULL DEFAULT 'Lec'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Schedule Detail';

-- --------------------------------------------------------

--
-- Table structure for table `refsubjectofferinghdr`
--

CREATE TABLE `refsubjectofferinghdr` (
  `subject_offering_id` int(11) NOT NULL,
  `term_id` int(5) NOT NULL,
  `subject_id` int(5) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `subject_code` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='List of Subjects Offered per Term';

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

CREATE TABLE `system_log` (
  `entry_id` bigint(20) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `datetime` int(11) NOT NULL,
  `action` mediumtext NOT NULL,
  `module` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`entry_id`, `ip_address`, `user`, `datetime`, `action`, `module`) VALUES
(1, '::1', 'root', 1471883306, 'Logged in', '/preregistration/login.php'),
(2, '::1', 'root', 1471883306, 'Query Executed: UPDATE user SET `password`=?, `salt`=?, `iteration`=?, `method`=? WHERE username=?\r\nArray\n(\n    [0] => ssiss\n    [1] => $2y$12$qJ8015HERw6pQNeMOwkkRuiPcKOlj8AGCm8ttU1BFPJ4iQO9z6E5y\n    [2] => qJ8015HERw6pQNeMOwkkRw\n    [3] => 12\n    [4] => blowfish\n    [5] => root\n)\n', '/preregistration/login.php'),
(3, '::1', 'root', 1471883326, 'Query executed: UPDATE user SET skin_id=''7'' WHERE username=''root''', '/preregistration/change_skin.php'),
(4, '::1', 'root', 1471883384, 'Pressed submit button', '/preregistration/sysadmin/add_person.php'),
(5, '::1', 'root', 1471883384, 'Query Executed: INSERT INTO person(person_id, first_name, middle_name, last_name, gender) VALUES(?,?,?,?,?)\r\nArray\n(\n    [0] => issss\n    [1] => \n    [2] => Angel\n    [3] => Serrano\n    [4] => Ruiz\n    [5] => Female\n)\n', '/preregistration/sysadmin/add_person.php'),
(6, '::1', 'root', 1471883412, 'Pressed submit button', '/preregistration/sysadmin/add_user.php'),
(7, '::1', 'root', 1471883413, 'Query Executed: INSERT INTO user(username, password, salt, iteration, method, person_id, role_id, skin_id) VALUES(?,?,?,?,?,?,?,?)\r\nArray\n(\n    [0] => sssisiii\n    [1] => asruiz\n    [2] => $2y$12$xGEJ6gDh5H3TB9mIC5gb1uLrjLN61DXQ5zStEScvfT9r9CemM6FtS\n    [3] => xGEJ6gDh5H3TB9mIC5gb1w\n    [4] => 12\n    [5] => blowfish\n    [6] => 2\n    [7] => \n    [8] => 7\n)\n', '/preregistration/sysadmin/add_user.php'),
(8, '::1', 'root', 1471883447, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz'' AND link_id IN (''37'',''38'',''39'',''40'',''41'',''42'',''43'',''44'',''45'',''46'',''47'',''48'',''49'',''50'',''51'',''52'',''53'',''54'',''55'',''56'',''57'',''58'',''59'',''60'',''61'',''62'',''63'',''64'')', '/preregistration/sysadmin/set_user_passports.php'),
(9, '::1', 'root', 1471883448, 'Query executed: INSERT INTO user_passport(username, link_id) VALUES(''asruiz'', ''37'')', '/preregistration/sysadmin/set_user_passports.php'),
(10, '::1', 'root', 1471883448, 'Query executed: UPDATE user SET role_id=''0'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(11, '::1', 'root', 1471883456, 'Logged out', '/preregistration/end.php'),
(12, '::1', 'asruiz', 1471883463, 'Logged in', '/preregistration/login.php'),
(13, '::1', 'asruiz', 1471883474, 'Logged out', '/preregistration/end.php'),
(14, '::1', 'root', 1471883478, 'Logged in', '/preregistration/login.php'),
(15, '::1', 'root', 1471883487, 'Pressed submit button', '/preregistration/sysadmin/edit_user.php'),
(16, '::1', 'root', 1471883487, 'Query Executed: UPDATE user SET username = ?, person_id = ?, role_id = ?, skin_id = ? WHERE username = ?\r\nArray\n(\n    [0] => siiis\n    [1] => asruiz\n    [2] => 2\n    [3] => 1\n    [4] => 7\n    [5] => asruiz\n)\n', '/preregistration/sysadmin/edit_user.php'),
(17, '::1', 'root', 1471883487, 'Query executed: DELETE FROM user_passport WHERE username = ''asruiz''', '/preregistration/sysadmin/edit_user.php'),
(18, '::1', 'root', 1471883487, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''1''', '/preregistration/sysadmin/edit_user.php'),
(19, '::1', 'root', 1471883492, 'Logged out', '/preregistration/end.php'),
(20, '::1', 'asruiz', 1471883497, 'Logged in', '/preregistration/login.php'),
(21, '::1', 'asruiz', 1471883510, 'Logged out', '/preregistration/end.php'),
(22, '::1', 'root', 1471883519, 'Logged in', '/preregistration/login.php'),
(23, '::1', 'root', 1471883536, 'Pressed submit button', '/preregistration/sysadmin/edit_user.php'),
(24, '::1', 'root', 1471883537, 'Query Executed: UPDATE user SET username = ?, person_id = ?, role_id = ?, skin_id = ? WHERE username = ?\r\nArray\n(\n    [0] => siiis\n    [1] => asruiz\n    [2] => 2\n    [3] => \n    [4] => 7\n    [5] => asruiz\n)\n', '/preregistration/sysadmin/edit_user.php'),
(25, '::1', 'root', 1471883549, 'Pressed submit button', '/preregistration/sysadmin/add_user_role.php'),
(26, '::1', 'root', 1471883558, 'Pressed submit button', '/preregistration/sysadmin/add_user_role.php'),
(27, '::1', 'root', 1471883558, 'Query Executed: INSERT INTO user_role(role_id, role, description) VALUES(?,?,?)\r\nArray\n(\n    [0] => iss\n    [1] => \n    [2] => Student\n    [3] => Only adding of subjects\n)\n', '/preregistration/sysadmin/add_user_role.php'),
(28, '::1', 'root', 1471883570, 'Query executed: DELETE FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/role_permissions.php'),
(29, '::1', 'root', 1471883570, 'Query executed: INSERT INTO user_role_links(role_id, link_id) VALUES(''3'', ''37'')', '/preregistration/sysadmin/role_permissions.php'),
(30, '::1', 'root', 1471883578, 'Pressed submit button', '/preregistration/sysadmin/edit_user.php'),
(31, '::1', 'root', 1471883579, 'Query Executed: UPDATE user SET username = ?, person_id = ?, role_id = ?, skin_id = ? WHERE username = ?\r\nArray\n(\n    [0] => siiis\n    [1] => asruiz\n    [2] => 2\n    [3] => 3\n    [4] => 7\n    [5] => asruiz\n)\n', '/preregistration/sysadmin/edit_user.php'),
(32, '::1', 'root', 1471883579, 'Query executed: DELETE FROM user_passport WHERE username = ''asruiz''', '/preregistration/sysadmin/edit_user.php'),
(33, '::1', 'root', 1471883579, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/edit_user.php'),
(34, '::1', 'root', 1471883582, 'Logged out', '/preregistration/end.php'),
(35, '::1', 'asruiz', 1471883586, 'Logged in', '/preregistration/login.php'),
(36, '::1', 'asruiz', 1471883595, 'Logged out', '/preregistration/end.php'),
(37, '::1', 'root', 1471883599, 'Logged in', '/preregistration/login.php'),
(38, '::1', 'root', 1471883649, 'Pressed cancel button', '/preregistration/sysadmin/add_user_passport_groups.php'),
(39, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(40, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(41, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(42, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(43, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(44, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(45, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(46, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(47, '::1', 'root', 1471883698, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(48, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(49, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(50, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(51, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(52, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(53, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(54, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(55, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(56, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(57, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(58, '::1', 'root', 1471883699, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(59, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(60, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(61, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(62, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(63, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(64, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(65, '::1', 'root', 1471883700, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(66, '::1', 'root', 1471883729, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz'' AND link_id IN (''37'',''38'',''39'',''40'',''41'',''42'',''43'',''44'',''45'',''46'',''47'',''48'',''49'',''50'',''51'',''52'',''53'',''54'',''55'',''56'',''57'',''58'',''59'',''60'',''61'',''62'',''63'',''64'')', '/preregistration/sysadmin/set_user_passports.php'),
(67, '::1', 'root', 1471883729, 'Query executed: INSERT INTO user_passport(username, link_id) VALUES(''asruiz'', ''37'')', '/preregistration/sysadmin/set_user_passports.php'),
(68, '::1', 'root', 1471883729, 'Query executed: UPDATE user SET role_id=''0'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(69, '::1', 'root', 1471883747, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports3.php'),
(70, '::1', 'root', 1471883747, 'Query executed: UPDATE user SET role_id=''3'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports3.php'),
(71, '::1', 'root', 1471883747, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/set_user_passports3.php'),
(72, '::1', 'root', 1471883758, 'Logged out', '/preregistration/end.php'),
(73, '::1', 'asruiz', 1471883763, 'Logged in', '/preregistration/login.php'),
(74, '::1', 'asruiz', 1471883772, 'Logged out', '/preregistration/end.php'),
(75, '::1', 'root', 1471883777, 'Logged in', '/preregistration/login.php'),
(76, '::1', 'root', 1471883814, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(77, '::1', 'root', 1471883814, 'Query executed: INSERT INTO user_passport(username, link_id) VALUES(''asruiz'', ''37''),(''asruiz'', ''33''),(''asruiz'', ''41''),(''asruiz'', ''4''),(''asruiz'', ''45''),(''asruiz'', ''49''),(''asruiz'', ''53''),(''asruiz'', ''16''),(''asruiz'', ''28''),(''asruiz'', ''8''),(''asruiz'', ''20''),(''asruiz'', ''24''),(''asruiz'', ''12''),(''asruiz'', ''57''),(''asruiz'', ''61''),(''asruiz'', ''39''),(''asruiz'', ''35''),(''asruiz'', ''43''),(''asruiz'', ''40''),(''asruiz'', ''36''),(''asruiz'', ''44''),(''asruiz'', ''7''),(''asruiz'', ''48''),(''asruiz'', ''52''),(''asruiz'', ''56''),(''asruiz'', ''19''),(''asruiz'', ''31''),(''asruiz'', ''11''),(''asruiz'', ''23''),(''asruiz'', ''27''),(''asruiz'', ''15''),(''asruiz'', ''60''),(''asruiz'', ''64''),(''asruiz'', ''38''),(''asruiz'', ''34''),(''asruiz'', ''42''),(''asruiz'', ''5''),(''asruiz'', ''46''),(''asruiz'', ''50''),(''asruiz'', ''54''),(''asruiz'', ''17''),(''asruiz'', ''29''),(''asruiz'', ''9''),(''asruiz'', ''21''),(''asruiz'', ''25''),(''asruiz'', ''13''),(''asruiz'', ''58''),(''asruiz'', ''62''),(''asruiz'', ''1''),(''asruiz'', ''6''),(''asruiz'', ''47''),(''asruiz'', ''51''),(''asruiz'', ''55''),(''asruiz'', ''32''),(''asruiz'', ''3''),(''asruiz'', ''2''),(''asruiz'', ''18''),(''asruiz'', ''30''),(''asruiz'', ''10''),(''asruiz'', ''22''),(''asruiz'', ''26''),(''asruiz'', ''14''),(''asruiz'', ''59''),(''asruiz'', ''63'')', '/preregistration/sysadmin/set_user_passports.php'),
(78, '::1', 'root', 1471883814, 'Query executed: UPDATE user SET role_id=''0'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(79, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(80, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(81, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(82, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(83, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(84, '::1', 'root', 1471883859, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(85, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(86, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(87, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(88, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(89, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(90, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(91, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(92, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(93, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(94, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(95, '::1', 'root', 1471883860, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(96, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(97, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(98, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(99, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(100, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(101, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(102, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(103, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(104, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(105, '::1', 'root', 1471883861, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(106, '::1', 'root', 1471883885, 'Pressed submit button', '/preregistration/sysadmin/add_user_passport_groups.php'),
(107, '::1', 'root', 1471883892, 'Pressed submit button', '/preregistration/sysadmin/add_user_passport_groups.php'),
(108, '::1', 'root', 1471883892, 'Query Executed: INSERT INTO user_passport_groups(passport_group_id, passport_group, priority, icon) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isis\n    [1] => \n    [2] => Student\n    [3] => 0\n    [4] => icon.png\n)\n', '/preregistration/sysadmin/add_user_passport_groups.php'),
(109, '::1', 'root', 1471883902, 'Pressed submit button', '/preregistration/sysadmin/edit_user.php'),
(110, '::1', 'root', 1471883902, 'Query Executed: UPDATE user SET username = ?, person_id = ?, role_id = ?, skin_id = ? WHERE username = ?\r\nArray\n(\n    [0] => siiis\n    [1] => asruiz\n    [2] => 2\n    [3] => 3\n    [4] => 7\n    [5] => asruiz\n)\n', '/preregistration/sysadmin/edit_user.php'),
(111, '::1', 'root', 1471883902, 'Query executed: DELETE FROM user_passport WHERE username = ''asruiz''', '/preregistration/sysadmin/edit_user.php'),
(112, '::1', 'root', 1471883902, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/edit_user.php'),
(113, '::1', 'root', 1471883946, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports3.php'),
(114, '::1', 'root', 1471883946, 'Query executed: UPDATE user SET role_id=''3'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports3.php'),
(115, '::1', 'root', 1471883946, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/set_user_passports3.php'),
(116, '::1', 'root', 1471883976, 'Pressed delete button', '/preregistration/sysadmin/delete_user_passport_groups.php'),
(117, '::1', 'root', 1471883976, 'Query Executed: DELETE FROM user_passport_groups WHERE passport_group_id = ?\r\nArray\n(\n    [0] => i\n    [1] => 3\n)\n', '/preregistration/sysadmin/delete_user_passport_groups.php'),
(118, '::1', 'root', 1471883983, 'Pressed submit button', '/preregistration/sysadmin/edit_user.php'),
(119, '::1', 'root', 1471883983, 'Query Executed: UPDATE user SET username = ?, person_id = ?, role_id = ?, skin_id = ? WHERE username = ?\r\nArray\n(\n    [0] => siiis\n    [1] => asruiz\n    [2] => 2\n    [3] => 3\n    [4] => 7\n    [5] => asruiz\n)\n', '/preregistration/sysadmin/edit_user.php'),
(120, '::1', 'root', 1471883984, 'Query executed: DELETE FROM user_passport WHERE username = ''asruiz''', '/preregistration/sysadmin/edit_user.php'),
(121, '::1', 'root', 1471883984, 'Query executed: INSERT `user_passport` SELECT ''asruiz'', `link_id` FROM user_role_links WHERE role_id=''3''', '/preregistration/sysadmin/edit_user.php'),
(122, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(123, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(124, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(125, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(126, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(127, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(128, '::1', 'root', 1471883999, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(129, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(130, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(131, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(132, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(133, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(134, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(135, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(136, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(137, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(138, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(139, '::1', 'root', 1471884000, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(140, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(141, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(142, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(143, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(144, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(145, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(146, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(147, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(148, '::1', 'root', 1471884001, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(149, '::1', 'root', 1471884019, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz'' AND link_id IN (''37'',''38'',''39'',''40'',''41'',''42'',''43'',''44'',''45'',''46'',''47'',''48'',''49'',''50'',''51'',''52'',''53'',''54'',''55'',''56'',''57'',''58'',''59'',''60'',''61'',''62'',''63'',''64'')', '/preregistration/sysadmin/set_user_passports.php'),
(150, '::1', 'root', 1471884019, 'Query executed: INSERT INTO user_passport(username, link_id) VALUES(''asruiz'', ''37'')', '/preregistration/sysadmin/set_user_passports.php'),
(151, '::1', 'root', 1471884019, 'Query executed: UPDATE user SET role_id=''0'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(152, '::1', 'root', 1471884075, 'ILLEGAL ACCESS ATTEMPT - Tried to access ''/preregistration/modules/modules/listview_addsubject.php'' without sufficient privileges.', '/preregistration/modules/modules/listview_addsubject.php'),
(153, '::1', 'root', 1471884086, 'Logged in', '/preregistration/login.php'),
(154, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(155, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(156, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(157, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(158, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(159, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(160, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(161, '::1', 'root', 1471884097, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(162, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(163, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(164, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(165, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(166, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(167, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(168, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(169, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(170, '::1', 'root', 1471884098, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(171, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(172, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(173, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(174, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(175, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(176, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(177, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(178, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(179, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(180, '::1', 'root', 1471884099, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(181, '::1', 'root', 1471884122, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(182, '::1', 'root', 1471884122, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(183, '::1', 'root', 1471884122, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(184, '::1', 'root', 1471884122, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(185, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(186, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(187, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(188, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(189, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(190, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(191, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(192, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(193, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(194, '::1', 'root', 1471884123, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(195, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(196, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(197, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(198, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(199, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(200, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(201, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(202, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(203, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(204, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(205, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(206, '::1', 'root', 1471884124, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(207, '::1', 'root', 1471884125, 'Query executed: UPDATE user_links SET status=''Off'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(208, '::1', 'root', 1471884134, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''41''', '/preregistration/sysadmin/module_control.php'),
(209, '::1', 'root', 1471884134, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''45''', '/preregistration/sysadmin/module_control.php'),
(210, '::1', 'root', 1471884134, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''49''', '/preregistration/sysadmin/module_control.php'),
(211, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''53''', '/preregistration/sysadmin/module_control.php'),
(212, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''57''', '/preregistration/sysadmin/module_control.php'),
(213, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''61''', '/preregistration/sysadmin/module_control.php'),
(214, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''39''', '/preregistration/sysadmin/module_control.php'),
(215, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''43''', '/preregistration/sysadmin/module_control.php'),
(216, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''40''', '/preregistration/sysadmin/module_control.php'),
(217, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''44''', '/preregistration/sysadmin/module_control.php'),
(218, '::1', 'root', 1471884135, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''48''', '/preregistration/sysadmin/module_control.php'),
(219, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''52''', '/preregistration/sysadmin/module_control.php'),
(220, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''56''', '/preregistration/sysadmin/module_control.php'),
(221, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''60''', '/preregistration/sysadmin/module_control.php'),
(222, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''64''', '/preregistration/sysadmin/module_control.php'),
(223, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''38''', '/preregistration/sysadmin/module_control.php'),
(224, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''42''', '/preregistration/sysadmin/module_control.php'),
(225, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''46''', '/preregistration/sysadmin/module_control.php'),
(226, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''50''', '/preregistration/sysadmin/module_control.php'),
(227, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''54''', '/preregistration/sysadmin/module_control.php'),
(228, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''58''', '/preregistration/sysadmin/module_control.php'),
(229, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''62''', '/preregistration/sysadmin/module_control.php'),
(230, '::1', 'root', 1471884136, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''47''', '/preregistration/sysadmin/module_control.php'),
(231, '::1', 'root', 1471884137, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''51''', '/preregistration/sysadmin/module_control.php'),
(232, '::1', 'root', 1471884137, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''55''', '/preregistration/sysadmin/module_control.php'),
(233, '::1', 'root', 1471884137, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''59''', '/preregistration/sysadmin/module_control.php'),
(234, '::1', 'root', 1471884137, 'Query executed: UPDATE user_links SET status=''On'' WHERE link_id=''63''', '/preregistration/sysadmin/module_control.php'),
(235, '::1', 'root', 1471884158, 'Pressed cancel button', '/preregistration/sysadmin/reporter_user_passport_groups.php'),
(236, '::1', 'root', 1471884162, 'Pressed cancel button', '/preregistration/sysadmin/csv_user_passport_groups.php'),
(237, '::1', 'root', 1471884165, 'Pressed cancel button', '/preregistration/sysadmin/edit_user_passport_groups.php'),
(238, '::1', 'root', 1471884227, 'Pressed submit button', '/preregistration/sysadmin/add_user_passport_groups.php'),
(239, '::1', 'root', 1471884227, 'Query Executed: INSERT INTO user_passport_groups(passport_group_id, passport_group, priority, icon) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => isis\n    [1] => \n    [2] => Student\n    [3] => 0\n    [4] => icon.png\n)\n', '/preregistration/sysadmin/add_user_passport_groups.php'),
(240, '::1', 'root', 1471884278, 'Pressed submit button', '/preregistration/sysadmin/edit_user_links.php'),
(241, '::1', 'root', 1471884278, 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => Add addsubject\n    [2] => modules/modules/add_addsubject.php\n    [3] => Add Addsubject\n    [4] => \n    [5] => 4\n    [6] => No\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 37\n)\n', '/preregistration/sysadmin/edit_user_links.php'),
(242, '::1', 'root', 1471884287, 'Pressed submit button', '/preregistration/sysadmin/edit_user_links.php'),
(243, '::1', 'root', 1471884287, 'Query Executed: UPDATE user_links SET name = ?, target = ?, descriptive_title = ?, description = ?, passport_group_id = ?, show_in_tasklist = ?, status = ?, icon = ?, priority = ? WHERE link_id = ?\r\nArray\n(\n    [0] => ssssisssii\n    [1] => View addsubject\n    [2] => modules/modules/listview_addsubject.php\n    [3] => Addsubject\n    [4] => \n    [5] => 4\n    [6] => Yes\n    [7] => On\n    [8] => form3.png\n    [9] => 0\n    [10] => 39\n)\n', '/preregistration/sysadmin/edit_user_links.php'),
(244, '::1', 'root', 1471884302, 'Query executed: DELETE FROM user_passport WHERE username=''asruiz'' AND link_id IN (''37'',''39'')', '/preregistration/sysadmin/set_user_passports.php'),
(245, '::1', 'root', 1471884302, 'Query executed: INSERT INTO user_passport(username, link_id) VALUES(''asruiz'', ''37''),(''asruiz'', ''39'')', '/preregistration/sysadmin/set_user_passports.php'),
(246, '::1', 'root', 1471884303, 'Query executed: UPDATE user SET role_id=''0'' WHERE username=''asruiz''', '/preregistration/sysadmin/set_user_passports.php'),
(247, '::1', 'root', 1471884318, 'Logged out', '/preregistration/end.php'),
(248, '::1', 'asruiz', 1471884322, 'Logged in', '/preregistration/login.php'),
(249, '::1', 'asruiz', 1471884334, 'Pressed submit button', '/preregistration/modules/modules/add_addsubject.php'),
(250, '::1', 'asruiz', 1471884339, 'Pressed cancel button', '/preregistration/modules/modules/add_addsubject.php'),
(251, '::1', 'asruiz', 1471884607, 'Pressed submit button', '/preregistration/modules/modules/add_addsubject.php'),
(252, '::1', 'asruiz', 1471884607, 'Query Executed: INSERT INTO addsubject(subject_code, subject_description, subject_section, subject_schedule) VALUES(?,?,?,?)\r\nArray\n(\n    [0] => ssss\n    [1] => SYSADD1\n    [2] => STRUCTURED SYSTEMS ANALYSIS AND DESIGN 1\n    [3] => SS141\n    [4] => 1:00-2:00\n)\n', '/preregistration/modules/modules/add_addsubject.php'),
(253, '::1', 'asruiz', 1471884642, 'Logged out', '/preregistration/end.php'),
(254, '::1', 'root', 1471884647, 'Logged in', '/preregistration/login.php');

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
(10, 'Modern Eden', 'skins/default_header.php', 'skins/default_footer.php', 'modern_eden_master.css', 'modern_eden_colors.css', 'modern_eden_fonts.css', 'modern_eden_override.css', 'cobalt');

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
('asruiz', '$2y$12$xGEJ6gDh5H3TB9mIC5gb1uLrjLN61DXQ5zStEScvfT9r9CemM6FtS', 'xGEJ6gDh5H3TB9mIC5gb1w', 12, 'blowfish', 2, 0, 7),
('root', '$2y$12$qJ8015HERw6pQNeMOwkkRuiPcKOlj8AGCm8ttU1BFPJ4iQO9z6E5y', 'qJ8015HERw6pQNeMOwkkRw', 12, 'blowfish', 1, 1, 7);

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
(37, 'Add addsubject', 'modules/modules/add_addsubject.php', 'Add Addsubject', '', 4, 'No', 'On', 'form3.png', 0),
(38, 'Edit addsubject', 'modules/modules/edit_addsubject.php', 'Edit Addsubject', '', 1, 'No', 'On', 'form3.png', 0),
(39, 'View addsubject', 'modules/modules/listview_addsubject.php', 'Addsubject', '', 4, 'Yes', 'On', 'form3.png', 0),
(40, 'Delete addsubject', 'modules/modules/delete_addsubject.php', 'Delete Addsubject', '', 1, 'No', 'On', 'form3.png', 0),
(41, 'Add course', 'modules/modules/add_course.php', 'Add Course', '', 1, 'No', 'On', 'form3.png', 0),
(42, 'Edit course', 'modules/modules/edit_course.php', 'Edit Course', '', 1, 'No', 'On', 'form3.png', 0),
(43, 'View course', 'modules/modules/listview_course.php', 'Course', '', 1, 'Yes', 'On', 'form3.png', 0),
(44, 'Delete course', 'modules/modules/delete_course.php', 'Delete Course', '', 1, 'No', 'On', 'form3.png', 0),
(45, 'Add refstudent', 'modules/modules/add_refstudent.php', 'Add Refstudent', '', 1, 'No', 'On', 'form3.png', 0),
(46, 'Edit refstudent', 'modules/modules/edit_refstudent.php', 'Edit Refstudent', '', 1, 'No', 'On', 'form3.png', 0),
(47, 'View refstudent', 'modules/modules/listview_refstudent.php', 'Refstudent', '', 1, 'Yes', 'On', 'form3.png', 0),
(48, 'Delete refstudent', 'modules/modules/delete_refstudent.php', 'Delete Refstudent', '', 1, 'No', 'On', 'form3.png', 0),
(49, 'Add refsubjectofferingdtl', 'modules/modules/add_refsubjectofferingdtl.php', 'Add Refsubjectofferingdtl', '', 1, 'No', 'On', 'form3.png', 0),
(50, 'Edit refsubjectofferingdtl', 'modules/modules/edit_refsubjectofferingdtl.php', 'Edit Refsubjectofferingdtl', '', 1, 'No', 'On', 'form3.png', 0),
(51, 'View refsubjectofferingdtl', 'modules/modules/listview_refsubjectofferingdtl.php', 'Refsubjectofferingdtl', '', 1, 'Yes', 'On', 'form3.png', 0),
(52, 'Delete refsubjectofferingdtl', 'modules/modules/delete_refsubjectofferingdtl.php', 'Delete Refsubjectofferingdtl', '', 1, 'No', 'On', 'form3.png', 0),
(53, 'Add refsubjectofferinghdr', 'modules/modules/add_refsubjectofferinghdr.php', 'Add Refsubjectofferinghdr', '', 1, 'No', 'On', 'form3.png', 0),
(54, 'Edit refsubjectofferinghdr', 'modules/modules/edit_refsubjectofferinghdr.php', 'Edit Refsubjectofferinghdr', '', 1, 'No', 'On', 'form3.png', 0),
(55, 'View refsubjectofferinghdr', 'modules/modules/listview_refsubjectofferinghdr.php', 'Refsubjectofferinghdr', '', 1, 'Yes', 'On', 'form3.png', 0),
(56, 'Delete refsubjectofferinghdr', 'modules/modules/delete_refsubjectofferinghdr.php', 'Delete Refsubjectofferinghdr', '', 1, 'No', 'On', 'form3.png', 0),
(57, 'Add xrefstudentcourse', 'modules/modules/add_xrefstudentcourse.php', 'Add Xrefstudentcourse', '', 1, 'No', 'On', 'form3.png', 0),
(58, 'Edit xrefstudentcourse', 'modules/modules/edit_xrefstudentcourse.php', 'Edit Xrefstudentcourse', '', 1, 'No', 'On', 'form3.png', 0),
(59, 'View xrefstudentcourse', 'modules/modules/listview_xrefstudentcourse.php', 'Xrefstudentcourse', '', 1, 'Yes', 'On', 'form3.png', 0),
(60, 'Delete xrefstudentcourse', 'modules/modules/delete_xrefstudentcourse.php', 'Delete Xrefstudentcourse', '', 1, 'No', 'On', 'form3.png', 0),
(61, 'Add xrefstudentschedule', 'modules/modules/add_xrefstudentschedule.php', 'Add Xrefstudentschedule', '', 1, 'No', 'On', 'form3.png', 0),
(62, 'Edit xrefstudentschedule', 'modules/modules/edit_xrefstudentschedule.php', 'Edit Xrefstudentschedule', '', 1, 'No', 'On', 'form3.png', 0),
(63, 'View xrefstudentschedule', 'modules/modules/listview_xrefstudentschedule.php', 'Xrefstudentschedule', '', 1, 'Yes', 'On', 'form3.png', 0),
(64, 'Delete xrefstudentschedule', 'modules/modules/delete_xrefstudentschedule.php', 'Delete Xrefstudentschedule', '', 1, 'No', 'On', 'form3.png', 0);

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
('asruiz', 37),
('asruiz', 39),
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
('root', 64);

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
(4, 'Student', 0, 'icon.png');

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
(3, 'Student', 'Only adding of subjects');

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
(3, 37);

-- --------------------------------------------------------

--
-- Table structure for table `xrefstudentcourse`
--

CREATE TABLE `xrefstudentcourse` (
  `student_id` varchar(11) NOT NULL,
  `course_id` varchar(13) NOT NULL DEFAULT '',
  `flowchart` varchar(250) DEFAULT NULL,
  `school_year` year(4) NOT NULL,
  `term` enum('1','2','3','S') DEFAULT '1',
  `is_graduating` enum('No','Yes') NOT NULL DEFAULT 'No',
  `student_status` enum('Enrolled','Withdraw','LOA','Shiftee') NOT NULL DEFAULT 'Enrolled',
  `flow_id` int(5) NOT NULL,
  `course` int(5) NOT NULL,
  `term_id` int(5) NOT NULL,
  `fee` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xrefstudentschedule`
--

CREATE TABLE `xrefstudentschedule` (
  `subject_offering_id` int(9) NOT NULL DEFAULT '0',
  `student_id` varchar(11) NOT NULL,
  `enrollment_status` enum('Dropped','Registered','Enrolled') DEFAULT 'Registered',
  `date` date DEFAULT NULL,
  `term_id` varchar(250) NOT NULL,
  `subject_code` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`course`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `refstudent`
--
ALTER TABLE `refstudent`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `refsubjectofferingdtl`
--
ALTER TABLE `refsubjectofferingdtl`
  ADD UNIQUE KEY `subject_offering_id` (`subject_offering_id`,`time`,`day`,`room`);

--
-- Indexes for table `refsubjectofferinghdr`
--
ALTER TABLE `refsubjectofferinghdr`
  ADD PRIMARY KEY (`subject_offering_id`);

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
-- Indexes for table `xrefstudentcourse`
--
ALTER TABLE `xrefstudentcourse`
  ADD PRIMARY KEY (`student_id`,`course`,`term_id`),
  ADD KEY `student_id` (`student_id`) USING BTREE;

--
-- Indexes for table `xrefstudentschedule`
--
ALTER TABLE `xrefstudentschedule`
  ADD PRIMARY KEY (`subject_offering_id`,`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cobalt_sst`
--
ALTER TABLE `cobalt_sst`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `refsubjectofferinghdr`
--
ALTER TABLE `refsubjectofferinghdr`
  MODIFY `subject_offering_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19098;
--
-- AUTO_INCREMENT for table `system_log`
--
ALTER TABLE `system_log`
  MODIFY `entry_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;
--
-- AUTO_INCREMENT for table `system_skins`
--
ALTER TABLE `system_skins`
  MODIFY `skin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_links`
--
ALTER TABLE `user_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
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
