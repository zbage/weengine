-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 22 日 18:33
-- 服务器版本: 5.1.28
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `we7`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_basic_reply`
--

DROP TABLE IF EXISTS `ims_basic_reply`;
CREATE TABLE IF NOT EXISTS `ims_basic_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ims_basic_reply`
--

INSERT INTO `ims_basic_reply` (`id`, `rid`, `content`) VALUES
(1, 1, '这里是默认文字回复'),
(2, 5, '&lt;a&nbsp;href=&quot;#&quot;&gt;xxxxxx&lt;/a&gt;'),
(3, 6, 'yyyyyyyyyyyyyyyyy');

-- --------------------------------------------------------

--
-- 表的结构 `ims_cache`
--

DROP TABLE IF EXISTS `ims_cache`;
CREATE TABLE IF NOT EXISTS `ims_cache` (
  `key` varchar(50) NOT NULL COMMENT '缓存键名',
  `value` varchar(2000) NOT NULL COMMENT '缓存内容',
  PRIMARY KEY (`key`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='缓存表';

--
-- 转存表中的数据 `ims_cache`
--

INSERT INTO `ims_cache` (`key`, `value`) VALUES
('category:1', 'a:8:{i:1;a:8:{s:2:"id";s:1:"1";s:4:"weid";s:1:"1";s:4:"name";s:8:"xxxxxxxx";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:49:"images/2013/06/5515d3ab1f510fabbe4f6951514b9c.jpg";s:11:"description";s:0:"";}i:2;a:8:{s:2:"id";s:1:"2";s:4:"weid";s:1:"1";s:4:"name";s:8:"xxxxxxxx";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:49:"images/2013/06/399f426850b8fa4e35411778697a1b.jpg";s:11:"description";s:0:"";}i:3;a:8:{s:2:"id";s:1:"3";s:4:"weid";s:1:"1";s:4:"name";s:8:"xxxxxxxx";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}i:4;a:8:{s:2:"id";s:1:"4";s:4:"weid";s:1:"1";s:4:"name";s:9:"yyyyyyyyy";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}i:5;a:8:{s:2:"id";s:1:"5";s:4:"weid";s:1:"1";s:4:"name";s:15:"zzzzzzzzzzzzzzz";s:8:"parentid";s:1:"1";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}i:6;a:8:{s:2:"id";s:1:"6";s:4:"weid";s:1:"1";s:4:"name";s:12:"wwwwwwwwwwww";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}i:7;a:8:{s:2:"id";s:1:"7";s:4:"weid";s:1:"1";s:4:"name";s:14:"ffffffffffffff";s:8:"parentid";s:1:"6";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}i:8;a:8:{s:2:"id";s:1:"8";s:4:"weid";s:1:"1";s:4:"name";s:13:"ddddddddddddd";s:8:"parentid";s:1:"0";s:12:"displayorder";s:1:"0";s:7:"enabled";s:1:"1";s:4:"icon";s:0:"";s:11:"description";s:0:"";}}'),
('weid', 's:1:"1";'),
('announcement', 's:624:"a:3:{s:6:"status";s:2:"OK";s:7:"content";a:2:{s:6:"status";i:1;s:7:"content";s:505:"<dl><dt>尊敬的站长：</dt><dd><font color="red">微擎 v0.23 UTF8 公测BAE版</font>已于2013年06月04日更新啦！请进入<a href="http://www.we7.cc" target="_blank">微擎官方网站</a>点击下载。</dd><dd>微擎官方交流群：32385562</dd><dd class="we7_tips_view"><a href="http://www.we7.cc" target="_blank" title="查看">查看详情</a></dd></dl><div style="display:none;"><script src="http://s13.cnzz.com/stat.php?id=1998411&web_id=1998411" language="JavaScript"></script></div>";}s:10:"lastupdate";i:1371892624;}";'),
('hooks:1', 'a:1:{s:6:"before";a:3:{i:0;a:2:{i:0;s:4:"news";i:1;s:10:"hookBefore";}i:1;a:2:{i:0;s:7:"userapi";i:1;s:10:"hookBefore";}i:2;a:2:{i:0;s:6:"wxwall";i:1;s:10:"hookBefore";}}}'),
('hooks:2', 'a:1:{s:6:"before";a:1:{i:0;a:2:{i:0;s:4:"news";i:1;s:10:"hookBefore";}}}'),
('setting:modules:2', 's:1497:"a:3:{s:5:"basic";a:9:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:5:"title";s:18:"基本文字回复";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}s:4:"news";a:9:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:5:"title";s:24:"基本混合图文回复";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}s:5:"music";a:9:{s:3:"mid";s:1:"4";s:4:"name";s:5:"music";s:5:"title";s:18:"基本语音回复";s:7:"ability";s:39:"提供语音、音乐等音频类回复";s:11:"description";s:183:"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}}";'),
('setting:modules:1', 's:2153:"a:5:{s:5:"basic";a:9:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:5:"title";s:18:"基本文字回复";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}s:4:"news";a:9:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:5:"title";s:24:"基本混合图文回复";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}s:5:"music";a:9:{s:3:"mid";s:1:"4";s:4:"name";s:5:"music";s:5:"title";s:18:"基本语音回复";s:7:"ability";s:39:"提供语音、音乐等音频类回复";s:11:"description";s:183:"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。";s:10:"rulefields";s:1:"1";s:8:"settings";s:1:"0";s:10:"issettings";s:1:"0";s:8:"issystem";s:1:"1";}s:7:"userapi";a:10:{s:3:"mid";s:1:"6";s:4:"name";s:7:"userapi";s:5:"title";s:21:"自定义接口回复";s:7:"ability";s:0:"";s:11:"description";s:0:"";s:10:"rulefields";s:1:"1";s:8:"settings";s:113:"a:3:{s:6:"apiurl";s:26:"http://localhost/test1.php";s:7:"default";s:15:"sssssssssssssss";s:4:"sign";s:5:"abced";}";s:10:"issettings";s:1:"1";s:8:"issystem";s:1:"0";s:12:"displayorder";s:1:"1";}s:6:"wxwall";a:10:{s:3:"mid";s:1:"7";s:4:"name";s:6:"wxwall";s:5:"title";s:9:"微信墙";s:7:"ability";s:0:"";s:11:"description";s:0:"";s:10:"rulefields";s:1:"1";s:8:"settings";s:0:"";s:10:"issettings";s:1:"1";s:8:"issystem";s:1:"0";s:12:"displayorder";s:3:"127";}}";'),
('setting:wechats', 's:939:"a:2:{i:2;a:18:{s:4:"weid";s:1:"2";s:4:"hash";s:5:"33c76";s:3:"uid";s:1:"1";s:5:"token";s:32:"5cab7c1cd84952e08e1dc66a0fad9917";s:4:"name";s:15:"测试公众号";s:4:"fans";s:1:"0";s:7:"account";s:0:"";s:8:"original";s:0:"";s:9:"signature";s:0:"";s:7:"country";s:0:"";s:8:"province";s:0:"";s:4:"city";s:0:"";s:8:"username";s:0:"";s:8:"password";s:0:"";s:7:"welcome";s:0:"";s:7:"default";s:0:"";s:14:"default_period";s:1:"0";s:10:"lastupdate";s:1:"0";}i:1;a:18:{s:4:"weid";s:1:"1";s:4:"hash";s:5:"3f00e";s:3:"uid";s:1:"1";s:5:"token";s:32:"7c14dfa66f7593f56be07127a6aa7f01";s:4:"name";s:15:"默认公众号";s:4:"fans";s:1:"0";s:7:"account";s:15:"默认公众号";s:8:"original";s:0:"";s:9:"signature";s:0:"";s:7:"country";s:0:"";s:8:"province";s:0:"";s:4:"city";s:0:"";s:8:"username";s:0:"";s:8:"password";s:0:"";s:7:"welcome";s:12:"欢迎信息";s:7:"default";s:12:"默认回复";s:14:"default_period";s:2:"10";s:10:"lastupdate";s:1:"0";}}";'),
('setting:stat:rule', 's:24:"a:1:{s:3:"use";s:1:"0";}";'),
('setting:stat:msg', 's:49:"a:2:{s:7:"history";s:1:"0";s:6:"maxday";s:1:"0";}";');

-- --------------------------------------------------------

--
-- 表的结构 `ims_category`
--

DROP TABLE IF EXISTS `ims_category`;
CREATE TABLE IF NOT EXISTS `ims_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图标',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT '分类描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ims_category`
--

INSERT INTO `ims_category` (`id`, `weid`, `name`, `parentid`, `displayorder`, `enabled`, `icon`, `description`) VALUES
(1, 1, 'xxxxxxxx', 0, 0, 1, 'images/2013/06/5515d3ab1f510fabbe4f6951514b9c.jpg', ''),
(2, 1, 'xxxxxxxx', 0, 0, 1, 'images/2013/06/399f426850b8fa4e35411778697a1b.jpg', ''),
(3, 1, 'xxxxxxxx', 0, 0, 1, '', ''),
(4, 1, 'yyyyyyyyy', 0, 0, 1, '', ''),
(5, 1, 'zzzzzzzzzzzzzzz', 1, 0, 1, '', ''),
(6, 1, 'wwwwwwwwwwww', 0, 0, 1, '', ''),
(7, 1, 'ffffffffffffff', 6, 0, 1, '', ''),
(8, 1, 'ddddddddddddd', 0, 0, 1, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_log_message`
--

