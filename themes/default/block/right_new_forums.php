<div class='box'>
<div class='box-header'>
最新贴子
</div>
<div class='inner'>
<ul class="unstyled">
<?php if(isset($new_forums)) foreach($new_forums as $v){?>
<li><a href="<?php echo site_url('forum/view/'.$v['fid']);?>" class="startbbs"><?php echo sb_substr($v['title'],14);?></a> <span class="fr gray"><?php echo $this->myclass->friendly_date($v['updatetime']);?></span></li>
<?php }?>
</ul>
</div>
</div>