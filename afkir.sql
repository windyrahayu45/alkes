/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.3.16-MariaDB : Database - db_alkes
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_alkes` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_alkes`;

/*Table structure for table `afkir` */

DROP TABLE IF EXISTS `afkir`;

CREATE TABLE `afkir` (
  `id_afkir` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_afkir`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `afkir` */

insert  into `afkir`(`id_afkir`,`id_barang`,`tgl`,`ket`,`id_petugas`,`created_at`,`created_by`) values 
(6,'KD-0HYZWJ','2023-06-15','rusak bagian karet tidak bisa diperbaiki',7,'2023-06-15 13:30:37',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
