<?php
function action_create($name) {

}
$cfg = array();
$cfg['available_versions'] = array('v1.0', 'v2.0');
$cfg['secret'] = '0f7e88773941e9ee5d089096f9d575b5';
$cfg['methods']['v1.0'][] = 'thread.search'; 
$cfg['methods']['v1.0'][] = 'member.bind';
$cfg['methods']['v1.0'][] = 'member.bindQuery';
$cfg['creator'] = 'action_create';
ApiUtility::init($cfg);

interface IApiAction {
    /**
     * 验证输入数据是否正确, 返回值等于 false 将中止执行, 并向调用端返回错误号 -10 (如果要使用业务级定义的错误号, 请直接在方法内部使用 ApiUtility::error), 其他值继续执行
     * 如果需要保存处理过的数据, 请将数据保存至实现类的私有成员中
     * @param void
     * @return bool
     */
    public function validate();

    /**
     * 执行接口服务, 返回值将自动包装并响应至调用者
     * @param void
     * @return mixed
     */
    public function invoke();
}

class ApiUtility {

    public static $_W = array();

    /**
     * API 全以 POST 提交, 需要提交系统级参数 version method timestamp sign, 时间戳误差不能超过 5 分钟, sign 为签名, 除 sign 外所有输入参数, 包括系统参数和应用参数\
     * 都需要参与签名. 签名算法: 按照键名正序排列后, 键名键值拼接附加上 secret 后计算 sha1 值.
     *
     * 当前网关支持的协议版本, 因为协议可能升级, 为了保证向前兼容, 同个网关可能支持多个版本的协议
     * $config['available_versions'] = array('v1.0');
     * 当前插件的传输密钥, 随机生成, 并应与微擎系统一致
     * $config['secret'] = '0f7e88773941e9ee5d089096f9d575b5';
     * 当前系统实现的方法服务, 每个版本可实现多个方法服务
     * $config['methods']['v1.0'][] = 'thread.search';
     * $config['methods']['v1.0'][] = 'member.bind';
     * $config['methods']['v1.0'][] = 'member.bindQuery';
     * 回调函数, 提供工厂操作, 输入参数为上述的方法服务名称(如: member.bindQuery), 返回值为 IApiAction 对象, 用于处理请求并返回
     * $config['creator'] = callable;
     */
    public static function init($config) {
        if(!is_array($config['available_versions']) || empty($config['available_versions'])) {
            ApiUtility::error(-50, '', 'error config arguments.');
        }
        if(empty($config['secret'])) {
            ApiUtility::error(-50, '', 'error config arguments.');
        }
        if(!is_array($config['methods']) || empty($config['methods'])) {
            ApiUtility::error(-50, '', 'error config arguments.');
        }
        if(empty($config['creator']) || !is_callable($config['creator'])) {
            ApiUtility::error(-50, '', 'error config arguments.');
        } 
        ApiUtility::$_W['config'] = $config;

        ApiUtility::$_W['siteroot'] = htmlspecialchars('http://'.$_SERVER['HTTP_HOST']);
        if($_SERVER['SERVER_PORT'] != '80') {
            ApiUtility::$_W['siteroot'] .= ":{$_SERVER['SERVER_PORT']}/";
        } else {
            ApiUtility::$_W['siteroot'] .= '/';
        }
        ApiUtility::$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';

        header('Content-Type: text/html; charset=utf-8');
        if(!in_array($_SERVER['REQUEST_METHOD'], array('GET', 'POST'))) {
            ApiUtility::error(-1);
        }
        $_POST = array_merge($_GET, $_POST); #debug
        if(empty($_POST['version'])) {
            ApiUtility::error(-2);
        }
        ApiUtility::$_W['version'] = $_POST['version'];
        if(!in_array(ApiUtility::$_W['version'], ApiUtility::$_W['config']['available_versions'])) {
            ApiUtility::error(-3);
        }
        if(empty($_POST['timestamp'])) {
            ApiUtility::error(-4);
        }
        if(!preg_match('/^\d{10}$/', $_POST['timestamp']) || abs(intval($_POST['timestamp']) - ApiUtility::$_W['timestamp']) > 300) {
            ApiUtility::error(-5);
        }
        if(empty($_POST['method'])) {
            ApiUtility::error(-6);
        }
        ApiUtility::$_W['method'] = $_POST['method'];
        if(!in_array(ApiUtility::$_W['method'], ApiUtility::$_W['config'][ApiUtility::$_W['version']])) {
            ApiUtility::error(-7);
        }
        if(empty($_POST['sign'])) {
            ApiUtility::error(-8);
        }
        ksort($_POST);
        $request = '';
        foreach($_POST as $key => $value) {
            if($key == 'sign') {
                continue;
            }
            $request .= "{$key}{$value}";
        }
        $request .= ApiUtility::$_W['config']['secret'];
        if($_POST['sign'] != sha1($request)) {
            ApiUtility::error(-9);
        }
        $instance = call_user_func(ApiUtility::$_W['config']['creator'], ApiUtility::$_W['method']);
        if(!($instance instanceof IApiAction)) {
            ApiUtility::error(-50, '', '已经定义了此接口, 但未实现(定义的类未实现请求版本的协议接口). 请联系服务提供者解决.');
        }
        if(!$instance->validate()) {
            ApiUtility::error(-10);
        }
        $data = $instance->invoke();
        ApiUtility::result($data);
    }

