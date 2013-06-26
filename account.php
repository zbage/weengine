<?php
/**
 * 公众号管理
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */

require './source/bootstrap.inc.php';
$actions = array();
if(!empty($_W['uid'])) {
	$actions = array('display', 'post', 'switch', 'delete', 'sync');
	$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'display';
} else {
	header('Location: '.create_url('member/login', array('referer' => $_W['script_name'])));
}

$controller = 'account';
$nav[$action] = ' class="current"';
require router($controller, $action);