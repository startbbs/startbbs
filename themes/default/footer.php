<div id='footer'>
<div class='container' id='footer-main'>
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
<div class='copywrite'>
<!--<div class="fr"> <a href="" target="_blank"><img src="" border="0" alt="Linode" width="120"></a></div>
<p>&copy; 2013 StartBBS Inc, Some rights reserved.</p>
</div>-->
<small class='text-muted'>
<?php echo $settings['site_name']?>  <?php echo $settings['site_stats']?>
<p>Powered by <a href="<?php echo $this->config->item('sys_url');?>" class="text-muted" target="_blank"><?php echo $this->config->item('sys_name');?></a>
<?php echo $this->config->item('sys_version');?> 2013-2014 Some rights reserved 页面执行时间:  {elapsed_time}s</p>
</small>
</div>
</div>

</body></html>