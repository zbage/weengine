<?php
function tpl_frame() {
    global $step;
    $steps = array('许可协议', '环境检测', '参数配置', '安装完成');
    $step -= 1;

    $contents = ob_get_contents();
    ob_clean();
    echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>微擎 - 微信公众平台自助开源引擎</title>
<link href="images/style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="header">
	<div class="top">
		<div class="top-logo">
		</div>
		<div class="top-link">
			<ul>
				<li><a href="http://www.we7.cc" target="_blank">微擎官方网站</a></li>
				<li><a href="http://www.we7.cc/bbs" target="_blank">微擎官方论坛</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="main">
	<div class="pleft">
		<dl class="setpbox t1">
			<dt>安装步骤</dt>
			<dd>
				<ul>
EOF;
    foreach ($steps as $index => $value) {
        $classname = '';
        if ($index == $step) {
            $classname = 'now';
        } elseif ($index < $step) {
            $classname = 'succeed';
        }
        echo '<li class="'.$classname.'">'.$value.'</li>';
    }
    echo <<<EOF
				</ul>
			</dd>
		</dl>
	</div>
	<div class="pright">
		{$contents}
	</div>
</div>

<div class="foot">

</div>
</body>
</html>
EOF;
}

function tpl_install_license() {
	echo <<<EOF
		<div class="pr-title"><h3>阅读许可协议</h3></div>
		<div class="pr-agreement">
				<p>版权所有 (c)2013，微擎团队保留所有权利。 </p>
				<p>感谢您选择微擎 - 微信公众平台自助开源引擎（以下简称WE7，WE7基于 PHP + MySQL的技术开发，全部源码开放。</p>
				<p>为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：</p>
			<strong>一、本授权协议适用且仅适用于W7任何版本，WE7官方对本授权协议的最终解释权。</strong>
			<strong>二、协议许可的权利 </strong>
				<p>1、您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。 </p>
				<p>2、您可以在协议规定的约束和限制范围内修改 WE7 源代码或界面风格以适应您的网站要求。 </p>
				<p>3、您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。 </p>
				<p>4、获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。 </p>
			<strong>二、协议规定的约束和限制 </strong>
				<p>1、未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目的或实现盈利的网站）。</p>
				<p>2、未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</p></p>
				<p>4、未经官方许可，禁止在 WE7 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</p>
				<p>5、如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。 </p>
			<strong>三、有限担保和免责声明 </strong>
				<p>1、本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。 </p>
				<p>2、用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。 </p>
				<p>3、电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装  WE7，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
				<p>4、如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。</p>
		</div>
		<div class="btn-box">
			<input name="readpact" type="checkbox" id="readpact" value="" /><label for="readpact"><strong class="fc-690 fs-14">我已经阅读并同意此协议</strong></label>
			<input type="button" class="btn-next" value="继续" onclick="document.getElementById('readpact').checked ?window.location.href='index.php?step=2' : alert('您必须同意软件许可协议才能安装！');" />
		</div>
	</div>
</div>
EOF;
	tpl_frame();
}

function tpl_install_check_env($result = array()) {
    extract($result);
    $chk_dir_html = '';
    foreach ($chk_dir as $dir) {
        $status = 'chk_'.md5($dir);
        $chk_dir_html .= '
         <tr>
    		<td>'.$dir.'</td>
    		<td><font color=green>[√]可写</font></td>
    		<td>'.$$status.'</td>
    	</tr>';    
    }
echo <<<EOF
<div class="pr-title"><h3>服务器信息</h3></div>
<table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
	<tr>
		<th width="300" align="center"><strong>参数</strong></th>
		<th width="424"><strong>值</strong></th>
	</tr>
	<tr>
		<td><strong>服务器操作系统</strong></td>
		<td>{$env_os}</td>
	</tr>
	<tr>
		<td><strong>服务器解译引擎</strong></td>
		<td>{$env_server}</td>
	</tr>
	<tr>
		<td><strong>PHP版本</strong></td>
		<td>{$env_version}</td>
	</tr>
	<tr>
		<td><strong>系统安装目录</strong></td>
		<td>{$env_pathroot}</td>
	</tr>
	<tr>
		<td><strong>磁盘空间</strong></td>
		<td>{$env_diskspace}</td>
	</tr>
	<tr>
		<td><strong>附件上传</strong></td>
		<td>{$env_uploadsize}</td>
	</tr>
	<tr>
		<td><strong>GD 库</strong></td>
		<td>{$env_gd}</td>
	</tr>
</table>
<div class="pr-title"><h3>程序依赖性检查</h3></div>
<table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
	<tr>
		<th width="200" align="center"><strong>需开启的变量或函数</strong></th>
		<th width="80"><strong>要求</strong></th>
		<th width="400"><strong>实际状态及建议</strong></th>
	</tr>
	<tr>
		<td>mysql_connect()</td>
		<td align="center">On </td>
		<td>{$mysql_connect} <small>(mysql_connect与pdo必须支持其中一个)</small></td>
	</tr>
	<tr>
		<td>PDO</td>
		<td align="center">On </td>
		<td>{$pdo_mysql} <small>(mysql_connect与pdo必须支持其中一个)</small></td>
	</tr>
	<tr>
		<td>allow_url_fopen</td>
		<td align="center">On </td>
		<td>{$allow_url_fopen} <small></small></td>
	</tr>
	<tr>
		<td>file_get_contents()</td>
		<td align="center">On</td>
		<td>{$file_get_contents} <small></small></td>
	</tr>
	<tr>
		<td>xml_parser_create()</td>
		<td align="center">On</td>
		<td>{$xml_parser_create} <small></small></td>
	</tr>
	<tr>
		<td>fsockopen()</td>
		<td align="center">On</td>
		<td>{$fsockopen} <small></small></td>
	</tr>
	<tr>
		<td>curl</td>
		<td align="center">On</td>
		<td>{$curl_init} <small></small></td>
	</tr>
</table>
<div class="notice">系统环境要求必须满足下列所有条件，否则系统或系统部份功能将无法使用。</div>

<div class="pr-title"><h3>目录权限检测</h3></div>
<table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
	<tr>
		<th width="300" align="center"><strong>目录名</strong></th>
		<th width="212"><strong>所需状态</strong></th>
		<th width="212"><strong>当前状态</strong></th>
	</tr>
    {$chk_dir_html}
</table>
<div class="notice">
	系统要求必须满足下列所有的目录权限全部可读写的需求才能使用，其它应用目录可安装后在管理后台检测。
</div>
<div class="btn-box">
	<input type="button" class="btn-back" value="后退" onclick="window.location.href='index.php';" />
	<input type="button" class="btn-next" value="继续" onclick="window.location.href='index.php?step=3';" />
</div>
EOF;
	tpl_frame();
}

