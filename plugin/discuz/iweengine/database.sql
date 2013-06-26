DROP TABLE IF EXISTS `pre_plugin_iweengine_bind`;
CREATE TABLE IF NOT EXISTS `pre_plugin_iweengine_bind` (
  `uid` int(10) unsigned NOT NULL,
  `wechat` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `isbind` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
