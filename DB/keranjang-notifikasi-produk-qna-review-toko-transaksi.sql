/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : baikmarketdb

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 29/09/2020 13:05:13
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
  `user_id` int(11) NULL DEFAULT NULL,
  `harga` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `transaksi_id` int(11) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of keranjang
-- ----------------------------
INSERT INTO `keranjang` VALUES (19, 2, 4, 50000, 3, 9, '2020-09-27 04:00:23');
INSERT INTO `keranjang` VALUES (20, 10004, 4, 20000, 2, 10, '2020-09-27 04:00:25');
INSERT INTO `keranjang` VALUES (21, 2, 1, 50000, 2, NULL, '2020-09-29 08:00:45');
INSERT INTO `keranjang` VALUES (22, 4, 4, 50000, 2, 9, '2020-09-27 08:28:06');

-- ----------------------------
-- Table structure for notifikasi
-- ----------------------------
DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE `notifikasi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `read` bit(1) NULL DEFAULT b'0',
  `datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifikasi
-- ----------------------------
INSERT INTO `notifikasi` VALUES (9, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Adam</b>', 'my_order', b'1', '2020-09-27 10:34:54');
INSERT INTO `notifikasi` VALUES (10, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 10:34:54');
INSERT INTO `notifikasi` VALUES (11, NULL, 4, 'Pesanan anda sedang di proses oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 10:35:57');
INSERT INTO `notifikasi` VALUES (12, NULL, 4, 'Pesanan anda sedang dikirimkan oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 10:53:46');
INSERT INTO `notifikasi` VALUES (13, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 12:35:10');
INSERT INTO `notifikasi` VALUES (14, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 12:35:10');
INSERT INTO `notifikasi` VALUES (15, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Adam</b>', 'my_order', b'1', '2020-09-27 14:36:42');
INSERT INTO `notifikasi` VALUES (16, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 14:36:42');
INSERT INTO `notifikasi` VALUES (17, NULL, 4, 'Pesanan anda sedang di proses oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 14:36:58');
INSERT INTO `notifikasi` VALUES (18, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Adam</b>', 'my_order', b'1', '2020-09-27 16:05:58');
INSERT INTO `notifikasi` VALUES (19, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 16:05:58');
INSERT INTO `notifikasi` VALUES (20, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> dibatalkan', 'my_recent_order', b'1', '2020-09-27 19:10:18');
INSERT INTO `notifikasi` VALUES (21, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> dibatalkan', 'my_recent_order', b'1', '2020-09-27 19:24:43');
INSERT INTO `notifikasi` VALUES (22, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> dibatalkan', 'my_recent_order', b'1', '2020-09-27 19:24:57');
INSERT INTO `notifikasi` VALUES (23, NULL, 4, 'Pesanan anda sedang di proses oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 19:28:13');
INSERT INTO `notifikasi` VALUES (24, NULL, 4, 'Pesanan anda sedang dikirimkan oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 19:28:21');
INSERT INTO `notifikasi` VALUES (25, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 19:28:43');
INSERT INTO `notifikasi` VALUES (26, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Adam</b>', 'my_order', b'1', '2020-09-27 20:18:06');
INSERT INTO `notifikasi` VALUES (27, NULL, 4, 'Pesanan anda di teruskan ke <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 20:18:06');
INSERT INTO `notifikasi` VALUES (28, NULL, 4, 'Pesanan anda sedang di proses oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 20:18:18');
INSERT INTO `notifikasi` VALUES (29, NULL, 4, 'Pesanan anda sedang dikirimkan oleh <b>Toko Haha</b>', 'my_order', b'1', '2020-09-27 20:18:25');
INSERT INTO `notifikasi` VALUES (30, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 20:18:36');
INSERT INTO `notifikasi` VALUES (31, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 20:22:44');
INSERT INTO `notifikasi` VALUES (32, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 20:26:06');
INSERT INTO `notifikasi` VALUES (33, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 20:26:17');
INSERT INTO `notifikasi` VALUES (34, NULL, 4, 'Pesanan anda pada <b>Toko Haha</b> sudah selesai', 'my_recent_order', b'1', '2020-09-27 20:27:40');
INSERT INTO `notifikasi` VALUES (35, NULL, 4, 'Pesanan anda pada <b>Toko Adam</b> dibatalkan', 'my_recent_order', b'1', '2020-09-29 06:45:46');

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
  `disc` int(11) NULL DEFAULT NULL,
  `terjual` int(11) NULL DEFAULT NULL,
  `rating` decimal(3, 2) NULL DEFAULT 0,
  `rating_count` int(11) NULL DEFAULT 0,
  `del` bit(1) NULL DEFAULT b'0',
  `ban` bit(1) NULL DEFAULT b'0',
  `created_date` datetime(0) NULL DEFAULT NULL,
  `modified_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10006 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 1, '1', 1, 'Beras Terbaik 1', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 50000, NULL, 99, 3.00, 0, b'0', b'0', '2020-08-20 02:55:12', NULL);
INSERT INTO `produk` VALUES (2, 1, '1', 1, 'Beras Terbaik 2', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 50000, NULL, 99, 3.50, 0, b'0', b'0', '2020-08-20 02:55:12', NULL);
INSERT INTO `produk` VALUES (3, 1, '1', 1, 'Beras Terbaik 3', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 50000, NULL, 99, 4.00, 0, b'0', b'0', '2020-08-20 02:55:12', NULL);
INSERT INTO `produk` VALUES (4, 1, '1', 1, 'Beras Terbaik 4', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 50000, NULL, 99, 4.50, 0, b'0', b'0', '2020-08-20 02:55:12', NULL);
INSERT INTO `produk` VALUES (5, 1, '6', 0, 'Tas Anak 1', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 100000, 0, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', '2020-09-14 10:41:37');
INSERT INTO `produk` VALUES (6, 1, '6', NULL, 'Tas Anak 2', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 75000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (7, 1, '6', NULL, 'Tas 1', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 75000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (8, 1, '6', NULL, 'Tas 2', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 75000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (9, 1, '6', NULL, 'Tas 3', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 75000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (10, 1, '6', NULL, 'Tas 4', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 100000, 75000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (12, 1, '5', 14, 'Sepatu 2', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, 1, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (13, 1, '5', 14, 'Sepatu 3', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (14, 1, '5', 14, 'Sepatu 4', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (15, 1, '5', 14, 'Sepatu 5', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (16, 1, '5', 14, 'Sepatu 6', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (17, 1, '5', 14, 'Sepatu 7', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (30, 1, '6', 0, 'Tas Anak 1', 'Deskripsi\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 1000000, 750000, 25, 0, 0.00, 0, b'0', b'0', '2020-09-14 10:15:49', '2020-09-14 10:21:36');
INSERT INTO `produk` VALUES (31, 1, '4', 4, 'Test', 'Peralatan serba guna', 400000, 80000, 80, 0, 0.00, 0, b'0', b'0', '2020-09-14 10:22:58', NULL);
INSERT INTO `produk` VALUES (10001, 1, '', 0, 'Cangkir cantik', 'Cangkir cantik berkualitas peninggalan dinasti yang\r\nStok langka dan terbatas', 20000, 16000, 20, 0, 0.00, 0, b'0', b'0', '2020-09-15 06:04:42', NULL);
INSERT INTO `produk` VALUES (10002, 1, '5', 14, 'Sepatu 1', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 150000, 100000, NULL, 0, 0.00, 0, b'0', b'0', '2020-08-29 21:49:56', NULL);
INSERT INTO `produk` VALUES (10003, 1, '', NULL, 'hahazazaza', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', 453645, 0, 100, 0, 0.00, 0, b'0', b'0', '2020-09-23 05:16:08', '2020-09-24 08:29:00');
INSERT INTO `produk` VALUES (10004, 16, '', 0, 'Lalala', 'Ini adalah deskripsi', 100000, 20000, 80, 6, 4.50, 2, b'0', b'0', '2020-09-26 09:32:55', NULL);
INSERT INTO `produk` VALUES (10005, 16, '4', 0, 'Produk', 'Deskripsi', 100000, 90000, 10, NULL, 0.00, 0, b'0', b'0', '2020-09-27 09:18:38', NULL);

-- ----------------------------
-- Table structure for qna
-- ----------------------------
DROP TABLE IF EXISTS `qna`;
CREATE TABLE `qna`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toko_id` bit(1) NULL DEFAULT b'0',
  `user_id` int(11) NULL DEFAULT NULL,
  `produk_id` int(11) NULL DEFAULT NULL,
  `created` datetime(0) NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT 0,
  `msg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `del` bit(1) NULL DEFAULT b'0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of qna
-- ----------------------------
INSERT INTO `qna` VALUES (1, b'1', 4, 10005, '2020-09-28 10:17:31', 0, 'sesuatu yang ditanya', b'0');
INSERT INTO `qna` VALUES (2, b'1', 4, 10005, '2020-09-28 10:19:13', 0, 'Tanya lagi ah\r\n', b'0');
INSERT INTO `qna` VALUES (3, b'1', 4, 10005, '2020-09-28 10:19:22', 0, 'Tanya 3 ini....', b'0');
INSERT INTO `qna` VALUES (4, b'0', 2, 10005, '2020-09-28 10:19:51', 0, 'Rezza bertanya...', b'0');
INSERT INTO `qna` VALUES (5, b'0', 2, 10005, '2020-09-28 10:20:01', 0, 'Stok ready?', b'0');
INSERT INTO `qna` VALUES (6, b'0', 2, 10005, '2020-09-28 12:49:47', 1, 'dsfsd', b'0');
INSERT INTO `qna` VALUES (7, b'0', 2, 10005, '2020-09-28 12:50:13', 5, 'Ready kang, langsung pesen aja.. ', b'0');
INSERT INTO `qna` VALUES (8, b'0', 2, 10005, '2020-09-28 12:50:34', 5, 'Brp harganya?', b'0');
INSERT INTO `qna` VALUES (9, b'1', 4, 10005, '2020-09-28 12:51:33', 4, 'Toko Haha menjawab..', b'0');
INSERT INTO `qna` VALUES (10, b'0', 1, 10005, '2020-09-28 12:54:40', 4, 'Iya gan...', b'0');
INSERT INTO `qna` VALUES (12, b'0', 1, 10004, '2020-09-28 13:05:24', 0, 'Apakah barang ini ready?', b'0');
INSERT INTO `qna` VALUES (13, b'1', 4, 10004, '2020-09-28 13:06:50', 12, 'Ready gan, mangga di pesen...', b'0');
INSERT INTO `qna` VALUES (14, b'1', 4, 10004, '2020-09-28 13:09:09', 12, 'Siap..', b'0');
INSERT INTO `qna` VALUES (15, b'1', 4, 10004, '2020-09-28 14:34:37', 0, 'sadas\r\nasd\r\nasd\r\nsadsa', b'0');
INSERT INTO `qna` VALUES (16, b'1', 4, 10004, '2020-09-28 15:10:21', 0, 'sdasd\r\nasd\r\nas', b'0');
INSERT INTO `qna` VALUES (17, b'1', 4, 10004, '2020-09-28 15:10:54', 0, 'qwe\r \\r\\n sad \\n', b'0');
INSERT INTO `qna` VALUES (18, b'1', 4, 10004, '2020-09-28 15:14:48', 0, 'a\r&#13;&#10;a', b'0');
INSERT INTO `qna` VALUES (19, b'1', 4, 10004, '2020-09-28 15:16:18', 0, 'a&#13;&#10;a', b'0');
INSERT INTO `qna` VALUES (20, b'1', 4, 10004, '2020-09-28 15:22:50', 19, 'Ready gan hehe..', b'0');
INSERT INTO `qna` VALUES (21, b'1', 4, 10004, '2020-09-28 15:23:11', 17, 'Test balas', b'0');
INSERT INTO `qna` VALUES (22, b'1', 4, 10004, '2020-09-28 15:27:51', 18, 'a\r\na\r\n', b'0');
INSERT INTO `qna` VALUES (23, b'0', 4, 10001, '2020-09-28 15:52:59', 0, 'Ready gan hah?', b'0');
INSERT INTO `qna` VALUES (24, b'0', 4, 10001, '2020-09-28 15:59:57', 23, 'Ready kok tenang ae haha..', b'0');

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `produk_id` int(11) NULL DEFAULT NULL,
  `transaksi_id` int(11) NULL DEFAULT NULL,
  `rating` int(11) NULL DEFAULT NULL,
  `msg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gambar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created` datetime(0) NULL DEFAULT NULL,
  `del` bit(1) NULL DEFAULT b'0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of review
-- ----------------------------
INSERT INTO `review` VALUES (1, 4, 10004, NULL, 4, 'a', NULL, '2020-09-29 02:17:40', b'0');
INSERT INTO `review` VALUES (2, 4, 10004, NULL, 4, 'a', NULL, '2020-09-29 02:19:14', b'0');
INSERT INTO `review` VALUES (3, 4, 10004, NULL, 5, 'a', NULL, '2020-09-29 02:19:35', b'0');
INSERT INTO `review` VALUES (4, 4, 10004, NULL, 5, 'a', '100045f727f050c2f7.png', '2020-09-29 02:25:41', b'0');
INSERT INTO `review` VALUES (5, 4, 10004, NULL, 4, 'ini penilaian bintang 4', '100045f7287def18dd.png', '2020-09-29 03:03:26', b'0');
INSERT INTO `review` VALUES (6, 4, 10004, NULL, 3, 'ini bintang 3', '100045f7287f38bea7.jpg', '2020-09-29 03:03:47', b'0');
INSERT INTO `review` VALUES (7, 4, 10004, NULL, 4, 'asd', NULL, '2020-09-29 03:18:31', b'0');
INSERT INTO `review` VALUES (8, 4, 10004, NULL, 5, 'dasd', NULL, '2020-09-29 03:19:56', b'0');
INSERT INTO `review` VALUES (9, 4, 10004, NULL, 5, 'asd', NULL, '2020-09-29 03:21:48', b'0');
INSERT INTO `review` VALUES (10, 4, 10004, NULL, 5, 'dasd', NULL, '2020-09-29 03:22:26', b'0');
INSERT INTO `review` VALUES (23, 4, 10004, 10, 5, 'Bintang 5', '100045f72a2ec571d9.jpg', '2020-09-29 04:58:52', b'0');

-- ----------------------------
-- Table structure for toko
-- ----------------------------
DROP TABLE IF EXISTS `toko`;
CREATE TABLE `toko`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telp` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kelurahan` bigint(20) NULL DEFAULT NULL,
  `kecamatan` int(11) NULL DEFAULT NULL,
  `kota` int(11) NULL DEFAULT NULL,
  `provinsi` int(11) NULL DEFAULT NULL,
  `kode_pos` int(11) NULL DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `active` smallint(1) NULL DEFAULT 1,
  `ban` smallint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of toko
-- ----------------------------
INSERT INTO `toko` VALUES (1, 1, 'Toko Adam', '082114578976', 'Test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0);
INSERT INTO `toko` VALUES (16, 4, 'Toko Haha', '09876543234', 'Bogor merdeka', 3201291003, 320129, 3201, 32, NULL, NULL, '45f72ba5dd6143.png', 1, 0);

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toko_id` int(11) NULL DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telp_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telp_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kelurahan` bigint(20) NULL DEFAULT NULL,
  `kecamatan` int(11) NULL DEFAULT NULL,
  `kota` int(11) NULL DEFAULT NULL,
  `provinsi` int(11) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `proccess_date` datetime(0) NULL DEFAULT NULL,
  `shipment_date` datetime(0) NULL DEFAULT NULL,
  `delivery_date` datetime(0) NULL DEFAULT NULL,
  `failed_date` datetime(0) NULL DEFAULT NULL,
  `failed_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (9, 1, 'Toko Adam', '082114578976', 4, 'Haha', '0823294094189', 'asdfghjkl, Sei Sentang, Kualuh Hilir, KAB. LABUHANBATU UTARA, Sumatera Utara', 0, 0, 0, 0, 10, '2020-09-27 08:18:06', NULL, NULL, NULL, '2020-09-29 06:45:46', 'Males terima ah..');
INSERT INTO `transaksi` VALUES (10, 16, 'Toko Haha', '09876543234', 4, 'Haha', '0823294094189', 'asdfghjkl, Sei Sentang, Kualuh Hilir, KAB. LABUHANBATU UTARA, Sumatera Utara', 0, 0, 0, 0, 9, '2020-09-27 08:18:06', '2020-09-27 20:18:18', '2020-09-27 20:18:25', '2020-09-27 20:27:40', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
