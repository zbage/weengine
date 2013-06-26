<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微擎 - 微信公众平台自助引擎 -  Powered by WE7.CC</title>
<meta name="keywords" content="微擎,微信,微信公众平台" />
<meta name="description" content="微信公众平台自助引擎，简称微擎，微擎是一款免费开源的微信公众平台管理系统。" />
<link type="text/css" rel="stylesheet" href="./resource/style/jquery-ui-1.7.3.css" />
<link type="text/css" rel="stylesheet" href="./resource/style/common.css" />
<script type="text/javascript" src="./resource/script/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="./resource/script/jquery-ui-1.7.3.min.js"></script>
<script type="text/javascript" src="./resource/script/common.js?v=<?php echo TIMESTAMP;?>"></script>
<script type="text/javascript" src="./resource/script/emotions.js"></script>
<?php if($_W['uid']) { ?>
<script type="text/javascript">session.online = true; session.uid = <?php echo $_W['uid'];?>; session.username = '<?php echo $_W['member']['username'];?>';</script>
<?php } ?>
</head>

<body>
	<ul id="my-account-menu" style="display:none;">
        <?php if(is_array($_W['setting']['wechats'])) { foreach($_W['setting']['wechats'] as $row) { ?>
        <li<?php if($id == $row['weid']) { ?> class="current"<?php } ?>><a href="<?php echo create_url('account/switch', array('id' => $row['weid']))?>"><?php echo $row['name'];?></a></li>
        <?php } } ?>
    </ul>
	<div id="header">
    	<div class="container-12">
        	<div class="row1">
            	<div class="logo grid-5 alpha"><a href="./index.php">微擎 - 微信公众平台自助引擎</a></div>
                <div class="fr grid-7 omega">
                	<ul class="nav finline fr">
						<?php if(empty($_W['uid'])) { ?>
                    	<li<?php echo $current['login'];?>><a href="<?php echo create_url('member/login')?>login">登录</a></li>
						<?php } else { ?>
                        	<?php if(!empty($_W['account'])) { ?>
                        	<li><a href="javascript:;">当前公众号：<?php echo $_W['account']['name'];?></a></li>
                            <?php } ?>
                        <li<?php echo $current['center'];?> class="my-account" id="my-account">
                        <a href="javascript:;">切换公众号</a>
                        </li>
                    	<li<?php echo $current['center'];?>><a href="<?php echo create_url('account')?>"><?php echo $_W['username'];?></a></li>
                        <li><a href="<?php echo create_url('member/logout')?>">退出</a></li>
						<?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row2">
            	<div class="nav-container grid-9">
                	<ul class="nav finline">
                        <li<?php if($controller == 'account') { ?> class="current"<?php } ?>><a href="<?php echo create_url('account')?>">公众号管理</a></li>
                        <li<?php if($controller == 'rule') { ?> class="current"<?php } ?>><a href="<?php echo create_url('rule')?>">回复管理</a></li>
						<li<?php if($controller == 'setting') { ?> class="current"<?php } ?>><a href="<?php echo create_url('setting/module')?>">系统管理</a></li>
                        <li<?php if($controller == 'send') { ?> class="current"<?php } ?>><a href="<?php echo create_url('send')?>">群发消息</a></li>
                        <li<?php if($controller == 'stat') { ?> class="current"<?php } ?>><a href="<?php echo create_url('stat')?>">统计分析</a></li>
						<li<?php if($controller == 'home') { ?> class="current"<?php } ?>><a href="<?php echo create_url('index/help')?>">帮助</a></li>
                        <li><a href="http://mp.weixin.qq.com/" target="_blank">微信公众平台</a></li>
						<li><a href="http://bbs.we7.cc/" target="_blank">微擎官方论坛</a></li>
                    	<?php if($current['context']) { ?><li class="current"><a href="javascript:;"><?php echo $current['context'];?></a></li><?php } ?>
                    </ul>
                </div>
                <div class="grid-3" style="text-align:right;">

                </div>
            </div>
        </div>
    </div>
	<div id="middle">
