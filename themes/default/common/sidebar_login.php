<?php if($this->session->userdata('uid')){ ?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <a href="<?php echo site_url('user/profile/'.$myinfo['uid']);?>"><img alt="<?php echo $myinfo['username']?> large avatar" class="img-rounded" src="<?php echo base_url($myinfo['avatar'].'big.png')?>" /></a>
            </div>
            <div class="col-md-7">
	            <ul class="list-unstyled">
	            	<li><a href="<?php echo site_url('user/profile/'.$myinfo['uid']);?>" title="<?php echo $myinfo['username']?>"><?php echo $myinfo['username']?></a></li>
	            	<li>用户组：<?php echo $myinfo['group_name']?></li>
	            	<li>积分：<?php echo $myinfo['credit']?></li>
	            </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-center">
	            <p><a href="<?php echo site_url('favorites');?>"><?php echo $myinfo['favorites']?></a></p>
	            <p><a href="<?php echo site_url('favorites');?>">话题收藏</a></p>
            </div>
            <div class="col-md-6">
	            <p><a href="<?php echo site_url('follow');?>"><?php echo $myinfo['follows']?></a></p>
	            <p><a href="<?php echo site_url('follow');?>">特别关注</a></p>
            </div>
        </div>
    </div>
    <div class="panel-footer text-muted">
		<?php if($myinfo['notices']){?>
		<img align="top" alt="Dot_orange" class="icon" src="<?php echo base_url('static/common/images/dot_orange.png');?>" />
		<a href="<?php echo site_url('notifications');?>"><?php echo $myinfo['notices']?> 条未读提醒</a>
		<?php } else{?>
		暂无提醒
		<?php }?>
	</div>
</div>
<?php } else {?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?php echo $settings['site_name']?></h4>
    </div>
    <div class="panel-body">
        <a href="<?php echo site_url('user/register');?>" class="btn btn-default">现在注册</a> 已注册请
<a href="<?php echo site_url('user/login');?>" class="startbbs">登入</a>
    </div>
</div>
<?php }?>