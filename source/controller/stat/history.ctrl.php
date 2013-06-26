<?php 
/**
 * 用户聊天记录
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */

defined('IN_IA') or exit('Access Denied');
$do = !empty($_GPC['do']) ? $_GPC['do'] : 'display';

if ($do == 'display') {
	$where = '';
	$_GPC['searchtype'] = isset($_GPC['searchtype']) ? $_GPC['searchtype'] : 'today';
	switch ($_GPC['searchtype']) {
		case 'today':
			$starttime = empty($_GPC['starttime']) ? strtotime(date('Y-m-d')) : strtotime($_GPC['starttime']);
			$endtime = empty($_GPC['endtime']) ? TIMESTAMP : strtotime($_GPC['endtime']);
			$where .= " AND createtime > '$starttime' AND createtime <= '$endtime'";
			break;
		case 'default':
			$where .= " AND module = 'default'";
			break;
		default:
			break;
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 50;
	$list = pdo_fetchall("SELECT * FROM ".tablename('stat_msg_history')." WHERE  weid = '{$_W['weid']}' $where ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.','. $psize);
	if (!empty($list)) {
		foreach ($list as $index => &$history) {
			if ($history['type'] == 'link') {
				$history['message'] = iunserializer($history['message']);
				$history['message'] = '<a href="'.$history['message']['link'].'" target="_blank" title="'.$history['message']['description'].'">'.$history['message']['title'].'</a>';
			} elseif ($history['type'] == 'image') {
				$history['message'] = '<a href="'.$history['message'].'" target="_blank">查看图片</a>';
			} elseif ($history['type'] == 'location') {
				$history['message'] = iunserializer($history['message']);
				$history['message'] = '<a href="http://st.map.soso.com/api?size=800*600&center='.$history['message']['y'].','.$history['message']['x'].'&zoom=16&markers='.$history['message']['y'].','.$history['message']['x'].',1" target="_blank">查看方位</a>';
			}
			if (!empty($history['rid'])) {
				$rids[$history['rid']] = $history['rid'];
			}
		}	
		
	}
	$rules = pdo_fetchall("SELECT name, id FROM ".tablename('rule')." WHERE id IN (".implode(',', $rids).")", array(), 'id');
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('stat_msg_history') . " WHERE weid = '{$_W['weid']}'");
	$pager = pagination($total, $pindex, $psize);
	template('stat/history');
}