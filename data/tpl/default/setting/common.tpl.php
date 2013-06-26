<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
    <div id="main-column" class="container-12 clearfix member-center">
        <div class="column2 grid-3 alpha omega">
            <?php include template('setting/nav', TEMPLATE_INCLUDEPATH);?>
        </div>
        <div class="column1 grid-10 alpha omega modules">
            <div class="form">
            	<div class="form_h">
            		<h6>系统信息</h6>
				</div>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<th>版本号</th>
                    <td>
						<?php echo IMS_VERSION;?> - <?php echo IMS_RELEASE_DATE;?>
					</td>
				</tr>
                </table>
           	 <form action="" method="post">
             	<div class="form_h">
            		<h6>统计分析</h6>
				</div>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<th>开启历史消息记录</th>
                    <td>
						<input type="radio" name="msg_history" value="1" id="msg_history_1" <?php if($category['enabled'] == '1') { ?>checked="true"<?php } ?>><label for="msg_history_1">是</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="msg_history" value="0" id="msg_history_0"  <?php if($category['enabled'] == '0') { ?>checked="true"<?php } ?>><label for="msg_history_0">否</label>
						<div class="notice">开启此项后，系统将记录用户与系统的往来消息记录。</div>
					</td>
				</tr>
                <tr>
                	<th>历史消息记录天数</th>
                    <td>
						<input type="text" name="msg_maxday" class="txt grid-4 alpha pin" value="<?php echo $category['name'];?>" />
						<div class="notice">设置保留历史消息记录的天数，为0则为保留全部。</div>
					</td>
				</tr>
                <tr>
                	<th>开启规则利用率统计</th>
                    <td>
						<input type="radio" name="rule_use" value="1" id="rule_use_1" <?php if($category['enabled'] == '1') { ?>checked="true"<?php } ?>><label for="rule_use_1">是</label>&nbsp;&nbsp;&nbsp;<input type="radio" name="rule_use" value="0" id="rule_use_0"  <?php if($category['enabled'] == '0') { ?>checked="true"<?php } ?>><label for="rule_use_0">否</label>
						<div class="notice">开启此项后，系统将记录用户与系统的往来消息记录。</div>
					</td>
				</tr>
                <tr>
                    <th></th>
                    <td>
                        <input name="submit" type="submit" value="提交" class="mt10 btn grid-2 alpha" />
                        <input type="hidden" name="token" value="<?php echo $_W['token'];?>" />
                    </td>
                </tr>
                </table>
                <div class="form_h">
            		<h6>系统锁操作</h6>
				</div>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<th>删除升级锁</th>
                    <td>
						<input name="bae_delete_update" type="submit" value="删除" class="btn grid-2 alpha" />
						<div class="notice">升级“微擎”系统时，需要先删除升级锁，确保升级正常进行。</div>
					</td>
				</tr>
                <tr>
                	<th>删除安装锁</th>
                    <td>
						<input name="bae_delete_install" type="submit" value="删除" class="btn grid-2 alpha" />
						<div class="notice">重新安装“微擎”系统时，需要先删除安装锁。</div>
					</td>
				</tr>
                </table>
            </form>
            </div>
        </div>
    </div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>