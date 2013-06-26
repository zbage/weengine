<?php 
/**
 * 用于调试时模拟用户发送信息到微号公众号
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 */

require './source/bootstrap.inc.php';
if(!DEVELOPMENT && $_W['clientip'] != '127.0.0.1') {
	exit('Running in development environment');
}
if(empty($_W['uid'])) {
	header('Location: '.create_url('member/login', array('referer' => $_W['script_name'])));
}
$list = account_search($_W['uid'], false);
template('common/header');
?>
<div id="main-column" class="container-12 clearfix member-center">
<div class="column1 alpha omega form" style="border:none;">
<form action="" method="get">
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>公众号</th>
		<td>
	<select name="account" id="account">
<?php 
	foreach ($list as $row) {
		$timestamp = TIMESTAMP;
		$nonce = salt(5);
		$token = $row['token'];
		$signkey = array($token, TIMESTAMP, $nonce);
		sort($signkey, SORT_STRING);
		$signString = implode($signkey);
		$signString = sha1($signString);
?>
	<option value="api.php?hash=<?php echo $row['hash'] ?>&timestamp=<?php echo $timestamp ?>&nonce=<?php echo $nonce ?>&signature=<?php echo $signString ?>"><?php echo $row['name'] ?>-<?php echo $row['token'] ?></option>
<?php
	}
?>
	</select>
		</td>
	</tr>
	<tr>
        <th>消息类型</th>
        <td>
        	<input type="radio" name="type" value="text" id="type_text" onclick="toggle('text')" /><label for="type_text">&nbsp;文本</label>
			<input type="radio" name="type" value="image" id="type_image" onclick="toggle('image')" /><label for="type_image">&nbsp;图片</label>
			<input type="radio" name="type" value="location" id="type_location" onclick="toggle('location')" /><label for="type_location">&nbsp;位置</label>
			<input type="radio" name="type" value="link" id="type_link" onclick="toggle('link')" /><label for="type_link">&nbsp;链接</label>
			<input type="radio" name="type" value="event" id="type_event" onclick="toggle('event')" /><label for="type_event">&nbsp;菜单</label>
			<input type="radio" name="type" value="subscribe" id="type_subscribe" onclick="toggle('subscribe')" /><label for="type_subscribe">&nbsp;订阅</label>
			<input type="radio" name="type" value="unsubscribe" id="type_unsubscribe" onclick="toggle('unsubscribe')" /><label for="type_unsubscribe">&nbsp;取消订阅</label>
		</td>
	</tr>
	<tr>
        <th>发送用户</th>
        <td>
        	<input type="text" id="fromuser" value="fromUser" class="txt grid-4 alpha pin" />
		</td>
	</tr>
	<tr>
        <th>接收用户</th>
        <td>
        	<input type="text" id="touser" value="toUser" class="txt grid-4 alpha pin" />
		</td>
	</tr>
	<tr>
		<td colspan="2" id="content">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" id="content_text">
				<tr>
        			<th>内容</th>
        			<td><textarea id="contentvalue" rows="5" cols="50">测试内容</textarea></td>
        		</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" id="content_image">
				<tr>
        			<th>图片</th>
        			<td><input type="text" id="picurl" value="http://www.baidu.com/img/bdlogo.gif" class="txt grid-4 alpha pin" /></td>
        		</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" id="content_location">
				<tr>
        			<th>X坐标</th>
        			<td><input type="text" id="location_x" class="txt grid-4 alpha pin" value="23.134521" /></td>
        		</tr>
        		<tr>
        			<th>Y坐标</th>
        			<td><input type="text" id="location_y" class="txt grid-4 alpha pin" value="113.358803" /></td>
        		</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" id="content_link">
				<tr>
        			<th>链接</th>
        			<td><input type="text" id="url" class="txt grid-4 alpha pin" value="http://baidu.com" /></td>
        		</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" id="content_event">
				<tr>
        			<th>EventKey</th>
        			<td><input type="text" id="event_key" class="txt grid-4 alpha pin" value="EVENTKEY" /></td>
        		</tr>
			</table>
		</td>
	</tr>
	<tr>
        <th>发送消息</th>
        <td>
        	<textarea id="sendxml" rows="10" cols="50"></textarea>	
		</td>
	</tr>
	<tr>
        <th>接收消息</th>
        <td id="receive"></td>
	</tr>
	<tr>
		<th></th>
		<td>
		<input name="submit" type="button" onclick="submitform()" value="提交" class="mt10 btn grid-2 alpha" />
		</td>
	</tr>
	</table>
