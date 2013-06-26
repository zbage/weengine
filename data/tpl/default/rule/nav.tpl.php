<?php defined('IN_IA') or exit('Access Denied');?><div class="area hot-tag">
    <h5>系统回复</h5>
    <ul>
        <li<?php echo $nav['system'];?>><a href="<?php echo create_url('rule/system')?>">管理回复</a></li>
    </ul>
</div>
<div class="area hot-tag">
    <h5>自定义回复</h5>
    <ul>
        <li<?php echo $nav['display'];?>><a href="<?php echo create_url('rule/display')?>">管理规则</a></li>
        <?php if(!empty($id)) { ?><li<?php echo $nav['post'];?>><a href="<?php echo create_url('rule/post', array('id' => $id))?>">编辑规则</a></li><?php } ?>
        <li<?php if(empty($id)) { ?><?php echo $nav['post'];?><?php } ?>><a href="<?php echo create_url('rule/post')?>">添加规则</a></li> 
    </ul>
</div>
