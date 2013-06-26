<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$current['register'] = ' class="current"';
if(checksubmit()) {
    require_once IA_ROOT . '/source/model/member.mod.php';
    hooks('member:register:before');
    $member = array();
    $member['username'] = trim($_GPC['username']);
    if(!preg_match(REGULAR_USERNAME, $member['username'])) {
        message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
    }
    if(member_check(array('username' => $member['username']))) {
        message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
    }
    $member['password'] = $_GPC['password'];
    if(istrlen($member['password']) < 8) {
        message('必须输入密码，且密码长度不得低于8位。');
    }
    $member['email'] = trim($_GPC['email']);
    if(!preg_match(REGULAR_EMAIL, $member['email'])) {
        message('必须输入正确的邮箱。');
    }
    if(member_check(array('email' => $member['email']))) {
        message('非常抱歉，此邮箱已经被注册，请更换注册邮箱！');
    }
    $uid = member_register($member);
    if($uid > 0) {
        unset($member['password']);
        $member['uid'] = $uid;
        hooks('member:register:success', $member);
        define('REGISTER_SUCCESS', true);
        _login();
    }
    message('注册用户失败，请稍候重试或联系网站管理员解决！');
}
template('member/register');
