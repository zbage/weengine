--安装或更新时需要注册的sql写在这里--
CREATE TABLE IF NOT EXISTS `pw_app_iweengine_bind` (
  `uid` int(10) unsigned NOT NULL,
  `wechat` varchar(50) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `vcode` char(6) NOT NULL,
  `vtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
