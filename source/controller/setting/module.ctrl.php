<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

$nav[$do] = ' class="current"';
if ($do == 'display') {
	$sql = "SELECT * FROM " . tablename('modules') . ' ORDER BY `mid` DESC';
    $modules = pdo_fetchall($sql, array(), 'mid');
    $mymodules = pdo_fetchall("SELECT mid, enabled, displayorder FROM ".tablename('wechats_modules')." WHERE weid = '{$_W['weid']}' ORDER BY enabled DESC, displayorder ASC, mid ASC", array(), 'mid');
    //拼接模块
    foreach ($mymodules as $mid => $row) {
    	if (!empty($modules[$mid])) {
    		$mymodules[$mid] = array_merge($mymodules[$mid], $modules[$mid]);
    		unset($modules[$mid]);
    	}
    }
    $mymodules = array_merge($mymodules, $modules);
    template('setting/module');	
} elseif ($do == 'enable') {
	$mid = intval($_GPC['mid']);
	$module = pdo_fetch("SELECT mid, issystem FROM ".tablename('modules')." WHERE mid = :mid", array(':mid' => $mid));
	if (empty($module)) {
		message('抱歉，模块不存在或是已经被删除！');
	}
	$exist = pdo_fetchcolumn("SELECT id FROM ".tablename('wechats_modules')." WHERE mid = :mid AND weid = :weid", array(':mid' => $mid, ':weid' => $_W['weid']));
	if (empty($exist)) {
		pdo_insert('wechats_modules', array(
			'mid' => $mid,
			'weid' => $_W['weid'],
			'enabled' => empty($_GPC['enabled']) ? 0 : 1,
			'displayorder' => $module['issystem'] ? '-1' : 127,
		));	
	} else {
		pdo_update('wechats_modules', array(
			'mid' => $mid,
			'weid' => $_W['weid'],
			'enabled' => empty($_GPC['enabled']) ? 0 : 1,
			'displayorder' => $module['issystem'] ? '-1' : 127,
		), array('id' => $exist));
	}
	cache_delete('setting:modules:'.$_W['weid']);
	message('模块操作成功！', '', 'success');
} elseif ($do == 'form') {
	include model('rule');
	if (empty($_GPC['name'])) {
		message('抱歉，模块不存在或是已经被删除！');
	}
	$modulename = !empty($_GPC['name']) ? $_GPC['name'] : 'basic';
	$module = module($modulename);
	if (is_error($module)) {
		exit($module['errormsg']);
	}
	$rid = intval($_GPC['id']);
	exit($module->fieldsFormDisplay($rid));
} elseif ($do == 'displayorder') {
	$mid = intval($_GPC['mid']);
	$displayorder = intval($_GPC['displayorder']);
	$module = pdo_fetch("SELECT mid, issystem FROM ".tablename('modules')." WHERE mid = :mid", array(':mid' => $mid));
	if (empty($module)) {
		message('抱歉，模块不存在或是已经被删除！');
	}
	if ($module['issystem']) {
		message('抱歉，系统模块无法设置优先级！');
	}
	pdo_query("UPDATE ".tablename('wechats_modules')." SET displayorder = 127 WHERE displayorder = '$displayorder' AND weid = '{$_W['weid']}'");
	pdo_update('wechats_modules', array('displayorder' => $displayorder == 0 ? 127 : $displayorder), array('mid' => $mid ,'weid' => $_W['weid']));
	cache_delete('setting:modules:'.$_W['weid']);
	message('操作成功！', referer());
} elseif ($do == 'setting') {
$mid = intval($_GPC['mid']);
	$mid = intval($_GPC['mid']);
	$module = pdo_fetch("SELECT name, settings, title FROM ".tablename('modules')." WHERE mid = :mid", array(':mid' => $mid));
	if (empty($module)) {
		message('抱歉，模块不存在或是已经被删除！');
	}
	if (checksubmit('submit')) {
		$sysgpc = array('act', 'do', 'mid', 'submit', 'token', 'session');
		$mid = intval($_GPC['mid']);
		$data = array();
		if (!empty($_GPC)) {
			foreach ($_GPC as $fields => $value) {
				if (!in_array($fields, $sysgpc)) {
					$data[$fields] = $value;
				}
			}
		}
		pdo_update('modules', array('settings' => iserializer($data)), array('mid' => $mid));
		message('模块设置成功！', referer(), 'success');
	}
	$module['settings'] = iunserializer($module['settings']);
	$moduleobj = module($module['name']);
	template('setting/module_setting');
}