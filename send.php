<?php
/**
 * 群发消息
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
set_time_limit(0);
$actions = array();
if(!empty($_W['uid'])) {
	$actions = array('original', 'weengine');
	$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'weengine';
} else {
	header('Location: '.create_url('member/login', array('referer' => $_W['script_name'])));
}
if (empty($_W['weid']) || empty($_W['account'])) {
	message('请您从“管理公众号”或是从顶部“切换公众号”选择要操作的公众号！', '', 'error');
}
if (empty($_W['account']['username']) || empty($_W['account']['password'])) {
	message('抱歉，使用此功能必须填您的“微信公众平台”帐号和密码！', create_url('account/display'), 'error');
}
$controller = 'send';
$nav[$action] = ' class="current"';
require router($controller, $action);