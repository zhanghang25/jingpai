# Host: localhost  (Version: 5.5.53)
# Date: 2019-03-28 15:51:59
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "qw_account"
#

DROP TABLE IF EXISTS `qw_account`;
CREATE TABLE `qw_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `type` tinyint(1) DEFAULT NULL COMMENT '支付用途  0:返佣金;1:充值;2:保证金;3:提现;4:购物;5:兑换扣反拍额;6:兑换扣积分',
  `mold` tinyint(1) DEFAULT NULL COMMENT '支付类型:0,支付宝;1,账户余额;2,积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='账户明细';

#
# Data for table "qw_account"
#

/*!40000 ALTER TABLE `qw_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `qw_account` ENABLE KEYS */;

#
# Structure for table "qw_address"
#

DROP TABLE IF EXISTS `qw_address`;
CREATE TABLE `qw_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地址主键id',
  `name` varchar(255) NOT NULL COMMENT '收件人姓名',
  `province` varchar(255) NOT NULL COMMENT '一级（省）（个别是市）',
  `city` varchar(255) NOT NULL COMMENT '二级（市）（可以是县例如北京市）',
  `county` varchar(255) NOT NULL COMMENT '三级（县）（可以是区）',
  `detailed
detailed` varchar(255) NOT NULL COMMENT '详细地址',
  `phone` char(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户表id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_address"
#

/*!40000 ALTER TABLE `qw_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `qw_address` ENABLE KEYS */;

#
# Structure for table "qw_article"
#

