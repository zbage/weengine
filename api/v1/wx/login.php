<?php 
/**
 * 登录微信接口
 * 
 */
require '../../bootstrap.inc.php';
$username = $_GPC['username'];
$password = $_GPC['password'];
if (empty($username) || empty($password)) {
	response(1, 'Invalid Username or Password');			
}
define('WEIXIN_ROOT', 'https://mp.weixin.qq.com');
$loginurl = WEIXIN_ROOT . '/cgi-bin/login?lang=zh_CN';
$post = array(
	'username' => $username,
	'pwd' => $password,
	'imgcode' => '',
	'f' => 'json',
);
//$data = weixin_http($username, $loginurl, $post, TRUE);
$data = array(
	'data' => '{
"Ret": 302,
"ErrMsg": "/cgi-bin/indexpage?t=wxm-index&lang=zh_CN&token=816479478",
"ShowVerifyCode": 0,
"ErrCode": 0
}',
	'header' => 'HTTP/1.1 200 OK
Server: nginx/0.7.64
Date: Thu, 09 May 2013 03:45:57 GMT
Content-Type: application/json; charset=UTF-8
Connection: keep-alive
Content-Length: 121
Cache-Control: no-cache, must-revalidate
Set-Cookie: cert=XR5Vts0Tq34RFiWluSL76OTr_14V2H1Z; Path=/; Secure; HttpOnly
Set-Cookie: slave_user=gh_4b1063013961; Path=/; Secure; HttpOnly
Set-Cookie: slave_sid=WFI1VnRzMFRxMzRSRmlXbHVTTDc2T1RyXzE0VjJIMVp4NFMwd1NSWFZWTnhjR1NGeEJLRG1DM2xCNmZCTmdBa2xwaVJlNkw3MHhFYWF1Tkgyd2tvNmxKSHJXaWViUXd1ZU1qcVMzeFN6OV9IRE5vREZaSHloRWRmVEt6Rmp1eUI=; Path=/; Secure; HttpOnly',
);
$data['data'] = json_decode($data['data'], true);
if ($data['data']['ErrCode'] == 0) {
	//输出header头
	$header = explode("\n", $data['header']);
	if (!empty($header)) {
		$fdata = '';
		foreach ($header as $row) {
			if (strpos($row, 'Set-Cookie') !== FALSE) {
				$fdata .= $row;
			}
		}
		header($fdata);
	} else {
		response(1, 'Login failed');
	}
} else {
	switch ($data['ErrCode']) {
		case "-1":
			$msg = "系统错误，请稍候再试。";
			break;
		case "-2":
			$msg = "微信公众帐号或密码错误。";
			break;
		case "-3":
			$msg = "微信公众帐号密码错误，请重新输入。";
			break;
		case "-4":
			$msg = "不存在该微信公众帐户。";
			break;
		case "-5":
			$msg = "您的微信公众号目前处于访问受限状态。";
			break;
		case "-6":
			$msg = "登录受限制，需要输入验证码，稍后再试！";
			break;
		case "-7":
			$msg = "此微信公众号已绑定私人微信号，不可用于公众平台登录。";
			break;
		case "-8":
			$msg = "微信公众帐号登录邮箱已存在。";
			break;
		case "-200":
			$msg = "因您的微信公众号频繁提交虚假资料，该帐号被拒绝登录。";
			break;
		case "-94":
			$msg = "请使用微信公众帐号邮箱登陆。";
			break;
		case "10":
			$msg = "该公众会议号已经过期，无法再登录使用。";
			break;
		default:
			$msg = "未知的返回。";
	}
	response($data['ErrCode'], $msg);
}


function weixin_http($username, $url, $post = '', $header = false, $referer = '') {
	$timeout = 30;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	if (!empty($post)) {
		curl_setopt($ch, CURLOPT_POST, 1);
		if (is_array($post)) {
			$post = http_build_query($post, '', '&');
		}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
	curl_setopt($ch, CURLOPT_REFERER, empty($referer) ? 'http://mp.weixin.qq.com/' : $referer);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	$result['data'] = curl_exec($ch);
	if (!empty($header)) {
		list($result['header'], $result['data']) = explode("\r\n\r\n", $result['data']);
	}
	$result['status'] = curl_getinfo($ch);
	$result['errorno'] = curl_errno($ch);
	curl_close($ch);
	return $result;
}