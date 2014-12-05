<!DOCTYPE html>
<html>
<head>
<meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?> - <?php echo $settings['site_name'];?></title>
<?php echo $this->load->view('common/header-meta');?>
</head>
<body id="startbbs">
<?php echo $this->load->view('common/header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row"><div class='col-xs-12 col-sm-6 col-md-8'>

<div class='box'>
<div class='cell' style="border-bottom-style: none;">
<a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> 设置
    <ul class="nav nav-tabs" style="margin-top:10px;">
    <li class="active">
    <a href="#">个人信息</a>
    </li>
    <li><a href="<?php echo site_url('settings/avatar');?>">头像</a></li>
    <li><a href="<?php echo site_url('settings/password');?>">修改密码</a></li>
    </ul>
</div>

<div class='inner'>
<form accept-charset="UTF-8" action="<?php echo site_url('settings/profile');?>" class="form-horizontal" method="post" novalidate="novalidate">
<input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_token;?>">
<div class="form-group">
<label class="col-sm-3 control-label" for="user_nickname">用户名</label>
<div class="col-sm-5">
<input class="form-control" disabled="disabled" id="user_nickname" name="username" size="50" type="text" value="<?php echo $username?>" />
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_email">电子邮件</label>
<div class="col-sm-5">
<input class="form-control" id="user_email" name="email" size="50" type="email" value="<?php echo $email?>" />
<span class="help-block red"><?php echo form_error('email');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_personal_website">个人网站</label>
<div class="col-sm-5">
<input class="form-control" id="user_account_attributes_personal_website" name="homepage" size="50" type="text" value="<?php echo $homepage?>" />
<span class="help-block red"><?php echo form_error('homepage');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_location">所在地</label>
<div class="col-sm-5">
<input class="form-control" id="user_account_attributes_location" name="location" size="50" type="text" value="<?php echo $location?>" />
<span class="help-block red"><?php echo form_error('location');?></span>
</div></div>

<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_signature">QQ</label>
<div class="col-sm-5">
<input class="form-control" id="user_account_attributes_signature" name="qq" size="50" type="text" value="<?php echo $qq?>" />
<span class="help-block red"><?php echo form_error('qq');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_signature">签名</label>
<div class="col-sm-5">
<input class="form-control" id="user_account_attributes_signature" name="signature" size="50" type="text" value="<?php echo $signature?>" />
<span class="help-block red"><?php echo form_error('signature');?></span>
</div></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="user_account_attributes_introduction">个人简介</label>
<div class="col-sm-5">
<textarea class="form-control" cols="40" id="user_account_attributes_introduction" name="introduction" rows="5"><?php echo $introduction?></textarea>
<span class="help-block red"><?php echo form_error('introduction');?></span>
</div></div>
<div class='form-group'>
	<div class="col-sm-offset-3 col-sm-9">
		<button type="submit" name="submit" class="btn btn-primary">保存设置</button>
	</div>
</div>
</form>

</div>
</div>

</div>
<div class='col-xs-12 col-sm-6 col-md-4' id='Rightbar'>
<?php $this->load->view('common/sidebar_login')?>


<?php $this->load->view('common/sidebar_ad');?>

</div>
</div></div></div>
<?php $this->load->view('common/footer');?>
</body>
</html>