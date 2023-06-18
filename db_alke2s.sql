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

/*Table structure for table `data_barang` */

DROP TABLE IF EXISTS `data_barang`;

CREATE TABLE `data_barang` (
  `id_barang` varchar(50) NOT NULL,
  `nama` text DEFAULT NULL,
  `merk` text DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `SN` varchar(30) DEFAULT NULL,
  `tahun` varchar(5) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `link` text DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `data_barang` */

insert  into `data_barang`(`id_barang`,`nama`,`merk`,`type`,`SN`,`tahun`,`harga`,`id_ruangan`,`tgl`,`link`,`id_status`,`created_at`,`created_by`,`updated_at`,`updated_by`,`jenis_barang`) values 
('KD-0HYZWJ','Termometer','Buavita','Indo','123456','2023',12000,3,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',2,'2023-06-15 10:51:05','windisri',NULL,NULL,NULL),
('KD-173TSH','Timbangan','ChocoPi','Lott','12Q','2023',156000,2,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',2,'2023-06-15 10:52:50','windisri',NULL,NULL,NULL),
('KD-27WUVO','Termometer','Buavita','Indo','123456','2023',12000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:51:06','windisri',NULL,NULL,NULL),
('KD-4VJBEB','Timbangan','ChocoPi','Lott','12Q','2023',156000,2,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',2,'2023-06-15 10:52:50','windisri',NULL,NULL,NULL),
('KD-74QDLP','Stetoskop','Philips','1200W','12WA','2023',100000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:03','windisri',NULL,NULL,NULL),
('KD-8322S4','Stetoskop','Philips','1200W','12WA','2023',100000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:03','windisri',NULL,NULL,NULL),
('KD-8J5FJG','Timbangan','ChocoPi','Lott','12Q','2023',156000,2,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:50','windisri',NULL,NULL,NULL),
('KD-A89KLN','Stetoskop','Philips','1200W','12WA','2023',100000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:03','windisri',NULL,NULL,NULL),
('KD-ARB2EV','Termometer','Buavita','Indo','123456','2023',12000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:51:06','windisri',NULL,NULL,NULL),
('KD-GHQXGJ','Timbangan','ChocoPi','Lott','12Q','2023',156000,2,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:50','windisri',NULL,NULL,NULL),
('KD-H6E9W2','Stetoskop','Philips','1200W','12WA','2023',100000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:03','windisri',NULL,NULL,NULL),
('KD-KB4J4Z','Timbangan','ChocoPi','Lott','12Q','2023',156000,2,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:50','windisri',NULL,NULL,NULL),
('KD-KKC8ME','Stetoskop','Philips','1200W','12WA','2023',100000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:52:03','windisri',NULL,NULL,NULL),
('KD-SXXK34','Termometer','Buavita','Indo','123456','2023',12000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:51:07','windisri',NULL,NULL,NULL),
('KD-XA81CU','Termometer','Buavita','Indo','123456','2023',12000,1,'2023-06-15','https://www.youtube.com/watch?v=2GRP1rkE4O0',1,'2023-06-15 10:51:07','windisri',NULL,NULL,NULL);

/*Table structure for table `history_pemeliharaan` */

DROP TABLE IF EXISTS `history_pemeliharaan`;

CREATE TABLE `history_pemeliharaan` (
  `id_history` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  PRIMARY KEY (`id_history`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `history_pemeliharaan` */

insert  into `history_pemeliharaan`(`id_history`,`tgl`,`created_at`,`created_by`,`ket`) values 
(1,'2022-11-01','2023-06-05 19:27:19',NULL,NULL);

/*Table structure for table `kalibrasi` */

DROP TABLE IF EXISTS `kalibrasi`;

CREATE TABLE `kalibrasi` (
  `id_kalibrasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `pelaksana` text DEFAULT NULL,
  `kondisi` enum('Lulus','Tidak Lulus') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `id_petugas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kalibrasi`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `kalibrasi` */

insert  into `kalibrasi`(`id_kalibrasi`,`id_barang`,`tgl`,`pelaksana`,`kondisi`,`created_at`,`id_petugas`) values 
(7,'KD-74QDLP','2023-06-15','bptn','Lulus','2023-06-15 13:35:40',7),
(8,'KD-4VJBEB','2023-06-15','poll','Tidak Lulus','2023-06-15 13:39:36',7);

/*Table structure for table `mutasi` */

DROP TABLE IF EXISTS `mutasi`;

CREATE TABLE `mutasi` (
  `id_mutasi` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` varchar(50) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `tgl_dipinjam` date DEFAULT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `status_mutasi` enum('Belum Dikembalikan','Dikembalikan') DEFAULT NULL,
  `jenis_mutasi` enum('Mutasi','Peminjaman') DEFAULT NULL,
  `nama_penerima` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `kondisi_sebelum` int(11) DEFAULT NULL,
  `kondisi_sesudah` int(11) DEFAULT NULL,
  `id_ruangan_penerima` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mutasi`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/*Data for the table `mutasi` */

insert  into `mutasi`(`id_mutasi`,`id_barang`,`id_petugas`,`id_ruangan`,`tgl_dipinjam`,`tgl_dikembalikan`,`ket`,`status_mutasi`,`jenis_mutasi`,`nama_penerima`,`created_at`,`kondisi_sebelum`,`kondisi_sesudah`,`id_ruangan_penerima`) values 
(36,'KD-0HYZWJ',5,1,'2023-06-15','2023-06-15','diberikan dalam kondisi baik','Belum Dikembalikan','Mutasi','Egi','2023-06-15 12:30:38',1,NULL,3),
(38,'KD-74QDLP',5,1,'2023-06-14','2023-06-15','dipinjamkan','Belum Dikembalikan','Peminjaman','ajdoo','2023-06-15 12:38:56',1,NULL,4);

/*Table structure for table `pemeliharaan` */

DROP TABLE IF EXISTS `pemeliharaan`;

CREATE TABLE `pemeliharaan` (
  `id_pemeliharaan` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_tindakan` date DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `id_barang` varchar(50) DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(40) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `kondisi_sebelum` int(11) DEFAULT NULL,
  `kondisi_sesudah` int(11) DEFAULT NULL,
  `berkala` enum('Ya','Tidak') DEFAULT NULL,
  PRIMARY KEY (`id_pemeliharaan`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `pemeliharaan` */

insert  into `pemeliharaan`(`id_pemeliharaan`,`tgl_tindakan`,`id_petugas`,`ket`,`id_barang`,`tgl_selesai`,`created_at`,`created_by`,`updated_at`,`updated_by`,`kondisi_sebelum`,`kondisi_sesudah`,`berkala`) values 
(11,'2023-06-15',7,'rusak bagian karet tidak bisa diperbaiki','KD-0HYZWJ','2023-06-15','2023-06-15 13:26:41',NULL,NULL,NULL,2,3,'Tidak'),
(14,'2023-06-15',7,'kondisi aman','KD-173TSH','2023-06-15','2023-06-15 13:30:10',NULL,NULL,NULL,1,1,'Tidak'),
(15,'2023-06-14',7,'rusak bagian karet tidak bisa diperbaiki','KD-0HYZWJ','2023-06-16','2023-06-15 13:26:41',NULL,NULL,NULL,2,1,'Ya'),
(16,'2023-06-18',7,'','KD-173TSH','0000-00-00','2023-06-15 13:30:10',NULL,NULL,NULL,1,NULL,'Tidak');

/*Table structure for table `petugas` */

DROP TABLE IF EXISTS `petugas`;

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `level` enum('Petugas Logistik','Teknisi','Pimpinan','Admin Prasarana') DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `telp` varchar(13) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `petugas` */

insert  into `petugas`(`id_petugas`,`username`,`password`,`level`,`nama`,`nik`,`telp`,`foto`,`created_at`,`created_by`,`updated_at`,`updated_by`,`id_ruangan`) values 
(1,'windisri','b1498f49462cd34902595e16fa2673ac90d8a4c7','Admin Prasarana','Windi','1303075502970002','082378394245',NULL,'2023-05-08 18:57:10',NULL,NULL,NULL,NULL),
(5,'leoanabul','b1498f49462cd34902595e16fa2673ac90d8a4c7','Petugas Logistik','Leonardo Decaprio','1234567890','082378394245','pendukung-23826.jpeg','2023-05-14 10:46:11',NULL,NULL,NULL,1),
(7,'Jadoo','b1498f49462cd34902595e16fa2673ac90d8a4c7','Teknisi','Jadoo','1303015502970001','082378394245',NULL,'2023-06-05 19:29:04',NULL,NULL,NULL,NULL),
(8,'tes','b1498f49462cd34902595e16fa2673ac90d8a4c7','Petugas Logistik','tes','1303015502970001','082378394245',NULL,'2023-06-07 14:55:48',NULL,NULL,NULL,2);

/*Table structure for table `ruangan` */

DROP TABLE IF EXISTS `ruangan`;

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `ruangan` */

insert  into `ruangan`(`id_ruangan`,`nama_ruangan`) values 
(1,'UGD'),
(2,'Poli Anak'),
(3,'Poli Ibu'),
(4,'Poli Paru'),
(5,'Rawatan Anak'),
(6,'Peri'),
(7,'Gudang Prasarana');

/*Table structure for table `status_barang` */

DROP TABLE IF EXISTS `status_barang`;

CREATE TABLE `status_barang` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status_barang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `status_barang` */

insert  into `status_barang`(`id_status`,`status_barang`) values 
(1,'Baik'),
(2,'Rusak Berat');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
