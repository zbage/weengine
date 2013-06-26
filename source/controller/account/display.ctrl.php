<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
include model('rule');

$list = account_search($_W['uid'], false);
template('account/display');