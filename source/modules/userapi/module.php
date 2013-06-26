<?php 
/**
 * 调用第三方数据接口模块
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class UserapiModule extends WeModule {
	public $name = 'userapi';
	public $title = '第三方接口回复';
	public $ability = '';
	public $tablename = 'userapi_reply';
	
	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		if (!empty($rid)) {
			$row = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		}
		include $this->template('userapi:form');
	}
	
	public function fieldsFormValidate($rid = 0) {
		return true;
	}
	
	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);
		//处理添加
		if (!empty($_GPC['apiurl'])) {
			$insert = array(
				'rid' => $rid,
				'apiurl' => $_GPC['apiurl'],
				'default_text' => $_GPC['default-text'],
				'default_apiurl' => $_GPC['default-apiurl'],
				'cachetime' => $_GPC['cachetime'],
			);
			if (empty($id)) {
				pdo_insert($this->tablename, $insert);
			} else {
				pdo_update($this->tablename, $insert, array('id' => $id));
			}
		}
		return true;
	}
	
	public function ruleDeleted($rid = 0) {
		
	}
	
	public function doFormDisplay() {
		
	}
	
	public function doDelete() {
		
	}
	
	public function settingsFormDisplay($settings = array()) {
		include $this->template('userapi:setting');
	}
}