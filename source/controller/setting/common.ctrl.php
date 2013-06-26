<?php 
/**
 * BAE相关设置选项
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
if (checksubmit('bae_delete_update') || checksubmit('bae_delete_install')) {
	if (!empty($_GPC['bae_delete_update'])) {
		unlink(IA_ROOT . '/data/update.lock');
	} elseif (!empty($_GPC['bae_delete_install'])) {
		unlink(IA_ROOT . '/data/install.lock');
	}
	message('操作成功！', create_url('setting/bae'), 'success');
} elseif (checksubmit('submit')) {
	setting_save(array('msg_history' => $_GPC['msg_history'], 'msg_maxday' => $_GPC['msg_maxday'], 'rule_use' => $_GPC['rule_use']), 'stat');
	message('更新设置成功！', create_url('setting/common'));
} else {
	$nav['common'] = ' class="current"';
	template('setting/common');
}