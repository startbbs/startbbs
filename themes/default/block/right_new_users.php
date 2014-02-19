<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">最新会员</h3>
    </div>
    <div class="panel-body">
    <ul class="list-inline user_list">
    <?php if(isset($new_users)) foreach($new_users as $v){?>
        <li>
            <a href="<?php echo site_url('user/info/'.$v['uid']);?>" class="profile_link" title="<?php echo $v['username'];?>">
<?php if($v['avatar']) {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url($v['avatar']);?>" />
<?php } else {?>
<img alt="<?php echo $v['username'];?> medium avatar" class="medium_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>" />
<?php }?>
</a>
        </li>
<?php }?>
    </ul>
    </div>
</div>
