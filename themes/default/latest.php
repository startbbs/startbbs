<!DOCTYPE html>
<html>
 <head>
  <title>Latest Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('common/header-meta')?>
 </head>
 <body style="background: #fff;">
 <?php foreach($list as $key=>$v){ ?>
 <?php if (($key%2) == 0){ ?>
<div class='cell comment_header text-muted' style="margin: 5px 0;">
<?php } else { ?>
<div class='cell text-muted'>
<?php } ?>
<div class='pull-right timeago'>
<?php echo $this->myclass->friendly_date($v['addtime'])?>
</div>
<?php echo $v['rname']?>
回复了
<a href="http://www.startbbs.com/user/profile/<?php echo $v['uid']; ?>" class="startbbs profile_link" title="admin" target="_blank"><?php echo $v['username']; ?></a>
创建的话题
<span class='chevron'>>></span>
<a href="http://www.startbbs.com/topic/show/<?php echo $v['topic_id']; ?>" class="startbbs" target=_blank><?php echo $v['title']; ?></a>
</div>
<?php } ?>
 </body>
</html>
