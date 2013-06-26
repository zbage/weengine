<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微擎 - 微信墙 - 微信公众平台自助引擎</title>
<meta name="keywords" content="微擎,微信,微信公众平台" />
<meta name="description" content="微信公众平台自助引擎，简称微擎，微擎是一款免费开源的微信公众平台管理系统。" />
<script type="text/javascript" src="./resource/script/jquery-1.7.2.min.js"></script>
<link type="text/css" rel="stylesheet" href="./source/modules/wxwall/template/common.css" />
</head>

<body>
<div id="wallMain">
	<div id="topbox" class="topbox">
		<div class="topbox_l">
			<div class="topic">
				<h1 class="msg_tit">添加微信号 <strong class="red">微信团队</strong></h1>
				<span class="addCnt">发送 <span class="red Topic_cnt">微信墙</span> 登记后刷内容广播自动上墙</span>
			</div>
		</div>
	</div>
    <div id="msg_list">
        <?php if(is_array($list)) { foreach($list as $row) { ?>
        <div class="talkList" id="msg_<?php echo $row['id'];?>">
            <div class="userPic"><img src="<?php if($row['member']['avatar']) { ?><?php echo $_W['attachurl'];?><?php echo $row['member']['avatar'];?><?php } else { ?>http://www.we7.cc/bbs/uc_server/images/noavatar_middle.gif<?php } ?>"></div>
            <div class="msgBox">
                <span class="userName"><strong><?php echo $row['member']['nickname'];?>：</strong></span>
                <span class="msgCnt"><?php echo $row['content'];?></span>
            </div>
        </div>
        <?php } } ?>
    </div>
</div>
<script type="text/javascript">
function getIncoming() {
	$.getJSON('<?php echo create_url('index/module', array('name' => 'wxwall', 'do' => 'incoming', 'id' => $wall['rid']))?>', function(s){
		if (!$('#msg_'+s.message.id)[0]) {
			$('#msg_list .talkList:last-child').hide('slow', function(){$(this).remove();});
			if (s.message.member.avatar) {
				var avatar = '<?php echo $_W['attachurl'];?>'+s.message.member.avatar;
			} else {
				var avatar = 'http://www.we7.cc/bbs/uc_server/images/noavatar_middle.gif';
			}
			var s = '<div class="talkList" id="msg_'+s.message.id+'">' +
					'<div class="userPic"><img src="'+avatar+'" onerror="" style="width:118px;height:128px;"></div>' +
					'<div class="msgBox"><span class="userName"><strong>'+s.message.member.nickname+'：</strong></span>' +
					'<span class="msgCnt">'+s.message.content+'</span></div></div>';
			$('#msg_list').prepend(s);
		}
		setTimeout(function(){
			getIncoming();
		},3000);
	});
}
$(function(){
	getIncoming();
});
</script>
</body>
</html>