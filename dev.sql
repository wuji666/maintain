/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : dev

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-11 09:25:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '管理员密码',
  `truename` varchar(20) NOT NULL COMMENT '管理员真实姓名',
  `gid` int(10) NOT NULL COMMENT '角色id',
  `status` tinyint(1) NOT NULL COMMENT '状态：0正常，1禁用',
  `add_time` int(10) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'a66abb5684c45962d887564f08346e8d', '123123', '3', '0', '0');
INSERT INTO `admins` VALUES ('4', 'lge', '3b84277cde329ce519e63b91c7aa8740', '张永刚', '1', '0', '1551239384');

-- ----------------------------
-- Table structure for `admin_groups`
-- ----------------------------
DROP TABLE IF EXISTS `admin_groups`;
CREATE TABLE `admin_groups` (
  `gid` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL COMMENT '角色名称',
  `rights` text NOT NULL COMMENT '菜单的mid，已json方式存储',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_groups
-- ----------------------------
INSERT INTO `admin_groups` VALUES ('1', '系统管理员', '[1,3,6,7,8,9,52,10,11,13,14,15,16,17,40,51,50,49,48,47,46,45,44,43,42,41]');
INSERT INTO `admin_groups` VALUES ('3', '网站编辑', '[1,3,6,40,45,44,41]');

-- ----------------------------
-- Table structure for `admin_menus`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menus`;
CREATE TABLE `admin_menus` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL COMMENT '上级菜单',
  `ord` int(10) NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL COMMENT '菜单名称',
  `controller` varchar(30) NOT NULL COMMENT '控制器',
  `method` varchar(30) NOT NULL COMMENT '控制器方法',
  `ishidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否隐藏：0正常，1隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0正常，1禁用',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menus
-- ----------------------------
INSERT INTO `admin_menus` VALUES ('1', '0', '0', 'Home页面', 'home', 'index', '1', '0');
INSERT INTO `admin_menus` VALUES ('3', '1', '0', '欢迎页面', 'home', 'welcome', '1', '0');
INSERT INTO `admin_menus` VALUES ('6', '0', '0', '管理员管理', '', '', '0', '0');
INSERT INTO `admin_menus` VALUES ('7', '6', '0', '管理员列表', 'admin', 'index', '0', '0');
INSERT INTO `admin_menus` VALUES ('8', '6', '0', '管理员添加', 'admin', 'add', '1', '0');
INSERT INTO `admin_menus` VALUES ('9', '6', '0', '管理员保存', 'admin', 'save', '1', '0');
INSERT INTO `admin_menus` VALUES ('10', '0', '0', '权限管理', '', '', '0', '0');
INSERT INTO `admin_menus` VALUES ('11', '10', '0', '菜单列表', 'menu', 'index', '0', '0');
INSERT INTO `admin_menus` VALUES ('13', '10', '0', '菜单添加', 'menu', 'add', '1', '0');
INSERT INTO `admin_menus` VALUES ('14', '10', '0', '菜单保存', 'menu', 'save', '1', '0');
INSERT INTO `admin_menus` VALUES ('15', '10', '0', '角色列表', 'roles', 'index', '0', '0');
INSERT INTO `admin_menus` VALUES ('16', '10', '0', '角色添加', 'roles', 'add', '1', '0');
INSERT INTO `admin_menus` VALUES ('17', '10', '0', '角色保存', 'roles', 'save', '1', '0');
INSERT INTO `admin_menus` VALUES ('52', '6', '0', '管理员删除', 'admin', 'delete', '1', '0');
INSERT INTO `admin_menus` VALUES ('51', '40', '0', '关键词信息保存', 'keyword', 'ensure', '1', '0');
INSERT INTO `admin_menus` VALUES ('50', '40', '0', '关键词信息修改', 'keyword', 'alter', '1', '0');
INSERT INTO `admin_menus` VALUES ('49', '40', '0', '关键词批量删除', 'keyword', 'deleteAll', '1', '0');
INSERT INTO `admin_menus` VALUES ('48', '40', '0', '关键词导出', 'keyword', 'download', '1', '0');
INSERT INTO `admin_menus` VALUES ('47', '40', '0', '关键词上传保存', 'keyword', 'add', '1', '0');
INSERT INTO `admin_menus` VALUES ('46', '40', '0', '关键词上传', 'keyword', 'upload', '1', '0');
INSERT INTO `admin_menus` VALUES ('45', '40', '0', '关键词编辑保存', 'keyword', 'save', '1', '0');
INSERT INTO `admin_menus` VALUES ('44', '40', '0', '关键词编辑', 'keyword', 'edit', '1', '0');
INSERT INTO `admin_menus` VALUES ('43', '40', '0', '关键词删除', 'keyword', 'delete', '1', '0');
INSERT INTO `admin_menus` VALUES ('42', '40', '0', '关键词分配', 'keyword', 'allot', '1', '0');
INSERT INTO `admin_menus` VALUES ('41', '40', '0', '关键词列表', 'keyword', 'index', '0', '0');
INSERT INTO `admin_menus` VALUES ('40', '0', '0', '关键词管理', '', '', '0', '0');

-- ----------------------------
-- Table structure for `keyword_artice`
-- ----------------------------
DROP TABLE IF EXISTS `keyword_artice`;
CREATE TABLE `keyword_artice` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL COMMENT '编辑名称',
  `ok_time` int(10) unsigned NOT NULL COMMENT '完成时间',
  `article_url` varchar(100) NOT NULL COMMENT '相关文章地址',
  `label` varchar(10) NOT NULL COMMENT '标签',
  `read_num` float(100,0) unsigned NOT NULL DEFAULT '0' COMMENT '文章阅读量',
  `add_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `performance` float(10,2) unsigned NOT NULL DEFAULT '1.00' COMMENT '绩效',
  `kid` int(255) unsigned NOT NULL COMMENT '关键词id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1代表完成  0代表未完成',
  `desc` text NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keyword_artice
-- ----------------------------

-- ----------------------------
-- Table structure for `keyword_info`
-- ----------------------------
DROP TABLE IF EXISTS `keyword_info`;
CREATE TABLE `keyword_info` (
  `kid` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '关键词id',
  `add_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `key_word_name` varchar(100) NOT NULL COMMENT '关键词名称',
  `count_day_search` float(100,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总日均搜索',
  `move_day_search` float(100,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '移动端日均搜索',
  `pc_ranking` float(100,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'pc端排名',
  `move_ranking` float(100,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '移动端排名',
  `is_issue` varchar(10) NOT NULL COMMENT '是否为问答',
  `ok_time` int(10) unsigned NOT NULL COMMENT '预计完成时间',
  `user_name` varchar(50) NOT NULL COMMENT '编辑名',
  PRIMARY KEY (`kid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of keyword_info
-- ----------------------------
