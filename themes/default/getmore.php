<?php if($list) foreach ($list as $v){?>
<div class='cell topic'>
<div class='avatar pull-left'>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username']?>">
<?php if($v['avatar']){?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="<?php echo base_url();?>/<?php echo $v['avatar'];?>"/>
<?php } else{?>
<img alt="<?php echo $v['username']?> medium avatar" class="medium_avatar" src="uploads/avatar/default.jpg" />
<?php }?>
</a>
</div>
<div class='item_title'>
<div class='pull-right'>
<div class='badge badge-info'><?php echo $v['comments']?></div>
</div>
<h2 class='topic_title'>
<a href="<?php echo url('topic_show',$v['topic_id']);?>" class="startbbs topic"><?php echo sb_substr($v['title'],30);?></a>
<?php if( $v['is_top'] == '1' ) echo '<span class="label label-info">置顶</span>'; ?>
</h2>
<div class='topic-meta'>
<a href="<?php echo url('node_show',$v['node_id']);?>" class="node"><?php echo $v['cname']?></a>
<span class='text-muted'>•</span>
<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" class="dark startbbs profile_link" title="<?php echo $v['username']?>"><?php echo $v['username']?></a>
<span class='text-muted'>•</span>
<?php echo $this->myclass->friendly_date($v['updatetime'])?>
<span class='text-muted'>•</span>
<?php if($v['rname']){?>
最后回复来自
<a href="<?php echo site_url('user/profile/'.$v['ruid']);?>" class="startbbs profile_link" title="<?php echo $v['rname']?>"><?php echo $v['rname']?></a>
<?php } else {?>
暂无回复
<?php }?>
</div>
</div>
</div>
<?php } ?>
