/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : ip_source

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-10-30 00:01:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_pass` varchar(250) CHARACTER SET utf8mb4 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `phone` varchar(40) CHARACTER SET utf8mb4 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', 'eyJpdiI6IkNYc2xzemcrNjZzdlJUeDJLNGN3QVE9PSIsInZhbHVlIjoiUFNDNlZOb24zWWw1djkxU3hTMFZWdz09IiwibWFjIjoiY2MyMDkxZWZiOTk3M2MzMmQxYjZlODUyZGJjNGM2OWY0YzNjZjlhNzhmN2M4ZGIwYTIwMmMyZjVlZTJhOTdhZCJ9', '大秦', '692860800@qq.com', '17772303505', null, '2017-10-22 10:19:32');

-- ----------------------------
-- Table structure for ip_catch_source
-- ----------------------------
DROP TABLE IF EXISTS `ip_catch_source`;
CREATE TABLE `ip_catch_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `match_preg` varchar(255) DEFAULT NULL,
  `last_match_num` int(11) DEFAULT '0' COMMENT '上次匹配ip数量',
  `status` enum('active','delete') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ip_catch_source
-- ----------------------------
INSERT INTO `ip_catch_source` VALUES ('1', 'http://204.152.197.21/info.php?pass=222&file=proxy_data_all_all', 'szy-ip', '/([\\d\\.]+\\:\\d+)\\s/', '2855', 'active', '2017-10-25 00:07:22', '2017-10-29 07:57:18');

-- ----------------------------
-- Table structure for ip_competitor
-- ----------------------------
DROP TABLE IF EXISTS `ip_competitor`;
CREATE TABLE `ip_competitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `flag` varchar(255) DEFAULT NULL COMMENT '首页标记（判断当前页面正确）',
  `min_num` int(11) NOT NULL DEFAULT '50',
  `status` enum('active','delete') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ip_competitor
-- ----------------------------
INSERT INTO `ip_competitor` VALUES ('1', 'couponfollow', 'https://couponfollow.com/', 'p', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('2', 'voucher_honey', 'https://www.voucherhoney.co.uk', '<h1 class=\"slogan\">', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('3', 'voucher_cloud', 'https://www.vouchercloud.com', 'class=\"page-section hero-search\"', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('4', 'cuponation_au', 'https://www.cuponation.com.au', 'class=\"cn-main\"', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('5', 'ozdiscount', 'https://www.ozdiscount.net', 'id=\"Glide\"', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('6', 'thebargainavenue', 'http://www.thebargainavenue.com.au', 'title=\"Join Thebargainavenue\"', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');
INSERT INTO `ip_competitor` VALUES ('7', 'topbargains', 'https://www.topbargains.com.au', 'id=\"block-system-main\"', '30', 'active', '2017-10-25 00:40:02', '2017-10-25 14:53:01');

-- ----------------------------
-- Table structure for ip_competitor_catch
-- ----------------------------
DROP TABLE IF EXISTS `ip_competitor_catch`;
CREATE TABLE `ip_competitor_catch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competitor_id` int(11) NOT NULL,
  `catch_success` int(11) NOT NULL DEFAULT '0',
  `catch_fail` int(11) NOT NULL DEFAULT '0',
  `catch_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `competitor_id` (`competitor_id`,`catch_date`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ip_competitor_catch
-- ----------------------------
INSERT INTO `ip_competitor_catch` VALUES ('1', '1', '3', '1', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('2', '2', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('3', '3', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('4', '4', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('5', '5', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('6', '6', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');
INSERT INTO `ip_competitor_catch` VALUES ('7', '7', '0', '0', '2017-10-29', '2017-10-29 16:19:58', '2017-10-29 16:23:38');

-- ----------------------------
-- Table structure for ip_competitor_catch_log
-- ----------------------------
DROP TABLE IF EXISTS `ip_competitor_catch_log`;
CREATE TABLE `ip_competitor_catch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competitor_id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `status` enum('success','fail') NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ip_competitor_catch_log
-- ----------------------------
INSERT INTO `ip_competitor_catch_log` VALUES ('1', '1', '37.187.66.59:3128', 'success', '2017-10-29 15:58:51');
INSERT INTO `ip_competitor_catch_log` VALUES ('2', '1', '37.187.66.59:3128', 'success', '2017-10-29 15:58:52');
INSERT INTO `ip_competitor_catch_log` VALUES ('3', '1', '37.187.66.59:3128', 'success', '2017-10-29 15:58:53');
INSERT INTO `ip_competitor_catch_log` VALUES ('4', '1', '37.187.66.59:3128', 'fail', '2017-10-29 16:00:52');

-- ----------------------------
-- Table structure for ip_source
-- ----------------------------
DROP TABLE IF EXISTS `ip_source`;
CREATE TABLE `ip_source` (
  `competitor_id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `catch_success` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抓取成功次数',
  `catch_fail` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抓取失败次数',
  `status` enum('normal','active','delete') DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `competitor_id` (`competitor_id`,`ip`),
  KEY `competitor_id_2` (`competitor_id`),
  KEY `ip` (`ip`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ip_source
-- ----------------------------
