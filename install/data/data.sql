INSERT INTO `ims_modules` (`mid`, `name`, `title`, `ability`, `description`, `rulefields`, `settings`, `issystem`) VALUES
(1, 'basic', '基本文字回复', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 1, '', 1),
(2, 'news', '基本混合图文回复', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 1, '', 1),
(3, 'simsimi', '小黄鸡自动回复', '最具智能化的自动陪聊系统', '一款趣味游戏，游戏中的机器人是一个能够和你聊天解闷的可爱机器人，为您的生活提供服务、甚至你还可以逗弄她，并且能实现自然语言的交互。', 0, '', 0),
(4, 'music', '基本语音回复', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 1, '', 1),
(5, 'wxapi', '乐享接口回复', '乐享微信营销管理平台与微擎管理系统的兼容服务', '微擎将试水与第三方管理平台进行战略融合，更好的服务于广大的微信公众平台用户。微擎内置模块的优先级高于其他平台接口，微擎无法处理的对话内容将交于第三方平台处理。', 0, '', 0);
INSERT INTO `ims_wechats` (`weid`, `hash`, `uid`, `token`, `name`, `fans`, `account`, `original`, `welcome`, `default`, `default_period`, `lastupdate`) VALUES(1, '3f00e', 1, '7c14dfa66f7593f56be07127a6aa7f01', '默认公众号', 0, '默认公众号', '', '欢迎信息', '默认回复', 10, 0);
INSERT INTO `ims_rule` (`id`, `weid`, `name`, `module`) VALUES(1, 1, '默认文字回复', 'basic');
INSERT INTO `ims_rule` (`id`, `weid`, `name`, `module`) VALUES(2, 1, '默认图文回复', 'news');
INSERT INTO `ims_rule_keyword` (`id`, `rid`, `content`, `type`) VALUES(1, 1, '文字', 2);
INSERT INTO `ims_rule_keyword` (`id`, `rid`, `content`, `type`) VALUES(2, 2, '图文', 2);
INSERT INTO `ims_basic_reply` (`id`, `rid`, `content`) VALUES(1, 1, '这里是默认文字回复');
INSERT INTO `ims_news_reply` (`id`, `rid`, `parentid`, `title`, `description`, `thumb`, `content`, `url`) VALUES(1, 2, 0, '这里是默认图文回复', '这里是默认图文描述', 'images/2013/01/d090d8e61995e971bb1f8c0772377d.png', '这里是默认图文原文这里是默认图文原文这里是默认图文原文', '');
INSERT INTO `ims_news_reply` (`id`, `rid`, `parentid`, `title`, `description`, `thumb`, `content`, `url`) VALUES(2, 2, 1, '这里是默认图文回复内容', '', 'images/2013/01/112487e19d03eaecc5a9ac87537595.jpg', '这里是默认图文回复原文这里是默认图文回复原文<br />', '');
INSERT INTO `ims_wechats_modules` (`weid`, `mid`, `enabled`, `displayorder`) VALUES
(1, 1, 1, -1),
(1, 2, 1, -1),
(1, 4, 1, -1);