    /**
     * 返回错误代码及错误描述，调用此方法将输出操作结果并直接退出
     * @param string $code 错误代码，约定请参与接口文档
     * @param string $message 附加的错误信息
     * @return void
     */
    public static function error($errno = 0, $error = '', $message = '') {
        static $errors = array();
        if(empty($errors)) {
            $errors['ivk.verb.invalid'] = array(-1, '调用的HTTP谓词错误');
            $errors['ivk.version.miss'] = array(-2, '未提供version参数');
            $errors['ivk.version.invalid'] = array(-3, '提供的协议版本不正确或不存在');
            $errors['ivk.timestamp.miss'] = array(-4, '未提供timestamp参数');
            $errors['ivk.timestamp.invalid'] = array(-5, 'timestamp格式错误, 或时间戳范围不正确');
            $errors['ivk.method.miss'] = array(-6, '未提供method参数');
            $errors['ivk.method.invalid'] = array(-7, 'method参数格式错误, 或不存在此method');
            $errors['ivk.sign.miss'] = array(-8, '未提供sign参数');
            $errors['ivk.sign.invalid'] = array(-9, '调用者提供的签名错误');
            $errors['ivk.parameter.invalid'] = array(-10, '调用者传入的参数不正确, 请根据API文档检查参数类型, 范围');
            $errors['ivk.exception'] = array(-49, '其他调用异常, 当前未能检测出, 但确定是调用端错误调用所引发的错误.');
            $errors['srv.dev.notimplement'] = array(-50, '当前提供者对应的功能尚未开发完成, 或者实现有错误');
            $errors['srv.exception'] = array(-99, '未知的服务端异常');
        }
        $r = array();
        $r['errno'] = intval($errno);
        $r['error'] = strval($error);
        if(empty($r['errno']) && !empty($r['error'])) {
            $r['errno'] = $errors[$r['error']][0];
        }
        if(empty($r['error']) && !empty($r['errno'])) {
            foreach($errors as $k => $v) {
                if($v[0] == $r['errno']) {
                    $r['error'] = $k;
                }
            }
        }
        if(empty($r['errno']) || empty($r['error'])) {
            ApiUtility::error(-50, '', '服务端期望返回错误, 但未正确指明错误内容, 请联系服务提供者解决. ');
        }
        if($r['errno'] < 0) {
            if($errors[$r['error']][0] != $r['errno']) {
                ApiUtility::error(-50, '', '服务端期望返回协议预定义错误, 但给定的错误码和错误标识不匹配. ');
            }
        }
        $r['message'] = strval($message);
        exit(json_encode($r));
    }

    /**
     * 执行成功，返回结果[集]
     * @param mixed $data 执行成功的结果[集]
     * @return void
     */
    public static function result($data) {
        exit(json_encode($data));
    }
}