DROP TABLE IF EXISTS `ims_log_message`;
CREATE TABLE IF NOT EXISTS `ims_log_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL COMMENT '微信号ID，关联wechats表',
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '用户最后发送信息时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ims_log_message`
--

INSERT INTO `ims_log_message` (`id`, `weid`, `from_user`, `lastupdate`) VALUES
(1, 1, 'otM6Jjlerqt12mYSzUHDFkx_lmI', 1370849091),
(2, 1, 'fromuser', 1371874747),
(3, 1, '', 1370856622);

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
(1, 'admin', '78774e9a1368a18ccedd7b41391beca189e0520b', '658736e3', '', 0, '', 0, 0, 1370335886);

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
(1, '', 1371862436, '127.0.0.1', 0, 0);

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
  `settings` varchar(1000) NOT NULL DEFAULT '' COMMENT '扩展设置项',
  `issettings` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有设置功能',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是系统模块',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `ims_modules`
--

INSERT INTO `ims_modules` (`mid`, `name`, `title`, `ability`, `description`, `rulefields`, `settings`, `issettings`, `issystem`) VALUES
(1, 'basic', '基本文字回复', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 1, '0', 0, 1),
(2, 'news', '基本混合图文回复', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 1, '0', 0, 1),
(3, 'simsimi', '小黄鸡自动回复', '最具智能化的自动陪聊系统', '一款趣味游戏，游戏中的机器人是一个能够和你聊天解闷的可爱机器人，为您的生活提供服务、甚至你还可以逗弄她，并且能实现自然语言的交互。', 0, '0', 0, 0),
(4, 'music', '基本语音回复', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 1, '0', 0, 1),
(5, 'wxapi', '乐享接口回复', '乐享微信营销管理平台与微擎管理系统的兼容', '微擎将试水与第三方管理平台进行战略融合，更好的服务于广大的微信公众平台用户。微擎内置模块的优先级高于其他平台接口，微擎无法处理的对话内容将交于第三方平台处理。', 0, '0', 0, 0),
(6, 'userapi', '自定义接口回复', '', '', 1, 'a:3:{s:6:"apiurl";s:26:"http://localhost/test1.php";s:7:"default";s:15:"sssssssssssssss";s:4:"sign";s:5:"abced";}', 1, 0),
(7, 'wxwall', '微信墙', '', '', 1, '', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_music_reply`
--

DROP TABLE IF EXISTS `ims_music_reply`;
CREATE TABLE IF NOT EXISTS `ims_music_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
  `url` varchar(300) NOT NULL DEFAULT '' COMMENT '音乐地址',
  `hqurl` varchar(300) NOT NULL DEFAULT '' COMMENT '高清地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
(1, 2, 0, '这里是默认图文回复', '这里是默认图文描述', '', '这里是默认图文原文这里是默认图文原文这里是默认图文原文', ''),
(2, 2, 1, '这里是默认图文回复内容', '', 'images/2013/01/112487e19d03eaecc5a9ac87537595.jpg', '这里是默认图文回复原文这里是默认图文回复原文<a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a> <img src="/iweengine/htdocs/resource/attachment/images/2013/06/f5a6c5815999a666b03cfe894b8f7b.jpg" alt="" /><br />', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule`
--

DROP TABLE IF EXISTS `ims_rule`;
CREATE TABLE IF NOT EXISTS `ims_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `name` varchar(50) NOT NULL DEFAULT '',
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `ims_rule`
--

INSERT INTO `ims_rule` (`id`, `weid`, `cid`, `name`, `module`) VALUES
(1, 1, 5, '默认文字回复', 'basic'),
(2, 1, 0, 'xxxxxxxxxxxxx', 'news'),
(4, 1, 0, 'yyyyyyyyyyyyyyyy', 'userapi'),
(5, 1, 0, '详细1', 'basic'),
(6, 1, 0, '详细2', 'basic'),
(7, 1, 0, '第三方哦', 'userapi'),
(8, 1, 0, 'xxxxxxxx', 'wxwall');

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule_keyword`
--

DROP TABLE IF EXISTS `ims_rule_keyword`;
CREATE TABLE IF NOT EXISTS `ims_rule_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则ID',
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `module` varchar(50) NOT NULL COMMENT '对应模块',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型1匹配，2包含，3正则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ims_rule_keyword`
--

INSERT INTO `ims_rule_keyword` (`id`, `rid`, `weid`, `module`, `content`, `type`) VALUES
(1, 1, 1, 'basic', '文字', 2),
(2, 2, 1, 'news', '图文', 2),
(3, 4, 1, 'userapi', 'api', 2),
(5, 5, 1, 'basic', '天气', 2),
(6, 6, 1, 'basic', '天气', 2),
(8, 7, 1, 'userapi', '/^a\\d{0,5}$/', 3),
(9, 8, 1, 'wxwall', '进入', 1);

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
('stat:msg', 's:49:"a:2:{s:7:"history";s:1:"0";s:6:"maxday";s:1:"0";}";', ''),
('stat:rule', 's:24:"a:1:{s:3:"use";s:1:"0";}";', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_msg_history`
--

DROP TABLE IF EXISTS `ims_stat_msg_history`;
CREATE TABLE IF NOT EXISTS `ims_stat_msg_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '所属帐号ID',
  `rid` int(10) unsigned NOT NULL COMMENT '命中规则ID',
  `module` varchar(50) NOT NULL COMMENT '命中模块',
  `message` varchar(1000) NOT NULL COMMENT '用户发送的消息',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ims_userapi_cache`
--

DROP TABLE IF EXISTS `ims_userapi_cache`;
CREATE TABLE IF NOT EXISTS `ims_userapi_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL COMMENT 'apiurl缓存标识',
  `content` varchar(1000) NOT NULL COMMENT '回复内容',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ims_userapi_cache`
--

INSERT INTO `ims_userapi_cache` (`id`, `key`, `content`, `lastupdate`) VALUES
(1, '57bda0348be076540c952b5300f43c86', 'a:4:{s:7:"MsgType";s:5:"music";s:5:"Music";a:4:{s:5:"Title";s:5:"Title";s:11:"Description";s:11:"Description";s:8:"MusicUrl";s:8:"MusicUrl";s:10:"HQMusicUrl";s:10:"HQMusicUrl";}s:12:"FromUserName";s:15:"gh_cc1cc1bc092c";s:10:"ToUserName";s:27:"otM6Jjlerqt12mYSzUHDFkx_lmI";}', 1370849084),
(2, '1258e6a98405ba863536408020c4046d', 'a:4:{s:7:"MsgType";s:5:"music";s:5:"Music";a:4:{s:5:"Title";s:5:"Title";s:11:"Description";s:11:"Description";s:8:"MusicUrl";s:8:"MusicUrl";s:10:"HQMusicUrl";s:10:"HQMusicUrl";}s:12:"FromUserName";s:0:"";s:10:"ToUserName";s:1:"";}', 1370856622),
(3, '1ebab99463965c0892f38bef63781f5b', 'a:4:{s:7:"MsgType";s:5:"music";s:5:"Music";a:4:{s:5:"Title";s:5:"Title";s:11:"Description";s:11:"Description";s:8:"MusicUrl";s:8:"MusicUrl";s:10:"HQMusicUrl";s:10:"HQMusicUrl";}s:12:"FromUserName";s:6:"toUser";s:10:"ToUserName";s:8:"fromUser";}', 1370924601),
(4, '0e228f0a568d208f9f53cb69d8a4e285', 'a:4:{s:7:"MsgType";s:5:"music";s:5:"Music";a:4:{s:5:"Title";s:5:"Title";s:11:"Description";s:17:"I am the userapi!";s:8:"MusicUrl";s:8:"MusicUrl";s:10:"HQMusicUrl";s:10:"HQMusicUrl";}s:12:"FromUserName";s:6:"toUser";s:10:"ToUserName";s:8:"fromUser";}', 1371696440);

-- --------------------------------------------------------

--
-- 表的结构 `ims_userapi_reply`
--

DROP TABLE IF EXISTS `ims_userapi_reply`;
CREATE TABLE IF NOT EXISTS `ims_userapi_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `apiurl` varchar(300) NOT NULL DEFAULT '' COMMENT '接口地址',
  `default_text` varchar(100) NOT NULL DEFAULT '' COMMENT '默认回复文字',
  `default_apiurl` varchar(300) NOT NULL DEFAULT '' COMMENT '默认回复接口地址',
  `cachetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '返回数据的缓存时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `ims_userapi_reply`
--

INSERT INTO `ims_userapi_reply` (`id`, `rid`, `apiurl`, `default_text`, `default_apiurl`, `cachetime`) VALUES
(14, 7, 'http://localhost/test1.php', 'xxxx', '', 0),
(13, 4, 'http://localhost/test.php', 'tttttttttttttt', '', 10);

-- --------------------------------------------------------

--
-- 表的结构 `ims_wechats`
--

DROP TABLE IF EXISTS `ims_wechats`;
CREATE TABLE IF NOT EXISTS `ims_wechats` (
  `weid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` char(5) NOT NULL COMMENT '用户标识. 随机生成保持不重复',
  `uid` int(10) unsigned NOT NULL COMMENT '关联的用户',
  `token` varchar(32) NOT NULL COMMENT '随机生成密钥',
  `name` varchar(30) NOT NULL COMMENT '公众号名称',
  `fans` int(10) unsigned NOT NULL DEFAULT '0',
  `account` varchar(30) NOT NULL COMMENT '微信帐号',
  `original` varchar(50) NOT NULL,
  `signature` varchar(100) NOT NULL COMMENT '功能介绍',
  `country` varchar(10) NOT NULL,
  `province` varchar(3) NOT NULL,
  `city` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `welcome` varchar(1000) NOT NULL,
  `default` varchar(1000) NOT NULL,
  `default_period` tinyint(3) unsigned NOT NULL COMMENT '回复周期时间',
  `lastupdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`weid`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ims_wechats`
--

INSERT INTO `ims_wechats` (`weid`, `hash`, `uid`, `token`, `name`, `fans`, `account`, `original`, `signature`, `country`, `province`, `city`, `username`, `password`, `welcome`, `default`, `default_period`, `lastupdate`) VALUES
(1, '3f00e', 1, '7c14dfa66f7593f56be07127a6aa7f01', '默认公众号', 0, '默认公众号', '', '', '', '', '', '', '', '欢迎信息', '默认回复', 10, 0),
(2, '33c76', 1, '5cab7c1cd84952e08e1dc66a0fad9917', '测试公众号', 0, '', '', '', '', '', '', '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_wechats_modules`
--

DROP TABLE IF EXISTS `ims_wechats_modules`;
CREATE TABLE IF NOT EXISTS `ims_wechats_modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `mid` int(10) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `displayorder` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '优先级',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ims_wechats_modules`
--

INSERT INTO `ims_wechats_modules` (`id`, `weid`, `mid`, `enabled`, `displayorder`) VALUES
(1, 1, 1, 1, -1),
(2, 1, 2, 1, -1),
(3, 1, 4, 1, -1),
(4, 1, 6, 1, 1),
(5, 1, 7, 1, 127),
(6, 2, 1, 1, -1),
(7, 2, 2, 1, -1),
(8, 2, 4, 1, -1),
(9, 2, 7, 0, 127);

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxwall_members`
--

DROP TABLE IF EXISTS `ims_wxwall_members`;
CREATE TABLE IF NOT EXISTS `ims_wxwall_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一身份ID',
  `rid` int(10) unsigned NOT NULL COMMENT '用户当前所在的微信墙话题',
  `lastupdate` int(10) unsigned NOT NULL COMMENT '用户最后发表时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ims_wxwall_members`
--

INSERT INTO `ims_wxwall_members` (`id`, `from_user`, `rid`, `lastupdate`) VALUES
(1, 'fromUser', 8, 1371724124);

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxwall_message`
--

DROP TABLE IF EXISTS `ims_wxwall_message`;
CREATE TABLE IF NOT EXISTS `ims_wxwall_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `from_user` varchar(50) NOT NULL COMMENT '用户的唯一ID',
  `content` varchar(1000) NOT NULL DEFAULT '' COMMENT '用户发表的内容',
  `type` varchar(10) NOT NULL COMMENT '发表内容类型',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ims_wxwall_message`
--

INSERT INTO `ims_wxwall_message` (`id`, `rid`, `from_user`, `content`, `type`, `isshow`, `createtime`) VALUES
(1, 8, 'fromUser', 'a:3:{s:5:"title";s:12:"测试链接";s:11:"description";s:18:"测试链接描述";s:4:"link";N;}', 'link', 1, 1371650507),
(3, 8, 'fromUser', '进入dddddddddddd', 'text', 1, 1371650561),
(4, 8, 'fromUser', 'wxwall/8/efded7a3aa3cb5443c9ec7f0924932.jpg', 'image', 1, 1371724124);

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxwall_reply`
--

DROP TABLE IF EXISTS `ims_wxwall_reply`;
CREATE TABLE IF NOT EXISTS `ims_wxwall_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL COMMENT '规则ID',
  `enter_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '进入提示',
  `quit_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '退出提示',
  `send_tips` varchar(300) NOT NULL DEFAULT '' COMMENT '发表提示',
  `quit_command` varchar(10) NOT NULL DEFAULT '' COMMENT '退出指令',
  `timeout` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '超时时间',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `ims_wxwall_reply`
--

INSERT INTO `ims_wxwall_reply` (`id`, `rid`, `enter_tips`, `quit_tips`, `send_tips`, `quit_command`, `timeout`, `isshow`) VALUES
(1, 8, '进入提示1', '退出提示', '发表提示', '退出', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
