<!DOCTYPE html>
<html>
<head>
<meta content='<?php echo $title?> - ' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title?>- <?php echo $settings['site_name']?></title>
<?php $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php $this->load->view('common/header');?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">最新会员</h3>
                    </div>
                    <div class="panel-body">
						<ul class='user-list clearfix'>
						<?php if($new_users) foreach($new_users as $v){?>
						<li>
						<a href="<?php echo site_url('user/profile/'.$v['uid']);?>" title="<?php echo $v['username'];?>">
						<img class="img-rounded" alt="<?php echo $v['username'];?>" src="<?php echo base_url($v['avatar'].'normal.png');?>" />
						</a></li>
						<?php }?>
						</ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">活跃会员</h3>
                    </div>
                    <div class="panel-body">
						<ul class='user-list clearfix'>
						<?php if($hot_users) foreach($hot_users as $v){?>
						<li>
						<a href="<?php echo site_url('user/profile/'.$v['uid']);?>"  title="<?php echo $v['username'];?>">
						<img class="img-rounded" alt="<?php echo $v['username'];?>" src="<?php echo base_url($v['avatar'].'normal.png');?>" />
						</a></li>
						<?php }?>
						</ul>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

            <div class="col-md-4">
			<?php $this->load->view('common/sidebar_login');?>
			<?php $this->load->view('common/sidebar_ad');?>
            </div><!-- /.col-md-4 -->

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php $this->load->view('common/footer');?>
</body>
</html>