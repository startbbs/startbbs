<footer id='footer'>
<div class='container' id='footer-main'>
<div class="pull-left">
<ul class='page-links list-inline'>
<?php if($page_links){?>
<?php foreach($page_links as $key=>$v){?>
<?php if($v['go_url']){?>
<li><a href="<?php echo $v['go_url'];?>" class="dark nav" target=_blank><?php echo $v['title'];?></a></li>
<?php } else{?>
<li><a href="<?php echo site_url('page/index/'.$v['pid']);?>" class="dark nav"><?php echo $v['title'];?></a></li>
<?php }?>
<?php if($key!=10){?>
<li class='snow'>·</li>
<?php }?>
<?php }?>
<?php }?>
</ul>
<p><?php echo $settings['site_name']?>  <?php echo $settings['site_stats']?></p>
<p>Powered by <a href="<?php echo $this->config->item('sys_url');?>" class="text-muted" target="_blank"><?php echo $this->config->item('sys_name');?></a>
<?php echo $this->config->item('sys_version');?> 2013-2014 Some rights reserved 页面执行时间:  {elapsed_time}s</p>
</div>
</div>
</footer>
<script type="text/javascript" src="<?php echo base_url('static/common/js/bootstrap.js');?>"></script>
</body>
</html>