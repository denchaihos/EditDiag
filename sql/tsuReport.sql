/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-10-07 21:35:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsuReport`
-- ----------------------------
DROP TABLE IF EXISTS `tsuReport`;
CREATE TABLE `tsuReport` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `namereport` varchar(255) DEFAULT NULL,
  `r_query` longtext,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of reportoth
-- ----------------------------

INSERT INTO `tsuReport` VALUES ('1', '', 'z110');
INSERT INTO `tsuReport` VALUES ('2', 'ค้นหาผู้ป่วยจากช่วงเวลาที่เลือก', 'select p.hn,p.fname,p.lname,m.namemale,o.vstdttm from ovst o join pt p on p.hn=o.hn join male m on m.male=p.male  WHERE date(o.vstdttm) BETWEEN ? AND ?');
