<?php if($this->session->userdata('uid')){ ?>
<div class='panel panel-default'>
<div class='panel-body'>
<table>
<tr>
<td valign='top' width='100'>
<a href="<?php echo site_url('user/info/'.$user['uid']);?>" class="profile_link" title="<?php echo $user['username']?>">
<img alt="<?php echo $user['username']?> large avatar" class="large_avatar" src="<?php echo base_url($user['big_avatar'])?>" />
</a>
</td>
<td valign='top' width='10'></td>
<td valign='left' width='auto'>
<div class='profile-link'><a href="<?php echo site_url('user/info/'.$user['uid']);?>" class="startbbs profile_link" title="<?php echo $user['username']?>"><?php echo $user['username']?></a>(<?php echo $group['group_name']?>)</div>
<div class='signature'></div>
</td>
</tr>
</table>
<div class='sep10'></div>
<table width='100%'>
<tr>
<td align='center' class='with_separator' width='34%'>
<a href="<?php echo site_url('favorites');?>" class="dark" style="display: block;">
<span class='bigger'>
<?php echo $users['favorites']?>
</span>
<div class='sep3'></div>
<span class='gray'>话题收藏</span>
</a></td>
<td align='center' width='33%'>
<a href="<?php echo site_url('follow');?>" class="dark" style="display: block;"><span class='bigger'><?php echo $users['follows']?></span>
<div class='sep3'></div>
<span class='gray'>特别关注</span>
</a></td>
</tr>

</table>
</div>
<?php if(!file_exists($user['big_avatar'])){?>
<div class='cell'>
<div class='text-muted alert alert-warn' style='margin-bottom: 0;'>
头像不够个性？
<a class='startbbs' href='<?php echo site_url('settings/avatar');?>'>立刻上传 →</a>
</div>
</div>
<?php }?>
<div class='panel-footer text-muted'>
<?php if($users['notices']){?>
<img align="top" alt="Dot_orange" class="icon" src="<?php echo base_url('static/common/images/dot_orange.png');?>" />
<a href="<?php echo site_url('notifications');?>"><?php echo $users['notices']?> 条未读提醒</a>
<?php } else{?>
暂无提醒
<?php }?>
</div>
</div>
<?php } else {?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $settings['site_name']?>
    </div>
    <div class="panel-body">
        <a href="<?php echo site_url('user/reg');?>" class="btn btn-default">现在注册</a> 已注册用户请
<a href="<?php echo site_url('user/login');?>" class="startbbs">登入</a>
    </div>
</div>
<?php }?>