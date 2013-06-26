<?php
/**
 * 用户管理
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
require './source/bootstrap.inc.php';

$actions = array();
$action = $_GET['act'];
if($_W['uid']) {
    $actions = array('logout', 'profile', 'setting');
    $action = in_array($action, $actions) ? $action : 'success';
} else {
    $actions = array('login');
    $action = in_array($action, $actions) ? $action : 'login';
}

$controller = 'member';
$nav[$action] = ' class="current"';
require router($controller, $action);

function _login($forward = '') {
    global $_GPC;
    require_once IA_ROOT . '/source/model/member.mod.php';
    hooks('member:login:before');
    $member = array();
    $username = trim($_GPC['username']);
    if(empty($username)) {
        message('请输入要登录的用户名或者邮箱');
    }
    if(strpos($username, '@') > -1) {
        if(!preg_match(REGULAR_EMAIL, $username)) {
            message('输入的邮箱不正确');
        }
        $member['email'] = $username;
    } else {
        if(!preg_match(REGULAR_USERNAME, $username)) {
            message('输入的用户名不正确！');
        }
        $member['username'] = $username;
    }
    $member['password'] = $_GPC['password'];
    if(empty($member['password'])) {
        message('请输入密码');
    }
    $record = member_single($member, true);
    if(!empty($record)) {
        if($record['status'] == -1) {
            message('您的账号已经被系统禁止，请联系网站管理员解决！');
        }
        $cookie = array();
        $cookie['uid'] = $record['uid'];
        $cookie['lastvisit'] = $record['lastvisit'];
        $cookie['lastip'] = $record['lastip'];
        $cookie['hash'] = md5($record['password'] . $record['salt']);
        $session = base64_encode(json_encode($cookie));
        isetcookie('session', $session);
        $status = array();
        $status['uid'] = $record['uid'];
        $status['lastvisit'] = TIMESTAMP;
        $status['lastip'] = CLIENT_IP;
        member_touch($status);
        hooks('member:login:success');
        if(empty($forward)) {
            $forward = $_GPC['forward'];
        }
        if(empty($forward)) {
            $forward = './index.php?refersh';
        }
        if(defined('REGISTER_SUCCESS')) { 
            message('成功注册，现在将以新注册的身份登录！', $forward);
        } else {
            message("欢迎回来，{$record['username']}。", $forward);
        }
    } else {
        message('登录失败，请检查您输入的用户名和密码！');
    }
}
