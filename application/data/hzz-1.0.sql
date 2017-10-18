/*
Navicat MySQL Data Transfer

Source Server         : 47.95.254.19
Source Server Version : 50556
Source Host           : 47.95.254.19:3306
Source Database       : hzz

Target Server Type    : MYSQL
Target Server Version : 50556
File Encoding         : 65001

Date: 2017-10-16 21:22:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for hzz_admin
-- ----------------------------
DROP TABLE IF EXISTS `hzz_admin`;
CREATE TABLE `hzz_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `passwd` varchar(50) NOT NULL COMMENT '密码',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `type` varchar(50) DEFAULT NULL COMMENT '类别',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '级别',
  `visits_ip2` varchar(20) DEFAULT NULL COMMENT '本次登陆ip',
  `visits_ip1` varchar(20) DEFAULT NULL COMMENT '上次登陆ip',
  `visits` int(10) DEFAULT NULL COMMENT '访问数',
  `sex` int(1) DEFAULT NULL,
  `updata_time` varchar(100) DEFAULT NULL,
  `create_time` varchar(50) DEFAULT NULL,
  `cookie` varchar(50) DEFAULT NULL COMMENT 'cookie验证登陆id',
  `state` int(1) DEFAULT '0' COMMENT '登陆状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of hzz_admin
-- ----------------------------
INSERT INTO `hzz_admin` VALUES ('1', 'admin', '15136079974', '09dd36a74a0b20e210475e0bb7518d6478a7f5a9', '631347947@qq.com', null, '0', '218.28.247.42', '218.28.247.42', '37', '0', '1508159429', '1506823611', 'ae1a2509798876106e7dbbdc041223fa', '1');
INSERT INTO `hzz_admin` VALUES ('2', 'zq', null, '09dd36a74a0b20e210475e0bb7518d6478a7f5a9', '6313479417@qq.com', null, '0', '127.0.0.1', '127.0.0.1', '6', '0', '1506823611', '1506823611', null, '0');

-- ----------------------------
-- Table structure for hzz_article
-- ----------------------------
DROP TABLE IF EXISTS `hzz_article`;
CREATE TABLE `hzz_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title2` varchar(255) DEFAULT NULL COMMENT '简略标题',
  `title` varchar(255) NOT NULL,
  `column` varchar(100) DEFAULT NULL COMMENT '栏目',
  `type` varchar(100) DEFAULT NULL COMMENT '类型',
  `sort` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键词',
  `abstract` text COMMENT '摘要、简介',
  `author` varchar(100) DEFAULT NULL COMMENT '作者',
  `sources` varchar(100) DEFAULT '本站' COMMENT '来源',
  `file` varchar(200) DEFAULT NULL COMMENT '缩略图',
  `editorvalue` text COMMENT '内容',
  `updata_time` varchar(20) DEFAULT NULL,
  `create_time` varchar(20) DEFAULT NULL,
  `click` int(10) DEFAULT '0' COMMENT '点击数',
  `state` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hzz_article
-- ----------------------------
INSERT INTO `hzz_article` VALUES ('31', '简略标题', '标题', null, '帮助说明', '0', '1000', '摘要', 'admin', '本站', '', '<p>内容</p>', '1507017251', '1507017251', '0', '0');
INSERT INTO `hzz_article` VALUES ('29', '建标', '111', '0', '帮助说明', '50', '', '', 'admin', '本站', '', '<p>1</p>', '1507016709', '1507016709', '0', '0');
INSERT INTO `hzz_article` VALUES ('18', '简略标题', '咨询标题（测试）', '行业新闻', '帮助说明', '0', '测试，尝试，显示', '摘要', 'admin', '本站', null, '这里是正文', '1506823611', '1506803611', '0', '0');
INSERT INTO `hzz_article` VALUES ('19', '简略标题', '咨询标题（测试）', '行业新闻', '帮助说明', '0', '测试，尝试，显示', '摘要', 'admin', '本站', null, '这里是正文', '1506823611', '1506803611', '0', '0');
INSERT INTO `hzz_article` VALUES ('20', '简略标题', '咨询标题（测试）', '行业新闻', '帮助说明', '0', '测试，尝试，显示', '摘要', 'admin', '本站', null, '这里是正文', '1506823611', '1506803611', '0', '0');
INSERT INTO `hzz_article` VALUES ('21', '简略标题', '咨询标题（测试）', '行业新闻', '帮助说明', '0', '测试，尝试，显示', '摘要', 'admin', '本站', null, '这里是正文', '1506823611', '1506803611', '0', '0');
INSERT INTO `hzz_article` VALUES ('22', '111', '111', '0', '帮助说明', '1', '1', '1', '01', '01', '', '<p>凄凄切切</p>', '1506857023', '1506857023', '0', '0');
INSERT INTO `hzz_article` VALUES ('24', '22', '222', '0', '帮助说明', '2', '22', '2', 'admin', '本站', '', '<p>222</p>', '1506860192', '1506860192', '0', '0');
INSERT INTO `hzz_article` VALUES ('25', '33', '233', '0', '帮助说明', '0', '3', '33', 'admin', '本站', '', '<p>333</p>', '1506860258', '1506860258', '0', '0');
INSERT INTO `hzz_article` VALUES ('26', '33', '233', '0', '帮助说明', '0', '3', '33', 'admin', '本站', '', '', '1506860295', '1506860295', '0', '1');
INSERT INTO `hzz_article` VALUES ('28', '33', '233', '0', '帮助说明', '0', '3', '33', 'admin', '本站', '', '<p>qqqq</p>', '1506999062', '1506999062', '0', '0');

-- ----------------------------
-- Table structure for hzz_fapiao
-- ----------------------------
DROP TABLE IF EXISTS `hzz_fapiao`;
CREATE TABLE `hzz_fapiao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL COMMENT '发票类型',
  `taxnumber` int(50) DEFAULT NULL,
  `khh` varchar(200) DEFAULT NULL,
  `khzh` varchar(30) DEFAULT NULL,
  `kpdz` varchar(200) DEFAULT NULL,
  `mobile` int(20) DEFAULT NULL,
  `rise` varchar(50) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `fpnr` varchar(50) DEFAULT NULL,
  `sjfdz` varchar(255) DEFAULT NULL,
  `sjr` varchar(20) DEFAULT NULL,
  `yzbm` varchar(20) DEFAULT NULL,
  `yldh` int(20) DEFAULT NULL,
  `describe` text,
  `create_time` varchar(20) DEFAULT NULL,
  `updata_time` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hzz_fapiao
-- ----------------------------
INSERT INTO `hzz_fapiao` VALUES ('1', '增值税专用发票', '1111', '111', '111aaaaaa', '11', '11', '111', '111', '0', '111', '11', '11', '111', '1111', '1507121388', '1507121388');
INSERT INTO `hzz_fapiao` VALUES ('2', '增值税普通发票', '1111111', '111', '111', '11', '11', '111', '111', '0', '111', '11', '11', '111', '1111', '1507116815', '1507116815');
INSERT INTO `hzz_fapiao` VALUES ('3', '增值税普通发票', '2147483647', '111', '111', '11', '11', '111', '111', '0', '111', '11', '11', '2', '1111', '1507120979', '1507120979');
INSERT INTO `hzz_fapiao` VALUES ('4', '增值税普通发票', '1111', '111aaa', '111', '11', '11', '111', '111', '0', '111', '11', '11', '111', '1111', '1507121167', '1507121167');
INSERT INTO `hzz_fapiao` VALUES ('5', '增值税普通发票', '1111', '111aaaa', '111', '11', '11', '111', '111', '0', '111', '11', '11', '111', '1111', '1507121189', '1507121189');

-- ----------------------------
-- Table structure for hzz_goodtype
-- ----------------------------
DROP TABLE IF EXISTS `hzz_goodtype`;
CREATE TABLE `hzz_goodtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '项目名',
  `describe` text COMMENT '描述',
  `updata_time` varchar(100) DEFAULT NULL,
  `create_time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of hzz_goodtype
-- ----------------------------
INSERT INTO `hzz_goodtype` VALUES ('1', 'PC网站', 'PC网站备注', '1506822744', '1506822744');
INSERT INTO `hzz_goodtype` VALUES ('2', 'PC+移动端网站', 'PC+移动端网站备注', '1506822744', '1506822744');
INSERT INTO `hzz_goodtype` VALUES ('3', '微信公众号建设', '微信公众号建设', '1506822744', '1506822744');
INSERT INTO `hzz_goodtype` VALUES ('4', '微信小程序建设', '微信小程序建设备注', '1506822744', '1506822744');
INSERT INTO `hzz_goodtype` VALUES ('5', '企业口碑建设', '企业口碑建设', '1506822744', '1506822744');

-- ----------------------------
-- Table structure for hzz_member
-- ----------------------------
DROP TABLE IF EXISTS `hzz_member`;
CREATE TABLE `hzz_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `passwd` varchar(50) NOT NULL COMMENT '密码',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL COMMENT '街道',
  `annotate` varchar(255) DEFAULT NULL COMMENT '备注',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '级别',
  `sex` int(1) DEFAULT NULL,
  `auditing` int(1) DEFAULT NULL COMMENT '是否需要审核',
  `history` text COMMENT '历史升级记录',
  `up_history` varchar(100) DEFAULT NULL COMMENT '最近一次升级记录',
  `updata_time` varchar(20) DEFAULT NULL,
  `create_time` varchar(20) DEFAULT NULL,
  `visits_ip2` varchar(20) DEFAULT NULL COMMENT '本次登陆ip',
  `visits_ip1` varchar(20) DEFAULT NULL COMMENT '上次登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hzz_member
-- ----------------------------
INSERT INTO `hzz_member` VALUES ('1', 'hzz001', '123456', '111111', '123456@qq.com', '山西省-阳泉市-郊区', '人民路168号', '测试备注', '2', '0', '0', null, null, '1506823611', '1506823611', null, null);
INSERT INTO `hzz_member` VALUES ('3', 'hzz002', '123456', '111111', '123456@qq.com', '山西省-阳泉市-郊区', '人民路168号', '测试备注', '3', '0', '0', null, null, '1506823611', '1506823611', null, null);
INSERT INTO `hzz_member` VALUES ('13', '11', '15136079974', '', '631347947@qq.com', '湖北省-十堰市-竹山县', 'ssss三十三', 'aaaaa', '0', '1', '1', null, null, '1508159451', '1508159451', null, null);
INSERT INTO `hzz_member` VALUES ('2', 'hzz003', '123456', '111111', '123456@qq.com', '山西省-阳泉市-郊区', '人民路168号', '测试备注', '3', '0', '0', null, null, '1506823611', '1506823611', null, null);

-- ----------------------------
-- Table structure for hzz_project
-- ----------------------------
DROP TABLE IF EXISTS `hzz_project`;
CREATE TABLE `hzz_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '项目名',
  `state` int(3) DEFAULT '0' COMMENT '项目进行状态',
  `price` varchar(20) DEFAULT NULL COMMENT '价格',
  `describe` text COMMENT '项目简介',
  `executor` varchar(20) DEFAULT NULL COMMENT '执行人',
  `updata_time` varchar(100) DEFAULT NULL,
  `create_time` varchar(50) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hzz_project
-- ----------------------------
INSERT INTO `hzz_project` VALUES ('1', '2', 'hzz测试项目名', '0', '10000', '测试项目简介', '2', '1506822744', '1506822744', '1', '2017-10-02 18:32:11', '2017-11-24 18:32:16');
INSERT INTO `hzz_project` VALUES ('2', '2', 'hzz测试项目名2', '1', '10000', '测试项目简介', '2', '1506822744', '1506822744', '2', '2017-10-02 18:32:11', '2017-11-24 18:32:16');
INSERT INTO `hzz_project` VALUES ('3', '2', 'hzz测试项目名2', '7', '10000', '测试项目简介', '2', '1506822744', '1506822744', '3', '2017-10-02 18:32:11', '2017-11-24 18:32:16');
INSERT INTO `hzz_project` VALUES ('8', '2', 'hzz测试项目名', '0', '10000', '测试项目简介1', '2', '1506999106', '1506999106', '2', '2017-10-02 18:32:11', '2017-11-24 18:32:16');
