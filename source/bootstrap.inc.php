<?php
/**
 * 系统初始化文件
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
session_start();
define('IN_IA', true); 
define('DEVELOPMENT', true);

if(phpversion() < '5.3.0') {
    set_magic_quotes_runtime(0);
}
define('IA_ROOT', str_replace("\\",'/', dirname(dirname(__FILE__))));
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('TIMESTAMP', time());
if(DEVELOPMENT) {
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}
require IA_ROOT . '/source/version.inc.php';
$_W = array();
//兼容BAE平台
if (!empty($_SERVER['HTTP_BAE_ENV_APPID'])) {
	$_W['platform'] = 'bae';
	$_W['bae'] = TRUE;
}
if (!empty($_W['platform'])) {
	$configfile = IA_ROOT . "/data/config.{$_W['platform']}.php";
} else {
	$configfile = IA_ROOT . "/data/config.php";
}

if(!is_file($configfile) && file_exists(IA_ROOT . '/install/index.php')){
	header('Content-Type: text/html; charset=utf-8');
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo "·如果你还没安装本程序，请运行<a href='install/index.php'> install/index.php 进入安装&gt;&gt; </a><br/><br/>";
	echo "&nbsp;&nbsp;<a href='http://www.we7.cc' style='font-size:12px' target='_blank'>Power by WE7 ".IMS_VERSION." &nbsp;微擎微信公众平台自助开源引擎</a>";
	exit();
}

$_W['timestamp'] = TIMESTAMP;
$_W['template']['current'] = 'default';
$_W['template']['source'] = IA_ROOT . '/themes';
$_W['template']['compile'] = IA_ROOT . '/data/tpl';

require $configfile;
require IA_ROOT . '/source/regular.inc.php';
require IA_ROOT . '/source/function/global.func.php';
require IA_ROOT . '/source/function/compat.func.php';
require IA_ROOT . '/source/function/file.func.php';
require IA_ROOT . '/source/function/template.func.php';
require IA_ROOT . '/source/function/pdo.func.php';
require IA_ROOT . '/source/function/communication.func.php';
require IA_ROOT . '/source/modules/engine.php';

$_W['token'] = token();
$pdo = $_W['pdo'] = null;

if(empty($config)) {
	exit('config file not found!');
}
$_W['config'] = $config;
$_W['charset'] = $_W['config']['setting']['charset'];
unset($config);

require IA_ROOT . '/source/function/cache.func.php';
require IA_ROOT . '/source/model/setting.mod.php';
require IA_ROOT . '/source/model/member.mod.php';
require IA_ROOT . '/source/model/account.mod.php';

if(!in_array($_W['config']['setting']['cache'], array('mysql', 'file'))) {
    $_W['config']['setting']['cache'] = 'mysql';
}
setting_load();
if(!empty($_W['setting']['template']['current'])) {
    $_W['template']['current'] = $_W['setting']['template']['current'];
}
define('CLIENT_IP', getip());
$_W['clientip'] = CLIENT_IP;
if(function_exists('date_default_timezone_set')){
    date_default_timezone_set($_W['config']['setting']['timezone']);
}
if(!empty($_W['config']['memory_limit']) && function_exists('ini_get') && function_exists('ini_set')) {
    if(@ini_get('memory_limit') != $_W['config']['memory_limit']) {
		@ini_set('memory_limit', $_W['config']['memory_limit']);
	}
}
$_W['script_name'] = basename($_SERVER['SCRIPT_FILENAME']);
if(basename($_SERVER['SCRIPT_NAME']) === $_W['script_name']) {
    $_W['script_name'] = $_SERVER['SCRIPT_NAME'];
} else if(basename($_SERVER['PHP_SELF']) === $_W['script_name']) {
    $_W['script_name'] = $_SERVER['PHP_SELF'];
} else if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $_W['script_name']) {
    $_W['script_name'] = $_SERVER['ORIG_SCRIPT_NAME'];
} else if(($pos = strpos($_SERVER['PHP_SELF'],'/' . $scriptName)) !== false) {
    $_W['script_name'] = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $_W['script_name'];
} else if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
    $_W['script_name'] = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
} else {
    $_W['script_name'] = 'unknown';
}
$_W['script_name'] = htmlspecialchars($_W['script_name']);
$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$_W['siteroot'] = htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$sitepath);
if($_SERVER['SERVER_PORT'] != '80' && empty($_W['platform'])) {
    $_W['siteroot'] .= ":{$_SERVER['SERVER_PORT']}/";
} else {
    $_W['siteroot'] .= '/';
}
$_W['attachurl'] = empty($_W['config']['upload']['attachurl']) ? $_W['siteroot'] . $_W['config']['upload']['attachdir'] : $_W['config']['upload']['attachurl'];
$_W['isajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';
if(MAGIC_QUOTES_GPC) {
	$_GET = istripslashes($_GET);
	$_POST = istripslashes($_POST);
    $_COOKIE = istripslashes($_COOKIE);
}
$_GPC = array();
$cplen = strlen($_W['config']['cookie']['pre']);
foreach($_COOKIE as $key => $value) {
    if(substr($key, 0, $cplen) == $_W['config']['cookie']['pre']) {
        $_GPC[substr($key, $cplen)] = $value;
    }
}
unset($cplen);
$_GPC = array_merge($_GET, $_POST, $_GPC);
if(!empty($_GPC['session'])) {
    $session = json_decode(base64_decode($_GPC['session']), true);
    if(is_array($session)) {
        $member = member_single(array('uid'=>$session['uid']), true);
        if(is_array($member) && $session['hash'] == md5($member['password'] . $member['salt'])) {
            $_W['uid'] = $member['uid'];
            $_W['username'] = $member['username'];
            $member['currentvisit'] = $member['lastvisit'];
            $member['currentip'] = $member['lastip'];
            $member['lastvisit'] = $session['lastvisit'];
            $member['lastip'] = $session['lastip'];
            $_W['member'] = $member;
        }
        unset($member);
    }
    unset($session);
    //获取用户全部公众号
    account_search($_W['uid']);
}
setting_modules();
cache_load('weid');
$_W['weid'] = $_W['cache']['weid'];
empty($_W['weid']) && $_W['weid'] = $_GPC['weid'];
$_W['account'] = $_W['setting']['wechats'][$_W['weid']];
unset($_GPC['weid']);
if (!empty($_W['weid'])) {
    member_modules();
}
header('Content-Type: text/html; charset='.$_W['charset']);