<?php defined('IN_IA') or exit('Access Denied');?><?php include template('common/header', TEMPLATE_INCLUDEPATH);?>
<div id="main-single" class="container-12 horizontal">
    <div class="message clearfix <?php echo $type;?>">
		<div class="icon fl"></div>
		<div class="fl grid-8">
			<h6><?php echo $msg;?></h6>
			<?php if($redirect) { ?>
			<p><a href="<?php echo $redirect;?>">如果你的浏览器没有自动跳转，请点击此链接</a></p>
			<script type="text/javascript">
				setTimeout(function () {
					window.top.location.href = "<?php echo $redirect;?>";
				}, 3000);
			</script>
			<?php } else { ?>
			<p>[<a href="javascript:history.go(-1);">点击这里返回上一页</a>] &nbsp; [<a href="./?refresh">首页</a>]</p>
			<?php } ?>
		</div>
    </div>
</div>
<?php include template('common/footer', TEMPLATE_INCLUDEPATH);?>