function tpl_install_db($error_msg = '') {
    if (!empty($error_msg)) {
        echo <<<EOF
        <div class="pr-title"><h3>错误信息</h3></div>
        <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
            <tr>
                <td><div style="color:red;">{$error_msg}</div></td>
            </tr>
        </table>    
EOF;
    }
?>
    <form action="" method="post" onsubmit="return check(this)">
    <div class="pr-title"><h3>数据库设定</h3></div>
    <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
<?php if (empty($GLOBALS['platform'])) { ?>
        <tr>
            <td class="onetd"><strong>数据库主机：</strong></td>
            <td><input name="dbhost" id="dbhost" type="text" value="localhost" class="input-txt" />
            <small>一般为localhost</small></td>
        </tr>
        <tr>
            <td class="onetd"><strong>数据库用户：</strong></td>
            <td><input name="dbuser" id="dbuser" type="text" value="root" class="input-txt" /></td>
        </tr>
        <tr>
            <td class="onetd"><strong>数据库密码：</strong></td>
            <td>
              <input name="dbpwd" id="dbpwd" type="text" class="input-txt" />
            </td>
        </tr>
		<tr>
            <td class="onetd"><strong>数据表前缀：</strong></td>
            <td><input name="dbprefix" id="dbprefix" type="text" value="ims_" class="input-txt" />
            <small>如无特殊需要,请不要修改</small></td>
        </tr>
        <tr>
            <td class="onetd"><strong>数据库名称：</strong></td>
            <td>
                <input name="dbname" id="dbname" type="text" value="we7" class="input-txt" />
            </td>
        </tr>
<?php } ?>
<?php if ($GLOBALS['platform'] == 'bae') { ?>
		<tr>
            <td colspan="2">请手动配置“/data/config.bae.php”配置文件</td>
        </tr>
<?php } ?>
    </table>

    <div class="pr-title"><h3>管理员初始密码</h3></div>
    <table width="726" border="0" align="center" cellpadding="0" cellspacing="0" class="twbox">
        <tr>
            <td class="onetd"><strong>管理员帐号：</strong></td>
            <td>
                <input name="adminuser" type="text" value="admin" class="input-txt" />
                <p><small>只能用'0-9'、'a-z'、'A-Z'、'.'、'@'、'_'、'-'、'!'以内范围的字符</small></p>
            </td>
        </tr>
        <tr>
            <td class="onetd"><strong>管理员密码：</strong></td>
            <td><input name="adminpwd" type="password" value="" class="input-txt" /></td>
        </tr>
        <tr>
            <td class="onetd"><strong>确认密码：</strong></td>
            <td><input name="confirmpwd" type="password" value="" class="input-txt" /></td>
        </tr>
    </table>

    <div class="btn-box">
        <input type="button" class="btn-back" value="后退" onclick="window.location.href='index.php?step=2';" />
        <input type="submit" name="install" id="install" class="btn-next" value="开始安装" />
  </div>
    </form>
    <script type="text/javascript">
    function check(form) {
<?php if (empty($GLOBALS['platform'])) { ?>
        if (!form['dbhost'].value) {
            alert('请填写数据库主机地址！');
            form['dbhost'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (!form['dbuser'].value) {
            alert('请填写数据库用户！');
            form['dbuser'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (!form['dbpwd'].value) {
            alert('请填写数据库密码！');
            form['dbpwd'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (!form['dbprefix'].value) {
            alert('请填写数据库表前缀！');
            form['dbprefix'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (!form['dbname'].value) {
            alert('请填写数据库名称！');
            form['dbname'].focus();
            form['install'].disabled = '';
            return false;
        }
<?php } ?>
        if (!form['adminuser'].value) {
            alert('请填写管理员帐号！');
            form['adminuser'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (!form['adminpwd'].value) {
            alert('请填写管理员帐号密码！');
            form['adminpwd'].focus();
            form['install'].disabled = '';
            return false;
        }
        if (form['adminpwd'].value != form['confirmpwd'].value) {
            alert('您两次输入的管理员帐号密码不相同，请检查！');
            form['adminpwd'].focus();
            form['install'].disabled = '';
            return false;
        }
		document.getElementById('install').disabled='disabled';
    }
    </script>
<?php 
    tpl_frame();
}

function tpl_install_finish() {
    echo <<<EOF
<div class="pr-title"><h3>安装完成</h3></div>
<div class="install-msg">
	恭喜您!已成功安装“微擎 - 微信公众平台自助开源引擎”系统，您现在可以:
	<br />
</div>
<div class="over-link fs-14">
	<a href="../index.php">访问网站首页</a>
</div>
EOF;
    tpl_frame();
}