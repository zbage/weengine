<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

$id = intval($_GPC['id']);
$row = pdo_fetch("SELECT weid, name FROM ".tablename('wechats')." WHERE weid = '$id'");
if (empty($row)) {
	message('抱歉，该公从号不存在或是已经被删除！', create_url('account/display'));
}
cache_write('weid', $row['weid']);
isetcookie('weid', $row['weid']);
message('', referer(), 'success');
