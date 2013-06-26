<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
    <h5>系统设置</h5>
    <ul>
		<li<?php echo $nav['profile'];?>><a href="<?php echo create_url('setting/profile')?>">账户设置</a></li>
    	<li<?php echo $nav['display'];?> <?php if($do == 'setting') { ?>class="current"<?php } ?>><a href="<?php echo create_url('setting/display')?>">模块管理</a></li>
		<li<?php echo $nav['common'];?>><a href="<?php echo create_url('setting/common')?>">全局管理</a></li>
        <li<?php echo $nav['settingcategory'];?>><a href="<?php echo create_url('setting/category')?>">分类管理</a></li>
    </ul>
    <h5>工具</h5>
    <ul>
		<li<?php echo $nav['settingupdatecache'];?>><a href="<?php echo create_url('setting/updatecache')?>">更新缓存</a></li>
    </ul>
</div>