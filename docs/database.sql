-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 01 月 16 日 19:01
-- 服务器版本: 5.1.28
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `iweengine`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_basic_reply`
--

DROP TABLE IF EXISTS `ims_basic_reply`;
CREATE TABLE IF NOT EXISTS `ims_basic_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ims_basic_reply`
--

INSERT INTO `ims_basic_reply` (`id`, `rid`, `content`) VALUES
(1, 2, '基本文字回复');

-- --------------------------------------------------------

--
-- 表的结构 `ims_cache`
--

DROP TABLE IF EXISTS `ims_cache`;
CREATE TABLE IF NOT EXISTS `ims_cache` (
  `key` varchar(50) NOT NULL COMMENT '缓存键名',
  `value` varchar(500) NOT NULL COMMENT '缓存内容',
  PRIMARY KEY (`key`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='缓存表';

--
-- 转存表中的数据 `ims_cache`
--

INSERT INTO `ims_cache` (`key`, `value`) VALUES
('setting:profile:welcome', 's:36:"欢迎信息欢迎信息欢迎信息";'),
('setting:profile:token', 's:32:"cnpmokzl2zk012trum3xdpkorghbvlw1";'),
('setting:profile:wechat', 's:0:"";'),
('setting:profile:default', 's:48:"默认回复默认回复默认回复默认回复";'),
('setting:modules', 's:974:"a:2:{s:5:"basic";a:8:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:5:"title";s:18:"基本文字回复";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:10:"rulefields";s:1:"1";s:8:"settings";s:0:"";s:7:"enabled";s:1:"1";}s:4:"news";a:8:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:5:"title";s:24:"基本混合图文回复";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全');

-- --------------------------------------------------------

--
-- 表的结构 `ims_members`
--

DROP TABLE IF EXISTS `ims_members`;
CREATE TABLE IF NOT EXISTS `ims_members` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(200) NOT NULL COMMENT '用户密码',
  `salt` varchar(10) NOT NULL COMMENT '加密盐',
  `email` varchar(80) NOT NULL COMMENT '用户邮箱',
  `newpms` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '新pm数量',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '用户头像',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态，0正常，-1禁用',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否管理员，1是，其他否',
  `joindate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ims_members`
--

INSERT INTO `ims_members` (`uid`, `username`, `password`, `salt`, `email`, `newpms`, `avatar`, `status`, `level`, `joindate`) VALUES
(1, 'admin', '6ea23bcb1c81451a863fb30460d1aa323770546c', 'c79e19c1', 'donknap@gmail.com', 0, '', 0, 0, 1355397094);

-- --------------------------------------------------------

--
-- 表的结构 `ims_member_status`
--

DROP TABLE IF EXISTS `ims_member_status`;
CREATE TABLE IF NOT EXISTS `ims_member_status` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户编号',
  `joinip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户注册时IP',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `lastip` varchar(15) NOT NULL DEFAULT '' COMMENT '最后一次登录IP',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次发表文章时间',
  `pquantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发表分享数量',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员状态附表';

--
-- 转存表中的数据 `ims_member_status`
--

INSERT INTO `ims_member_status` (`uid`, `joinip`, `lastvisit`, `lastip`, `lastpost`, `pquantity`) VALUES
(1, '', 1358332596, '124.200.52.25', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules`
--

DROP TABLE IF EXISTS `ims_modules`;
CREATE TABLE IF NOT EXISTS `ims_modules` (
  `mid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '标识',
  `title` varchar(20) NOT NULL COMMENT '名称',
  `ability` varchar(20) NOT NULL COMMENT '功能描述',
  `description` varchar(200) NOT NULL COMMENT '介绍',
  `rulefields` tinyint(1) NOT NULL COMMENT '是否需要扩展规则字段',
  `settings` varchar(500) NOT NULL COMMENT '扩展设置项',
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ims_modules`
--

INSERT INTO `ims_modules` (`mid`, `name`, `title`, `ability`, `description`, `rulefields`, `settings`, `enabled`) VALUES
(1, 'basic', '基本文字回复', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 1, '', 1),
(2, 'news', '基本混合图文回复', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 1, '', 1),
(3, 'DXPlugin', 'Discuz! X论坛助手', '', '', 0, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_news_reply`
--

DROP TABLE IF EXISTS `ims_news_reply`;
CREATE TABLE IF NOT EXISTS `ims_news_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(60) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ims_news_reply`
--

INSERT INTO `ims_news_reply` (`id`, `rid`, `parentid`, `title`, `description`, `thumb`, `content`, `url`) VALUES
(1, 1, 0, '主标题主标题主标题主标题主标题', '主描述主描述主描述主描述主描述主描述主描述主描述主描述', 'images/2013/01/0c508e3621c7d4e3420737ecf87ab0.png', '主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文主原文', ''),
(2, 1, 1, '副标题', '', 'images/2013/01/9f0c11f9fbc546ebdee42044cd7e6b.png', '副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文副原文', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule`
--

DROP TABLE IF EXISTS `ims_rule`;
CREATE TABLE IF NOT EXISTS `ims_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ims_rule`
--

INSERT INTO `ims_rule` (`id`, `uid`, `name`, `module`) VALUES
(1, 1, '图文规则', 'news'),
(2, 1, '基本文字回复', 'basic');

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule_keyword`
--

DROP TABLE IF EXISTS `ims_rule_keyword`;
CREATE TABLE IF NOT EXISTS `ims_rule_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则ID',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型1匹配，2正则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ims_rule_keyword`
--

INSERT INTO `ims_rule_keyword` (`id`, `rid`, `content`, `type`) VALUES
(1, 1, '图文', 2),
(2, 2, '你好', 2);

-- --------------------------------------------------------

--
-- 表的结构 `ims_settings`
--

DROP TABLE IF EXISTS `ims_settings`;
CREATE TABLE IF NOT EXISTS `ims_settings` (
  `key` varchar(200) NOT NULL COMMENT '设置键名',
  `value` text NOT NULL COMMENT '设置内容，大量数据将序列化',
  `description` varchar(200) NOT NULL COMMENT '描述',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_settings`
--

INSERT INTO `ims_settings` (`key`, `value`, `description`) VALUES
('profile:wechat', 's:0:"";', ''),
('profile:token', 's:32:"cnpmokzl2zk012trum3xdpkorghbvlw1";', ''),
('profile:welcome', 's:36:"欢迎信息欢迎信息欢迎信息";', ''),
('profile:default', 's:48:"默认回复默认回复默认回复默认回复";', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
