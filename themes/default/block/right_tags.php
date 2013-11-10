<div class='box'>
<div class='box-header'>
最新标签
</div>
<div class='inner'>
<?php if($taglist){?>
<ul class="list_unstyled"">
<?php foreach($taglist as $v){?>
	<span class="tags"><a href="<?php echo site_url('tag/index/'.$v['tag_title']);?>"><?php echo $v['tag_title'];?></a></span>
<?php }?>
</ul>
<?php }?>
</div>
</div>