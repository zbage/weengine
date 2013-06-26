<?php
/**
 * 微擎版本公告信息
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

cache_load('announcement');
if (!empty($_W['cache']['announcement'])) {
	$cache = iunserializer($_W['cache']['announcement']);
	$_W['cache']['announcement'] = $cache['content'];
}
if(empty($_W['cache']['announcement']) ||  TIMESTAMP - $cache['lastupdate'] >= 3600 * 5) {
	$response = http_get('http://www.we7.cc/api/v1/announcement.php');
	$response['content'] = json_decode($response['content'], TRUE);
	$cache = array(
		'status' => $response['status'],
		'content' => $response['content'],
		'lastupdate' => TIMESTAMP,
	);
	cache_write('announcement', iserializer($cache));
	$_W['cache']['announcement'] = $cache['content'];
}
print('<div id="we7_tips" '.($_W['cache']['announcement']['status'] ? '' : 'style="display:none;"').'><div class="we7_tips"><div class="we7_tips_main">');
print('<div class="we7_tips_header" style="padding-left:5px;"><a title="关闭" href="javascript:;" onclick="closetips()" class="we7_tips_close"></a><div class="we7_tips_title">微擎提醒您</div></div>');
print('<div class="we7_tips_content">');
print($_W['cache']['announcement']['content']);
print('</div></div></div></div>');
