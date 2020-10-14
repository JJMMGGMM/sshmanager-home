/*
Navicat MySQL Data Transfer

Source Server         : MYSQL
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : sshmanager_home_app

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2020-09-28 19:01:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `activated_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remember_session` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_expiration` int(10) unsigned DEFAULT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `remaining_emails` int(10) unsigned NOT NULL,
  `block_emails_until` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'sshmanager', 'sshmanager@email.com', '$2y$12$ZS8vb09UQlduZUdlNDI3QuCZS4ev8b9/vsiCbXCEVqhELcgY3WhoC', '2020-09-10 20:16:08', '2020-09-10 20:18:08', '2020-09-04 00:07:39', null, null, 'f1d42c02ea1c7aad514f91faa3cc6f37', '1602028788', '1', '3', null);

-- ----------------------------
-- Table structure for features
-- ----------------------------
DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `feature_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_id` int(10) unsigned NOT NULL,
  `title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`feature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of features
-- ----------------------------
INSERT INTO `features` VALUES ('1', '2', 'Instalador principal', 'Herramienta para instalar completamente el script', 'ico-1592377524.png', 'img-1592377524.png', '2020-06-17 02:05:24', null);
INSERT INTO `features` VALUES ('2', '2', 'Desinstalador principal', 'Herramienta para desinstalar completamente el script', 'ico-1592451664.png', 'img-1592451664.png', '2020-06-17 18:10:26', '2020-06-17 22:41:04');
INSERT INTO `features` VALUES ('3', '2', 'Menú de entrada', 'Apartado para acceder a todas las funciones disponibles', 'ico-1592452026.png', 'img-1592452026.png', '2020-06-17 19:40:44', '2020-06-17 22:47:06');
INSERT INTO `features` VALUES ('4', '2', 'Menú de usuarios', 'Apartado para controlar a todos los usuarios disponibles', 'ico-1592452132.png', 'img-1592452132.png', '2020-06-17 20:29:27', '2020-06-17 22:48:52');
INSERT INTO `features` VALUES ('5', '2', 'Administrador SSH', 'Administrador de servicio SSH y Dropbear', 'ico-1592453082.png', 'img-1592453082.png', '2020-06-17 23:04:42', null);
INSERT INTO `features` VALUES ('6', '2', 'Administrador Squid', 'Administrador de servicio Squid Proxy', 'ico-1592453227.png', 'img-1592453227.png', '2020-06-17 23:07:07', null);
INSERT INTO `features` VALUES ('7', '2', 'Administrador Stunnel', 'Administrador de servicio SSL', 'ico-1592453403.png', 'img-1592453403.png', '2020-06-17 23:10:03', null);
INSERT INTO `features` VALUES ('8', '2', 'Administrador OpenVPN', 'Administrador de servicio OpenVPN', 'ico-1592453471.png', 'img-1592453471.png', '2020-06-17 23:11:11', null);
INSERT INTO `features` VALUES ('9', '2', 'Administrador Shadowsocks', 'Administrador de servicio Shadowsocks', 'ico-1592453584.png', 'img-1592453584.png', '2020-06-17 23:12:03', '2020-06-17 23:13:04');
INSERT INTO `features` VALUES ('10', '2', 'Administrador V2Ray', 'Administrador de servicio V2Ray', 'ico-1593842411.png', 'img-1593842411.png', '2020-06-17 23:14:13', '2020-08-05 00:26:48');
INSERT INTO `features` VALUES ('11', '1', 'Main installer', 'Install, customize and use the tools only what you need', 'ico-1597783133.png', 'img-1597783133.png', '2020-08-18 15:38:53', '2020-08-18 16:08:56');
INSERT INTO `features` VALUES ('12', '1', 'Main uninstaller', 'No need to recreate the VM, full cleaning of components', 'ico-1597783693.png', 'img-1597783693.png', '2020-08-18 15:48:13', '2020-08-18 16:18:37');
INSERT INTO `features` VALUES ('13', '1', 'Main menu', 'Access to all available included functions in a few steps', 'ico-1597785776.png', 'img-1597785776.png', '2020-08-18 16:22:56', '2020-08-18 16:25:58');
INSERT INTO `features` VALUES ('14', '1', 'Users menu', 'Create, update, backup, restore, limit your users easily', 'ico-1597787058.png', 'img-1597787058.png', '2020-08-18 16:44:18', null);
INSERT INTO `features` VALUES ('15', '1', 'SSH service manager', 'Controls and manages SSH and Dropbear services', 'ico-1597791319.png', 'img-1597791319.png', '2020-08-18 17:55:19', null);
INSERT INTO `features` VALUES ('16', '1', 'Squid service manager', 'Controls and manages Squid proxy service', 'ico-1597793569.png', 'img-1597793569.png', '2020-08-18 18:32:49', null);
INSERT INTO `features` VALUES ('17', '1', 'Stunnel service manager', 'Controls and manages SSL Stunnel service', 'ico-1597794414.png', 'img-1597794414.png', '2020-08-18 18:46:54', null);
INSERT INTO `features` VALUES ('18', '1', 'OpenVPN service manager', 'Controls and manages OpenVPN service', 'ico-1597795264.png', 'img-1597795264.png', '2020-08-18 19:01:04', null);
INSERT INTO `features` VALUES ('19', '1', 'Shadowsocks service manager', 'Controls and manages Shadowsocks service', 'ico-1597796110.png', 'img-1597796110.png', '2020-08-18 19:12:00', '2020-08-18 19:15:10');
INSERT INTO `features` VALUES ('20', '1', 'V2Ray service manager', 'Controls and manages V2Ray service', 'ico-1597796033.png', 'img-1597796033.png', '2020-08-18 19:13:53', null);

-- ----------------------------
-- Table structure for languages
-- ----------------------------
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `lang_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of languages
-- ----------------------------
INSERT INTO `languages` VALUES ('1', 'english', 'en', '2020-08-18 00:29:03', null);
INSERT INTO `languages` VALUES ('2', 'spanish', 'es', '2020-08-18 00:29:20', null);

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_at` datetime NOT NULL,
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for operations
-- ----------------------------
DROP TABLE IF EXISTS `operations`;
CREATE TABLE `operations` (
  `operation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `operation_type_id` int(10) unsigned NOT NULL,
  `admin_id` int(10) unsigned NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` datetime NOT NULL,
  PRIMARY KEY (`operation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of operations
-- ----------------------------

-- ----------------------------
-- Table structure for operation_types
-- ----------------------------
DROP TABLE IF EXISTS `operation_types`;
CREATE TABLE `operation_types` (
  `operation_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`operation_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of operation_types
-- ----------------------------
INSERT INTO `operation_types` VALUES ('1', 'ACC_ACTIVATION');
INSERT INTO `operation_types` VALUES ('2', 'ACC_UPDATE_EMAIL');
INSERT INTO `operation_types` VALUES ('3', 'ACC_UPDATE_PASSWORD');
INSERT INTO `operation_types` VALUES ('4', 'ACC_DELETE');
INSERT INTO `operation_types` VALUES ('5', 'ACC_RECOVER');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `permission_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'ADMIN', '2020-05-29 14:13:28');
INSERT INTO `permissions` VALUES ('2', 'LIMITED', '2020-05-29 18:24:46');
INSERT INTO `permissions` VALUES ('3', 'VISITOR', '2020-05-29 18:25:15');
INSERT INTO `permissions` VALUES ('4', 'BLOCKED', '2020-07-15 15:17:17');

-- ----------------------------
-- Table structure for unsuscribe
-- ----------------------------
DROP TABLE IF EXISTS `unsuscribe`;
CREATE TABLE `unsuscribe` (
  `unsuscribed_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`unsuscribed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of unsuscribe
-- ----------------------------
