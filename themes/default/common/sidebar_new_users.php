<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">最新会员</h3>
    </div>
    <div class="panel-body">
		<ul class='user-list clearfix'>
		<?php if($new_users) foreach($new_users as $v){?>
		<li>
		<a href="<?php echo site_url('user/profile/'.$v['uid']);?>"  title="<?php echo $v['username'];?>">
		<img class="img-rounded" alt="<?php echo $v['username'];?>" src="<?php echo base_url($v['avatar'].'normal.png');?>" />
		</a></li>
		<?php }?>
		</ul>
    </div>
</div>