DROP TABLE IF EXISTS `qw_article`;
CREATE TABLE `qw_article` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL COMMENT '分类id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `seotitle` varchar(255) DEFAULT NULL COMMENT 'SEO标题',
  `keywords` varchar(255) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '摘要',
  `thumbnail` varchar(255) NOT NULL COMMENT '缩略图',
  `content` text NOT NULL COMMENT '内容',
  `t` int(10) unsigned NOT NULL COMMENT '时间',
  `n` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击',
  PRIMARY KEY (`aid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "qw_article"
#

/*!40000 ALTER TABLE `qw_article` DISABLE KEYS */;
INSERT INTO `qw_article` VALUES (1,36,'啊啊','测试','青天河','测试文章','/Public/attached/2019/03/14/5c89ecffdcc2e.png','测试',1552542983,0);
/*!40000 ALTER TABLE `qw_article` ENABLE KEYS */;

#
# Structure for table "qw_auction_info"
#

DROP TABLE IF EXISTS `qw_auction_info`;
CREATE TABLE `qw_auction_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `carousel_figure1` varchar(255) DEFAULT NULL,
  `carousel_figure2` varchar(255) DEFAULT NULL,
  `carousel_figure3` varchar(255) DEFAULT NULL,
  `detail` text,
  `start_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `additional_shot_range` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `reference_price` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `high_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00',
  `guaranty` decimal(6,2) NOT NULL DEFAULT '0.00',
  `session_id` int(11) NOT NULL DEFAULT '0' COMMENT '场次id',
  `start_time` int(10) NOT NULL DEFAULT '0' COMMENT '拍卖开始时间',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '拍卖结束时间',
  `user_id` int(11) DEFAULT NULL COMMENT '成交人',
  `success_price` decimal(7,2) DEFAULT '0.00' COMMENT '成交价',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '拍卖信息状态:0,未开拍;1,参拍中;2,已结束',
  `auction_person` tinytext COMMENT '参拍人',
  `shop_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `session_name` varchar(255) DEFAULT NULL COMMENT '场次名称',
  `shop_time` int(10) DEFAULT NULL COMMENT '商品添加时间',
  `session_time` int(10) DEFAULT NULL COMMENT '场次开始时间',
  `shop_status` tinyint(1) DEFAULT NULL COMMENT '商品状态',
  `session_status` tinyint(1) DEFAULT NULL COMMENT '场次状态',
  `session_end_time` int(10) DEFAULT NULL,
  `add_times` int(5) DEFAULT '0' COMMENT '加价次数',
  `short_show` text COMMENT '简介信息',
  `success_times` int(3) NOT NULL DEFAULT '0' COMMENT '加价次数',
  `shop_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;

#
# Data for table "qw_auction_info"
#

/*!40000 ALTER TABLE `qw_auction_info` DISABLE KEYS */;
INSERT INTO `qw_auction_info` VALUES (91,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,15.00,15.00,9,1553667480,1553670000,NULL,0.00,1,NULL,'hanger','2点场',1553311483,1553752800,0,0,NULL,0,NULL,0,0),(92,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553667480,1553670000,NULL,0.00,1,NULL,'xxaxx123','2点场',1553251093,1553752800,0,0,NULL,0,NULL,0,0),(93,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553667480,1553670000,NULL,0.00,1,NULL,'gou','2点场',1553251062,1553752800,0,0,NULL,0,NULL,0,0),(94,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553667480,1553670000,NULL,30.00,2,NULL,'muyulu','2点场',1553251032,1553752800,0,0,NULL,0,NULL,0,0),(95,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,10,1553671620,1553673600,NULL,60.00,2,NULL,'hanger','15点场',1553311483,1553670000,0,0,NULL,0,'',0,0),(96,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,10,1553671620,1553673600,NULL,30.00,2,NULL,'xxaxx123','15点场',1553251093,1553670000,0,0,NULL,0,NULL,0,0),(97,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,10,1553671620,1553673600,NULL,0.00,1,NULL,'gou','15点场',1553251062,1553670000,0,0,NULL,0,NULL,0,0),(98,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,10,1553671620,1553673600,NULL,30.00,2,NULL,'muyulu','15点场',1553251032,1553670000,0,0,NULL,0,NULL,0,0),(99,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,9,1553675340,1553677200,NULL,90.00,2,NULL,'hanger','16点场',1553675365,1553752800,0,0,NULL,0,NULL,1,0),(100,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553675340,1553677200,NULL,0.00,1,NULL,'xxaxx123','16点场',1553251093,1553752800,0,0,NULL,0,NULL,0,0),(101,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553675340,1553677200,NULL,0.00,1,NULL,'gou','16点场',1553251062,1553752800,0,0,NULL,0,NULL,0,0),(102,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553675340,1553677200,NULL,0.00,1,NULL,'muyulu','16点场',1553251032,1553752800,0,0,NULL,0,NULL,0,0),(104,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,60.00,15.00,11,1553746740,1553749200,NULL,30.00,2,NULL,'xxaxx123','17点场',1553251093,1553745600,0,0,NULL,0,'',12,7),(105,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,11,1553678340,1553680800,NULL,0.00,1,NULL,'gou','17点场',1553251062,1553745600,0,0,NULL,0,NULL,0,6),(106,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,11,1553678340,1553680800,NULL,0.00,1,NULL,'muyulu','17点场',1553251032,1553745600,0,0,NULL,0,NULL,0,8),(107,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,13,1553681040,1553683500,NULL,0.00,1,NULL,'hanger','18点场',1553675365,1553749200,0,0,NULL,0,NULL,0,5),(108,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553681040,1553683500,NULL,0.00,1,NULL,'xxaxx123','18点场',1553251093,1553749200,0,0,NULL,0,NULL,0,7),(109,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553681040,1553683500,NULL,0.00,1,NULL,'gou','18点场',1553251062,1553749200,0,0,NULL,0,NULL,0,6),(110,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553681040,1553683500,NULL,0.00,1,NULL,'muyulu','18点场',1553251032,1553749200,0,0,NULL,0,NULL,0,8),(111,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,13,1553733780,1553734800,NULL,0.00,1,NULL,'hanger','8点场',1553675365,1553749200,0,0,NULL,0,NULL,0,5),(112,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553733780,1553734800,NULL,0.00,1,NULL,'xxaxx123','8点场',1553251093,1553749200,0,0,NULL,0,NULL,0,7),(113,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553733780,1553734800,NULL,0.00,1,NULL,'gou','8点场',1553251062,1553749200,0,0,NULL,0,NULL,0,6),(114,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553733780,1553734800,NULL,0.00,1,NULL,'muyulu','8点场',1553251032,1553749200,0,0,NULL,0,NULL,0,8),(115,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,12,1553742240,1553745600,16,105.00,2,'16,4,3,2,1','hanger','11点场',1553675365,1553742000,0,0,NULL,0,NULL,11,5),(116,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,12,1553742240,1553745600,NULL,0.00,1,NULL,'xxaxx123','11点场',1553251093,1553742000,0,0,NULL,0,NULL,0,7),(117,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,12,1553742240,1553745600,NULL,0.00,1,NULL,'gou','11点场',1553251062,1553742000,0,0,NULL,0,NULL,0,6),(118,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,12,1553742240,1553745600,NULL,0.00,1,NULL,'muyulu','11点场',1553251032,1553742000,0,0,NULL,0,NULL,0,8),(119,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,11,1553745720,1553749200,16,105.00,2,'16,4,3,2,1','hanger','12点场',1553675365,1553745600,0,0,NULL,0,NULL,11,5),(120,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,11,1553745720,1553749200,NULL,0.00,1,NULL,'xxaxx123','12点场',1553251093,1553745600,0,0,NULL,0,NULL,0,7),(121,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,11,1553745720,1553749200,NULL,0.00,1,NULL,'gou','12点场',1553251062,1553745600,0,0,NULL,0,NULL,0,6),(122,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,11,1553745720,1553749200,NULL,0.00,1,NULL,'muyulu','12点场',1553251032,1553745600,0,0,NULL,0,NULL,0,8),(123,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,13,1553749260,1553752800,NULL,75.00,1,NULL,'hanger','1',1553675365,1553749200,0,0,NULL,0,NULL,16,5),(124,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553749260,1553752800,NULL,0.00,1,NULL,'xxaxx123','1',1553251093,1553749200,0,0,NULL,0,NULL,0,7),(125,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553749260,1553752800,NULL,0.00,1,NULL,'gou','1',1553251062,1553749200,0,0,NULL,0,NULL,0,6),(126,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,13,1553749260,1553752800,NULL,0.00,1,NULL,'muyulu','1',1553251032,1553749200,0,0,NULL,0,NULL,0,8),(127,'/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,9,1553754240,1553756400,16,90.00,2,'16,7','hanger','14点场',1553675365,1553752800,0,0,NULL,0,NULL,6,5),(128,'/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553754240,1553756400,NULL,0.00,1,NULL,'xxaxx123','14点场',1553251093,1553752800,0,0,NULL,0,NULL,0,7),(129,'/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553754240,1553756400,NULL,0.00,1,NULL,'gou','14点场',1553251062,1553752800,0,0,NULL,0,NULL,0,6),(130,'/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,9,1553754240,1553756400,NULL,0.00,1,NULL,'muyulu','14点场',1553251032,1553752800,0,0,NULL,0,NULL,0,8);
/*!40000 ALTER TABLE `qw_auction_info` ENABLE KEYS */;

#
# Structure for table "qw_auth_group"
#

DROP TABLE IF EXISTS `qw_auth_group`;
CREATE TABLE `qw_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "qw_auth_group"
#

/*!40000 ALTER TABLE `qw_auth_group` DISABLE KEYS */;
INSERT INTO `qw_auth_group` VALUES (1,'超级管理员',1,'1,2,58,65,59,60,61,62,3,56,4,6,5,7,8,9,10,51,52,53,57,11,54,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,29,30,31,32,33,34,36,37,38,39,40,41,42,43,44,45,46,47,63,48,49,50,55'),(2,'管理员',1,'13,14,23,22,21,20,19,18,17,16,15,24,36,34,33,32,31,30,29,27,26,25,1'),(3,'普通用户',1,'1'),(6,'333',0,'1,2');
/*!40000 ALTER TABLE `qw_auth_group` ENABLE KEYS */;

#
# Structure for table "qw_auth_group_access"
#

DROP TABLE IF EXISTS `qw_auth_group_access`;
CREATE TABLE `qw_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_auth_group_access"
#

/*!40000 ALTER TABLE `qw_auth_group_access` DISABLE KEYS */;
INSERT INTO `qw_auth_group_access` VALUES (1,1);
/*!40000 ALTER TABLE `qw_auth_group_access` ENABLE KEYS */;

#
# Structure for table "qw_auth_rule"
#

DROP TABLE IF EXISTS `qw_auth_rule`;
CREATE TABLE `qw_auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `islink` tinyint(1) NOT NULL DEFAULT '1',
  `o` int(11) NOT NULL COMMENT '排序',
  `tips` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

#
# Data for table "qw_auth_rule"
#

/*!40000 ALTER TABLE `qw_auth_rule` DISABLE KEYS */;
INSERT INTO `qw_auth_rule` VALUES (1,0,'Index/index','控制台','menu-icon fa fa-tachometer',1,1,'',1,1,'友情提示：经常查看操作日志，发现异常以便及时追查原因。'),(2,0,'','系统设置','menu-icon fa fa-cog',1,1,'',1,2,''),(3,2,'Setting/setting','网站设置','menu-icon fa fa-caret-right',1,1,'',1,3,'这是网站设置的提示。'),(4,2,'Menu/index','后台菜单','menu-icon fa fa-caret-right',1,1,'',1,4,''),(5,2,'Menu/add','新增菜单','menu-icon fa fa-caret-right',1,1,'',1,5,''),(6,4,'Menu/edit','编辑菜单','',1,1,'',0,6,''),(7,2,'Menu/update','保存菜单','menu-icon fa fa-caret-right',1,1,'',0,7,''),(8,2,'Menu/del','删除菜单','menu-icon fa fa-caret-right',1,1,'',0,8,''),(9,2,'Database/backup','数据库备份','menu-icon fa fa-caret-right',1,1,'',1,9,''),(10,9,'Database/recovery','数据库还原','',1,1,'',0,10,''),(11,2,'Update/update','在线升级','menu-icon fa fa-caret-right',1,1,'',1,11,''),(12,2,'Update/devlog','开发日志','menu-icon fa fa-caret-right',1,1,'',1,12,''),(13,0,'','管理员信息','menu-icon fa fa-users',1,1,'',1,13,''),(14,13,'Member/index','用户管理','menu-icon fa fa-caret-right',1,1,'',1,14,''),(15,13,'Member/add','新增用户','menu-icon fa fa-caret-right',1,1,'',1,15,''),(16,13,'Member/edit','编辑用户','menu-icon fa fa-caret-right',1,1,'',0,16,''),(17,13,'Member/update','保存用户','menu-icon fa fa-caret-right',1,1,'',0,17,''),(18,13,'Member/del','删除用户','',1,1,'',0,18,''),(19,13,'Group/index','用户组管理','menu-icon fa fa-caret-right',1,1,'',1,19,''),(20,13,'Group/add','新增用户组','menu-icon fa fa-caret-right',1,1,'',1,20,''),(21,13,'Group/edit','编辑用户组','menu-icon fa fa-caret-right',1,1,'',0,21,''),(22,13,'Group/update','保存用户组','menu-icon fa fa-caret-right',1,1,'',0,22,''),(23,13,'Group/del','删除用户组','',1,1,'',0,23,''),(24,0,'','网站内容','menu-icon fa fa-desktop',1,1,'',1,24,''),(25,24,'Article/index','文章管理','menu-icon fa fa-caret-right',1,1,'',1,25,'网站虽然重要，身体更重要，出去走走吧。'),(26,24,'Article/add','新增文章','menu-icon fa fa-caret-right',1,1,'',1,26,''),(27,24,'Article/edit','编辑文章','menu-icon fa fa-caret-right',1,1,'',0,27,''),(29,24,'Article/update','保存文章','menu-icon fa fa-caret-right',1,1,'',0,29,''),(30,24,'Article/del','删除文章','',1,1,'',0,30,''),(31,24,'Category/index','分类管理','menu-icon fa fa-caret-right',1,1,'',1,31,''),(32,24,'Category/add','新增分类','menu-icon fa fa-caret-right',1,1,'',1,32,''),(33,24,'Category/edit','编辑分类','menu-icon fa fa-caret-right',1,1,'',0,33,''),(34,24,'Category/update','保存分类','menu-icon fa fa-caret-right',1,1,'',0,34,''),(36,24,'Category/del','删除分类','',1,1,'',0,36,''),(37,0,'','其它功能','menu-icon fa fa-legal',1,1,'',1,37,''),(38,37,'Link/index','友情链接','menu-icon fa fa-caret-right',1,1,'',1,38,''),(39,37,'Link/add','增加链接','',1,1,'',1,39,''),(40,37,'Link/edit','编辑链接','',1,1,'',0,40,''),(41,37,'Link/update','保存链接','',1,1,'',0,41,''),(42,37,'Link/del','删除链接','',1,1,'',0,42,''),(43,37,'Flash/index','焦点图','menu-icon fa fa-desktop',1,1,'',1,43,''),(44,37,'Flash/add','新增焦点图','',1,1,'',1,44,''),(45,37,'Flash/update','保存焦点图','',1,1,'',0,45,''),(46,37,'Flash/edit','编辑焦点图','',1,1,'',0,46,''),(47,37,'Flash/del','删除焦点图','',1,1,'',0,47,''),(48,0,'Personal/index','个人中心','menu-icon fa fa-user',1,1,'',1,48,''),(49,48,'Personal/profile','个人资料','menu-icon fa fa-user',1,1,'',1,49,''),(50,48,'Logout/index','退出','',1,1,'',1,50,''),(51,9,'Database/export','备份','',1,1,'',0,51,''),(52,9,'Database/optimize','数据优化','',1,1,'',0,52,''),(53,9,'Database/repair','修复表','',1,1,'',0,53,''),(54,11,'Update/updating','升级安装','',1,1,'',0,54,''),(55,48,'Personal/update','资料保存','',1,1,'',0,55,''),(56,3,'Setting/update','设置保存','',1,1,'',0,56,''),(57,9,'Database/del','备份删除','',1,1,'',0,57,''),(58,2,'variable/index','自定义变量','',1,1,'',1,0,''),(59,58,'variable/add','新增变量','',1,1,'',0,0,''),(60,58,'variable/edit','编辑变量','',1,1,'',0,0,''),(61,58,'variable/update','保存变量','',1,1,'',0,0,''),(62,58,'variable/del','删除变量','',1,1,'',0,0,''),(63,37,'Facebook/add','用户反馈','',1,1,'',1,63,''),(66,0,'','商品信息','menu-icon fa fa-bars',1,1,'',1,3,'ssss'),(67,66,'Shop/index','商品列表','',1,1,'',1,1,''),(68,66,'Shop/add','新增商品','',1,1,'',1,2,''),(69,0,'','场次信息','menu-icon fa fa-bars',1,1,'',1,4,''),(70,69,'Session/index','场次列表','',1,1,'',1,1,''),(71,69,'Session/add','新增场次','',1,1,'',1,2,''),(72,0,'','客户信息表','menu-icon fa fa-users',1,1,'',1,5,''),(73,72,'User/add','新增客户','',1,1,'',1,1,''),(74,72,'User/index','客户列表','',1,1,'',1,2,''),(75,0,'','拍卖信息表','menu-icon fa fa-bars',1,1,'',1,6,''),(76,75,'AuctionInfo/index','拍卖信息列表','',1,1,'',1,1,''),(77,2,'Setting/config','配置信息','',1,1,'',1,5,'');
/*!40000 ALTER TABLE `qw_auth_rule` ENABLE KEYS */;

#
# Structure for table "qw_bidding"
#

DROP TABLE IF EXISTS `qw_bidding`;
CREATE TABLE `qw_bidding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0,正在进行;1,拍中；2,未拍中',
  `price` decimal(6,2) DEFAULT NULL,
  `profit` decimal(2,2) DEFAULT NULL,
  `time` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

#
# Data for table "qw_bidding"
#

/*!40000 ALTER TABLE `qw_bidding` DISABLE KEYS */;
INSERT INTO `qw_bidding` VALUES (2,16,98,1,30.00,0.99,1553671764858),(3,16,96,1,30.00,0.99,1553672500270),(4,16,95,0,30.00,0.99,1553672665727),(5,16,95,0,45.00,0.99,1553672675509),(6,16,95,1,60.00,0.99,1553674558939),(7,16,99,0,30.00,0.99,1553675469994),(8,16,99,0,45.00,0.99,1553675485868),(9,16,99,0,60.00,0.99,1553675521200),(10,16,99,0,75.00,0.99,1553675552028),(11,16,99,1,90.00,0.99,1553675822864),(12,16,103,1,30.00,0.99,1553680358291),(29,1,119,2,30.00,0.99,1553746600579),(30,2,119,2,45.00,0.99,1553746691823),(31,3,119,2,60.00,0.99,1553746702034),(32,4,119,2,75.00,0.99,1553746711966),(33,16,119,2,90.00,0.99,1553747209807),(34,16,119,1,99.99,0.99,1553747760328),(35,8,104,0,30.00,0.99,1553748462113),(36,8,104,0,45.00,0.99,1553748475000),(37,8,104,0,60.00,0.99,1553748561579),(38,8,104,0,75.00,0.99,1553748642224),(39,8,104,0,90.00,0.99,1553748651294),(40,8,104,0,99.99,0.99,1553748720891),(41,8,104,0,99.99,0.99,1553748811502),(42,8,104,0,99.99,0.99,1553748891620),(43,8,104,0,99.99,0.99,1553748934934),(44,8,104,0,99.99,0.99,1553749002795),(45,8,104,0,99.99,0.99,1553749106656),(46,8,104,0,99.99,0.99,1553749150739),(47,16,123,0,30.00,0.99,1553749342006),(48,16,123,0,45.00,0.99,1553749351924),(49,16,123,0,60.00,0.99,1553749363386),(50,7,123,0,75.00,0.99,1553751646047),(62,7,123,0,90.00,0.99,1553753587005),(63,7,127,4,30.00,0.99,1553754333094),(64,7,127,4,45.00,0.99,1553754342955),(65,7,127,4,60.00,0.99,1553754354364),(66,16,127,4,75.00,0.99,1553754488419),(68,16,127,1,90.00,0.99,1553755172811);
/*!40000 ALTER TABLE `qw_bidding` ENABLE KEYS */;

#
# Structure for table "qw_category"
#

DROP TABLE IF EXISTS `qw_category`;
CREATE TABLE `qw_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '0正常，1单页，2外链',
  `pid` int(11) NOT NULL COMMENT '父ID',
  `name` varchar(100) NOT NULL COMMENT '分类名称',
  `dir` varchar(100) NOT NULL COMMENT '目录名称',
  `seotitle` varchar(200) DEFAULT NULL COMMENT 'SEO标题',
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `cattemplate` varchar(100) NOT NULL,
  `contemplate` varchar(100) NOT NULL,
  `o` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `fsid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "qw_category"
#

/*!40000 ALTER TABLE `qw_category` DISABLE KEYS */;
INSERT INTO `qw_category` VALUES (36,0,0,'测试','','测试','测试','测试','','','','',1);
/*!40000 ALTER TABLE `qw_category` ENABLE KEYS */;

#
# Structure for table "qw_devlog"
#

DROP TABLE IF EXISTS `qw_devlog`;
CREATE TABLE `qw_devlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `v` varchar(225) NOT NULL COMMENT '版本号',
  `y` int(4) NOT NULL COMMENT '年分',
  `t` int(10) NOT NULL COMMENT '发布日期',
  `log` text NOT NULL COMMENT '更新日志',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "qw_devlog"
#

/*!40000 ALTER TABLE `qw_devlog` DISABLE KEYS */;
INSERT INTO `qw_devlog` VALUES (1,'1.0.0',2016,1440259200,'QWADMIN第一个版本发布。'),(2,'1.0.1',2016,1440259200,'修改cookie过于简单的安全风险。');
/*!40000 ALTER TABLE `qw_devlog` ENABLE KEYS */;

#
# Structure for table "qw_flash"
#

DROP TABLE IF EXISTS `qw_flash`;
CREATE TABLE `qw_flash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `o` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `o` (`o`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_flash"
#

/*!40000 ALTER TABLE `qw_flash` DISABLE KEYS */;
/*!40000 ALTER TABLE `qw_flash` ENABLE KEYS */;

#
# Structure for table "qw_links"
#

DROP TABLE IF EXISTS `qw_links`;
CREATE TABLE `qw_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `o` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `o` (`o`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_links"
#

/*!40000 ALTER TABLE `qw_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `qw_links` ENABLE KEYS */;

#
# Structure for table "qw_log"
#

DROP TABLE IF EXISTS `qw_log`;
CREATE TABLE `qw_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `t` int(10) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `log` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=191 DEFAULT CHARSET=utf8;

#
# Data for table "qw_log"
#

/*!40000 ALTER TABLE `qw_log` DISABLE KEYS */;
INSERT INTO `qw_log` VALUES (1,'admin',1552470230,'::1','登录成功。'),(2,'admin',1552525057,'::1','登录成功。'),(3,'admin',1552525238,'::1','新增菜单，名称：商品信息'),(4,'admin',1552525374,'::1','编辑菜单，ID：66'),(5,'admin',1552525494,'::1','新增菜单，名称：商品列表'),(6,'admin',1552525512,'::1','编辑菜单，ID：67'),(7,'admin',1552535630,'::1','新增菜单，名称：新增商品'),(8,'admin',1552535652,'::1','编辑菜单，ID：68'),(9,'admin',1552542952,'::1','新增分类，ID：36，名称：测试'),(10,'admin',1552542983,'::1','新增文章，AID：1'),(11,'admin',1552547871,'::1','新增商品，AID：1'),(12,'admin',1552555720,'::1','新增菜单，名称：场次信息'),(13,'admin',1552555743,'::1','编辑菜单，ID：69'),(14,'admin',1552555808,'::1','编辑菜单，ID：69'),(15,'admin',1552555927,'::1','编辑菜单，ID：69'),(16,'admin',1552556083,'::1','编辑菜单，ID：69'),(17,'admin',1552556123,'::1','编辑菜单，ID：69'),(18,'admin',1552556331,'::1','新增商品，AID：2'),(19,'admin',1552557242,'::1','新增商品，AID：3'),(20,'admin',1552557259,'::1','新增商品，AID：4'),(21,'admin',1552616192,'::1','删除商品，AID：1'),(22,'admin',1552616253,'::1','删除商品，AID：2,3,4'),(23,'admin',1552616286,'::1','新增商品，AID：5'),(24,'admin',1552616308,'::1','新增商品，AID：6'),(25,'admin',1552617136,'::1','新增菜单，名称：场次列表'),(26,'admin',1552617184,'::1','新增菜单，名称：新增场次'),(27,'admin',1552620923,'::1','新增场次，AID：1'),(28,'admin',1552622492,'::1','新增场次，AID：2'),(29,'admin',1552623241,'::1','编辑场次，AID：1'),(30,'admin',1552623376,'::1','新增场次，AID：3'),(31,'admin',1552629243,'::1','删除场次，AID：1,2'),(32,'admin',1552634515,'::1','登录成功。'),(33,'admin',1552697557,'::1','登录成功。'),(34,'admin',1552715654,'::1','登录成功。'),(35,'admin',1552716069,'::1','登录成功。'),(36,'admin',1552721090,'::1','新增菜单，名称：客户信息表'),(37,'admin',1552721982,'::1','编辑菜单，ID：13'),(38,'admin',1552722165,'::1','新增菜单，名称：新增客户'),(39,'admin',1552722200,'::1','新增菜单，名称：客户列表'),(40,'admin',1552728626,'::1','编辑场次，AID：3'),(41,'admin',1552728649,'::1','新增商品，AID：7'),(42,'admin',1552728789,'::1','新增商品，AID：8'),(43,'admin',1552728826,'::1','编辑商品，AID：6'),(44,'admin',1552730483,'::1','编辑菜单，ID：73'),(45,'admin',1552730600,'::1','新增客户，AID：2'),(46,'admin',1552730933,'::1','新增客户，AID：3'),(47,'admin',1552731495,'::1','编辑客户，AID：3'),(48,'admin',1552870053,'::1','登录成功。'),(49,'admin',1552870228,'::1','新增客户，AID：4'),(50,'admin',1552873684,'::1','编辑客户，AID：3'),(51,'admin',1552879559,'::1','编辑客户，AID：4'),(52,'admin',1552880379,'::1','新增客户，AID：5'),(53,'admin',1552880970,'::1','新增客户，AID：6'),(54,'admin',1552881290,'::1','编辑客户，AID：6'),(55,'admin',1552881463,'::1','编辑客户，AID：6'),(56,'admin',1552881506,'::1','编辑客户，AID：6'),(57,'admin',1552889884,'::1','登录成功。'),(58,'admin',1552890680,'::1','新增菜单，名称：拍卖信息表'),(59,'admin',1552890777,'::1','编辑菜单，ID：75'),(60,'admin',1552891052,'::1','编辑菜单，ID：75'),(61,'admin',1552892476,'::1','新增菜单，名称：拍卖信息列表'),(62,'admin',1552892541,'::1','编辑菜单，ID：76'),(63,'admin',1552900123,'::1','新增客户，AID：7'),(64,'admin',1552900143,'::1','新增客户，AID：8'),(65,'admin',1552901746,'::1','编辑商品，AID：5'),(66,'admin',1552963968,'::1','登录成功。'),(67,'admin',1552964054,'::1','登录成功。'),(68,'admin',1552964078,'::1','新增场次，AID：4'),(69,'admin',1552964107,'::1','新增场次，AID：5'),(70,'admin',1552964164,'::1','新增场次，AID：6'),(71,'admin',1552964195,'::1','新增场次，AID：7'),(72,'admin',1552974336,'::1','新增场次，AID：8'),(73,'admin',1552975633,'::1','删除场次，AID：7'),(74,'admin',1552975865,'::1','删除场次，AID：5'),(75,'admin',1552975872,'::1','删除场次，AID：8'),(76,'admin',1552975878,'::1','删除场次，AID：4'),(77,'admin',1552975885,'::1','删除场次，AID：6'),(78,'admin',1552975943,'::1','新增场次，AID：9'),(79,'admin',1552975988,'::1','新增场次，AID：10'),(80,'admin',1552976031,'::1','新增场次，AID：11'),(81,'admin',1552976112,'::1','新增场次，AID：12'),(82,'admin',1552976139,'::1','编辑场次，AID：3'),(83,'admin',1552978769,'::1','编辑商品，AID：7'),(84,'admin',1552981298,'::1','编辑场次，AID：12'),(85,'admin',1552981315,'::1','编辑场次，AID：11'),(86,'admin',1552981331,'::1','编辑场次，AID：3'),(87,'admin',1552981346,'::1','编辑场次，AID：10'),(88,'admin',1552981360,'::1','编辑场次，AID：9'),(89,'admin',1552982273,'::1','编辑场次，AID：12'),(90,'admin',1552982345,'::1','编辑场次，AID：11'),(91,'admin',1552984735,'::1','编辑场次，AID：11'),(92,'admin',1552986612,'::1','编辑商品，AID：24'),(93,'admin',1552986639,'::1','编辑商品，AID：24'),(94,'admin',1552986876,'::1','编辑商品，AID：24'),(95,'admin',1552986962,'::1','编辑商品，AID：24'),(96,'admin',1552987029,'::1','编辑商品，AID：6'),(97,'admin',1552987059,'::1','编辑商品，AID：26'),(98,'admin',1552988965,'::1','编辑场次，AID：12'),(99,'admin',1552988993,'::1','编辑商品，AID：25'),(100,'admin',1552989026,'::1','编辑商品，AID：26'),(101,'admin',1552989055,'::1','编辑商品，AID：27'),(102,'admin',1552992506,'::1','删除场次，AID：3'),(103,'admin',1552992592,'::1','新增场次，AID：13'),(104,'admin',1552995228,'::1','编辑场次，AID：10'),(105,'admin',1552995264,'::1','编辑商品，AID：25'),(106,'admin',1552995876,'::1','编辑商品，AID：25'),(107,'admin',1552996148,'::1','编辑商品，AID：25'),(108,'admin',1553044601,'::1','编辑场次，AID：9'),(109,'admin',1553044657,'::1','编辑场次，AID：13'),(110,'admin',1553044697,'::1','编辑场次，AID：10'),(111,'admin',1553044730,'::1','编辑场次，AID：11'),(112,'admin',1553044759,'::1','编辑场次，AID：12'),(113,'admin',1553044796,'::1','删除商品，AID：25,26,27,22,23,24,5,6,7,8,9,18,19,20,21'),(114,'admin',1553044805,'::1','删除商品，AID：14,15,16,17,10,11,12,13'),(115,'admin',1553044853,'::1','编辑商品，AID：6'),(116,'admin',1553044880,'::1','编辑商品，AID：8'),(117,'admin',1553052417,'::1','编辑场次，AID：10'),(118,'admin',1553054384,'::1','编辑场次，AID：9'),(119,'admin',1553054406,'::1','编辑场次，AID：9'),(120,'admin',1553060001,'::1','登录成功。'),(121,'admin',1553060027,'::1','编辑场次，AID：9'),(122,'admin',1553072362,'::1','编辑场次，AID：10'),(123,'admin',1553072404,'::1','编辑场次，AID：10'),(124,'admin',1553078172,'::1','删除商品，AID：45,44,43,42,41,40,39,36,37,38,34,35,31,32,33'),(125,'admin',1553078179,'::1','删除商品，AID：28,29,30'),(126,'admin',1553079735,'::1','编辑商品，AID：46'),(127,'admin',1553079766,'::1','编辑场次，AID：12'),(128,'admin',1553079828,'::1','编辑商品，AID：46'),(129,'admin',1553080573,'::1','编辑场次，AID：12'),(130,'admin',1553161978,'::1','编辑场次，AID：12'),(131,'admin',1553162016,'::1','编辑场次，AID：10'),(132,'admin',1553162110,'::1','编辑商品，AID：48'),(133,'admin',1553162149,'::1','编辑场次，AID：11'),(134,'admin',1553163573,'::1','编辑商品，AID：48'),(135,'admin',1553215641,'::1','登录成功。'),(136,'admin',1553215685,'::1','删除商品，AID：46,47,49,48,50,51'),(137,'admin',1553215798,'::1','编辑场次，AID：12'),(138,'admin',1553215839,'::1','编辑场次，AID：10'),(139,'admin',1553215930,'::1','编辑场次，AID：10'),(140,'admin',1553215986,'::1','编辑场次，AID：11'),(141,'admin',1553220401,'::1','编辑场次，AID：13'),(142,'admin',1553220506,'::1','编辑场次，AID：13'),(143,'admin',1553220578,'::1','编辑场次，AID：13'),(144,'admin',1553221450,'::1','编辑商品，AID：58'),(145,'admin',1553232920,'::1','编辑场次，AID：9'),(146,'admin',1553236469,'::1','编辑场次，AID：12'),(147,'admin',1553245547,'::1','编辑场次，AID：10'),(148,'admin',1553247911,'::1','编辑场次，AID：11'),(149,'admin',1553251032,'::1','编辑商品，AID：8'),(150,'admin',1553251062,'::1','编辑商品，AID：6'),(151,'admin',1553251093,'::1','编辑商品，AID：7'),(152,'admin',1553251122,'::1','编辑商品，AID：5'),(153,'admin',1553251653,'::1','编辑商品，AID：57'),(154,'admin',1553252129,'::1','编辑商品，AID：57'),(155,'admin',1553252461,'::1','编辑商品，AID：57'),(156,'admin',1553301943,'::1','编辑场次，AID：10'),(157,'admin',1553302034,'::1','编辑场次，AID：11'),(158,'admin',1553305186,'::1','删除商品，AID：59,58,72,73,74,75,57,56,55,68,69,70,71,52,53'),(159,'admin',1553305194,'::1','删除商品，AID：54,65,66,67,62,63,64,61,60'),(160,'admin',1553308511,'::1','编辑场次，AID：13'),(161,'admin',1553310070,'::1','编辑场次，AID：12'),(162,'admin',1553311483,'::1','编辑商品，AID：5'),(163,'admin',1553311740,'::1','编辑商品，AID：84'),(164,'admin',1553318780,'::1','编辑场次，AID：9'),(165,'admin',1553482076,'127.0.0.1','登录成功。'),(166,'admin',1553501913,'127.0.0.1','登录成功。'),(167,'admin',1553651136,'127.0.0.1','登录成功。'),(168,'admin',1553667441,'::1','删除商品，AID：88,89,90,84,85,86,87,80,81,82,83,76,77,78,79'),(169,'admin',1553667465,'::1','编辑场次，AID：9'),(170,'admin',1553668957,'::1','登录成功。'),(171,'admin',1553669936,'::1','新增菜单，名称：配置信息'),(172,'admin',1553669998,'::1','编辑菜单，ID：77'),(173,'admin',1553671653,'::1','编辑场次，AID：10'),(174,'admin',1553672563,'::1','编辑商品，AID：95'),(175,'admin',1553672635,'::1','编辑商品，AID：95'),(176,'admin',1553675365,'::1','编辑商品，AID：5'),(177,'admin',1553675389,'::1','编辑场次，AID：9'),(178,'admin',1553678384,'::1','编辑场次，AID：11'),(179,'admin',1553681065,'::1','编辑场次，AID：13'),(180,'admin',1553733672,'::1','登录成功。'),(181,'admin',1553733786,'::1','编辑场次，AID：13'),(182,'admin',1553733794,'::1','编辑场次，AID：13'),(183,'admin',1553742274,'::1','编辑场次，AID：12'),(184,'admin',1553745740,'::1','编辑场次，AID：11'),(185,'admin',1553747594,'::1','登录成功。'),(186,'admin',1553747678,'::1','删除商品，AID：103'),(187,'admin',1553748425,'::1','编辑商品，AID：104'),(188,'admin',1553749266,'::1','编辑场次，AID：13'),(189,'admin',1553754212,'::1','编辑场次，AID：9'),(190,'admin',1553754221,'::1','编辑场次，AID：9');
/*!40000 ALTER TABLE `qw_log` ENABLE KEYS */;

#
# Structure for table "qw_logistics"
#

DROP TABLE IF EXISTS `qw_logistics`;
CREATE TABLE `qw_logistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `sid` int(10) unsigned NOT NULL COMMENT '商品id',
  `logistics` varchar(255) DEFAULT '' COMMENT '物流公司名',
  `Logistics_number` varchar(255) DEFAULT '' COMMENT '物流编号',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `logistics_price` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '物流费用',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `placetime` int(11) NOT NULL COMMENT '下单时间',
  `shop_name` varchar(255) NOT NULL COMMENT '商品名称',
  `shop_price` decimal(10,0) NOT NULL COMMENT '商品价格',
  `pic` varchar(255) DEFAULT '' COMMENT '商品图片',
  `lasttime` int(11) DEFAULT NULL COMMENT '交易完成时间',
  `paytime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_logistics"
#

/*!40000 ALTER TABLE `qw_logistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `qw_logistics` ENABLE KEYS */;

#
# Structure for table "qw_member"
#

DROP TABLE IF EXISTS `qw_member`;
CREATE TABLE `qw_member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(225) NOT NULL,
  `head` varchar(255) NOT NULL COMMENT '头像',
  `sex` tinyint(1) NOT NULL COMMENT '0保密1男，2女',
  `birthday` int(10) NOT NULL COMMENT '生日',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `qq` varchar(20) NOT NULL COMMENT 'QQ',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `password` varchar(32) NOT NULL,
  `t` int(10) unsigned NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "qw_member"
#

/*!40000 ALTER TABLE `qw_member` DISABLE KEYS */;
INSERT INTO `qw_member` VALUES (1,'admin','/Public/attached/201601/1453389194.png',1,1420128000,'13800138000','331349451','xieyanwei@qq.com','66d6a1c8748025462128dc75bf5ae8d1',1442505600);
/*!40000 ALTER TABLE `qw_member` ENABLE KEYS */;

#
# Structure for table "qw_session"
#

DROP TABLE IF EXISTS `qw_session`;
CREATE TABLE `qw_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '场次名称',
  `time` int(10) DEFAULT NULL COMMENT '场次时间',
  `status` tinyint(3) DEFAULT NULL COMMENT '场次状态:0,未开始;1,正在进行;2,结束',
  `end_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='场次表';

#
# Data for table "qw_session"
#

/*!40000 ALTER TABLE `qw_session` DISABLE KEYS */;
INSERT INTO `qw_session` VALUES (9,'14点场',1553752800,0,1553756400),(10,'15点场',1553670000,0,1553673600),(11,'12点场',1553745600,0,1553749200),(12,'11点场',1553742000,0,1553745600),(13,'1',1553749200,0,1553752800);
/*!40000 ALTER TABLE `qw_session` ENABLE KEYS */;

#
# Structure for table "qw_setting"
#

DROP TABLE IF EXISTS `qw_setting`;
CREATE TABLE `qw_setting` (
  `k` varchar(100) NOT NULL COMMENT '变量',
  `v` varchar(255) NOT NULL COMMENT '值',
  `type` tinyint(1) NOT NULL COMMENT '0系统，1自定义',
  `name` varchar(255) NOT NULL COMMENT '说明',
  PRIMARY KEY (`k`),
  KEY `k` (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "qw_setting"
#

/*!40000 ALTER TABLE `qw_setting` DISABLE KEYS */;
INSERT INTO `qw_setting` VALUES ('description','网站描述',0,''),('footer','2016©恰维网络',0,''),('keywords','关键词',0,''),('sitename','QWADMIN',0,''),('test','测试',1,'测试变量'),('title','恰维网络',0,'');
/*!40000 ALTER TABLE `qw_setting` ENABLE KEYS */;

#
# Structure for table "qw_shop"
#

DROP TABLE IF EXISTS `qw_shop`;
CREATE TABLE `qw_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `thumbnail` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图',
  `carousel_figure1` varchar(255) NOT NULL COMMENT '轮播图',
  `carousel_figure2` varchar(255) NOT NULL,
  `carousel_figure3` varchar(255) DEFAULT NULL,
  `detail` text COMMENT '详情页',
  `start_price` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '起拍价',
  `additional_shot_range` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '加拍幅度',
  `reference_price` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '参考价',
  `high_price` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '最高成交价',
  `guaranty` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态：0下架 1上架',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品添加时间',
  `short_show` text COMMENT '文字简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "qw_shop"
#

/*!40000 ALTER TABLE `qw_shop` DISABLE KEYS */;
INSERT INTO `qw_shop` VALUES (5,'hanger','/Public/attached/2019/03/15/5c8b0b4d7add1.jpg','/Public/attached/2019/03/22/5c94bb2983fff.jpg','/Public/attached/2019/03/22/5c94bb2c4e53e.jpg','/Public/attached/2019/03/22/5c94bb2f445bf.jpg','<p>\r\n\t5165161\r\n</p>',15.00,15.00,15.00,90.00,15.00,0,1553675365,'asdfsfd'),(6,'gou','/Public/attached/2019/03/20/5c91956a4429c.jpg','/Public/attached/2019/03/22/5c94baedaa3a0.jpg','/Public/attached/2019/03/22/5c94baf0b38be.jpg','/Public/attached/2019/03/22/5c94baf360936.jpg','615561',15.00,15.00,15.00,15.00,15.00,0,1553251062,NULL),(7,'xxaxx123','/Public/attached/2019/03/15/5c8b0b69e3c0b.jpg','/Public/attached/2019/03/22/5c94bb0caa6a5.jpg','/Public/attached/2019/03/22/5c94bb0fa8040.jpg','/Public/attached/2019/03/22/5c94bb120f760.jpg','615561',15.00,15.00,15.00,15.00,15.00,0,1553251093,NULL),(8,'muyulu','/Public/attached/2019/03/20/5c91958821268.jpg','/Public/attached/2019/03/22/5c94bace79f08.jpg','/Public/attached/2019/03/22/5c94bad17d27c.jpg','/Public/attached/2019/03/22/5c94bad3a018f.jpg','615561',15.00,15.00,15.00,15.00,15.00,0,1553251032,NULL);
/*!40000 ALTER TABLE `qw_shop` ENABLE KEYS */;

#
# Structure for table "qw_user"
#

DROP TABLE IF EXISTS `qw_user`;
CREATE TABLE `qw_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '客户姓名',
  `point` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `available_balance` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '可用余额',
  `guaranty` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `freeze` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '冻结账户',
  `anti_money` int(7) NOT NULL DEFAULT '0' COMMENT '反拍额',
  `invite_code` varchar(255) DEFAULT NULL COMMENT '邀请码',
  `status` tinyint(3) DEFAULT NULL COMMENT '0,未审核:1,正常,2禁用',
  `parent_id` int(7) DEFAULT NULL COMMENT '上级id',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `phone_num` char(11) DEFAULT NULL COMMENT '手机号',
  `ming_password` varchar(255) NOT NULL DEFAULT '' COMMENT '明文密码',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密文密码',
  `thumb` varchar(255) DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户表';

#
# Data for table "qw_user"
#

/*!40000 ALTER TABLE `qw_user` DISABLE KEYS */;
INSERT INTO `qw_user` VALUES (1,'哈哈',0.00,6.00,0.00,0.00,0,'123156afdsh',NULL,NULL,NULL,'0','','',NULL),(2,'15',0.00,0.00,0.00,0.00,0,'7cd5abf2c227a31b7d892a54a590fb3b',0,NULL,1552730600,'0','','',NULL),(3,'测试aa',99.99,15.00,15.00,15.00,15,'836e3f157d7ce502eb43ad6a991c4964',0,NULL,1552730933,'0','','',NULL),(4,'hanger112',0.00,10.00,0.00,0.00,0,'03b6d15725896d3559c5e09120dfd306',0,NULL,1552870228,'15903600277','213433','',NULL),(5,'hangercc',15.00,15.00,100.00,15.00,15,'96784065',1,1,1552880379,'13800138000','213433','4a8a08f09d37b73795649038408b5f33',NULL),(6,'测试ssss',0.00,0.00,0.00,0.00,0,'9b8a18e9',1,1,1552880970,'15903602970','213433565','4a8a08f09d37b73795649038408b5f33',NULL),(7,'ce1',15.00,75.00,40.00,75.00,15,'6b399603',1,1,1552900123,'15903602211','213433','b3afb61a83cb2baa0ab811832db82dc4',NULL),(8,'ce2',15.00,97.00,70.00,45.00,21,'de9492d6',1,1,1552900143,'15903602213','213433','b3afb61a83cb2baa0ab811832db82dc4',NULL),(16,'aaaaaa',540.00,115.00,185.00,345.00,0,'47a8152f',1,8,1553657118,'15903602970','213433','b3afb61a83cb2baa0ab811832db82dc4',NULL);
/*!40000 ALTER TABLE `qw_user` ENABLE KEYS */;
