<?php
defined('WEKIT_VERSION') or exit(403);
/**
 * App_Iweengine_IweengineDao - dao
 *
 * @author  <>
 * @copyright 
 * @license 
 */
class App_IWeEngine_Bind extends PwBaseDao {
	
	/**
	 * table name
	 */
	protected $_table = 'app_iweengine_bind';
	/**
	 * primary key
	 */
	protected $_pk = 'uid';
	/**
	 * table fields
	 */
	protected $_dataStruct = array('uid', 'wechat', 'dateline', 'isbind', 'vcode', 'vtime');
	
	public function add($fields) {
		return $this->_add($fields, true);
	}
	
	public function update($id, $fields) {
		return $this->_update($id, $fields);
	}
	
	public function delete($id) {
		return $this->_delete($id);
	}
	
	public function get($id) {
		return $this->_get($id);
	}
}
