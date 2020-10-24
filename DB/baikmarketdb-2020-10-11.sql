-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `ekspedisi`;
CREATE TABLE `ekspedisi` (
  `id` varchar(191) NOT NULL,
  `nama` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ekspedisi` (`id`, `nama`) VALUES
('pos',	'POS Indonesia (POS)'),
('lion',	'Lion Parcel (LION)'),
('ninja',	'Ninja Xpress (NINJA)'),
('sicepat',	'SiCepat Express (SICEPAT)'),
('jne',	'Jalur Nugraha Ekakurir (JNE)'),
('tiki',	'Citra Van Titipan Kilat (TIKI)'),
('pandu',	'Pandu Logistics (PANDU)'),
('wahana',	'Wahana Prestasi Logistik (WAHANA)'),
('j&t',	'J&T Express (J&T)'),
('pahala',	'Pahala Kencana Express (PAHALA)');

DROP TABLE IF EXISTS `toko`;
CREATE TABLE `toko` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kelurahan` bigint(20) DEFAULT NULL,
  `kecamatan` int(11) DEFAULT NULL,
  `kota` int(11) DEFAULT NULL,
  `provinsi` int(11) DEFAULT NULL,
  `kode_pos` int(11) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `active` smallint(1) DEFAULT 1,
  `ban` smallint(1) DEFAULT 0,
  `ekspedisi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


-- 2020-10-10 17:22:57
