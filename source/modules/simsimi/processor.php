<?php
/**
 * 小黄鸡处理类
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

class SimsimiModuleProcessor extends WeModuleProcessor {
	public $name = 'SimsimiRobotModuleProcessor';
	public $cookie_jar;
	
	public function isNeedInitContext() {
		return 0;
	}
	
	public function respond() {
		global $_W;
		$r['FromUserName'] = $this->message['to'];
		$r['ToUserName'] = $this->message['from'];
		$r['MsgType'] = 'text';
		$response = $this->getSimsimiReply($this->message['content']);
		if (strpos($response['response'], 'Unauthorized') !== FALSE) {
			$this->loginSimsimi();	
			$response = $this->getSimsimiReply($this->message['content']);
		}
		if (strpos($response['response'], 'Unauthorized') === FALSE) { 
			$r['Content'] = $response['response'];
		} else {
			//XXX 此处预留默认回复话语
			$r['Content'] = '';
			return array();
		}
		return $r;
	}
	
	public function isNeedSaveContext() {
		return false;
	}
	
	private function getSimsimiReply($sendtext='') {  
	    $url = 'http://www.simsimi.com/func/req?msg='.urlencode($sendtext).'&lc=ch';
	    $auth = cache_load('simsimi:cookie');
	    $response = http_request($url, '', array('CURLOPT_REFERER' => "http://www.simsimi.com/talk.htm?lc=ch", 'CURLOPT_COOKIE' => $auth));
	    print_r($response);
	    if (!empty($content)) {
	        return json_decode($content, true);
	    } else {
	        return array();
	    }
	}
	
	private function loginSimsimi() {
		$url = "http://www.simsimi.com/talk.htm?lc=ch";
		$response = http_request($url);
		cache_write('simsimi:cookie', implode('; ', (array)$response['headers']['Set-Cookie']));
	}
}