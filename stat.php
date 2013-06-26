<?php
/**
 * 统计分析
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
checklogin();
checkaccount();

$actions = array('history');
$action = in_array($_GPC['act'], $actions) ? $_GPC['act'] : 'history';

$nav[$action] = ' class="current"';
$controller = 'stat';
require router($controller, $action);

