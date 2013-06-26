<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
include model('rule');

if (checksubmit('submit')) {
	$rid = intval($_GPC['id']);
	if (empty($_GPC['name'])) {
		message('抱歉，规则名称为必填项，请选回修改！');	
	}
	$cid = $_GPC['cate_2'] ? $_GPC['cate_2'] : $_GPC['cate_1'];
	$rule = array(
		'weid' => $_W['weid'],
		'cid' => $cid,
		'name' => $_GPC['name'],
	    'module' => $_GPC['module'],
	);
	if (!empty($rid)) {
		$isexists = pdo_fetch("SELECT id, module FROM ".tablename('rule')." WHERE id = :id", array(':id' => $rid));
		if (empty($isexists)) {
			message('抱歉，要修改的规则不存在或是已经被删除！');
		}	
		$rule['module'] = $isexists['module'];
		$result = pdo_update('rule', $rule, array('id' => $rid));
	} else {
		$result = pdo_insert('rule', $rule);
		$rid = pdo_insertid();
	}
	if (!empty($rid)) {
		//更新，添加，删除关键字
		if (!empty($_GPC['keyword'])) {
			foreach ($_GPC['keyword'] as $id => $row) {
				$data = array(
					'content' => $row,
					'type' => intval($_GPC['type'][$id]), 
					'rid' => $rid, 
					'id' => $id,
					'weid' => $_W['weid'],
					'module' => $rule['module'],
				);
				rule_insert_keyword($data);
			}
		}
		if (!empty($_GPC['keyword-new'])) {
			foreach ($_GPC['keyword-new'] as $id => $row) {
				$data = array(
					'content' => $row,
					'type' => intval($_GPC['type-new'][$id]),
					'rid' => $rid,
					'weid' => $_W['weid'],
					'module' => $_GPC['module'],
				);
				rule_insert_keyword($data);
			}
		}
		if (!empty($_GPC['delete'])) {
			pdo_delete('rule_keyword', "id IN ('".implode("','", $_GPC['delete'])."')");
		}
		//调用模块处理
		$modulename = $rule['module'];
		$module = module($modulename);
		if (is_error($module)) {
			message('抱歉，模块不存在请重新其它模块！');	
		}
		
		if ($module->fieldsFormValidate()) {
			$module->fieldsFormSubmit($rid);
			message('规则操作成功！', 'rule.php?act=post&id='.$rid);
		} else {
			message('规则操作失败，请重试或联系管理员！');
		}	
	}
} else {
	$id = intval($_GPC['id']);
	$types = array('', '等价', '包含', '正则表达式匹配');
	$typeslabel = "'".implode("','", $types)."'";
	if (!empty($id)) {
		$rule = rule_single($id);
		if (empty($rule['rule'])) {
		    message('抱歉，您操作的规则不在存或是已经被删除！', create_url('rule/display'), 'error');
		}
		$module = $rule['rule']['module'];
		$module = module($module);
		$rule['reply'] = $module;
	}
	$category = cache_load('category:'.$_W['weid']);
	template('rule/post');
}
