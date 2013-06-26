<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 从数据库中加载设置信息存至 cache 中 setting:分组下，并加载设置信息至全局变量 $_W['setting'] 下
 * @params 如果指定key，则单独加载某一项设置信息
 * @params mixed
 */
function setting_load($key = '') {
    global $_W;
    if(empty($key)) {
        cache_load('setting:');
        if(empty($_W['cache']['setting'])) {
            $sql = 'SELECT * FROM ' . tablename('settings');
            $ds = pdo_fetchall($sql);
            if(is_array($ds)) {
                foreach($ds as $k => &$v) {
                    $v['value'] = iunserializer($v['value']);
                    $_W['setting'][$v['key']] = $v;
                    cache_write("setting:{$v['key']}", $v['value']);
                }
            }
        }
        $_W['setting'] = &$_W['cache']['setting'];
        return $_W['setting'];
    } else {
        cache_load("setting:{$key}");
        if(empty($_W['cache']['setting'][$key])) {
            $sql = 'SELECT * FROM ' . tablename('settings') . ' WHERE `key`=:key';
            $params = array();
            $params[':key'] = $key;
            $record = pdo_fetch($sql, $params);
            if(!empty($record)) {
                $record['value'] = iunserializer($record['value']);
                cache_write("setting:{$key}", $record['value']);
            }
        } else {
        	$record['value'] = $_W['cache']['setting'][$key];
        }
        $_W['setting'] = &$_W['cache']['setting'];
        return $record['value'];
    }
}

/**
 * 将设置信息保存至数据库，将会同时更新全局变量 $_W['setting']，过期缓存
 * @param mixed $data 如果提供 $data，则将 $data 做为指定键的 $key 的值来更新
 * @param string $key 如果提供 $key，则至更新指定键名
 * @return void
 */
function setting_save($data = '', $key = '') {
    if (empty($data) && empty($key)) {
        return FALSE;
    }
    if (is_array($data) && empty($key)) {
        foreach ($data as $key => $value) {
            $record[] = "('$key', '".iserializer($value)."')";
        }
        if ($record) {
            $return = pdo_query("REPLACE INTO ".tablename('settings')." (`key`, `value`) VALUES " . implode(',', $record));
        }
        $return && cache_clean('setting');
    } else {
        $record = array();
        $record['key'] = $key;
        $record['value'] = iserializer($data);
        $return = pdo_insert('settings', $record, TRUE);
        $return && cache_delete("setting:{$key}");
    }
    return $return;
}

function setting_modules() {
    global $_W;
    $_W['setting']['modules'] = (array)pdo_fetchall("SELECT * FROM ".tablename('modules'), array(), 'name');
    return $_W['setting']['modules'];
}
