<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$id = intval($_GPC['id']);
if (checksubmit('submit')) {
	if (empty($_GPC['name'])) {
		message('抱歉，请填写公众号名称！');
	}
	$data = array(
		'uid' => $_W['uid'],
		'name' => $_GPC['name'],
		'account' => $_GPC['account'],
		'original' => $_GPC['original'],
	    'token' => $_GPC['wetoken'],
		'signature' => '',
		'country' => '',
		'province' => '',
		'city' => '',
		'username' => '',
		'password' => '',
		'welcome' => '',
		'default' => '',
		'lastupdate' => '0',
		'default_period' => '0',
	);
	if (!empty($_GPC['islogin']) && !empty($_GPC['username']) && !empty($_GPC['password']) && $_GPC['password'] != '******') {
		$loginstatus = account_weixin_login($_GPC['username'], md5($_GPC['password']));
		$data['username'] = $_GPC['username'];
		$data['password'] = md5($_GPC['password']);
		$data['lastupdate'] = 0;
	} else {

	}
	if (!empty($id)) {
		unset($data['hash']);
		if ($_GPC['password'] == '******') {
		    unset($data['username']);
		    unset($data['password']);
		    unset($data['lastupdate']);
		}
		if (pdo_update('wechats', $data, array('weid' => $id))) {
			cache_delete('setting:wechats');
			message('更新公众号设置成功！', create_url('account/post', array('id' => $id)));
		}
	} else {
		$data['hash'] = salt(5);
		$data['token'] = salt(32);
		if (pdo_insert('wechats', $data)) {
			$weid = pdo_insertid();
			//添加模块信息
			$modules = array(1, 2, 4);
			foreach ($modules as $mid) {
				pdo_insert('wechats_modules', array(
					'weid' => $weid,
					'mid' => $mid,
					'enabled' => '1',
				));
			}
			cache_delete('setting:wechats');
			message('添加公众号成功！', create_url('account/post'));
		}
	}
	message('公众号管理操作失败！', create_url('account/display'));

} else {
	if (!empty($id)) {
		$wechat = pdo_fetch("SELECT * FROM ".tablename('wechats')." WHERE weid = '$id'");
	}
	if(!empty($wechat['username']) && (empty($wechat['lastupdate']) || TIMESTAMP - $wechat['lastupdate'] > 86400 * 7)) {
		$loginstatus = account_weixin_login($wechat['username'], $wechat['password']);
		$basicinfo = account_weixin_basic();
		if (!empty($basicinfo['name'])) {
			$update = array(
				'name' => $basicinfo['name'],
				'account' => $basicinfo['username'],
				'original' => $basicinfo['original'],
				'signature' => $basicinfo['signature'],
				'country' => $basicinfo['country'],
				'province' => $basicinfo['province'],
				'city' => $basicinfo['city'],
				'lastupdate' => TIMESTAMP,
			);
			pdo_update('wechats', $update, array('weid' => $id));
			cache_delete('setting:wechats');
			$wechat['name'] = $basicinfo['name'];
			$wechat['account'] = $basicinfo['username'];
			$wechat['original'] = $basicinfo['original'];
			$wechat['signature'] = $basicinfo['signature'];
			$wechat['country'] = $basicinfo['country'];
			$wechat['province'] = $basicinfo['province'];
			$wechat['city'] = $basicinfo['city'];
		}
	} else {
		$wechat['username'] = '';
		
	}
	template('account/post');
}