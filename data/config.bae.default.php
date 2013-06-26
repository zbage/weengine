<?php
/**
 * 配置BAE相关设置
 * 
 * 配置选项时请注意不要破坏代码的结构和语法。
 * database, bucket, ak, sk为必填项，其他选项请充分理解后进行修改。
 * 
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */
defined('IN_IA') or exit('Access Denied');

$config = array();
/* 数据库连接配置，请勿修改 */
$config['db']['host'] = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
$config['db']['username'] = getenv('HTTP_BAE_ENV_AK');
$config['db']['password'] = getenv('HTTP_BAE_ENV_SK');
$config['db']['port'] = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
$config['db']['charset'] = 'utf8';
$config['db']['pconnect'] = 0;
/* 数据库名称 */
$config['db']['database'] = '';
/* 数据库表前缀 */
$config['db']['tablepre'] = 'ims_';

// --------------------------  CONFIG BAE  --------------------------- //
/* 云存储bucket，见 http://developer.baidu.com/wiki/index.php?title=docs/cplat/stor/guide#.E5.88.9B.E5.BB.BAbucket */
$config['bae']['bucket'] = '';
/* 云存储Access Key，见 http://developer.baidu.com/bae/ref/key/ */
$config['bae']['ak'] = '';
/* 云存储Secure Key，见 http://developer.baidu.com/bae/ref/key/ */
$config['bae']['sk'] = '';

// --------------------------  CONFIG COOKIE  --------------------------- //
$config['cookie']['pre'] = 'baec_';
$config['cookie']['domain'] = '';
$config['cookie']['path'] = '/';

// --------------------------  CONFIG SETTING  --------------------------- //
$config['setting']['charset'] = 'utf-8';
$config['setting']['cache'] = 'mysql';
$config['setting']['timezone'] = 'Asia/Shanghai';
$config['setting']['memory_limit'] = '256M';
$config['setting']['filemode'] = 0644;
$config['setting']['authkey'] = 'bae' . $_SERVER['HTTP_BAE_ENV_APPID'] . '_';

// --------------------------  CONFIG UPLOAD  --------------------------- //
$config['upload']['image']['extentions'] = array('gif', 'jpg', 'jpeg', 'png');
$config['upload']['image']['limit'] = 5000;
/* 云存储附件存放目录 */
$config['upload']['attachdir'] = '/';
$config['upload']['attachurl'] = 'http://bcs.duapp.com/'.$config['bae']['bucket'] . '/';
