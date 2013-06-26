<?php 
/**
 * 更新系统配置
 * 更新模板缓存
 * 更新模块挂勾
 * ...
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */

if (checksubmit('submit')) {
	if (in_array('data', $_GPC['type'])) {
		//更新帐号
		$sql = "SELECT * FROM " . tablename('wechats') . " WHERE uid = '{$_W['uid']}' ORDER BY `weid` DESC";
		$wechats = pdo_fetchall($sql, array(), 'weid');
		if(is_array($wechats)) {
			cache_write('setting:wechats', iserializer($wechats));
		}
		$modules = pdo_fetchall("SELECT * FROM " . tablename('modules') . ' ORDER BY `mid` ASC', array(), 'name');
		//根据帐号写入缓存
		if (!empty($wechats)) {
			foreach ($wechats as $index => $row) {
				$modulecache = array();
				$mymodules = pdo_fetchall("SELECT mid, enabled, displayorder FROM ".tablename('wechats_modules')." WHERE weid = '{$row['weid']}' AND enabled = '1'", array(), 'mid');
				if (!empty($mymodules)) {
					foreach ($modules as $name => $module) {
						if (empty($mymodules[$module['mid']])) {
							continue;
						}
						$mymodules[$module['mid']]['displayorder'] >= 0 && $module['displayorder'] = $mymodules[$module['mid']]['displayorder'];
						$modulecache[$module['name']] = $module;
					}
					if(is_array($modulecache)) {
						cache_write('setting:modules:'.$row['weid'], iserializer($modulecache));
					}
				}
			}
			unset($row);
		}
		//更新公告缓存
    	cache_clean('announcement');
    	//更新模板
    	rmdirs(IA_ROOT . '/data/tpl/default', true);
		if (!empty($modules) || !empty($wechats)) {
			foreach ($modules as $mid => $module) {
				$file = IA_ROOT . "/source/modules/{$module['name']}/processor.php";
				if (!file_exists($file)) {
					continue;
				}
				include_once $file;
			}
			
			$classes = get_declared_classes();
			$classnames = $hooks =array();
			$namekey = 'ModuleProcessor';
			$namekeyLen = strlen($namekey);
			
			foreach($classes as $classname) {
				if(substr($classname, -$namekeyLen) == $namekey) {
					$classnames[] = $classname;
				}
			}
			foreach($classnames as $index => $classname) {
				$methods = get_class_methods($classname);
				foreach($methods as $funcname) {
					preg_match('/hook(.*)/', $funcname, $match);
					if (empty($match[1])) {
						continue;
					}
					foreach ($wechats as $index => $row) {
						$hookname = strtolower($match[1]);
						$mymodules = pdo_fetchall("SELECT a.mid, b.name FROM ".tablename('wechats_modules')." AS a LEFT JOIN ".tablename('modules')." AS b ON a.mid = b.mid WHERE a.weid = '{$row['weid']}' AND a.enabled = '1'", array(), 'name');
						$modulename = strtolower(str_replace($namekey, '', $classname));
						if (in_array($modulename, array_keys($mymodules))) {
							$hooks[$row['weid']][$hookname][] = array($modulename, $funcname);
						}
					}
				}
			}
			if (!empty($hooks)) {
				foreach ($hooks as $weid => $hook) {
					cache_write('hooks:'.$weid, $hook);
				}
			}
		}
	}
	message('缓存更新成功！', create_url('setting/updatecache'));
} else {
	template('setting/updatecache');
}