<?php 
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
$do = !empty($_GPC['do']) && in_array($_GPC['do'], array('display', 'send')) ? $_GPC['do'] : 'display';
if ($do == 'display') {
    template('send/weengine_display');
} elseif ($do == 'send') {
    $pindex = max(0, intval($_GPC['pindex']));
    $psize = intval($_GPC['pagesize']);
    $psize = empty($psize) ? 10 : $psize;
    //^_^请保留我们的后缀^_^
    $message = $_GPC['message'] . '「微擎 WE7.CC」';
    account_weixin_login();
    $userlist = account_weixin_userlist($pindex, $psize, $total);
    if (!empty($userlist)) {
        foreach ($userlist as $uid) {
            account_weixin_send($uid, $message);
        }
    }
    $pindex += 1;
    if ($pindex < $total) {
        message('已完成发送'.ceil($pindex / $total * 100).'%！', create_url('send/weengine/send', array('pindex' => $pindex, 'message' => $_GPC['message'])));
    } else {
        message('群发成功！', create_url('send/weengine'), 'success');
    }
}