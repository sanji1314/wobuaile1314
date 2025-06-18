-- MySQL dump 10.13  Distrib 5.7.40, for Linux (x86_64)
--
-- Host: localhost    Database: 111_229_239_209
-- ------------------------------------------------------
-- Server version	5.7.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `qingka_wangke_class`
--

DROP TABLE IF EXISTS `qingka_wangke_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_class` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '网课平台名字',
  `getnoun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询参数',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接参数',
  `nocheck` int(11) DEFAULT '0' COMMENT '是否无查下单',
  `changePass` int(11) DEFAULT '0' COMMENT '是否支持改密',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '定价',
  `queryplat` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询平台',
  `docking` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接平台',
  `yunsuan` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT '代理费率运算',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '说明',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `uptime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '更新时间',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态0为下架。1为上架',
  `fenlei` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类',
  `mall_custom` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_class`
--

LOCK TABLES `qingka_wangke_class` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_config`
--

DROP TABLE IF EXISTS `qingka_wangke_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_config` (
  `v` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `k` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `v` (`v`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_config`
--

LOCK TABLES `qingka_wangke_config` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_config` DISABLE KEYS */;
INSERT INTO `qingka_wangke_config` VALUES ('akcookie','7321sPn6n+Yt9tGs1wy7f2ULOKbENP2W/J83w50jYbpDpQEXjkGRJnZOlXPY7XeOX5zCSU6vfhOLJSoKLMeWQ7cv9ghbEsFowYoCzQ'),('api_bs','10'),('api_ck','15'),('api_ck_threshold','30'),('api_ckkf','0'),('api_proportion','20'),('api_tongb','1'),('api_tongbc','3'),('api_xd','5'),('description','小月'),('dklcookie','d1abUN9efprWp3E93jrzR27IaTDLsmnV7AGLOb+rPKLrml1YDKRVBgXW0JxsfktUYm/Ym/Sk9J4eJiLfEdoPFXgKRuy/vtoV4YXYuRkarpydLsoeMgp93qAWuTWF9vRdk4xdew4QGgPIt/LzbMnUsDOHq/u5HGrnMhU8wbD35T/47sGC5cCVzGlGK565qMhH3kUzazhgiEoEpDJNAOFXttowDLKM+6G1iAApLyUNDxP7rluq383FyGxO3tcYR4VVuTEJA1V0LTNTOzhq8TJXl0l/hGE6JfDmLkDo4piWok2lnG5VTzYdMf6AJYSHwO+W4P2rAxgd3augn/kkJUfvxRiWZWPoddS4n0n1kRpIJrBNgTWuE3U9EQqxIMMwMWLI3IZvP0NZE/Nl0yqyFg'),('epay_api',''),('epay_key',''),('epay_pid',''),('flkg','1'),('fllx','2'),('is_alipay','1'),('is_qqpay','0'),('is_wxpay','1'),('keywords','小月'),('khkg','1'),('khyue','1000'),('login_apiurl',''),('login_appid',''),('login_appkey',''),('logo','https://s1.ax1x.com/2023/03/15/pp33mvV.png'),('nanatoken','14cen/DXBsnMXkKPE50giKP/KmWGgIwn/B2sdw9z+b7zL2riFzG2mvyb04YP/xdD5w5h8uvXIKwjCo7AIF3QgzvCoiOdJfK+a9IdjpFcb2mSpzqGg9jRrEeFOomuokkA0F971RhK'),('notice','<div class=\"layui-timeline\" style=\"padding: 20px; line-height: 5px; color: #fff; font-weight: 300px;\">\r\n    <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <h3 class=\"layui-timeline-title\">6月9日</h3>\r\n      <ul>\r\n        <li>上架自营学习通/职教云/中国大学，嘎嘎稳定质量拉满</li>\r\n        <li>新上架几个国开渠道，质量自测</li>\r\n        <li>凌云志修复青书学堂不做人脸考试的题目</li>\r\n      </ul>\r\n    </div>\r\n  </div>\r\n    <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-timeline-axis\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <h3 class=\"layui-timeline-title\">5月12日</h3>\r\n      <ul>\r\n        <li>少年，强盛智慧树系列涨价，对接用户记得同步</li>\r\n        <li>优化凌云志成教云跑单不稳定问题，修复部分账号不考试问题！作业考试都包满分！刷新缓存在看！</li>\r\n        <li>修复凌云志微知库卡单问题！极速干完！</li>\r\n        <li>对青书学堂考试进行重构！除主观题填空题那种，考试能直接满分！</li>\r\n      </ul>\r\n    </div>\r\n  </div>\r\n  <div class=\"layui-timeline-item\">\r\n    <i class=\"layui-icon layui-anim layui-anim-rotate layui-anim-loop layui-timeline-axis\"></i>\r\n    <div class=\"layui-timeline-content layui-text\">\r\n      <div class=\"layui-timeline-title\">更早以前......</div>\r\n    </div>\r\n  </div>\r\n</div>'),('onlineStore_add','500%'),('onlineStore_open','1'),('onlineStore_trdltz','0'),('qgkg','0'),('settings','1'),('sitename','小月'),('sjqykg','1'),('storePath','/components/onlineStore.php'),('sykg','0'),('tcgonggao','<div style=\"padding: 20px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300px;\">顾客自助售后地址：xxxxk/<br><br>TG群xxx(问题反馈，吹水)<br><br>新上架自营职教云系列自营中国大学系列，官方题库质量拉满，下单首选<br><br>对接联系站长免费开通key<br>自营商品有密价</div>'),('tongzhidizhi','1'),('user_htkh','1'),('user_ktmoney','0'),('user_yqzc','0'),('zdpay','10');
/*!40000 ALTER TABLE `qingka_wangke_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_czk`
--

DROP TABLE IF EXISTS `qingka_wangke_czk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_czk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usetime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_czk`
--

LOCK TABLES `qingka_wangke_czk` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_czk` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_czk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_dengji`
--

DROP TABLE IF EXISTS `qingka_wangke_dengji`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_dengji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `addkf` varchar(11) NOT NULL,
  `gjkf` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_dengji`
--

LOCK TABLES `qingka_wangke_dengji` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_dengji` DISABLE KEYS */;
INSERT INTO `qingka_wangke_dengji` VALUES (1,'1','顶级代理',0.20,58.00,'1','1','1','2023-03-14 '),(2,'2','钻石代理',0.30,28.00,'1','1','1','2023-03-15 '),(3,'3','黄金代理',0.40,999.00,'1','1','1','2023-03-15 ');
/*!40000 ALTER TABLE `qingka_wangke_dengji` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_fenlei`
--

DROP TABLE IF EXISTS `qingka_wangke_fenlei`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_fenlei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(11) NOT NULL DEFAULT '0',
  `name` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL,
  `mall_custom` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_fenlei`
--

LOCK TABLES `qingka_wangke_fenlei` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_fenlei` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_fenlei` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_gongdan`
--

DROP TABLE IF EXISTS `qingka_wangke_gongdan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_gongdan` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(3) NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单类型',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单标题',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单内容',
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单回复',
  `state` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单状态',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_gongdan`
--

LOCK TABLES `qingka_wangke_gongdan` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_gongdan` DISABLE KEYS */;
INSERT INTO `qingka_wangke_gongdan` VALUES (7,473,'bug反馈','为什么下单余额会变少','希望尽快修复！','','待回复','2023-06-21 17:46:24');
/*!40000 ALTER TABLE `qingka_wangke_gongdan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_gonggao`
--

DROP TABLE IF EXISTS `qingka_wangke_gonggao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_gonggao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `time` text NOT NULL,
  `uid` int(11) NOT NULL,
  `status` varchar(11) NOT NULL COMMENT '状态',
  `zhiding` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_gonggao`
--

LOCK TABLES `qingka_wangke_gonggao` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_gonggao` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_gonggao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_huodong`
--

DROP TABLE IF EXISTS `qingka_wangke_huodong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_huodong` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动名字',
  `yaoqiu` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '1为邀人活动 2为订单活动',
  `num` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求数量',
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '奖励',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动开始时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动结束时间',
  `status_ok` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为正常 2为结束',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为进行中  2为待领取 3为已完成',
  PRIMARY KEY (`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_huodong`
--

LOCK TABLES `qingka_wangke_huodong` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_huodong` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_huodong` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_huoyuan`
--

DROP TABLE IF EXISTS `qingka_wangke_huoyuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_huoyuan` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `pt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '不带http 顶级',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cookie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_huoyuan`
--

LOCK TABLES `qingka_wangke_huoyuan` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_huoyuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_huoyuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_km`
--

DROP TABLE IF EXISTS `qingka_wangke_km`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_km` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '卡密id',
  `content` varchar(255) NOT NULL COMMENT '卡密内容',
  `money` int(11) NOT NULL COMMENT '卡密金额',
  `status` int(11) DEFAULT NULL COMMENT '卡密状态',
  `uid` int(11) DEFAULT NULL COMMENT '使用者id',
  `addtime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `usedtime` varchar(255) DEFAULT NULL COMMENT '使用时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_km`
--

LOCK TABLES `qingka_wangke_km` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_km` DISABLE KEYS */;
INSERT INTO `qingka_wangke_km` VALUES (1,'IRsSazp1Go8vtvQL',1,1,1,'2023-11-10 09:49:23','2023-11-10 10:29:05'),(2,'xJNBdDXvoIP7eAfv',10,1,1,'2023-11-10 10:36:24','2023-11-10 10:36:35'),(3,'MByGDtJImksUHeyA',10000,1,1,'2023-11-16 01:30:36','2023-11-16 01:30:48');
/*!40000 ALTER TABLE `qingka_wangke_km` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_log`
--

DROP TABLE IF EXISTS `qingka_wangke_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smoney` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_log`
--

LOCK TABLES `qingka_wangke_log` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_log` DISABLE KEYS */;
INSERT INTO `qingka_wangke_log` VALUES (1,1,'卡密充值','使用卡密成功给uid为1的靓仔充值10000元,扣除10000元','-10000','20000.00','111.14.220.182','2023-11-15 17:30:48'),(2,1,'卡密充值','您使用站长的卡密成功充值10000元','10000','20000.00','111.14.220.182','2023-11-15 17:30:48'),(3,1,'登录','登录成功小月','0','20000.00','112.224.161.58','2024-03-14 14:32:20'),(4,1,'登录','登录成功小月','0','20000.00','112.224.163.98','2024-03-18 14:42:56'),(5,1,'登录','登录成功小月','0','20000.00','223.160.155.40','2025-02-19 01:50:02'),(6,1,'登录','登录成功小月','0','20000.00','223.160.155.40','2025-02-19 01:52:37'),(7,1,'登录','登录成功小月','0','20000.00','223.160.155.40','2025-02-19 07:35:15');
/*!40000 ALTER TABLE `qingka_wangke_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_mijia`
--

DROP TABLE IF EXISTS `qingka_wangke_mijia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_mijia` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '0.价格的基础上扣除 1.倍数的基础上扣除 2.直接定价',
  `price` varchar(100) NOT NULL,
  `addtime` varchar(100) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_mijia`
--

LOCK TABLES `qingka_wangke_mijia` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_mijia` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_mijia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_order`
--

DROP TABLE IF EXISTS `qingka_wangke_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL COMMENT '平台ID',
  `hid` int(11) NOT NULL COMMENT '接口ID',
  `yid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接站ID',
  `ptname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '平台名字',
  `school` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '学校',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号',
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `kcid` text COLLATE utf8_unicode_ci NOT NULL COMMENT '课程ID',
  `kcname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程名字',
  `courseStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程开始时间',
  `courseEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程结束时间',
  `examStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试开始时间',
  `examEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试结束时间',
  `chapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '总章数',
  `unfinishedChapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '剩余章数',
  `cookie` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'cookie',
  `fees` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '扣费',
  `shoujia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '商城售价',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接标识',
  `miaoshua` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0不秒 1秒',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下单ip',
  `dockstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '对接状态 0待 1成  2失 3重复 4取消',
  `loginstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '待处理',
  `process` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bsnum` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '补刷次数',
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `score` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '分数',
  `shichang` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '时长',
  `uptime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qg` text,
  `out_trade_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paytime` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payUser` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `type` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_order`
--

LOCK TABLES `qingka_wangke_order` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_pay`
--

DROP TABLE IF EXISTS `qingka_wangke_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_pay` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `out_trade_no` varchar(64) NOT NULL,
  `trade_no` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `money2` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '代理商城收支',
  `ip` varchar(20) DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `payUser` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_pay`
--

LOCK TABLES `qingka_wangke_pay` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_qglist`
--

DROP TABLE IF EXISTS `qingka_wangke_qglist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_qglist` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `yid` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `total` varchar(255) DEFAULT NULL,
  `score` varchar(255) NOT NULL DEFAULT '0',
  `sytime` varchar(255) NOT NULL,
  `addtime` varchar(255) NOT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `dockstatus` varchar(255) NOT NULL DEFAULT '0',
  `zhuangtai` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`qid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_qglist`
--

LOCK TABLES `qingka_wangke_qglist` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_qglist` DISABLE KEYS */;
/*!40000 ALTER TABLE `qingka_wangke_qglist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qingka_wangke_user`
--

DROP TABLE IF EXISTS `qingka_wangke_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qingka_wangke_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qq_openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQuid',
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQ昵称',
  `faceimg` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQ头像',
  `money` decimal(10,3) NOT NULL DEFAULT '0.000',
  `zcz` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `addprice` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '加价',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yqm` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请码',
  `yqprice` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请单价',
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最后一次登录ip',
  `endaddress` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '上次登录地址',
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `qq` varchar(100) COLLATE utf8_unicode_ci DEFAULT '123456',
  `wx` varchar(100) COLLATE utf8_unicode_ci DEFAULT '123456',
  `tourist` int(2) DEFAULT '0',
  `ck` int(11) DEFAULT '0',
  `xd` int(11) DEFAULT '0',
  `jd` int(11) DEFAULT '0',
  `bs` int(11) DEFAULT '0',
  `ck1` int(11) DEFAULT '0',
  `xd1` int(11) DEFAULT '0',
  `jd1` int(11) DEFAULT '0',
  `bs1` int(11) DEFAULT '0',
  `paydata` text COLLATE utf8_unicode_ci COMMENT '支付独立配置',
  `fldata` text COLLATE utf8_unicode_ci COMMENT '分类数据',
  `cldata` text COLLATE utf8_unicode_ci COMMENT '课程数据',
  `touristdata` text COLLATE utf8_unicode_ci COMMENT '商城独立配置',
  `czAuth` varchar(11) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '在线充值权限',
  `kuahu` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '跨户权限',
  `qgmj` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '强国密价费率',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=492 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qingka_wangke_user`
--

LOCK TABLES `qingka_wangke_user` WRITE;
/*!40000 ALTER TABLE `qingka_wangke_user` DISABLE KEYS */;
INSERT INTO `qingka_wangke_user` 
(`uid`, `uuid`, `user`, `pass`, `name`, `qq_openid`, `nickname`, `faceimg`, `money`, 
`zcz`, `addprice`, `key`, `yqm`, `yqprice`, `notice`, `addtime`, `endtime`, `ip`, 
`grade`, `active`, `kuahu`, `qgmj`) 
VALUES 
(1, 1, 'admin', '123456', '小月', '', '', '', 20000.000, 
'30000', 0.20, '0', '0000', '0.2', '', '2022-05-20 22:58:54', '2025-02-19 15:35:27', '223.160.155.40',
'', '1', '', '');
/*!40000 ALTER TABLE `qingka_wangke_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database '111_229_239_209'
--

--
-- Dumping routines for database '111_229_239_209'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-19 15:42:15
