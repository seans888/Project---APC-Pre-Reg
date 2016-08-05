-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2011 at 01:06 AM
-- Server version: 5.1.58
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cobalt`
--

-- --------------------------------------------------------

--
-- Table structure for table `database_connection`
--

CREATE TABLE IF NOT EXISTS `database_connection` (
  `DB_Connection_ID` char(44) NOT NULL,
  `Project_ID` char(44) NOT NULL,
  `DB_Connection_Name` varchar(255) NOT NULL,
  `Hostname` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Database` varchar(255) NOT NULL,
  PRIMARY KEY (`DB_Connection_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `Page_ID` char(44) NOT NULL,
  `Page_Name` varchar(255) NOT NULL,
  `Generator` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`Page_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`Page_ID`, `Page_Name`, `Generator`, `Description`) VALUES
('+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'Add1', 'Add1.php', 'Standard input form'),
('alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'Edit1', 'Edit1.php', 'Standard edit form'),
('AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'DetailView1', 'DetailView1.php', 'Detail View of a record'),
('Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'ListView', 'ListView1.php', 'List View of a table'),
('qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'Delete1', 'Delete1.php', 'Standard record deletion page'),
('DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'CSVExport1', 'CSVExport1.php', 'Standard export data to CSV module'),
('X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'ReporterInterface1', 'ReporterInterface1.php', 'Default "custom reporting tool" interface'),
('/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'ReporterResult1', 'ReporterResult1.php', 'Default "custom reporting tool" result page'),
('EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'ReporterResultPDF1', 'ReporterResultPDF1.php', 'Default "custom reporting tool" PDF result');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `Project_ID` char(44) NOT NULL,
  `Project_Name` varchar(255) NOT NULL,
  `Client_Name` varchar(255) NOT NULL,
  `Project_Description` text NOT NULL,
  `Base_Directory` varchar(255) NOT NULL,
  `Database_Connection_ID` varchar(255) NOT NULL,
  PRIMARY KEY (`Project_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE IF NOT EXISTS `table` (
  `Table_ID` char(44) NOT NULL,
  `Project_ID` char(44) NOT NULL,
  `DB_Connection_ID` varchar(255) NOT NULL,
  `Table_Name` varchar(255) NOT NULL,
  `Remarks` tinytext NOT NULL,
  PRIMARY KEY (`Table_ID`),
  KEY `DB_Connection_ID` (`DB_Connection_ID`),
  KEY `Project_ID` (`Project_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `table_fields`
--

CREATE TABLE IF NOT EXISTS `table_fields` (
  `Field_ID` char(44) NOT NULL,
  `Table_ID` char(44) NOT NULL,
  `Field_Name` varchar(255) NOT NULL,
  `Data_Type` varchar(255) NOT NULL,
  `Nullable` varchar(255) NOT NULL,
  `Length` int(11) NOT NULL,
  `Attribute` varchar(255) NOT NULL,
  `Auto_Increment` char(1) NOT NULL,
  `Control_Type` varchar(255) NOT NULL,
  `Label` varchar(255) NOT NULL,
  `In_Listview` varchar(255) NOT NULL,
  PRIMARY KEY (`Field_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_book_list`
--

CREATE TABLE IF NOT EXISTS `table_fields_book_list` (
  `Field_ID` char(44) NOT NULL,
  `Book_List_Generator` varchar(255) NOT NULL,
  PRIMARY KEY (`Field_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_list`
--

CREATE TABLE IF NOT EXISTS `table_fields_list` (
  `Field_ID` char(44) NOT NULL,
  `List_ID` char(44) NOT NULL,
  PRIMARY KEY (`Field_ID`,`List_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_list_source_select`
--

CREATE TABLE IF NOT EXISTS `table_fields_list_source_select` (
  `Field_ID` char(44) NOT NULL,
  `Auto_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Select_Field_ID` char(44) NOT NULL,
  `Display` varchar(255) NOT NULL,
  PRIMARY KEY (`Field_ID`,`Auto_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_list_source_where`
--

CREATE TABLE IF NOT EXISTS `table_fields_list_source_where` (
  `Field_ID` char(44) NOT NULL,
  `Where_Field_ID` char(44) NOT NULL,
  `Where_Field_Operand` varchar(20) NOT NULL,
  `Where_Field_Value` varchar(200) NOT NULL,
  `Where_Field_Connector` varchar(255) NOT NULL,
  PRIMARY KEY (`Field_ID`,`Where_Field_ID`,`Where_Field_Operand`,`Where_Field_Value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_predefined_list`
--

CREATE TABLE IF NOT EXISTS `table_fields_predefined_list` (
  `List_ID` char(44) NOT NULL,
  `Project_ID` char(44) NOT NULL,
  `List_Name` varchar(255) NOT NULL,
  `Remarks` varchar(255) NOT NULL,
  PRIMARY KEY (`List_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_fields_predefined_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `table_fields_predefined_list_items`
--

CREATE TABLE IF NOT EXISTS `table_fields_predefined_list_items` (
  `List_ID` char(44) NOT NULL,
  `Number` int(11) NOT NULL,
  `List_Item` varchar(255) NOT NULL,
  PRIMARY KEY (`List_ID`,`Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_fields_predefined_list_items`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_fields_secondary_validation`
--

CREATE TABLE IF NOT EXISTS `table_fields_secondary_validation` (
  `Field_ID` char(44) NOT NULL,
  `Validation_Routine` varchar(255) NOT NULL,
  PRIMARY KEY (`Field_ID`,`Validation_Routine`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_pages`
--

CREATE TABLE IF NOT EXISTS `table_pages` (
  `Table_ID` char(44) NOT NULL,
  `Page_ID` char(44) NOT NULL,
  `Path_Filename` varchar(255) NOT NULL,
  PRIMARY KEY (`Table_ID`,`Page_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_relations`
--

CREATE TABLE IF NOT EXISTS `table_relations` (
  `Relation_ID` char(44) NOT NULL,
  `Project_ID` char(44) NOT NULL,
  `Relation` varchar(255) NOT NULL,
  `Parent_Field_ID` char(44) NOT NULL,
  `Child_Field_ID` char(44) NOT NULL,
  `Label` varchar(255) NOT NULL,
  `Child_Field_Subtext` varchar(255) NOT NULL,
  PRIMARY KEY (`Relation_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
