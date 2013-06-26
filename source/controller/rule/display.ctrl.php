<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

include model('rule');
$pindex = max(1, intval($_GPC['page']));
$psize = 20;
$module = empty($_GPC['module']) ? 'basic' : $_GPC['module'];
$list = rule_search("weid = '{$_W['weid']}' AND module = '$module'", $pindex, $psize, $total);
if (!empty($list)) {
	foreach($list as &$item) {
	    $condition = "`rid`={$item['id']}";
	    $item['keywords'] = rule_keywords_search($condition);
	}
}
$types = array('', '等价', '包含', '正则表达式匹配');
$pager = pagination($total, $pindex, $psize);

$wechat = $_W['setting']['wechats'][$_W['weid']];
$temp = iunserializer($wechat['default']);
if (is_array($temp)) {
	$wechat['default'] = $temp;
	$wechat['defaultrid'] = $temp['id'];
}
$temp = iunserializer($wechat['welcome']);
if (is_array($temp)) {
	$wechat['welcome'] = $temp;
	$wechat['welcomerid'] = $temp['id'];
}
$mymodule = pdo_fetchall("SELECT * FROM ".tablename('modules')." AS a LEFT JOIN ".tablename('wechats_modules')." AS b ON a.mid = b.mid WHERE b.enabled = '1' AND b.weid = '{$_W['weid']}'");
template('rule/display');
