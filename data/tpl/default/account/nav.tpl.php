<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
    <h5>公众号管理</h5>
    <ul>
    	 <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('account/post')?>">添加公众号</a></li>
    	<li<?php if(empty($id)) { ?><?php echo $nav['display'];?><?php } ?>><a href="<?php echo create_url('account/display')?>">管理公众号</a></li>
    </ul>
</div>
