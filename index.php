<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
$actions = array('attachment', 'help', 'announcement', 'module');
$action = $_GPC['act'];
$action = in_array($action, $actions) ? $action : '';
$controller = 'home';
if (empty($action)) {
	header('Location: '.create_url('account/display'));
} else {
	require router($controller, $action);
}

