<!DOCTYPE html><html><head><meta content='' name='description'>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php echo $title;?>- <?php echo $settings['site_name'];?></title>
<?php echo $this->load->view('header-meta');?>
</head>
<body id="startbbs">
<?php echo $this->load->view('header');?>

<div id="wrap"><div class="container" id="page-main"><div class="row-fluid"><div class='span8'>

<div class='box'>
<div class='cell' style="border-bottom-style: none;">
<a href="<?php echo site_url()?>" class="startbbs"><?php echo $settings['site_name']?></a> <span class="chevron">&nbsp;›&nbsp;</span> 设置
    <ul class="nav nav-tabs" style="margin-top:10px;">
    <li>
    <a href="<?php echo site_url('settings/profile');?>">个人信息</a>
    </li>
    <li><a href="<?php echo site_url('settings/avatar');?>">头像</a></li>
    <li class="active"><a href="#">修改密码</a></li>
    </ul>
</div>
<span style="color:red" id="error"><?php echo isset($msg)?$msg:''; ?></span>
<div class='inner'>
<form accept-charset="UTF-8" action="<?php echo site_url('settings/password');?>" class="simple_form form-horizontal" id="edit_user_313" method="post" novalidate="novalidate"><div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="bFgf4gFtDOwT1iCoDRGI7aqc14eXt1h403ny+0VSrz0=" /></div>
<strong class='fade'>如果你不想更改密码，请留空以下输入框。</strong>
<div class='sep5'></div>
<div class="control-group password optional">
<label class="password optional control-label" for="user_current_password">当前密码</label>
<div class="controls">
<input class="password optional" id="user_current_password" name="password" size="50" type="password" />
</div></div>
<div class="control-group password optional">
<label class="password optional control-label" for="user_password">新密码</label>
<div class="controls">
<input class="password optional" id="user_password" name="newpassword" size="50" type="password" />
</div></div>
<div class="control-group password optional">
<label class="password optional control-label" for="user_password_confirmation">新密码确认</label>
<div class="controls">
<input class="password optional" id="user_password_confirmation" name="newpassword2" size="50" type="password" /></div></div>
<div class='form-actions'>
<input class="btn btn-small btn-primary" name="commit" type="submit" value="修改密码" />
</div>
</form>

</div>
</div>

</div>
<div class='span4' id='Rightbar'>
<?php $this->load->view('block/right_login')?>

<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view('footer');?>