</form>
</div>
</div>
<script type="text/javascript">
	var curtype = 'text';
	function toggle(type) {
		curtype = type;
		$('#content table').css('display', 'none');
		if ($('#content_'+type)[0]) {
			$('#content_'+type).css('display', 'block');
		}
		buildRequest(type);
	}
	function buildRequest(type) {
		xml = 	"<xml>\n"+
				"<ToUserName><![CDATA["+$('#touser').val()+"]]></ToUserName>\n"+
			 	"<FromUserName><![CDATA["+$('#fromuser').val()+"]]></FromUserName>\n"+
			 	"<CreateTime>"+Math.round(new Date().getTime()/1000)+"</CreateTime>\n";
		if (type == 'text') {
			xml += "<MsgType><![CDATA[text]]></MsgType>\n";
			xml += "<Content><![CDATA["+$('#contentvalue').val()+"]]></Content>\n";
		} else if (type == 'image') {
			xml += "<MsgType><![CDATA[image]]></MsgType>\n";
			xml += "<PicUrl><![CDATA["+$('#picurl').val()+"]]></PicUrl>";
		} else if (type == 'location') {
			xml += "<MsgType><![CDATA[location]]></MsgType>\n";
			xml += "<Location_X>"+parseFloat($('#location_x').val())+"</Location_X>\n";
			xml += "<Location_Y>"+parseFloat($('#location_y').val())+"</Location_Y>\n";
			xml += "<Scale>20</Scale>\n";
			xml += "<Label><![CDATA[位置信息]]></Label>\n";
		} else if (type == 'link') {
			xml += "<MsgType><![CDATA[link]]></MsgType>\n";
			xml += "<Title><![CDATA[测试链接]]></Title>\n";
			xml += "<Description><![CDATA[测试链接描述]]></Description>\n";
			xml += "<Url><![CDATA["+$('#url').val()+"]]></Url>\n";
		} else if (type == 'subscribe') {
			xml += "<MsgType><![CDATA[event]]></MsgType>\n";
			xml += "<Event><![CDATA[subscribe]]></Event>\n";
			xml += "<EventKey><![CDATA[]]></EventKey>\n";
		} else if (type == 'unsubscribe') {
			xml += "<MsgType><![CDATA[event]]></MsgType>\n";
			xml += "<Event><![CDATA[unsubscribe]]></Event>\n";
			xml += "<EventKey><![CDATA[]]></EventKey>\n";
		} else if (type == 'event') {
			xml += "<MsgType><![CDATA[event]]></MsgType>\n";
			xml += "<Event><![CDATA[CLICK]]></Event>\n";
			xml += "<EventKey><![CDATA["+$('#event_key').val()+"]]></EventKey>\n";
		}
		xml +=  "<MsgId>1234567890123456</MsgId>\n"+
		 		"</xml>";
 		$('#sendxml').val(xml);
	}
	function submitform() {
		buildRequest(curtype);
		$.ajax($('#account').val(), {
			type : 'POST',
			headers : {"Content-type" : "text/xml"},
			data : $('#sendxml').val().replace(/[\r\n]/g,""),
			beforeSend : function(){$('#receive').text('加载中。。。');}
		}).done(function(s){
			$('#receive').text(s);
		})
	}
	toggle(curtype);
</script>
<?php template('common/footer'); ?>
