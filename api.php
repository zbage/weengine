<?php
/**
 * 微信公众平台接口
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';
require model('rule');

$sql = "SELECT `weid`,`hash`,`token`,`default_period` FROM " . tablename('wechats') . " WHERE `hash`=:hash LIMIT 1";
$wechat = pdo_fetch($sql, array(':hash' => $_GPC['hash']));
if(empty($wechat)) {
    exit('Access Denied');
}
$_W['wechat'] = $wechat;
$_W['weid'] = $wechat['weid'];
$engine = new WeEngine();
$engine->start();