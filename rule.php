<?php
/**
 * 规则管理
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';

$actions = array();
if(!empty($_W['uid'])) {
	$actions = array('display', 'post', 'system', 'delete');
	$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'display';
} else {
	header('Location: '.create_url('member/login', array('referer' => $_W['script_name'])));
}
if (empty($_W['weid']) || !pdo_fetchcolumn("SELECT weid FROM ".tablename('wechats')." WHERE weid = '{$_W['weid']}'")) {
	message('请您从“管理公众号”或是从顶部“切换公众号”选择要操作的公众号！', '', 'error');
}
$controller = 'rule';
$nav[$action] = ' class="current"';
require router($controller, $action);
