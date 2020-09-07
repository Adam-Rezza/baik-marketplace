/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : pob

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 01/09/2020 02:12:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `rating` decimal(3, 2) NULL DEFAULT 0,
  `del` bit(1) NULL DEFAULT b'0',
  `ban` bit(1) NULL DEFAULT b'0',
  `created_date` datetime(0) NULL DEFAULT NULL,
  `modified_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
