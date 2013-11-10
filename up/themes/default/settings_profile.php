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

<div id="wrap"><div class="container" id="page-main"><div class="row-fluid"><div class='span8'>

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
<form accept-charset="UTF-8" action="<?php echo site_url('settings/profile');?>" class="simple_form form-horizontal" id="edit_user_313" method="post" novalidate="novalidate">
<!--<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="bFgf4gFtDOwT1iCoDRGI7aqc14eXt1h403ny+0VSrz0=" />
</div>-->
<div class="control-group string required disabled">
<label class="string required control-label" for="user_nickname">用户名</label>
<div class="controls">
<input class="string required disabled" disabled="disabled" id="user_nickname" name="username" size="50" type="text" value="<?=$username?>" />
</div></div>
<div class="control-group email optional">
<label class="email optional control-label" for="user_email">电子邮件</label>
<div class="controls">
<input class="string email optional" id="user_email" name="email" size="50" type="email" value="<?=$email?>" />
</div></div>
<div class="control-group string optional">
<label class="string optional control-label" for="user_account_attributes_personal_website">个人网站</label>
<div class="controls">
<input class="string optional" id="user_account_attributes_personal_website" name="homepage" size="50" type="text" value="<?=$homepage?>" /></div></div>
<div class="control-group string optional">
<label class="string optional control-label" for="user_account_attributes_location">所在地</label>
<div class="controls">
<input class="string optional" id="user_account_attributes_location" name="location" size="50" type="text" value="<?=$location?>" /></div></div>

<div class="control-group string optional">
<label class="string optional control-label" for="user_account_attributes_signature">QQ</label>
<div class="controls">
<input class="string optional" id="user_account_attributes_signature" name="qq" size="50" type="text" value="<?=$qq?>" />
</div></div>
<div class="control-group string optional">
<label class="string optional control-label" for="user_account_attributes_signature">签名</label>
<div class="controls">
<input class="string optional" id="user_account_attributes_signature" name="signature" size="50" type="text" value="<?=$signature?>" />
</div></div>
<div class="control-group text optional">
<label class="text optional control-label" for="user_account_attributes_introduction">个人简介</label>
<div class="controls">
<textarea class="text optional" cols="40" id="user_account_attributes_introduction" name="introduction" rows="5"><?=$introduction?></textarea>
</div></div>
<input id="user_account_attributes_id" name="user[account_attributes][id]" type="hidden" value="326" />
<div class='form-actions'>
<input class="btn btn-small btn-primary" name="submit" type="submit" value="保存设置" />
</div>
</form>

</div>
</div>

</div>
<div class='span4' id='Rightbar'>
<?php $this->load->view('/block/right_login')?>


<?php $this->load->view('block/right_ad');?>

</div>
</div></div></div>
<?php $this->load->view('footer');?>