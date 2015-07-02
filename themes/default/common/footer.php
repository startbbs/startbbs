<footer class="small">
	<div class="container">
		<div class="row">
			<?php if($page_links){?>
			<ul class="list-inline">
			<?php foreach($page_links as $key=>$v){?>
			<?php if($v['go_url']){?>
			<li><a href="<?php echo $v['go_url'];?>" target=_blank><?php echo $v['title'];?></a></li>
			<?php } else{?>
			<li><a href="<?php echo site_url('page/index/'.$v['pid']);?>"><?php echo $v['title'];?></a></li>
			<?php }?>
			 <?php }?>
			</ul>
			<?php }?>
			<p><?php echo $settings['site_name']?>  <?php echo $settings['site_stats']?></p>
			<p>Powered by <a href="<?php echo $this->config->item('sys_url');?>" class="text-muted" target="_blank"><?php echo $this->config->item('sys_name');?></a>
<?php echo $this->config->item('sys_version');?> 2013-2014 Some rights reserved 页面执行时间:  {elapsed_time}s</p>
		</div>
	</div>
</footer>
<script src="<?php echo base_url('static/common/js/bootstrap.min.js')?>"></script>