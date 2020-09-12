/*
 Navicat Premium Data Transfer

 Source Server         : Mysql Local
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : baikmarketdb

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 13/09/2020 06:03:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `cookies` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `remember` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'no',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'admin', '$2y$10$cQEWoJvO4hOUJ28jGjFKzuz3Gp/vtAW5cVFanJXOVNnjlhsinpPbq', '2020-08-03 16:19:35', '2020-08-03 16:19:35', NULL, 'wT1GZgUVpOikaqEiMov30vp9Rzd2GFtu1LmI0y7xwkqLu5C57mUIfND8chWgMxes', 'yes');
INSERT INTO `admins` VALUES (2, 'test', '09a9922c001f7f65bea539ec3eecfe15bb60b008', '2020-08-10 18:49:50', '2020-08-10 18:49:50', '2020-08-10 19:08:54', NULL, 'no');

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(11) NULL DEFAULT NULL,
  `active` bit(1) NULL DEFAULT b'0',
  `del` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES (1, '68f8c66aa8476025fa12dcb728a2b7d4.jpg', '#', 1, b'1', NULL);
INSERT INTO `banner` VALUES (2, '8570d5bf27f91078bacd608140e81037.jpg', '#', 2, b'1', NULL);

-- ----------------------------
-- Table structure for gambar_produk
-- ----------------------------
DROP TABLE IF EXISTS `gambar_produk`;
CREATE TABLE `gambar_produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NULL DEFAULT NULL,
  `gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `del` smallint(1) NULL DEFAULT NULL,
  `urutan` smallint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gambar_produk
-- ----------------------------
INSERT INTO `gambar_produk` VALUES (1, 1, '1_1_1.jpg', NULL, 1);
INSERT INTO `gambar_produk` VALUES (2, 1, '1_1_2.jpg', NULL, 2);

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `urutan` int(11) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `active` smallint(1) NULL DEFAULT NULL,
  `del` smallint(1) NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Sembako', 1, '2020-08-23 02:55:04', 1, NULL, NULL);
INSERT INTO `kategori` VALUES (6, 'Beras', 1, '2020-09-07 05:01:59', 1, NULL, 1);
INSERT INTO `kategori` VALUES (7, 'Minyak', 2, '2020-09-07 05:02:27', 1, NULL, 1);
INSERT INTO `kategori` VALUES (8, 'Sayur dan Buah', 2, '2020-09-07 05:02:52', 1, NULL, NULL);
INSERT INTO `kategori` VALUES (9, 'Elektronik', 3, '2020-09-07 05:14:52', 1, NULL, NULL);
INSERT INTO `kategori` VALUES (10, 'Komputer', 1, '2020-09-07 05:15:13', 1, NULL, 9);

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toko_id` int(11) NULL DEFAULT NULL,
  `kategori_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sub_kategori_id` int(11) NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `harga_asli` int(11) NULL DEFAULT NULL,
  `harga_disc` int(11) NULL DEFAULT NULL,
  `terjual` int(11) NULL DEFAULT NULL,
  `rating` decimal(3, 2) NULL DEFAULT 0.00,
  `del` bit(1) NULL DEFAULT b'0',
  `ban` bit(1) NULL DEFAULT b'0',
  `created_date` datetime(0) NULL DEFAULT NULL,
  `modified_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 1, '1', 6, 'Beras Rojo Lele', 'Ini Deskripsi Beras Rojo Lele', 1000, 900, 0, 0.00, b'0', b'0', '2020-09-13 04:38:16', '2020-09-13 04:38:18');

-- ----------------------------
-- Table structure for toko
-- ----------------------------
DROP TABLE IF EXISTS `toko`;
CREATE TABLE `toko`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `active` smallint(1) NULL DEFAULT 1,
  `ban` smallint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of toko
-- ----------------------------
INSERT INTO `toko` VALUES (1, 1, 'Toko Adam', 'Test', '082114578976', 'logo.png', 1, 0);
INSERT INTO `toko` VALUES (2, 1, 'Toko Nurul', 'Test1', '0821145789761', 'logo.png', 1, 0);

SET FOREIGN_KEY_CHECKS = 1;
