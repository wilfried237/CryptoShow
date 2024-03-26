-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.3.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cryptoshowdb
CREATE DATABASE IF NOT EXISTS `cryptoshowdb` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `cryptoshowdb`;

-- Dumping structure for table cryptoshowdb.device
CREATE TABLE IF NOT EXISTS `device` (
  `Device_id` int(11) NOT NULL AUTO_INCREMENT,
  `Member_id` int(11) NOT NULL,
  `Thread_id` int(11) NOT NULL,
  `Device_name` varchar(255) NOT NULL,
  `Device_image` blob DEFAULT NULL,
  `Device_description` varchar(255) DEFAULT NULL,
  `Device_registered_timestamp` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `Device_updated_at` varchar(255) DEFAULT current_timestamp(),
  PRIMARY KEY (`Device_id`),
  KEY `Thread_id` (`Thread_id`),
  KEY `Member_id` (`Member_id`),
  CONSTRAINT `device_ibfk_1` FOREIGN KEY (`Thread_id`) REFERENCES `thread` (`Thread_id`),
  CONSTRAINT `device_ibfk_2` FOREIGN KEY (`Member_id`) REFERENCES `member` (`Member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table cryptoshowdb.member
CREATE TABLE IF NOT EXISTS `member` (
  `Member_id` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Passwords` varchar(255) NOT NULL,
  `Surface` int(11) NOT NULL DEFAULT 3,
  `Colour` varchar(255) DEFAULT NULL,
  `Profilepic` blob DEFAULT NULL,
  `Created_at` varchar(255) DEFAULT current_timestamp(),
  `Updated_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Member_id`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Phone` (`Phone`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table cryptoshowdb.member_devices
CREATE TABLE IF NOT EXISTS `member_devices` (
  `Member_id` int(11) NOT NULL,
  `Thread_id` int(11) NOT NULL,
  `Device_id` int(11) NOT NULL,
  `Device_image` blob DEFAULT NULL,
  `Device_description` varchar(255) NOT NULL,
  `Created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `Updated_at` varchar(255) DEFAULT current_timestamp(),
  PRIMARY KEY (`Member_id`,`Thread_id`,`Device_id`),
  KEY `Thread_id` (`Thread_id`),
  KEY `Device_id` (`Device_id`),
  CONSTRAINT `member_devices_ibfk_1` FOREIGN KEY (`Member_id`) REFERENCES `member` (`Member_id`),
  CONSTRAINT `member_devices_ibfk_2` FOREIGN KEY (`Thread_id`) REFERENCES `thread` (`Thread_id`),
  CONSTRAINT `member_devices_ibfk_3` FOREIGN KEY (`Device_id`) REFERENCES `device` (`Device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table cryptoshowdb.organiser_list
CREATE TABLE IF NOT EXISTS `organiser_list` (
  `Organiser_id` int(11) NOT NULL AUTO_INCREMENT,
  `Member_id` int(11) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  PRIMARY KEY (`Organiser_id`),
  UNIQUE KEY `Member_id` (`Member_id`),
  CONSTRAINT `organiser_list_ibfk_1` FOREIGN KEY (`Member_id`) REFERENCES `member` (`Member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table cryptoshowdb.thread
CREATE TABLE IF NOT EXISTS `thread` (
  `Thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `Thread_name` varchar(255) NOT NULL,
  `Thread_date` varchar(255) DEFAULT NULL,
  `Venue` varchar(255) NOT NULL,
  `Member_id` int(11) NOT NULL,
  `Thread_image` blob DEFAULT NULL,
  `Thread_description` varchar(255) NOT NULL,
  `Created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `Updated_at` varchar(255) DEFAULT current_timestamp(),
  `Thread_Limit` int(11) DEFAULT 15,
  PRIMARY KEY (`Thread_id`),
  KEY `Member_id` (`Member_id`),
  CONSTRAINT `thread_ibfk_1` FOREIGN KEY (`Member_id`) REFERENCES `member` (`Member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table cryptoshowdb.thread_register
CREATE TABLE IF NOT EXISTS `thread_register` (
  `Thread_id` int(11) NOT NULL,
  `Member_id` int(11) NOT NULL,
  `Created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Thread_id`,`Member_id`),
  KEY `Member_id` (`Member_id`),
  CONSTRAINT `thread_register_ibfk_1` FOREIGN KEY (`Thread_id`) REFERENCES `thread` (`Thread_id`),
  CONSTRAINT `thread_register_ibfk_2` FOREIGN KEY (`Member_id`) REFERENCES `member` (`Member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
