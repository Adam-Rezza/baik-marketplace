/*
 Navicat Premium Data Transfer

 Source Server         : Laragon MySql
 Source Server Type    : MySQL
 Source Server Version : 100410
 Source Host           : localhost:3306
 Source Schema         : baikmarketdb

 Target Server Type    : MySQL
 Target Server Version : 100410
 File Encoding         : 65001

 Date: 09/09/2020 13:41:48
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
INSERT INTO `admins` VALUES (1, 'admin', '$2y$10$cQEWoJvO4hOUJ28jGjFKzuz3Gp/vtAW5cVFanJXOVNnjlhsinpPbq', '2020-08-03 16:19:35', '2020-08-03 16:19:35', NULL, 'gcYqId4kln1Dtfb2GXgVwHWOn09lKOEZirhpSFievNa0mTjSmJQCLrVFCP2Qsyzd', 'yes');
INSERT INTO `admins` VALUES (2, 'test', '09a9922c001f7f65bea539ec3eecfe15bb60b008', '2020-08-10 18:49:50', '2020-08-10 18:49:50', '2020-08-10 19:08:54', NULL, 'no');

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `active` bit(1) NULL DEFAULT b'0',
  `urutan` int(11) NULL DEFAULT NULL,
  `del` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES (1, 'a3afcb806fc3ff7685b3dc58be5f9df5.jpg', '#', b'1', 1, NULL);
INSERT INTO `banner` VALUES (2, '3f2e5d89e28f982aca4f375c3bea8b2f.jpg', '#', b'1', 2, b'1');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'Sembako', 1, '2020-08-23 02:55:04', 1, NULL, NULL);
INSERT INTO `kategori` VALUES (2, 'Beras', 1, '2020-08-23 02:56:02', 1, NULL, 1);

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toko_id` int(11) NULL DEFAULT NULL,
  `kategori_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga_asli` int(11) NULL DEFAULT NULL,
  `harga_disc` int(11) NULL DEFAULT NULL,
  `terjual` int(11) NULL DEFAULT NULL,
  `rating` decimal(3, 2) NULL DEFAULT NULL,
  `del` smallint(1) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 1, '2', 'Beras Rojo Lele', 10000, 9000, 0, 0.00, NULL, '2020-08-23 02:56:56');

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
