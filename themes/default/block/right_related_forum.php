<?php if(isset($related_forum_list)){?>
<div class="panel panel-default">
<div class='panel-heading'>
<h3 class="panel-title">相关话题</h3>
</div>
<div class="panel-body">
<ul class="list-unstyled">
<?php foreach($related_forum_list as $v){?>
<li><a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="text-muted"><?php echo sb_substr($v['title'],20)?></a></li>
<?php }?>
</ul>
</div>
</div>
<?php }?>