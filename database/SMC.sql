-- --------------------------------------------------------
-- Host:                         lcpbq9az4jklobvq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com
-- Server version:               8.0.23 - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for vsvldnmhaa4x6nx0
DROP DATABASE IF EXISTS `vsvldnmhaa4x6nx0`;
CREATE DATABASE IF NOT EXISTS `vsvldnmhaa4x6nx0` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vsvldnmhaa4x6nx0`;

-- Dumping structure for table vsvldnmhaa4x6nx0.branches
DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `branch_code` varchar(50) NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `country` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table vsvldnmhaa4x6nx0.branches: ~3 rows (approximately)
REPLACE INTO `branches` (`id`, `branch_code`, `street`, `city`, `state`, `zip_code`, `country`, `contact`, `date_created`) VALUES
	(1, 'vzTL0PqMogyOWhF', 'China Unichem ind. L', '', '', '', '', '', '2022-07-14 13:27:34'),
	(2, 'KyIab3mYBgAX71t', 'Heinrich Christen', '', '', '', '', '', '2022-07-14 13:27:34'),
	(3, 'dIbUK5mEh96f0Zc', 'Sunny Success int.', '', '', '', '', '', '2022-07-14 13:27:34'),
	(4, 'KyIab3mYBgAX71t', 'Curacao Trading', '', '', '', '', '', '2022-07-14 13:27:34'),
	(5, 'KyIab3mYBgAX71t', 'Global Wax LLC', '', '', '', '', '', '2022-07-14 13:27:34'),
	(6, 'KyIab3mYBgAX71t', 'Sao Visitor', '', '', '', '', '', '2022-07-14 13:27:34'),
	(7, 'KyIab3mYBgAX71t', 'Hci Wax', '', '', '', '', '', '2022-07-14 13:27:34'),
	(8, 'KyIab3mYBgAX71t', 'Tranpak', '', '', '', '', '', '2022-07-14 13:27:34'),
	(9, 'KyIab3mYBgAX71t', 'Brascera S.A', '', '', '', '', '', '2022-07-14 13:27:34'),
	(10, 'KyIab3mYBgAX71t', 'Masterank Global L.', '', '', '', '', '', '2022-07-14 13:27:34'),
	(11, 'KyIab3mYBgAX71t', 'All American', '', '', '', '', '', '2022-07-14 13:27:34'),
	(12, 'KyIab3mYBgAX71t', 'Fortunare', '', '', '', '', '', '2022-07-14 13:27:34'),
	(13, 'KyIab3mYBgAX71t', 'AM WAX, INC.', '', '', '', '', '', '2022-07-14 13:27:34'),
	(14, 'KyIab3mYBgAX71t', 'Mexim  S.A', '', '', '', '', '', '2022-07-14 13:27:34');

-- Dumping structure for table vsvldnmhaa4x6nx0.parcels
DROP TABLE IF EXISTS `parcels`;
CREATE TABLE IF NOT EXISTS `parcels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(100) NOT NULL,
  `sender_name` text NOT NULL,
  `sender_address` text NOT NULL,
  `sender_contact` text NOT NULL,
  `recipient_name` text NOT NULL,
  `recipient_address` text NOT NULL,
  `recipient_contact` text NOT NULL,
  `type` int NOT NULL COMMENT '1 = Deliver, 2=Pickup',
  `from_branch_id` varchar(30) NOT NULL,
  `to_branch_id` varchar(30) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `height` varchar(100) NOT NULL,
  `width` varchar(100) NOT NULL,
  `length` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table vsvldnmhaa4x6nx0.parcels: ~2 rows (approximately)

-- Dumping structure for table vsvldnmhaa4x6nx0.parcel_tracks
DROP TABLE IF EXISTS `parcel_tracks`;
CREATE TABLE IF NOT EXISTS `parcel_tracks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parcel_id` int NOT NULL,
  `status` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table vsvldnmhaa4x6nx0.parcel_tracks: ~10 rows (approximately)
REPLACE INTO `parcel_tracks` (`id`, `parcel_id`, `status`, `date_created`) VALUES
	(11, 9, 4, '2022-07-14 13:46:12');

-- Dumping structure for table vsvldnmhaa4x6nx0.system_settings
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table vsvldnmhaa4x6nx0.system_settings: ~0 rows (approximately)
REPLACE INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
	(1, 'Sistema de Manejo de Contenedores', 'info@josepaiewonsky.com', '809-575-1512', 'Avenida Estrella Sadhala #84, Santiago, República Dominicana', '');

-- Dumping structure for table vsvldnmhaa4x6nx0.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1 = admin, 2 = staff',
  `branch_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table vsvldnmhaa4x6nx0.users: ~0 rows (approximately)
REPLACE INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `branch_id`, `date_created`) VALUES
	(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, 0, '2020-11-26 10:57:04');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
