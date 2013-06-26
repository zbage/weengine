<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('stat/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega">
			<div class="floattop">
				<ul>
					<li><a <?php if($_GPC['searchtype'] == 'today') { ?>class="current"<?php } ?> href="<?php echo create_url('stat/history/display', array('searchtype' => 'today'))?>">今日</a></li>
					<li><a <?php if($_GPC['searchtype'] == 'default') { ?>class="current"<?php } ?> href="<?php echo create_url('stat/history/display', array('searchtype' => 'default'))?>">默认回复</a></li>
					<li><a <?php if($_GPC['searchtype'] == 'all') { ?>class="current"<?php } ?> href="<?php echo create_url('stat/history/display', array('searchtype' => 'all'))?>">全部</a></li>
				</ul>
			</div>
            <div class="form wxwallManage">
                <form action="" method="post" onsubmit="">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr class="listHead">
                        <td style="width:40px; padding-left:5px;">选择</td>
                        <td>内容</td>
                        <td style="width:100px;">回复规则</td>
                         <td>回复类型</td>
                        <td style="width:100px;">时间</td>
                        <td style="width:110px;">操作</td>
                    </tr>
                    <?php if(is_array($list)) { foreach($list as $row) { ?>
                    <tr class="list" id="list">
                        <th><input type="checkbox" name="select[]" value="<?php echo $row['id'];?>" /></th>
                        <td><?php echo $row['message'];?></td>
                        <td><a target="_blank" href="<?php echo create_url('rule/post', array('id' => $row['rid']))?>"><?php echo cutstr($rules[$row['rid']]['name'], 12)?></a></td>
                        <td><?php echo $row['module'];?></td>
                        <td style="font-size:12px; color:#666;">
                            <div style="margin-bottom:10px;"><?php echo date('Y-m-d', $row['createtime']);?></div>
                            <div><?php echo date('h:i:s', $row['createtime']);?></div>
                        </td>
                        <td>
                       		<a href="#">删除</a>
                        </td>
                    </tr>
                    <?php } } ?>
                    <tr>
                        <th><img src="./resource/image/arrow_ltr.png" /></th>
                        <td>
                            <input type="button" value="全选" class="btn alpha" onclick="_select('.list', 0);" />
                            <input type="button" value="反选" class="btn alpha" onclick="_select('.list', 1);" />
                            <input type="button" value="取消" class="btn alpha" onclick="_select('.list', 2);" />
                            <input type="submit" name="verify" value="审核" class="btn alpha" />
                            <input type="submit" name="delete" value="删除" class="btn alpha" />
                            <input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
                        </td>
                    </tr>
				</table>
                </form>
            </div>
			<?php echo $pager;?>
        </div>
    </div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>