<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 用户注册
 * PS:密码字段不要加密
 * @param array $member 用户注册信息，需要的字段必须包括 username, password, email
 * @return int 成功返回新增的用户编号，失败返回 0
 */
function member_register($member) {
    $member['salt'] = salt(8);
    $member['joindate'] = TIMESTAMP;
    $member['password'] = member_hash($member['password'], $member['salt']);
    $result = pdo_insert('members', $member);
    if($result) {
        if(empty($member['uid'])) {
            $member['uid'] = pdo_insertid();
        }
        if($member['uid'] > 0) {
            $status = array();
            $status['uid'] = $member['uid'];
            $status['joinip'] = CLIENT_IP;
            pdo_insert('member_status', $status);
        }
    }
    return $member['uid'];
}

/**
 * 检查用户是否存在，多个如果检查的参数包括多个字段，则必须满足所有参数条件符合才返回true
 * PS:密码字段不要加密，不能单独依靠密码查询
 * @param array $member 用户信息，需要的字段可以包括 uid, username, password, email, status
 * @return bool
 */
function member_check($member) {
    $sql = 'SELECT COUNT(*) AS `cnt`,`password`,`salt` FROM ' . tablename('members') . " WHERE 1";
    $params = array();
    if(!empty($member['uid'])) {
        $sql .= ' AND `uid`=:uid';
        $params[':uid'] = intval($member['uid']);
    }
    if(!empty($member['username'])) {
        $sql .= ' AND `username`=:username';
        $params[':username'] = $member['username'];
    }
    if(!empty($member['email'])) {
        $sql .= ' AND `email`=:email';
        $params[':email'] = $member['email'];
    }
    if(!empty($member['status'])) {
        $sql .= " AND `status`=:status";
        $params[':status'] = intval($member['status']);
    }
    $sql .= " LIMIT 1";
    $record = pdo_fetch($sql, $params);
    if(!$record || $record['cnt'] == 0 || empty($record['password']) || empty($record['salt'])) {
        return false;
    }
    if(!empty($member['password'])) {
        $password = member_hash($member['password'], $record['salt']);
        return $password == $record['password'];
    }
    return true;
}

/**
 * 获取单条用户信息，如果查询参数多于一个字段，则查询满足所有字段的用户
 * PS:密码字段不要加密
 * @param array $member 要查询的用户字段，可以包括  uid, username, password, email, status
 * @param bool 是否要同时获取状态信息
 * @return array 完整的用户信息
 */
function member_single($member, $status = false) {
    $sql = 'SELECT * FROM ' . tablename('members') . " WHERE 1";
    $params = array();
    if(!empty($member['uid'])) {
        $sql .= ' AND `uid`=:uid';
        $params[':uid'] = intval($member['uid']);
    }
    if(!empty($member['username'])) {
        $sql .= ' AND `username`=:username';
        $params[':username'] = $member['username'];
    }
    if(!empty($member['email'])) {
        $sql .= ' AND `email`=:email';
        $params[':email'] = $member['email'];
    }
    if(!empty($member['status'])) {
        $sql .= " AND `status`=:status";
        $params[':status'] = intval($member['status']);
    }
    $sql .= " LIMIT 1";
    $record = pdo_fetch($sql, $params);
    if(!$record) {
        return false;
    }
    if(!empty($member['password'])) {
        $password = member_hash($member['password'], $record['salt']);
        if($password != $record['password']) {
            return false;
        }
    }
    if($status) {
        $sql = 'SELECT * FROM ' . tablename('member_status') . ' WHERE `uid`=:uid';
        $s = pdo_fetch($sql, array(':uid' => $record['uid']));
        $record = array_merge($record, $s);
    }
    $record['avatar'] = $_W['attachurl'] . $record['avatar'];
    if(empty($record['avatar']) || !file_exists(IA_ROOT . $record['avatar'])) {
        $record['avatar'] = './resource/image/default-avatar.png';
    }
    return $record;
}

/**
 * 更新用户状态信息
 * @param array $status 用户的状态信息数据, 需要的字段可以包括lastvisit, lastip, lastpost, lastsendmail, 必须包括 uid
 * @return bool
 */
