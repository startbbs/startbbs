<!DOCTYPE html>
<html>
<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?> - <?php echo $settings['site_name'];?></title>
<?php echo $this->load->view('header-meta');?>
</head>
<body id="startbbs">

<?php echo $this->load->view('header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8' class="clearfix">

<div class='box'>
<div class='cell' style="border-bottom-style: none;">
<a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> 设置
    <ul class="nav nav-tabs" style="margin-top:10px;">
    <li>
    <a href="<?php echo site_url('settings/profile');?>">个人信息</a>
    </li>
    <li class="active"><a href="#">头像</a></li>
    <li><a href="<?php echo site_url('settings/password');?>">修改密码</a></li>
    </ul>
</div>

	<div class="inner">
		<form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url('settings/avatar')?>" method="post">
  			<fieldset>
    			<div class="form-group">
      				<label class="col-sm-3 control-label">当前头像</label>
      				<div class="col-sm-8">
      					<p>
      					<?php if ($user['avatar']){?>
      						<img class="large_avatar" src="<?php echo base_url($avatars['big']); ?>"/>
      						<img class="middle_avatar" src="<?php echo base_url($avatars['middle']); ?>"/>
      						<img class="small_avatar" src="<?php echo base_url($avatars['small']); ?>"/>
      					<?php } else {?>
							<img class="large_avatar" src="<?php echo base_url('uploads/avatar/avatar_large.jpg');?>"/>
      						<img class="middle_avatar" src="<?php echo base_url('uploads/avatar/default.jpg');?>"/>
      						<img class="small_avatar" src="<?php echo base_url('uploads/avatar/avatar_small.jpg');?>"/>
      					<?php }?>
      					</p>
      					
       					<p class="alert alert-info">
       						<strong>注意</strong> 支持 500k 以内的 PNG / GIF / JPG 图片文件作为头像，推荐使用正方形的图片以获得最佳效果。
	      				</p>
      				</div>
    			</div>
    			
    			<div class="form-group">
      				<label class="col-sm-3 control-label" for="avatar_file">选择图片</label>
      				<div class="col-sm-5">
       					<input type="file" id="avatar_file" name="userfile" />
      				</div>
    			</div>
    			
    			<div class="form-group">
	    			<div class="col-sm-offset-3 col-sm-9">
    				<button type="submit" name="upload" class="btn btn-sm btn-primary">上传新头像</button>
    				</div>
    			</div>
    		</fieldset>
    	</form>
	</div>
	
</div>
</div>

<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('block/right_login')?>
<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view('footer');?>