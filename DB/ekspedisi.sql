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

 Date: 12/10/2020 22:35:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ekspedisi
-- ----------------------------
DROP TABLE IF EXISTS `ekspedisi`;
CREATE TABLE `ekspedisi`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ekspedisi
-- ----------------------------
INSERT INTO `ekspedisi` VALUES ('pos', 'POS Indonesia (POS)');
INSERT INTO `ekspedisi` VALUES ('lion', 'Lion Parcel (LION)');
INSERT INTO `ekspedisi` VALUES ('ninja', 'Ninja Xpress (NINJA)');
INSERT INTO `ekspedisi` VALUES ('sicepat', 'SiCepat Express (SICEPAT)');
INSERT INTO `ekspedisi` VALUES ('jne', 'Jalur Nugraha Ekakurir (JNE)');
INSERT INTO `ekspedisi` VALUES ('tiki', 'Citra Van Titipan Kilat (TIKI)');
INSERT INTO `ekspedisi` VALUES ('pandu', 'Pandu Logistics (PANDU)');
INSERT INTO `ekspedisi` VALUES ('wahana', 'Wahana Prestasi Logistik (WAHANA)');
INSERT INTO `ekspedisi` VALUES ('j&t', 'J&T Express (J&T)');
INSERT INTO `ekspedisi` VALUES ('pahala', 'Pahala Kencana Express (PAHALA)');

SET FOREIGN_KEY_CHECKS = 1;
