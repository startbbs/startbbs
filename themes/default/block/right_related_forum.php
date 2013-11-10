<?php if(isset($related_forum_list)){?>
<div class="box">
<div class='box-header'>
相关话题
</div>
<div class="infolist">
<ul>
<?php foreach($related_forum_list as $v){?>
<li><a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="text-muted"><?php echo sb_substr($v['title'],20)?></a></li>
<?php }?>
</ul>
</div>
</div>
<?php }?>