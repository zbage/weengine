<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('setting/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega modules">
            <div class="list">
				<?php if(is_array($mymodules)) { foreach($mymodules as $row) { ?>
            	<div class="module_item clearfix<?php if(!$row['enabled']) { ?> disabled<?php } ?>">
                    <div class="module_content clearfix">
                    	<div class="data fl"><?php echo $row['title'];?><span style="font-size:12px;">（标识：<?php echo $row['name'];?>）</span></div>
                        <div class="fr">
                        <?php if($row['enabled']) { ?>
                        <?php if(!$row['issystem']) { ?>
							优先级：
							<select onchange="ajaxopen('<?php echo create_url('setting/module/displayorder', array('mid' => $row['mid']))?>&displayorder=' + this.options[this.selectedIndex].value)">
                            	<option <?php if($row['displayorder'] == 0) { ?> selected="selected"<?php } ?> value="0">默认级别</option>
								<option <?php if($row['displayorder'] == 1) { ?> selected="selected"<?php } ?>value="1">1</option>
								<option <?php if($row['displayorder'] == 2) { ?> selected="selected"<?php } ?>value="2">2</option>
								<option <?php if($row['displayorder'] == 3) { ?> selected="selected"<?php } ?>value="3">3</option>
								<option <?php if($row['displayorder'] == 4) { ?> selected="selected"<?php } ?>value="4">4</option>
								<option <?php if($row['displayorder'] == 5) { ?> selected="selected"<?php } ?>value="5">5</option>
							</select>
                        <?php } else { ?>
                        系统模块始终优先
                        <?php } ?>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="module_desc clearfix" style="height:auto;line-height:25px;">
						<div class="module_m">
							<div class="fl">
								<?php echo $row['ability'];?>
							</div>
							<div class="fr">
                            	<?php if($row['issettings']) { ?><a href="<?php echo create_url('setting/module/setting', array('mid' => $row['mid']))?>">设置</a><?php } ?>
								<a href="###" id="description_button_<?php echo $row['mid'];?>" status="1" onclick="toggle_description(this.id);return false;">介绍</a>
								<span>
								<?php if($row['enabled']) { ?>
								<a id="enabled_<?php echo $row['mid'];?>_0" href="<?php echo create_url('setting/module/enable', array('mid' => $row['mid'], 'enabled' => 0))?>" onclick="return ajaxopen(this.href, function(){toggle(0, '<?php echo $row['mid'];?>')});">禁用</a>
								<?php } else { ?>
								<a id="enabled_<?php echo $row['mid'];?>_1" href="<?php echo create_url('setting/module/enable', array('mid' => $row['mid'], 'enabled' => 1))?>" onclick="return ajaxopen(this.href, function(){toggle(1, '<?php echo $row['mid'];?>')});">启用</a>
								<?php } ?>
								</span>
							</div>
						</div>
						<div class="module_description">
							<span class="fl"><span style="font-weight:bold;">功能介绍：</span><?php echo $row['description'];?></span>
						</div>
                        <!--table>
                            <tr>
                                <td width="80">模块标识</td>
                                <td><?php echo $row['name'];?></td>
                            </tr>
                            <tr>
                                <td>模块名称</td>
                                <td><?php echo $row['title'];?></td>
                            </tr>
                            <tr>
                                <td>功能描述</td>
                                <td><?php echo $row['ability'];?></td>
                            </tr>
                            <tr>
                                <td>功能介绍</td>
                                <td><?php echo $row['description'];?></td>
                            </tr>
                            <?php if(is_array($row['settings'])) { ?>
                            <tr>
                                <td>配置选项</td>
                                <td>
                                    <?php if(is_array($row['settings'])) { foreach($row['settings'] as $name => $title) { ?>
                                        <a href="<?php echo $name;?>"><?php echo $title;?></a> <br />
                                    <?php } } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table-->
                    </div>
                </div>
				<?php } } ?>
            </div>
			<div>
				<?php echo $pager;?>
			</div>
        </div>
    </div>
    <script type="text/javascript">
        function toggle(status, id) {
            var container = $('#enabled_'+id+'_'+status).parent().parent().parent().parent().parent();
			if(status) {
				container.removeClass('disabled');
				//container.find('.desc').slideDown('normal');
				$('#enabled_'+id+'_'+status).parent().html('<a id="enabled_'+id+'_0" href="setting.php?act=module&do=enable&mid='+id+'&enabled=0" onclick="return ajaxopen(this.href, function(){toggle(0, \''+id+'\')});">禁用</a>');
			} else {
				container.addClass('disabled');
				//container.find('.desc').slideUp('normal');
				$('#enabled_'+id+'_'+status).parent().html('<a id="enabled_'+id+'_1" href="setting.php?act=module&do=enable&mid='+id+'&enabled=1" onclick="return ajaxopen(this.href, function(){toggle(1, \''+id+'\')});">启用</a>');
			}
        }
		function toggle_description(id) {
			var container = $('#'+id).parent().parent().parent();
			var status = $('#'+id).attr("status");
			if(status == 1) {
				$('#'+id).attr("status", "0")
				container.find(".module_description").show();
			} else {
				$('#'+id).attr("status", "1")
				container.find(".module_description").hide();
			}
        }
    </script>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>