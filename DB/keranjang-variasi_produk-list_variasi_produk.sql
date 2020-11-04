/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : baikmarketdb

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 04/11/2020 08:56:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for keranjang
-- ----------------------------
DROP TABLE IF EXISTS `keranjang`;
CREATE TABLE `keranjang`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk_id` int(11) NULL DEFAULT NULL,
  `variasi_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `harga` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `transaksi_id` int(11) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of keranjang
-- ----------------------------
INSERT INTO `keranjang` VALUES (1, 5, NULL, 4, 100000, 1, 1, '2020-10-18 09:07:10');
INSERT INTO `keranjang` VALUES (2, 10001, NULL, 4, 16000, 1, 1, '2020-10-18 09:07:18');
INSERT INTO `keranjang` VALUES (3, 10017, NULL, 4, 420000, 1, 2, '2020-10-18 09:07:31');
INSERT INTO `keranjang` VALUES (4, 10003, NULL, 4, 226822, 1, 1, '2020-10-19 02:11:55');
INSERT INTO `keranjang` VALUES (5, 10016, NULL, 4, 177000, 1, 3, '2020-10-19 02:16:32');
INSERT INTO `keranjang` VALUES (6, 7, NULL, 4, 75000, 1, 4, '2020-10-19 02:17:00');
INSERT INTO `keranjang` VALUES (7, 10001, NULL, 2, 16000, 3, 5, '2020-10-19 02:18:53');
INSERT INTO `keranjang` VALUES (8, 12, NULL, 2, 100000, 2, 5, '2020-10-19 02:19:01');
INSERT INTO `keranjang` VALUES (9, 12, NULL, 2, 100000, 2, 6, '2020-10-19 02:19:20');
INSERT INTO `keranjang` VALUES (10, 10001, NULL, 2, 16000, 2, 6, '2020-10-19 02:19:27');
INSERT INTO `keranjang` VALUES (11, 12, NULL, 2, 100000, 1, 7, '2020-10-19 02:41:53');
INSERT INTO `keranjang` VALUES (12, 10003, NULL, 2, 226822, 1, 8, '2020-10-19 10:35:36');
INSERT INTO `keranjang` VALUES (13, 10017, NULL, 2, 420000, 1, 9, '2020-10-19 10:35:43');
INSERT INTO `keranjang` VALUES (14, 12, NULL, 2, 100000, 1, 10, '2020-10-19 10:45:45');
INSERT INTO `keranjang` VALUES (15, 5, NULL, 2, 100000, 1, 10, '2020-10-19 10:45:55');
INSERT INTO `keranjang` VALUES (16, 7, NULL, 2, 75000, 1, 10, '2020-10-19 10:46:04');
INSERT INTO `keranjang` VALUES (17, 10001, NULL, 2, 16000, 1, 11, '2020-10-19 11:06:46');
INSERT INTO `keranjang` VALUES (18, 10004, NULL, 1, 20000, 3, 12, '2020-10-22 16:28:39');
INSERT INTO `keranjang` VALUES (19, 10004, NULL, 1, 20000, 1, NULL, '2020-10-23 02:31:03');
INSERT INTO `keranjang` VALUES (23, 10031, '[\"4\",\"15\"]', 7, 16000, 2, 13, '2020-11-03 19:26:35');
INSERT INTO `keranjang` VALUES (24, 10031, '[\"3\",\"16\"]', 7, 16000, 2, 13, '2020-11-03 19:26:37');
INSERT INTO `keranjang` VALUES (28, 10004, NULL, 7, 20000, 2, 14, '2020-11-03 20:40:40');

-- ----------------------------
-- Table structure for list_variasi_produk
-- ----------------------------
DROP TABLE IF EXISTS `list_variasi_produk`;
CREATE TABLE `list_variasi_produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  `produk_id` int(11) NULL DEFAULT NULL,
  `active` bit(1) NULL DEFAULT b'1',
  `del` bit(1) NULL DEFAULT b'0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of list_variasi_produk
-- ----------------------------
INSERT INTO `list_variasi_produk` VALUES (3, 'Pedas', 1001, 10031, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (4, 'Asam-manis', 1001, 10031, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (5, 'List Variasi 1', 1002, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (6, 'List Variasi 2', 1002, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (11, 'List Variasi 3', 1002, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (12, '1kg', 1004, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (13, '2kg', 1004, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (14, '3kg', 1004, 10032, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (15, 'Makaroni keong', 1005, 10031, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (16, 'Mie keriting', 1005, 10031, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (17, 'Merah', 1006, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (18, 'Hijau', 1006, 5, b'1', b'1');
INSERT INTO `list_variasi_produk` VALUES (19, 'S', 1007, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (20, 'M', 1007, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (21, '500gr', 1008, 5, b'1', b'1');
INSERT INTO `list_variasi_produk` VALUES (22, '1000gr', 1008, 5, b'1', b'1');
INSERT INTO `list_variasi_produk` VALUES (23, '100gr', 1008, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (24, '200gr', 1008, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (25, '300gr', 1008, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (26, '400gr', 1008, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (27, 'Kuning', 1006, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (28, 'Hijau', 1006, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (29, 'Biru', 1006, 5, b'1', b'0');
INSERT INTO `list_variasi_produk` VALUES (30, 'Ungu', 1006, 5, b'1', b'0');

-- ----------------------------
-- Table structure for variasi_produk
-- ----------------------------
DROP TABLE IF EXISTS `variasi_produk`;
CREATE TABLE `variasi_produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `produk_id` int(11) NULL DEFAULT NULL,
  `del` bit(1) NULL DEFAULT b'0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1009 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of variasi_produk
-- ----------------------------
INSERT INTO `variasi_produk` VALUES (1001, 'Rasa', 10031, b'0');
INSERT INTO `variasi_produk` VALUES (1002, 'Judul Variasi', 10032, b'0');
INSERT INTO `variasi_produk` VALUES (1004, 'Berat', 10032, b'0');
INSERT INTO `variasi_produk` VALUES (1005, 'Varian', 10031, b'0');
INSERT INTO `variasi_produk` VALUES (1006, 'Warna', 5, b'0');
INSERT INTO `variasi_produk` VALUES (1007, 'Ukuran', 5, b'1');
INSERT INTO `variasi_produk` VALUES (1008, 'Berat', 5, b'0');

SET FOREIGN_KEY_CHECKS = 1;
