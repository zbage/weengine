<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once 'api/api.func.php';

define('SUCCESS', 0);
define('ERROR_UNKNOW', -1);
define('ERROR_INVALID_PARAMS', 1);
define('ERROR_USER_NOT_FOUND', 2);
define('ERROR_USER_BOUND', 3);
define('ERROR_INVALID_PASSWORD', 4);
define('ERROR_INVALID_VERIFY', 5);
define('ERROR_WECHAT_NOT_FOUND', 6);
define('SUCCESS_BIND_VERIFY', 11);

if(!isset($_G['cache']['plugin']['iweengine'])){
	loadcache('plugin');
}
$ops = array('bind', 'unbind', 'verify', 'manual', 'thread');
$op = in_array($_G['gp_op'], $ops) ? $_G['gp_op'] : exit('Access Denied');

/**
 * 实现论坛用户与微信用户绑定
 * 
 * @param user <用户名 | 用户UID>
 * @param wechat <微信用户ID>
 * @param password [密码]
 * 
 * @return array('status', 'message'); 0为成功，否则失败，并返回错误信息
 */
$expire = $_G['timestamp'] - 5*60;
DB::delete('plugin_iweengine_bind', "dateline < '$expire' AND isbind = 0");

if ($op == 'bind') {
	$user = $_G['gp_user'];
	$wechat = $_G['gp_wechat'];
	$password = $_G['gp_password'];

	if (empty($user) || empty($wechat)) {
		api_response(ERROR_INVALID_PARAMS, 'Invalid params');	
	}
	
	$userinfo = _userinfo($user);
	if (empty($userinfo)) {
		api_response(ERROR_USER_NOT_FOUND, 'User is not found');
	}
	
	$bind = DB::fetch_first("SELECT uid FROM ".DB::table('plugin_iweengine_bind')." WHERE uid = %s ", array($userinfo['uid']));
	if (!empty($bind)) {
		if ($bind['bind'] == 1) {
			api_response(ERROR_USER_BOUND, 'User was already bound');
		} elseif ($bind['bind'] == 0) {
			api_response(SUCCESS_BIND_VERIFY);
		}
	}
	//输入密码则验证用户名与密码
	//否则插入一条验证信息
	if (!empty($_G['gp_password'])) {
		loaducenter();
		$login = uc_user_login($userinfo['username'], $password);
		if ($login[0] > 0) {
			_bind($userinfo['uid'], $userinfo['username'], $wechat, 1);	
			api_response(SUCCESS);
		} else {
			api_response(ERROR_INVALID_PASSWORD, 'Invalid user password');
		}
	} else {
		_bind($userinfo['uid'], $userinfo['username']);
		api_response(SUCCESS_BIND_VERIFY);
	}
} elseif ($op == 'verify') {
	$user = $_G['gp_user'];
	$wechat = $_G['gp_wechat'];
	$verifycode = $_G['gp_verify'];
	
	if (empty($user) || empty($wechat) || empty($verifycode)) {
		api_response(ERROR_INVALID_PARAMS, 'Invalid params');	
	}
	
	$userinfo = _userinfo($user);
	if (empty($userinfo)) {
		api_response(ERROR_USER_NOT_FOUND, 'User is not found');
	}
	
	$bind = DB::fetch_first("SELECT uid, wechat FROM ".DB::table('plugin_iweengine_bind')." WHERE uid = %s", array($userinfo['uid']));
	if ($bind['wechat'] == $verifycode) {
		$update = array(
			'wechat' => $wechat,
			'dateline' => $_G['timestamp'],
			'isbind' => 1,
		);
		DB::update('plugin_iweengine_bind', $update, array('uid' => $userinfo['uid']));
		api_response(SUCCESS);
	} else {
		api_response(ERROR_INVALID_VERIFY);
	}
	
} elseif ($op == 'unbind') {
	$wechat = $_G['gp_wechat'];

	$bind = DB::fetch_first("SELECT uid FROM ".DB::table('plugin_iweengine_bind')." WHERE wechat = %s", array($wechat));
	if (empty($bind)) {
		api_response(ERROR_WECHAT_NOT_FOUND, 'Wechat is not found');
	}		
	
	DB::delete('plugin_iweengine_bind', array('uid' => $bind['uid']));
	api_response(SUCCESS);
}
function _bind($uid, $username, $wechat = '', $isbind = 0) {
	global $_G;
	$insert = array(
		'uid' => $uid,
		'username' => $username,
		'wechat' => $wechat,
		'isbind' => $isbind,
		'dateline' => $_G['timestamp'],
	);
	if (empty($isbind)) {
		$insert['wechat'] = random(6, true);	
	}
	if (DB::insert('plugin_iweengine_bind', $insert)) {
		return true;
	} else {
		return false;
	}
}

function _userinfo($user) {
	$userinfo = array();
	$userinfo = DB::fetch_first("SELECT uid, username FROM ".DB::table('common_member')." WHERE username = %s LIMIT 1", array($user));
	if (empty($user) && is_numeric($user)) {
		$userinfo = DB::fetch_first("SELECT uid, username FROM ".DB::table('common_member')." WHERE uid = %s LIMIT 1", array($user));
	}	

	return $userinfo;
}