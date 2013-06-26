<?php
/**
 * 系统初始化文件
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
define('IN_IA', true); 
define('DEVELOPMENT', false);

if(phpversion() < '5.3.0') {
    set_magic_quotes_runtime(0);
}
define('IA_ROOT', str_replace("\\",'/', dirname(dirname(__FILE__))));
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('TIMESTAMP', time());
if(DEVELOPMENT) {
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(E_ERROR);
}

$_W = array();
$_W['timestamp'] = TIMESTAMP;
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
if($_SERVER['SERVER_PORT'] != '80') {
    $_W['siteroot'] .= ":{$_SERVER['SERVER_PORT']}/";
} else {
    $_W['siteroot'] .= '/';
}
$_W['isajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';
if(!MAGIC_QUOTES_GPC) {
	$_GET = istripslashes($_GET);
	$_POST = istripslashes($_POST);
    $_COOKIE = istripslashes($_COOKIE);
}
$_GPC = array();
$cplen = 'weengine_';
foreach($_COOKIE as $key => $value) {
    if(substr($key, 0, $cplen) == $_W['config']['cookie']['pre']) {
        $_GPC[substr($key, $cplen)] = $value;
    }
}
unset($cplen);
$_GPC = array_merge($_GET, $_POST, $_GPC);

function response($status = 0, $message = '') {
	exit(json_encode(array('status' => $status, 'message' => $message)));
}