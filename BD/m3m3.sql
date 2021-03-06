/*
 Navicat Premium Data Transfer

 Source Server         : MySQL localhost
 Source Server Type    : MySQL
 Source Server Version : 80019
 Source Host           : localhost:3306
 Source Schema         : m3m3

 Target Server Type    : MySQL
 Target Server Version : 80019
 File Encoding         : 65001

 Date: 03/06/2020 21:25:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for asignacion
-- ----------------------------
DROP TABLE IF EXISTS `asignacion`;
CREATE TABLE `asignacion`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(0) NOT NULL,
  `created_at` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `asignacion_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of asignacion
-- ----------------------------
INSERT INTO `asignacion` VALUES ('poster', 6, 1590186782);
INSERT INTO `asignacion` VALUES ('poster', 7, 1590305836);
INSERT INTO `asignacion` VALUES ('poster', 9, 1591237240);

-- ----------------------------
-- Table structure for comentario
-- ----------------------------
DROP TABLE IF EXISTS `comentario`;
CREATE TABLE `comentario`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `texto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_usuario` int(0) NOT NULL,
  `id_publicacion` int(0) NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_usuario`(`id_usuario`) USING BTREE,
  INDEX `id_publicacion`(`id_publicacion`) USING BTREE,
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comentario
-- ----------------------------

-- ----------------------------
-- Table structure for etiqueta
-- ----------------------------
DROP TABLE IF EXISTS `etiqueta`;
CREATE TABLE `etiqueta`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of etiqueta
-- ----------------------------
INSERT INTO `etiqueta` VALUES (1, 'Animales', 'paw', 1);
INSERT INTO `etiqueta` VALUES (2, 'Anime', 'rocket', 1);
INSERT INTO `etiqueta` VALUES (3, 'Comida', 'food', 0);
INSERT INTO `etiqueta` VALUES (4, 'GIFs', 'bolt', 1);
INSERT INTO `etiqueta` VALUES (5, 'Videos', 'play', 1);
INSERT INTO `etiqueta` VALUES (6, 'Wholesome', 'star', 1);
INSERT INTO `etiqueta` VALUES (7, 'Divertido', 'smile face', 1);
INSERT INTO `etiqueta` VALUES (8, 'Dank', 'list', 0);
INSERT INTO `etiqueta` VALUES (9, 'Depressing', 'sad face', 0);

-- ----------------------------
-- Table structure for grupo_permisos
-- ----------------------------
DROP TABLE IF EXISTS `grupo_permisos`;
CREATE TABLE `grupo_permisos`  (
  `code` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int(0) NULL DEFAULT NULL,
  `updated_at` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`code`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of grupo_permisos
-- ----------------------------
INSERT INTO `grupo_permisos` VALUES ('poster', 'poster', 1590079563, 1590079563);
INSERT INTO `grupo_permisos` VALUES ('userCommonPermissions', 'User common permission', 1572332208, 1572332208);
INSERT INTO `grupo_permisos` VALUES ('userManagement', 'User management', 1572332207, 1572332207);

-- ----------------------------
-- Table structure for pais
-- ----------------------------
DROP TABLE IF EXISTS `pais`;
CREATE TABLE `pais`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pais
-- ----------------------------
INSERT INTO `pais` VALUES (1, 'mx', 'México', '2020-05-23 00:37:00', NULL);
INSERT INTO `pais` VALUES (2, 'us', 'Estados unidos', '2020-05-23 00:37:08', NULL);
INSERT INTO `pais` VALUES (3, 'es', 'España', '2020-05-23 00:37:20', NULL);

-- ----------------------------
-- Table structure for permiso
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` int(0) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` int(0) NULL DEFAULT NULL,
  `updated_at` int(0) NULL DEFAULT NULL,
  `group_code` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  INDEX `fk_auth_item_group_code`(`group_code`) USING BTREE,
  CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `rol` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`group_code`) REFERENCES `grupo_permisos` (`code`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permiso
-- ----------------------------
INSERT INTO `permiso` VALUES ('/*', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth-item-group/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/change-own-password', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/confirm-email', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/confirm-email-receive', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/confirm-registration-email', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/login', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/logout', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/password-recovery', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/password-recovery-receive', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/auth/registration', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/*', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/refresh-routes', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/set-child-permissions', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/set-child-routes', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/permission/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/*', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/bulk-activate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/bulk-deactivate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/bulk-delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/create', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/grid-page-size', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/grid-sort', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/index', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/set-child-permissions', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/set-child-roles', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/toggle-attribute', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/update', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/role/view', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-permission/*', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-permission/set', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-permission/set-roles', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/*', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/bulk-activate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/bulk-deactivate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/bulk-delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/create', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/grid-page-size', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/grid-sort', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/index', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/toggle-attribute', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/update', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user-visit-log/view', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/*', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/bulk-activate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/bulk-deactivate', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/bulk-delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/change-password', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/create', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/delete', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/grid-page-size', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/grid-sort', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/index', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/toggle-attribute', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/update', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/auth/user/view', 3, NULL, NULL, NULL, 1591237078, 1591237078, NULL);
INSERT INTO `permiso` VALUES ('/base/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/comentario/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/comentario/new', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/db-explain', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/download-mail', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/toolbar', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/default/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/user/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/user/reset-identity', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/debug/user/set-identity', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/etiqueta/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/etiqueta/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/etiqueta/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/etiqueta/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/etiqueta/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/gii/*', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/*', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/action', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/diff', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/index', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/preview', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/gii/default/view', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/site/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/captcha', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/comment', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/comments', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/error', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/feed', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/post', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/settings', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/site/upload', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/*', 3, NULL, NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth-item-group/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/change-own-password', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/confirm-email', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/confirm-email-receive', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/confirm-registration-email', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/login', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/logout', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/password-recovery', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/password-recovery-receive', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/auth/registration', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/refresh-routes', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/set-child-permissions', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/set-child-routes', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/permission/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/set-child-permissions', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/set-child-roles', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/role/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-permission/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-permission/set', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-permission/set-roles', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/bulk-activate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/bulk-deactivate', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/bulk-delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/create', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/delete', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/grid-page-size', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/index', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/update', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user-visit-log/view', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/*', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/bulk-activate', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/bulk-deactivate', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/bulk-delete', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/change-password', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/create', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/delete', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/grid-page-size', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/grid-sort', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/index', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/toggle-attribute', 3, NULL, NULL, NULL, 1591237079, 1591237079, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/update', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('/user-management/user/view', 3, NULL, NULL, NULL, 1572332208, 1572332208, NULL);
INSERT INTO `permiso` VALUES ('Admin', 1, 'Admin', NULL, NULL, 1572332207, 1572332207, NULL);
INSERT INTO `permiso` VALUES ('assignRolesToUsers', 2, 'Assign roles to users', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('bindUserToIp', 2, 'Bind user to IP', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('changeOwnPassword', 2, 'Change own password', NULL, NULL, 1572332208, 1572332208, 'userCommonPermissions');
INSERT INTO `permiso` VALUES ('changeUserPassword', 2, 'Change user password', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('commonPermission', 2, 'Common permission', NULL, NULL, 1572332206, 1572332206, NULL);
INSERT INTO `permiso` VALUES ('createUsers', 2, 'Create users', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('deleteUsers', 2, 'Delete users', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('editUserEmail', 2, 'Edit user email', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('editUsers', 2, 'Edit users', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('p', 2, 'poster', NULL, NULL, 1591236784, 1591236784, 'poster');
INSERT INTO `permiso` VALUES ('poster', 1, 'poster', NULL, NULL, 1590079501, 1590079501, NULL);
INSERT INTO `permiso` VALUES ('viewRegistrationIp', 2, 'View registration IP', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('viewUserEmail', 2, 'View user email', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('viewUserRoles', 2, 'View user roles', NULL, NULL, 1572332208, 1572332208, 'userManagement');
INSERT INTO `permiso` VALUES ('viewUsers', 2, 'View users', NULL, NULL, 1572332207, 1572332207, 'userManagement');
INSERT INTO `permiso` VALUES ('viewVisitLog', 2, 'View visit log', NULL, NULL, 1572332208, 1572332208, 'userManagement');

-- ----------------------------
-- Table structure for publicacion
-- ----------------------------
DROP TABLE IF EXISTS `publicacion`;
CREATE TABLE `publicacion`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `url` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nsfw` tinyint(0) NOT NULL,
  `id_usuario` int(0) NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `url`(`url`) USING BTREE,
  INDEX `id_usuario`(`id_usuario`) USING BTREE,
  CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of publicacion
-- ----------------------------

-- ----------------------------
-- Table structure for puntaje_comentario
-- ----------------------------
DROP TABLE IF EXISTS `puntaje_comentario`;
CREATE TABLE `puntaje_comentario`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `puntaje` tinyint(0) NULL DEFAULT NULL,
  `id_usuario` int(0) NOT NULL,
  `id_comentario` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_usuario`(`id_usuario`) USING BTREE,
  INDEX `id_publicacion`(`id_comentario`) USING BTREE,
  CONSTRAINT `puntaje_comentario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `puntaje_comentario_ibfk_2` FOREIGN KEY (`id_comentario`) REFERENCES `comentario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of puntaje_comentario
-- ----------------------------

-- ----------------------------
-- Table structure for puntaje_publicacion
-- ----------------------------
DROP TABLE IF EXISTS `puntaje_publicacion`;
CREATE TABLE `puntaje_publicacion`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `puntaje` tinyint(0) NULL DEFAULT NULL,
  `id_usuario` int(0) NOT NULL,
  `id_publicacion` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_usuario`(`id_usuario`) USING BTREE,
  INDEX `id_publicacion`(`id_publicacion`) USING BTREE,
  CONSTRAINT `puntaje_publicacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `puntaje_publicacion_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of puntaje_publicacion
-- ----------------------------

-- ----------------------------
-- Table structure for rel_permiso_grupo_permisos
-- ----------------------------
DROP TABLE IF EXISTS `rel_permiso_grupo_permisos`;
CREATE TABLE `rel_permiso_grupo_permisos`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `rel_permiso_grupo_permisos_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rel_permiso_grupo_permisos_ibfk_2` FOREIGN KEY (`child`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rel_permiso_grupo_permisos
-- ----------------------------
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/auth/auth/change-own-password');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/auth/auth/login');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/auth/auth/logout');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/comentario/new');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/comment');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/comments');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/error');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/feed');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/index');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/post');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/settings');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/site/upload');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('changeOwnPassword', '/user-management/auth/change-own-password');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/user-management/auth/change-own-password');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/user-management/auth/login');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('p', '/user-management/auth/logout');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('assignRolesToUsers', '/user-management/user-permission/set');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('assignRolesToUsers', '/user-management/user-permission/set-roles');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('editUsers', '/user-management/user/bulk-activate');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('editUsers', '/user-management/user/bulk-deactivate');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('deleteUsers', '/user-management/user/bulk-delete');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('changeUserPassword', '/user-management/user/change-password');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('createUsers', '/user-management/user/create');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('deleteUsers', '/user-management/user/delete');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('viewUsers', '/user-management/user/grid-page-size');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('viewUsers', '/user-management/user/index');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('editUsers', '/user-management/user/update');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('viewUsers', '/user-management/user/view');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'assignRolesToUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'changeOwnPassword');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('poster', 'changeOwnPassword');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'changeUserPassword');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'createUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'deleteUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'editUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('poster', 'p');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('editUserEmail', 'viewUserEmail');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('assignRolesToUsers', 'viewUserRoles');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('Admin', 'viewUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('assignRolesToUsers', 'viewUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('changeUserPassword', 'viewUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('createUsers', 'viewUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('deleteUsers', 'viewUsers');
INSERT INTO `rel_permiso_grupo_permisos` VALUES ('editUsers', 'viewUsers');

-- ----------------------------
-- Table structure for rel_publicacion_etiqueta
-- ----------------------------
DROP TABLE IF EXISTS `rel_publicacion_etiqueta`;
CREATE TABLE `rel_publicacion_etiqueta`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `id_publicacion` int(0) NOT NULL,
  `id_etiqueta` int(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rel_publicacion_etiqueta_ibfk_2`(`id_etiqueta`) USING BTREE,
  INDEX `id_publicacion`(`id_publicacion`) USING BTREE,
  CONSTRAINT `rel_publicacion_etiqueta_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiqueta` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rel_publicacion_etiqueta_ibfk_3` FOREIGN KEY (`id_publicacion`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rel_publicacion_etiqueta
-- ----------------------------

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created_at` int(0) NULL DEFAULT NULL,
  `updated_at` int(0) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rol
-- ----------------------------

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `confirmation_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(0) NOT NULL DEFAULT 1,
  `superadmin` smallint(0) NULL DEFAULT 0,
  `created_at` int(0) NOT NULL,
  `updated_at` int(0) NOT NULL,
  `registration_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bind_to_ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email_confirmed` smallint(0) NOT NULL DEFAULT 0,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `avatar` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_pais` int(0) NULL DEFAULT NULL,
  `nsfw` tinyint(0) NOT NULL DEFAULT 0,
  `sexo` tinyint(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `avatar`(`avatar`) USING BTREE,
  INDEX `id_pais`(`id_pais`) USING BTREE,
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 'm3m3boss', 'zbW1eZpAQMkdriDVTeu810P1aIV_xBKY', '$2y$13$JRAll.pQglbCTVqMCWzaLeQ6g6OKU1m9JDGrT4c.CMRuwsDoRZueu', NULL, 1, 1, 1572332206, 1590022648, NULL, '', 'admin@me.me', 1, NULL, NULL, 'Administrador', '1998-06-22', '/media/avatars/superadmin.jpg', 1, 1, 0);
INSERT INTO `usuario` VALUES (6, 'donal_56', 'kWLrv3PuaM_1rQQQmeXCnzOEe3ZNo5JQ', '$2y$13$7WRkGxgBfQW5FH1K.vE19.U.0MM4Xc/6jXhGGfR28HtVyTUdvpcIu', NULL, 1, NULL, 1590186782, 1590305423, '127.0.0.1', '', 'donal_56@hotmail.com', 0, NULL, NULL, 'Carlos Donaldo Ramon Gómez', NULL, '/media/avatars/donal_56.png', NULL, 0, NULL);
INSERT INTO `usuario` VALUES (7, 'Usuario240', 'AI-pvChfBvK5FUtuHEaylw5IHNVvqHhg', '$2y$13$EcI6ZX/ysmskQ6jMkwSD5egW0UbE4940XN/B91ZmmxVhzLDhvmOBC', NULL, 1, NULL, 1590305836, 1590309123, '127.0.0.1', '', 'Usuario240@hotmail.com', 0, NULL, NULL, 'Usuario240', NULL, '/media/avatars/Usuario240.jpg', NULL, 0, NULL);
INSERT INTO `usuario` VALUES (9, 'User5235', 'gGGpxY9SBiM9Y3KufI0pLPJCovhc7DWp', '$2y$13$mtg.5y1Im2i4aNDxAY6hiu3XRfcqvGwPibATbjzGjkDlz4USZ/RX2', NULL, 1, NULL, 1591237240, 1591237240, '127.0.0.1', '', 'user5235@hotmail.com', 0, NULL, NULL, 'Usuario', NULL, '/media/avatars/User5235.png', NULL, 0, NULL);

-- ----------------------------
-- Table structure for visita
-- ----------------------------
DROP TABLE IF EXISTS `visita`;
CREATE TABLE `visita`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(0) NULL DEFAULT NULL,
  `visit_time` int(0) NOT NULL,
  `browser` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `os` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of visita
-- ----------------------------
INSERT INTO `visita` VALUES (26, '5ec6aff2e7223', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1590079474, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (27, '5ec6b2ba7fe10', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1590080186, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (28, '5ec72538e4bde', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1590109496, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (29, '5ec8102c16ba0', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1590169644, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (30, '5ec8506c3fed3', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', NULL, 1590186092, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (31, '5ec8531e7a8e2', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 6, 1590186782, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (32, '5ec853d43a5a5', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 6, 1590186964, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (33, '5ec969866d385', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 6, 1590258054, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (34, '5eca1eb1028e4', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 6, 1590304433, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (35, '5eca242c4e14d', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 7, 1590305836, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (36, '5eca264c579cf', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 7, 1590306380, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (37, '5eca28acc8e3d', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 7, 1590306988, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (38, '5ed0b1f909fa4', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1590735353, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (39, '5ed53546213c0', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591031110, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (40, '5ed7550d926d1', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591170317, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (41, '5ed76055bde29', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591173205, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (42, '5ed84f8a20262', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591234442, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (43, '5ed855b461f12', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591236020, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (44, '5ed857647241e', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', NULL, 1591236452, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (45, '5ed8581c6cfc4', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591236636, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (46, '5ed85a78ebb64', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 9, 1591237240, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (47, '5ed85ad4b2943', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 1, 1591237332, 'Chrome', 'Windows');
INSERT INTO `visita` VALUES (48, '5ed85b0290dd8', '127.0.0.1', 'es', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.142 Safari/537.36', 9, 1591237378, 'Chrome', 'Windows');

-- ----------------------------
-- Procedure structure for comments
-- ----------------------------
DROP PROCEDURE IF EXISTS `comments`;
delimiter ;;
CREATE PROCEDURE `comments`(IN `url` text, IN `type` text, IN `user` int)
BEGIN
	IF url IS NOT NULL THEN
		SET @user = user;
		SET @url = url;
		
		SET @query = "SELECT 
		c.*,
		u.username poster,
		u.avatar poster_avatar,
		c.media REGEXP '(.mp4|.avi|.webm)$' es_video,
		IFNULL(l.numero, 0) puntuacion,
		pun.puntaje me_gusta
		FROM comentario c
		INNER JOIN publicacion p ON c.id_publicacion = p.id
		LEFT JOIN (SELECT pun.id_comentario, sum(pun.puntaje) numero FROM puntaje_comentario pun GROUP BY pun.id_comentario) l ON l.id_comentario = c.id
		LEFT JOIN puntaje_comentario pun ON (pun.id_comentario = c.id AND pun.id_usuario = ?)
		INNER JOIN usuario u ON c.id_usuario = u.id
		WHERE p.url= ? ";
		
		CASE type
			WHEN "destacado" THEN
				SET @query = CONCAT(@query, "ORDER BY puntuacion DESC ");
			WHEN "nuevo" THEN
				SET @query = CONCAT(@query, "ORDER BY c.fecha_creacion DESC ");
			ELSE
				BEGIN END;
		END CASE;		
		
		PREPARE stmt FROM @query;
		EXECUTE stmt USING @user, @url;
		DEALLOCATE PREPARE stmt;
		
	END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for feed
-- ----------------------------
DROP PROCEDURE IF EXISTS `feed`;
delimiter ;;
CREATE PROCEDURE `feed`(IN `page` int, IN `type` text, IN `tag` text, IN `user` int, IN `nsfw` int)
BEGIN
	SET @paginacion = 3;
	SET @desfase = (page - 1) * @paginacion;
	SET @user = user;
	
	IF page >= 1 AND type IS NOT NULL AND nsfw IN (1, 0)THEN
		SET @query = "SELECT 
		p.*,
		u.username poster,
		u.avatar poster_avatar,
		p.media REGEXP '(.mp4|.avi|.webm)$' es_video,
		IFNULL(c.numero, 0) comentarios,
		IFNULL(l.numero, 0) puntuacion,
		GROUP_CONCAT(DISTINCT e.nombre ORDER BY e.nombre SEPARATOR ', ') etiquetas,
		pun.puntaje me_gusta
		FROM publicacion p
		INNER JOIN rel_publicacion_etiqueta rel  ON rel.id_publicacion = p.id
		INNER JOIN etiqueta e ON rel.id_etiqueta = e.id
		INNER JOIN usuario u ON p.id_usuario = u.id
		LEFT JOIN (SELECT com.id_publicacion, count(com.id_publicacion) numero FROM comentario com GROUP BY com.id_publicacion) c ON c.id_publicacion = p.id
		LEFT JOIN (SELECT pun.id_publicacion, sum(pun.puntaje) numero FROM puntaje_publicacion pun GROUP BY pun.id_publicacion) l ON l.id_publicacion = p.id
		LEFT JOIN puntaje_publicacion pun ON (pun.id_publicacion = p.id AND pun.id_usuario = ?)
		WHERE e.activo = 1 ";
		
		IF nsfw = 0 THEN
				SET @query = CONCAT(@query, " AND p.nsfw = false ");
		END IF;
		
		IF tag IS NOT NULL THEN
				SET @query = CONCAT(@query, " AND e.nombre = '", tag, "' ");
		END IF;
		
		SET @query = CONCAT(@query, "GROUP BY p.id ");
		
		CASE type
			WHEN "popular" THEN
				SET @query = CONCAT(@query, "ORDER BY comentarios DESC ");
			WHEN "tendencia" THEN
				SET @query = CONCAT(@query, "ORDER BY puntuacion DESC ");
			WHEN "nuevo" THEN
				SET @query = CONCAT(@query, "ORDER BY p.fecha_creacion DESC ");
			ELSE
				BEGIN END;
		END CASE;		
		
		SET @query = CONCAT(@query, "LIMIT ? OFFSET ?;");
		
		PREPARE stmt FROM @query;
		EXECUTE stmt USING @user, @paginacion, @desfase;
		DEALLOCATE PREPARE stmt;
		
	END IF;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for post
-- ----------------------------
DROP PROCEDURE IF EXISTS `post`;
delimiter ;;
CREATE PROCEDURE `post`(IN `url` text, IN `user` int)
BEGIN
	SELECT 
	p.*,
	u.username poster,
	u.avatar poster_avatar,
	p.media REGEXP '(.mp4|.avi|.webm)$' es_video,
	IFNULL(c.numero, 0) comentarios,
	IFNULL(l.numero, 0) puntuacion,
	GROUP_CONCAT(DISTINCT e.nombre ORDER BY e.nombre SEPARATOR ', ') etiquetas,
	pun.puntaje me_gusta
	FROM publicacion p
	INNER JOIN rel_publicacion_etiqueta rel  ON rel.id_publicacion = p.id
	INNER JOIN etiqueta e ON rel.id_etiqueta = e.id
	INNER JOIN usuario u ON p.id_usuario = u.id
	LEFT JOIN (SELECT com.id_publicacion, count(com.id_publicacion) numero FROM comentario com GROUP BY com.id_publicacion) c ON c.id_publicacion = p.id
	LEFT JOIN (SELECT pun.id_publicacion, sum(pun.puntaje) numero FROM puntaje_publicacion pun GROUP BY pun.id_publicacion) l ON l.id_publicacion = p.id
	LEFT JOIN puntaje_publicacion pun ON (pun.id_publicacion = p.id AND pun.id_usuario = user)
	WHERE e.activo = 1 AND p.url = url GROUP BY url;

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
