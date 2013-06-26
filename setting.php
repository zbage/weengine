<?php 
/**
 * 设置中心
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
checklogin();
checkaccount();

$actions = array('profile', 'module', 'common', 'category', 'updatecache');
$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'module';
$nav['setting'.$action] = ' class="current"';
$controller = 'setting';
require router($controller, $action);

