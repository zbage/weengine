<?php 
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

if (checksubmit('submit')) {
    $settings = array(
        'profile:wechat' => $_GPC['wx_uid'],
    	'profile:token' => $_GPC['wx_token'],
    );
    if (setting_save($settings)) {
        message('系统设置操作成功。 如果你设置了新的 Token 值，请立即登录微信公众平台更改您的接口设置，已便正常调用接口！', create_url('member/setting'));
    } else {
        message('你没有更改任何内容！', create_url('member/setting'));
    }
} else {
    
    template('member/setting');
}
?>
