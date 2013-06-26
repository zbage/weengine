<?php
/**
 * 提供API接口相关函数
 * 
 */

function api_response($status = 0, $message = '') {
	exit(json_encode(array('status' => $status, 'message' => $message)));
}

if (!function_exists('json_encode')) {
	function json_encode($value) {
		static $jsonobj;
		if (!isset($jsonobj)) {
			include_once ('JSON.php');
			$jsonobj = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $jsonobj->encode($value);
	}
}

if (!function_exists('json_decode')) {
	function json_decode($jsonString) {
		static $jsonobj;
		if (!isset($jsonobj)) {
			include_once ('JSON.php');
			$jsonobj = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $jsonobj->decode($jsonString);
	}
}