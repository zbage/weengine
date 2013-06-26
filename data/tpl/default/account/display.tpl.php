<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script type="text/javascript" src="./resource/script/jquery.zclip.min.js"></script>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('account/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega">
            <div class="list">
				<?php if(is_array($list)) { foreach($list as $row) { ?>
            	<div class="account_item clearfix">
                	<div class="account_content clearfix">
                    	<div class="data fl"><?php echo $row['name'];?> <span style="font-size:12px;">（微信号：<?php echo $row['account'];?>）</span></div>
                        <div class="fr">
                        <a href="<?php echo create_url('account/switch', array('id' => $row['weid']))?>">切换</a>
                        &nbsp;
                        <a href="<?php echo create_url('account/post', array('id' => $row['weid']))?>">编辑</a>
                        &nbsp;
						<a onclick="return confirm('删除帐号将同时删除全部规则及回复，确认吗？');return false;" href="<?php echo create_url('account/delete', array('id' => $row['weid']))?>">删除</a>
                        </div>
                    </div>
                    <div class="account_desc clearfix" style="height:auto;">
                        <div id="api_<?php echo $row['weid'];?>"><label>API地址：</label><span><input type="text" value="<?php echo $_W['siteroot'];?>api.php?hash=<?php echo $row['hash'];?>" /><button class="btn">复制</button></span></div> 
                        <div id="token_<?php echo $row['weid'];?>"><label>Token：</label><span><input type="text" value="<?php echo $row['token'];?>" /><button class="btn">复制</button></span></div> 
                    </div>
                </div>
				<script type="text/javascript">
					$(function() {
						$("#api_<?php echo $row['weid'];?> button").zclip({
							path:'./resource/script/ZeroClipboard.swf',
							copy:$('#api_<?php echo $row['weid'];?> input').val()
						});
						$("#token_<?php echo $row['weid'];?> button").zclip({
							path:'./resource/script/ZeroClipboard.swf',
							copy:$('#token_<?php echo $row['weid'];?> input').val()
						});
					});
				</script>
				<?php } } ?>
            </div>
        </div>
    </div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
