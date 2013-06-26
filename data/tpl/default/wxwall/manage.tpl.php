<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('account/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega">
			<div class="floattop">
				<div class="fr" style="color:red;">当前在线人数：<?php echo $onlinemember;?></div>
				<?php if($_W['uid']) { ?>
				<ul>
					<li><a href="<?php echo create_url('index/module', array('do' => 'manage', 'name' => 'wxwall', 'id' => $id, 'isshow' => 0))?>">待审核</a></li>
					<li><a href="<?php echo create_url('index/module', array('do' => 'manage', 'name' => 'wxwall', 'id' => $id, 'isshow' => 1))?>">已审核</a></li>
					<li><a href="">黑名单</a></li>
				</ul>
				<?php } ?>
			</div>
            <div class="form wxwallManage">
                <form action="" method="post" onsubmit="">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr class="listHead">
					<td style="width:40px; padding-left:5px;">选择</td>
					<td>消息</td>
					<td style="width:100px;">时间</td>
					<td style="width:110px;">操作</td>
				</tr>
				<?php if(is_array($list)) { foreach($list as $row) { ?>
				<tr class="list" id="list">
					<th><?php if($_W['uid']) { ?><input type="checkbox" name="select[]" value="<?php echo $row['id'];?>" /><?php } ?></th>
					<td>
						<img src="http://www.we7.cc/bbs/uc_server/images/noavatar_middle.gif" class="avatar" />
						<div class="mainContent">
							<div class="nickname">测试用户名</div>
							<?php echo $row['content'];?>
						</div>
					</td>
					<td style="font-size:12px; color:#666;">
						<div style="margin-bottom:10px;"><?php echo date('Y-m-d', $row['createtime']);?></div>
						<div><?php echo date('h:i:s', $row['createtime']);?></div>
					</td>
					<td>
						<div class="manageBtn">
							<input type="submit" name="verify" value="审核" class="btn alpha" />
							<input type="submit" name="delete" value="删除" class="btn alpha" />
						</div>
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