function member_touch($status) {
    if(empty($status['uid'])) {
        return false;
    }
    $params = array();
    if($status['lastvisit']) {
        $params['lastvisit'] = $status['lastvisit'];
    }
    if($status['lastip']) {
        $params['lastip'] = $status['lastip'];
    }
    if($status['lastpost']) {
        $params['lastpost'] = $status['lastpost'];
    }
    if($status['lastsendmail']) {
        $params['lastsendmail'] = $status['lastsendmail'];
    }
    if(empty($params)) {
        return false;
    }
    return pdo_update('member_status', $params, array('uid' => intval($status['uid'])));
} 

/**
 * 更新用户资料
 * PS:密码字段需要加密
 * @param array $member 用户的新资料信息，需要的字段可以包括password, newpms, status, level, avatar, 必须包括 uid
 * @return bool
 */
function member_update($member) {
    if(empty($member['uid'])) {
        return false;
    }
    $params = array();
    if($member['password']) {
        $params['password'] = $member['password'];
    }
    if($member['newpms']) {
        $params['newpms'] = $member['newpms'];
    }
    if($member['status']) {
        $params['status'] = $member['status'];
    }
    if($member['level']) {
        $params['level'] = $member['level'];
    }
    if($member['avatar']) {
        $params['avatar'] = $member['avatar'];
    }
    if($member['email']) {
        $params['email'] = $member['email'];
    }
    if(empty($params)) {
        return false;
    }
    return pdo_update('members', $params, array('uid' => intval($member['uid'])));
}

/**
 * 计算用户密码hash
 * @param string $input 输入字符串
 * @param string $salt 附加字符串
 * @return string
 */
function member_hash($input, $salt) {
    global $_W;
    $input = "{$input}-{$salt}-{$_W['config']['setting']['authkey']}";
    return sha1($input);
}

function member_level() {
    return array(
        '-3' => '锁定用户',
        '-2' => '禁止访问',
        '-1' => '禁止发言',
        '0' => '普通会员',
        '1' => '管理员',
    );
}

/**
 * 插入一条用户登录失败记录，如果存在则+1
 * 
 */
function member_failed_count($username, $ip) {
	$failed = pdo_fetch("SELECT count, lastvisit FROM ".tablename('member_login_failed')." WHERE ip = :ip AND username = :username", array(':ip' => $ip, ':username' => $username));
	
	if (empty($failed)) {
		return 0;
	}
	if ($failed['lastvisit'] < $_W['timestamp'] - 300) {
		pdo_delete('member_login_failed', array('username' => $username, 'ip' => $ip));
		return 0;
	}
	return $failed['count'];
}

function member_failed_update($username, $ip) {
	$failed = pdo_fetch("SELECT id, count, lastvisit FROM ".tablename('member_login_failed')." WHERE ip = :ip AND username = :username", array(':ip' => $ip, ':username' => $username));
	if (empty($failed)) {
		$data = array(
			'username' => $username,
			'ip' => $ip,
			'count' => 1,
			'lastvisit' => $GLOBALS['_W']['timestamp'],
		);
		pdo_insert('member_login_failed', $data);
	} else {
		pdo_query("UPDATE ".tablename('member_login_failed')." SET count = count + 1 WHERE id = :id", array(':id' => $failed['id']));
	}
	
	return true;
}

function member_modules($cache = true) {
    global $_W;
    cache_load('setting:modules:'.$_W['weid']);
    if(empty($_W['cache']['setting']['modules'][$_W['weid']])) {
    	$mymodules = pdo_fetchall("SELECT mid, enabled, displayorder FROM ".tablename('wechats_modules')." WHERE weid = '{$_W['weid']}' AND enabled = '1'", array(), 'mid');
    	if (!empty($mymodules)) {
    	    $modules = pdo_fetchall("SELECT * FROM " . tablename('modules') . ' WHERE mid IN ('.implode(',', array_keys($mymodules)).') ORDER BY `mid` ASC', array(), 'name');
    	    foreach ($modules as &$row) {
    	    	$mymodules[$row['mid']]['displayorder'] >= 0 && $row['displayorder'] = $mymodules[$row['mid']]['displayorder'];
    	    }
    	    if(is_array($modules)) {
    	        cache_write('setting:modules:'.$_W['weid'], iserializer($modules));
    	    }   
    	} else {
    	    $modules = array();
    	} 
        $_W['cache']['setting']['modules'][$_W['weid']] = $modules;
    } else {
        $_W['cache']['setting']['modules'][$_W['weid']] = iunserializer($_W['cache']['setting']['modules'][$_W['weid']]);
    }
    return $_W['cache']['setting']['modules'][$_W['weid']];
}