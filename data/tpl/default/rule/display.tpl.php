<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
	<script>
	$(function() {
		$(".rule_desc:first").show();
		$(".list").delegate(".rule_item", "hover", function(){
			$(".rule_desc").each(function() { $(this).hide(); });
			$(this).find(".rule_desc").toggle();
		});
	});
	</script>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('rule/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega">
			<div class="floattop">
				<ul>
					<?php if(is_array($mymodule)) { foreach($mymodule as $row) { ?>
					<li><a href="<?php echo create_url('rule/display', array('module' => $row['name']))?>" <?php if($row['name']==$module) echo 'class=current';?>><?php echo $row['title'];?></a></li>
					<?php } } ?>
				</ul>
			</div>
            <div class="list">
				<?php if(is_array($list)) { foreach($list as $row) { ?>
            	<div class="rule_item clearfix">
                	<div class="rule_content clearfix">
                    	<div class="data fl"><?php echo $row['name'];?> <span style="font-size:12px;">（<?php echo $_W['setting']['modules'][$row['module']]['title'];?>）</span></div>
                        <div class="fr">
						设置为：[
						<?php if($wechat['defaultrid'] == $row['id']) { ?><a href="<?php echo create_url('rule/system/cancel', array('type' => 'default'))?>" onclick="ajaxopen(this.href, message);return false;" style="color:#FF3300">取消默认回复</a><?php } else { ?><a href="<?php echo create_url('rule/system/set', array('id' => $row['id'], 'type' => 'default'))?>" onclick="ajaxopen(this.href, message);return false;">默认回复</a><?php } ?>
						]&nbsp;[
						<?php if($wechat['welcomerid'] == $row['id']) { ?><a href="<?php echo create_url('rule/system/cancel', array('type' => 'welcome'))?>" onclick="ajaxopen(this.href, message);return false;" style="color:#FF3300">取消欢迎信息</a><?php } else { ?><a href="<?php echo create_url('rule/system/set', array('id' => $row['id'], 'type' => 'welcome'))?>" onclick="ajaxopen(this.href, message);return false;">欢迎信息</a><?php } ?>]
						&nbsp;&nbsp;
                        <a href="<?php echo create_url('rule/post', array('id' => $row['id']))?>">编辑/查看</a>
                        &nbsp;
						<a onclick="return confirm('删除规则将同时删除关键字与回复，确认吗？');return false;" href="<?php echo create_url('rule/delete', array('id' => $row['id'], 'type' => 'rule'))?>">删除</a>
                        </div>
                    </div>
                    <div class="rule_desc clearfix" style="height:auto;line-height:25px;">
                        <?php if(is_array($row['keywords'])) { foreach($row['keywords'] as $kw) { ?>
                       <span class="rule_kw"> <?php echo $kw['content'];?></span>
                        <?php } } ?>
                    </div>
                </div>
				<?php } } ?>
            </div>
			<div>
				<?php echo $pager;?>
			</div>
        </div>
    </div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
